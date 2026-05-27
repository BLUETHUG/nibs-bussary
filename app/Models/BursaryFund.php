<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;
use App\Helpers\AuditLogger;

class BursaryFund {
    public int $id;
    public string $fund_name;
    public float $total_amount;
    public float $available_amount;
    public string $academic_year;
    public string $source;
    public int $created_by;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM bursary_funds WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function all(): array {
        $db = Database::getConnection();
        return $db->query("SELECT * FROM bursary_funds ORDER BY created_at DESC")->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("SELECT * FROM bursary_funds WHERE $where");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public function save(): bool {
        $db = Database::getConnection();
        if (isset($this->id)) {
            $stmt = $db->prepare("UPDATE bursary_funds SET fund_name=?, total_amount=?, available_amount=?, source=? WHERE id=?");
            $result = $stmt->execute([$this->fund_name, $this->total_amount, $this->available_amount, $this->source, $this->id]);
            AuditLogger::log($_SESSION['user_id'] ?? null, 'UPDATE', 'bursary_funds', $this->id);
            return $result;
        } else {
            $stmt = $db->prepare("INSERT INTO bursary_funds (fund_name, total_amount, available_amount, academic_year, source, created_by) VALUES (?,?,?,?,?,?)");
            $result = $stmt->execute([$this->fund_name, $this->total_amount, $this->available_amount, $this->academic_year, $this->source, $this->created_by]);
            $this->id = (int) $db->lastInsertId();
            AuditLogger::log($_SESSION['user_id'] ?? null, 'INSERT', 'bursary_funds', $this->id);
            return $result;
        }
    }

    public function delete(): bool {
        $db = Database::getConnection();
        return $db->prepare("DELETE FROM bursary_funds WHERE id = ?")->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $obj = new self();
        foreach ($row as $k => $v) {
            if (is_string($k) && property_exists($obj, $k)) $obj->$k = $v;
        }
        return $obj;
    }
}
