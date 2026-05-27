<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;

class Notification {
    public int $id;
    public int $user_id;
    public string $title;
    public string $message;
    public bool $is_read;
    public string $created_at;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM notifications WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function forUser(int $userId, bool $unreadOnly = false): array {
        $db = Database::getConnection();
        $sql = "SELECT * FROM notifications WHERE user_id = ?";
        if ($unreadOnly) $sql .= " AND is_read = 0";
        $sql .= " ORDER BY created_at DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function all(): array {
        return Database::getConnection()->query("SELECT * FROM notifications ORDER BY created_at DESC")->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("SELECT * FROM notifications WHERE $where");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public static function markAllRead(int $userId): void {
        Database::getConnection()->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?")->execute([$userId]);
    }

    public function save(): bool {
        $db = Database::getConnection();
        if (isset($this->id)) {
            return $db->prepare("UPDATE notifications SET is_read = ? WHERE id = ?")->execute([$this->is_read ? 1 : 0, $this->id]);
        }
        $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?,?,?)");
        $result = $stmt->execute([$this->user_id, $this->title, $this->message]);
        $this->id = (int) $db->lastInsertId();
        return $result;
    }

    public function delete(): bool {
        return Database::getConnection()->prepare("DELETE FROM notifications WHERE id = ?")->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $obj = new self();
        foreach ($row as $k => $v) if (is_string($k) && property_exists($obj, $k)) $obj->$k = $v;
        return $obj;
    }
}
