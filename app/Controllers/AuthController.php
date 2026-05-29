<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Helpers\Validator;
use App\Helpers\AuditLogger;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Models\User;

class AuthController {

    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 900; // 15 min
    private const HASH_ALGO = PASSWORD_ARGON2ID;

    public function login(): void {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();

            $indexNumber = Validator::clean($_POST['index_number'] ?? '');
            $password    = $_POST['password'] ?? '';
            $remember    = isset($_POST['remember_me']);
            $errors      = Validator::validateRequired($_POST, ['index_number', 'password']);

            if (empty($errors)) {
                // Check brute force lockout
                $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
                if ($this->isLockedOut($indexNumber, $ip)) {
                    $errors[] = 'Too many login attempts. Please try again in 15 minutes.';
                    AuditLogger::log(null, 'LOGIN_BLOCKED', 'users', null, null, null, 'Locked out: ' . $indexNumber);
                    $this->renderLogin($errors);
                    return;
                }

                $user = User::findByIndex($indexNumber) ?? User::findByEmail($indexNumber);
                $passwordOk = $user && password_verify($password, $user->password_hash);

                if ($passwordOk) {
                    // Check if rehashing needed (upgrade from bcrypt to Argon2id)
                    if (password_needs_rehash($user->password_hash, self::HASH_ALGO)) {
                        $db = Database::getConnection();
                        $newHash = password_hash($password, self::HASH_ALGO);
                        $stmt = $db->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                        $stmt->execute([$newHash, $user->id]);
                    }

                    // Clear lockout on success
                    $this->clearLoginAttempts($indexNumber, $ip);

                    // Update last login
                    $db = Database::getConnection();
                    $stmt = $db->prepare("UPDATE users SET last_login_at = datetime('now'), login_attempts = 0, locked_until = NULL WHERE id = ?");
                    $stmt->execute([$user->id]);

                    session_regenerate_id(true);
                    $_SESSION['user_id']       = $user->id;
                    $_SESSION['role']          = $user->role;
                    $_SESSION['full_name']     = $user->full_name;
                    $_SESSION['last_activity'] = time();
                    $_SESSION['auth_method']   = 'password';

                    AuditLogger::log($user->id, 'LOGIN', 'users', $user->id, null, null, 'Login successful');

                    // Remember me
                    if ($remember && !empty($_POST['remember_me'])) {
                        $this->setRememberMe($user->id);
                    }

                    match ($user->role) {
                        'admin', 'officer' => header('Location: /admin/dashboard'),
                        'committee'        => header('Location: /admin/committee'),
                        'accountant'       => header('Location: /admin/finance'),
                        default            => header('Location: /student/dashboard'),
                    };
                    exit;
                } else {
                    $this->recordLoginAttempt($indexNumber, $ip);
                    // Increment user's counter
                    if ($user) {
                        $db = Database::getConnection();
                        $db->prepare("UPDATE users SET login_attempts = COALESCE(login_attempts, 0) + 1 WHERE id = ?")->execute([$user->id]);
                    }
                    $errors[] = 'Invalid index number or password.';
                    AuditLogger::log($user?->id, 'LOGIN_FAILED', 'users', $user?->id, null, null, 'Failed login: ' . $indexNumber);
                }
            }

            $this->renderLogin($errors);
            return;
        }

