<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\Database;
use App\Helpers\AuditLogger;

class AuthMiddleware {
    public static function require(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check session auth
        if (empty($_SESSION['user_id'])) {
            // Try remember-me
            if (!self::tryRememberMe()) {
                header('Location: /login');
                exit;
            }
        }

        // Session timeout after 30 minutes of inactivity
        $timeout = 1800;
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
            AuditLogger::log($_SESSION['user_id'] ?? null, 'SESSION_TIMEOUT', 'users', $_SESSION['user_id'] ?? null);
            session_unset();
            session_destroy();
            header('Location: /login?timeout=1');
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    public static function guest(): void {
        if (!empty($_SESSION['user_id'])) {
            $role = $_SESSION['role'] ?? 'student';
            if ($role === 'admin' || $role === 'officer') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /student/dashboard');
            }
            exit;
        }
    }

    private static function tryRememberMe(): bool {
        $token = $_COOKIE['remember_token'] ?? '';
        if (empty($token)) return false;

        $hash = hash('sha256', $token);
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT rt.*, u.full_name, u.role FROM remember_tokens rt JOIN users u ON u.id = rt.user_id WHERE rt.token_hash = ? AND rt.expires_at > datetime('now') AND u.is_active = 1");
        $stmt->execute([$hash]);
        $row = $stmt->fetch();

        if (!$row) {
            // Token expired or invalid — clear it
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            return false;
        }

        // Rotate token (delete old, issue new)
        $stmt = $db->prepare("DELETE FROM remember_tokens WHERE id = ?");
        $stmt->execute([$row['id']]);

        $newToken = bin2hex(random_bytes(32));
        $newHash = hash('sha256', $newToken);
        $expires = date('Y-m-d H:i:s', time() + 86400 * 30);
        $stmt = $db->prepare("INSERT INTO remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$row['user_id'], $newHash, $expires]);
        setcookie('remember_token', $newToken, time() + 86400 * 30, '/', '', false, true);

        session_regenerate_id(true);
        $_SESSION['user_id']       = (int)$row['user_id'];
        $_SESSION['role']          = $row['role'];
        $_SESSION['full_name']     = $row['full_name'];
        $_SESSION['last_activity'] = time();
        $_SESSION['auth_method']   = 'remember_me';

        AuditLogger::log((int)$row['user_id'], 'LOGIN_REMEMBER', 'users', (int)$row['user_id']);

        return true;
    }
}
