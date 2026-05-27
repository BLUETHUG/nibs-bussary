<?php
declare(strict_types=1);

namespace App\Middleware;

class CsrfMiddleware {
    public static function generate(): string {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validate(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
            if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
                http_response_code(403);
                die('CSRF validation failed.');
            }
        }
    }

    public static function field(): string {
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(self::generate()) . '">';
    }
}
