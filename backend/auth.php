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

function register($data, $pdo) {
    if (!validateCsrf($data)) {
        echo json_encode(['error' => 'Invalid request security token']);
        return;
    }
    if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
        echo json_encode(['error' => 'All fields are required']);
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$data['email']]);
        if ($stmt->fetch()) {
            echo json_encode(['error' => 'Email already registered']);
            return;
        }

        $hash = password_hash($data['password'], PASSWORD_BCRYPT);
        $index = $data['index_number'] ?? $data['email'];
        $phone = $data['phone'] ?? '0700000000';
        $stmt = $pdo->prepare("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, 'student')");
        $stmt->execute([$data['name'], $index, $data['email'], $phone, $hash]);
        
        echo json_encode(['success' => 'Registration successful']);
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

    try {
        // Try email first, then index_number
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR index_number = ?");
        $stmt->execute([$data['email'], $data['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['password'], $user['password_hash'])) {
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
            if ($isAjax) { echo json_encode(['error' => 'Invalid email or password']); return; }
            header('Location: login.php?error=Invalid+email+or+password', true, 302); exit;
        }
    } catch (PDOException $e) {
        if ($isAjax) { echo json_encode(['error' => 'Database error: ' . $e->getMessage()]); return; }
        header('Location: login.php?error=Database+error', true, 302); exit;
    }
}

function logout() {
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
