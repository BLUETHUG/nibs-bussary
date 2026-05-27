<?php
declare(strict_types=1);

namespace App\Middleware;

class RoleMiddleware {
    public static function require(string ...$roles): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userRole = $_SESSION['role'] ?? null;
        if (!in_array($userRole, $roles, true)) {
            http_response_code(403);
            require __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }
}
