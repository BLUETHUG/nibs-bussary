<?php
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 1800,
        'path' => '/',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

// CSRF token generation
function csrfToken(): string {
    if (empty($_SESSION['_old_csrf_token'])) {
        $_SESSION['_old_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_old_csrf_token'];
}

$action = $_GET['action'] ?? '';

if ($action === 'csrf') {
    echo json_encode(['token' => csrfToken()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!$data) {
        parse_str($raw, $data);
        if (empty($data)) $data = $_POST;
    }
    
    if ($action === 'register') {
        register($data, $pdo);
    } elseif ($action === 'login') {
        login($data, $pdo);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'logout') {
    logout();
}

function validateCsrf($data): bool {
    $token = $data['_csrf_token'] ?? '';
    return !empty($_SESSION['_old_csrf_token']) && hash_equals($_SESSION['_old_csrf_token'], $token);
}

function isLockedOut($pdo, string $email, string $ip): bool {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM login_attempts WHERE (email = ? OR ip_address = ?) AND success = 0 AND attempted_at > datetime('now', '-900 seconds')");
    $stmt->execute([$email, $ip]);
    return $stmt->fetchColumn() >= 5;
}

function recordAttempt($pdo, string $email, string $ip): void {
    $stmt = $pdo->prepare("INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, 0)");
    $stmt->execute([$email, $ip]);
}

function clearAttempts($pdo, string $email, string $ip): void {
    $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE (email = ? OR ip_address = ?)");
    $stmt->execute([$email, $ip]);
}

function register($data, $pdo) {
    if (!validateCsrf($data)) {
        echo json_encode(['error' => 'Invalid request security token']);
        return;
    }
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        echo json_encode(['error' => 'All fields are required']);
        return;
    }

    // Password strength
    if (strlen($data['password']) < 8) {
        echo json_encode(['error' => 'Password must be at least 8 characters']);
        return;
    }
    if (!preg_match('/[A-Z]/', $data['password'])) {
        echo json_encode(['error' => 'Password must contain an uppercase letter']);
        return;
    }
    if (!preg_match('/[0-9]/', $data['password'])) {
        echo json_encode(['error' => 'Password must contain a number']);
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            echo json_encode(['error' => 'Email already registered']);
            return;
        }

        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
        $hash = password_hash($data['password'], $algo);
        $index = $data['index_number'] ?? $data['email'];
        $phone = $data['phone'] ?? '0700000000';
        $stmt = $pdo->prepare("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, 'student')");
        $stmt->execute([$data['name'], $index, $data['email'], $phone, $hash]);
        
        // Generate email verification token
        $userId = $pdo->lastInsertId();
        $token = bin2hex(random_bytes(32));
        $stmt = $pdo->prepare("INSERT INTO email_verifications (user_id, token, expires_at) VALUES (?, ?, datetime('now', '+24 hours'))");
        $stmt->execute([$userId, $token]);
        
        echo json_encode(['success' => 'Registration successful. Please verify your email.', 'verify_token' => $token]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function login($data, $pdo) {
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if (!validateCsrf($data)) {
        if ($isAjax) { echo json_encode(['error' => 'Invalid request security token']); return; }
        header('Location: login.php?error=Invalid+request+security+token', true, 302); exit;
    }
    if (empty($data['email']) || empty($data['password'])) {
        if ($isAjax) { echo json_encode(['error' => 'Email and password are required']); return; }
        header('Location: login.php?error=Email+and+password+are+required', true, 302); exit;
    }

    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (isLockedOut($pdo, $data['email'], $ip)) {
        if ($isAjax) { echo json_encode(['error' => 'Too many attempts. Try again in 15 minutes.']); return; }
        header('Location: login.php?error=Too+many+attempts', true, 302); exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR index_number = ?");
        $stmt->execute([$data['email'], $data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password_hash'])) {
            // Rehash if needed (bcrypt -> Argon2 upgrade)
            $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
            if (password_needs_rehash($user['password_hash'], $algo)) {
                $newHash = password_hash($data['password'], $algo);
                $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $stmt->execute([$newHash, $user['id']]);
            }

            clearAttempts($pdo, $data['email'], $ip);
            $stmt = $pdo->prepare("UPDATE users SET last_login_at = datetime('now'), login_attempts = 0, locked_until = NULL WHERE id = ?");
            $stmt->execute([$user['id']]);

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['last_activity'] = time();
            
            if ($isAjax) {
                echo json_encode(['success' => 'Login successful', 'role' => $user['role'], 'name' => $user['full_name']]);
            } else {
                $redirect = $user['role'] === 'admin' ? '/admin/dashboard' : '/student/dashboard';
                header('Location: ' . $redirect, true, 302); exit;
            }
        } else {
            recordAttempt($pdo, $data['email'], $ip);
            if ($user) {
                $stmt = $pdo->prepare("UPDATE users SET login_attempts = COALESCE(login_attempts, 0) + 1 WHERE id = ?");
                $stmt->execute([$user['id']]);
            }
            if ($isAjax) { echo json_encode(['error' => 'Invalid email or password']); return; }
            header('Location: login.php?error=Invalid+email+or+password', true, 302); exit;
        }
    } catch (PDOException $e) {
        if ($isAjax) { echo json_encode(['error' => 'Database error: ' . $e->getMessage()]); return; }
        header('Location: login.php?error=Database+error', true, 302); exit;
    }
}

function logout() {
    // Clear remember-me
    if (isset($_COOKIE['remember_token'])) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
        $stmt->execute([hash('sha256', $_COOKIE['remember_token'])]);
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }
    session_destroy();
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if ($isAjax) {
        echo json_encode(['success' => 'Logged out', 'redirect' => '/login.php']);
    } else {
        header('Location: login.php', true, 302);
    }
    exit;
}
?>
