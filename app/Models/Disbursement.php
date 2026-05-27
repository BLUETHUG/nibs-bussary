<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;

class Disbursement {
    public int $id;
    public int $application_id;
    public float $amount;
    public string $payment_method;
    public int $disbursed_by;
    public string $disbursed_at;
    public string $reference_number;
    public ?string $notes;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM disbursements WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function all(): array {
        return Database::getConnection()->query("
            SELECT d.*, u.full_name as disbursed_by_name, a.amount_approved, s.course,
                   us.full_name as student_name, us.index_number
            FROM disbursements d
            JOIN users u ON d.disbursed_by = u.id
            JOIN applications a ON d.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN users us ON s.user_id = us.id
            ORDER BY d.disbursed_at DESC
        ")->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "d.$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("SELECT d.* FROM disbursements d WHERE $where");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public function save(): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO disbursements (application_id, amount, payment_method, disbursed_by, reference_number, notes) VALUES (?,?,?,?,?,?)");
        $result = $stmt->execute([$this->application_id, $this->amount, $this->payment_method, $this->disbursed_by, $this->reference_number, $this->notes]);
        $this->id = (int) $db->lastInsertId();
        return $result;
    }

    public function delete(): bool {
        return Database::getConnection()->prepare("DELETE FROM disbursements WHERE id = ?")->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $obj = new self();
        foreach ($row as $k => $v) if (is_string($k) && property_exists($obj, $k)) $obj->$k = $v;
        return $obj;
    }
}
