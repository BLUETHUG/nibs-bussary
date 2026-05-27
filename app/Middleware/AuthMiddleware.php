<?php
declare(strict_types=1);

namespace App\Middleware;

class AuthMiddleware {
    public static function require(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is authenticated
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Session timeout after 30 minutes of inactivity
        $timeout = 1800;
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
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
}
