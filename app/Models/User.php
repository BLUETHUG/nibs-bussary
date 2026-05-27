<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;
use App\Helpers\AuditLogger;

class User {
    public int $id;
    public string $full_name;
    public string $index_number;
    public string $email;
    public string $phone;
    public string $password_hash;
    public string $role;
    public bool $is_active;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ? AND is_active = 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function findByIndex(string $indexNumber): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE index_number = ? AND is_active = 1");
        $stmt->execute([$indexNumber]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function findByEmail(string $email): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function all(): array {
        $db = Database::getConnection();
        return $db->query("SELECT * FROM users WHERE is_active = 1 ORDER BY created_at DESC")->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("SELECT * FROM users WHERE $where");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public function save(): bool {
        $db = Database::getConnection();
        if (isset($this->id)) {
            $stmt = $db->prepare("UPDATE users SET full_name=?, email=?, phone=?, role=?, is_active=? WHERE id=?");
            $result = $stmt->execute([$this->full_name, $this->email, $this->phone, $this->role, $this->is_active ? 1 : 0, $this->id]);
            AuditLogger::log($_SESSION['user_id'] ?? null, 'UPDATE', 'users', $this->id, null, ['role' => $this->role]);
            return $result;
        } else {
            $stmt = $db->prepare("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES (?,?,?,?,?,?)");
            $result = $stmt->execute([$this->full_name, $this->index_number, $this->email, $this->phone, $this->password_hash, $this->role]);
            $this->id = (int) $db->lastInsertId();
            AuditLogger::log(null, 'INSERT', 'users', $this->id, null, ['index_number' => $this->index_number]);
            return $result;
        }
    }

    public function delete(): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
        AuditLogger::log($_SESSION['user_id'] ?? null, 'DELETE', 'users', $this->id, ['is_active' => 1], ['is_active' => 0]);
        return $stmt->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $user = new self();
        foreach ($row as $key => $value) {
            if (is_string($key) && property_exists($user, $key)) {
                if ($key === 'is_active') {
                    $user->is_active = (bool) $value;
                } else {
                    $user->$key = $value;
                }
            }
        }
        return $user;
    }
}
