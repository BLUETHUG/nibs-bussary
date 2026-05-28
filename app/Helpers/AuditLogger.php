<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Database;

class AuditLogger {
    public static function log(?int $userId, string $action, string $table, ?int $recordId, ?array $oldValue = null, ?array $newValue = null, ?string $detail = null): void {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO audit_logs (user_id, action, table_affected, record_id, old_value, new_value, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $userId,
            $detail ? $action . ': ' . $detail : $action,
            $table,
            $recordId,
            $oldValue ? json_encode($oldValue) : null,
            $newValue ? json_encode($newValue) : null,
            $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            $_SERVER['HTTP_USER_AGENT'] ?? null,
        ]);
    }
}