        $this->renderLogin();
    }

    public function register(): void {
        AuthMiddleware::guest();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();

            $errors = Validator::validateRequired($_POST, ['full_name','index_number','email','phone','password','confirm_password']);

            if ($_POST['password'] !== $_POST['confirm_password']) {
                $errors[] = 'Passwords do not match.';
            }
            if (!Validator::validateEmail($_POST['email'] ?? '')) {
                $errors[] = 'Invalid email address.';
            }

            // Password strength
            $pwErrors = Validator::validatePassword($_POST['password'] ?? '');
            $errors = array_merge($errors, $pwErrors);

            if (empty($errors)) {
                $existing = User::where(['index_number' => $_POST['index_number']]);
                if (!empty($existing)) {
                    $errors[] = 'Index number already registered.';
                } else {
                    $existingEmail = User::where(['email' => $_POST['email']]);
                    if (!empty($existingEmail)) {
                        $errors[] = 'Email already registered.';
                    } else {
                        $user = new User();
                        $user->full_name     = Validator::clean($_POST['full_name']);
                        $user->index_number  = Validator::clean($_POST['index_number']);
                        $user->email         = Validator::clean($_POST['email']);
                        $user->phone         = Validator::clean($_POST['phone']);
                        $user->password_hash = password_hash($_POST['password'], self::HASH_ALGO);
                        $user->role          = 'student';
                        $user->is_active     = true;
                        $user->save();

                        // Insert student profile
                        $db = Database::getConnection();
                        $stmt = $db->prepare("INSERT INTO students (user_id, course, year_of_study, gender, date_of_birth, guardian_name, guardian_phone, guardian_monthly_income, family_size, bank_name, bank_account, mpesa_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
                        $stmt->execute([
                            $user->id,
                            Validator::clean($_POST['course'] ?? 'Not specified'),
                            (int)($_POST['year_of_study'] ?? 1),
                            Validator::clean($_POST['gender'] ?? 'male'),
                            $_POST['dob'] ?? date('Y-m-d'),
                            Validator::clean($_POST['guardian_name'] ?? 'N/A'),
                            Validator::clean($_POST['guardian_phone'] ?? '0700000000'),
                            (float)($_POST['guardian_income'] ?? 0),
                            (int)($_POST['family_size'] ?? 1),
                            Validator::clean($_POST['bank_name'] ?? ''),
                            Validator::clean($_POST['bank_account'] ?? ''),
                            Validator::clean($_POST['mpesa_phone'] ?? ''),
                        ]);

                        // Generate email verification token
                        $token = bin2hex(random_bytes(32));
                        $stmt = $db->prepare("INSERT INTO email_verifications (user_id, token, expires_at) VALUES (?, ?, datetime('now', '+24 hours'))");
                        $stmt->execute([$user->id, $token]);

                        AuditLogger::log($user->id, 'REGISTER', 'users', $user->id, null, null, 'Account created, verification sent');

                        session_regenerate_id(true);
                        $_SESSION['user_id']       = $user->id;
                        $_SESSION['role']          = 'student';
                        $_SESSION['full_name']     = $user->full_name;
                        $_SESSION['last_activity'] = time();
                        $_SESSION['auth_method']   = 'register';

                        // Redirect to dashboard with verification prompt
                        $_SESSION['verify_prompt'] = true;
                        header('Location: /student/dashboard');
                        exit;
                    }
                }
            }

            require __DIR__ . '/../Views/auth/register.php';
            return;
        }

        require __DIR__ . '/../Views/auth/register.php';
    }

    public function verifyEmail(): void {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            header('Location: /login?error=Invalid+verification+link');
            exit;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM email_verifications WHERE token = ? AND verified_at IS NULL AND expires_at > datetime('now')");
        $stmt->execute([$token]);
        $row = $stmt->fetch();

        if (!$row) {
            header('Location: /login?error=Invalid+or+expired+verification+link');
            exit;
        }

        $stmt = $db->prepare("UPDATE email_verifications SET verified_at = datetime('now') WHERE id = ?");
        $stmt->execute([$row['id']]);

        $stmt = $db->prepare("UPDATE users SET email_verified_at = datetime('now') WHERE id = ?");
        $stmt->execute([$row['user_id']]);

        AuditLogger::log((int)$row['user_id'], 'EMAIL_VERIFIED', 'users', (int)$row['user_id']);

        $_SESSION['email_verified'] = true;
        header('Location: /student/dashboard?verified=1');
        exit;
    }

    public function resendVerification(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT email_verified_at FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if ($user && !empty($user['email_verified_at'])) {
            header('Location: /student/dashboard?already_verified=1');
            exit;
        }

        // Invalidate old tokens
        $stmt = $db->prepare("UPDATE email_verifications SET verified_at = datetime('now') WHERE user_id = ? AND verified_at IS NULL");
        $stmt->execute([$_SESSION['user_id']]);

        $token = bin2hex(random_bytes(32));
        $stmt = $db->prepare("INSERT INTO email_verifications (user_id, token, expires_at) VALUES (?, ?, datetime('now', '+24 hours'))");
        $stmt->execute([$_SESSION['user_id'], $token]);

        AuditLogger::log($_SESSION['user_id'], 'VERIFICATION_RESENT', 'users', $_SESSION['user_id']);

        $_SESSION['verify_prompt'] = true;
        header('Location: /student/dashboard?resent=1');
        exit;
    }

    public function logout(): void {
        if (isset($_SESSION['user_id'])) {
            AuditLogger::log($_SESSION['user_id'], 'LOGOUT', 'users', $_SESSION['user_id'], null, null, 'User logged out');
            // Clear remember-me cookies
            if (isset($_COOKIE['remember_token'])) {
                $db = Database::getConnection();
                $stmt = $db->prepare("DELETE FROM remember_tokens WHERE token_hash = ?");
                $stmt->execute([hash('sha256', $_COOKIE['remember_token'])]);
                setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            }
        }
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

    private function renderLogin(array $errors = []): void {
        require __DIR__ . '/../Views/auth/login.php';
    }

    private function isLockedOut(string $email, string $ip): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE (email = ? OR ip_address = ?) AND success = 0 AND attempted_at > datetime('now', '-' || ? || ' seconds')");
        $stmt->execute([$email, $ip, self::LOCKOUT_DURATION]);
        return $stmt->fetchColumn() >= self::MAX_LOGIN_ATTEMPTS;
    }

    private function recordLoginAttempt(string $email, string $ip): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, 0)");
        $stmt->execute([$email, $ip]);
    }

    private function clearLoginAttempts(string $email, string $ip): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM login_attempts WHERE (email = ? OR ip_address = ?)");
        $stmt->execute([$email, $ip]);
    }

    private function setRememberMe(int $userId): void {
        $token = bin2hex(random_bytes(32));
        $hash = hash('sha256', $token);
        $expires = date('Y-m-d H:i:s', time() + 86400 * 30); // 30 days

        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $hash, $expires]);

        setcookie('remember_token', $token, time() + 86400 * 30, '/', '', false, true);
    }
}
