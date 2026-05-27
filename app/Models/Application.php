<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;
use App\Helpers\AuditLogger;

class Application {
    public int $id;
    public int $student_id;
    public int $fund_id;
    public string $academic_year;
    public string $status;
    public float $amount_requested;
    public float $amount_approved;
    public ?string $special_circumstances;
    public ?string $supporting_doc_path;
    public ?int $reviewed_by;
    public ?string $rejection_reason;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM applications WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function all(): array {
        $db = Database::getConnection();
        try {
            return $db->query("
                SELECT a.*, u.full_name, u.index_number, s.course, s.year_of_study
                FROM applications a
                JOIN students s ON a.student_id = s.id
                JOIN users u ON s.user_id = u.id
                ORDER BY COALESCE(a.updated_at, a.created_at) DESC
            ")->fetchAll();
        } catch (\Exception $e) {
            error_log('Application::all() failed: ' . $e->getMessage());
            return [];
        }
    }

    public static function byStudent(int $studentId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM applications WHERE student_id = ? ORDER BY created_at DESC");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "a.$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("
            SELECT a.*, u.full_name, u.index_number, s.course 
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE $where ORDER BY a.created_at DESC
        ");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public function save(): bool {
        $db = Database::getConnection();
        if (isset($this->id)) {
            $stmt = $db->prepare("
                UPDATE applications SET status=?, amount_requested=?, amount_approved=?, 
                reviewed_by=?, review_date=NOW(), rejection_reason=?, 
                special_circumstances=?, updated_at=NOW() WHERE id=?
            ");
            $result = $stmt->execute([
                $this->status, $this->amount_requested, $this->amount_approved,
                $this->reviewed_by, $this->rejection_reason,
                $this->special_circumstances, $this->id
            ]);
            AuditLogger::log($_SESSION['user_id'] ?? null, 'UPDATE_APPLICATION', 'applications', $this->id, null, ['status' => $this->status]);
            return $result;
        } else {
            $stmt = $db->prepare("
                INSERT INTO applications (student_id, fund_id, academic_year, amount_requested, special_circumstances, supporting_doc_path, status)
                VALUES (?,?,?,?,?,?,'pending')
            ");
            $result = $stmt->execute([$this->student_id, $this->fund_id, $this->academic_year, $this->amount_requested, $this->special_circumstances, $this->supporting_doc_path]);
            $this->id = (int) $db->lastInsertId();
            AuditLogger::log($_SESSION['user_id'] ?? null, 'INSERT_APPLICATION', 'applications', $this->id, null, ['student_id' => $this->student_id]);
            return $result;
        }
    }

    public function delete(): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM applications WHERE id = ?");
        AuditLogger::log($_SESSION['user_id'] ?? null, 'DELETE_APPLICATION', 'applications', $this->id);
        return $stmt->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $app = new self();
        foreach ($row as $key => $value) {
            if (is_string($key) && property_exists($app, $key)) {
                $app->$key = $value;
            }
        }
        return $app;
    }
}
