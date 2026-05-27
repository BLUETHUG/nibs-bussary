<?php
declare(strict_types=1);

namespace App\Models;

use App\Helpers\Database;

class Student {
    public int $id;
    public int $user_id;
    public string $course;
    public int $year_of_study;
    public string $gender;
    public string $date_of_birth;
    public string $guardian_name;
    public string $guardian_phone;
    public ?string $guardian_occupation;
    public float $guardian_monthly_income;
    public int $family_size;
    public ?string $photo_path;

    public static function find(int $id): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function findByUserId(int $userId): ?self {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM students WHERE user_id = ?");
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row ? self::fromArray($row) : null;
    }

    public static function all(): array {
        $db = Database::getConnection();
        return $db->query("SELECT s.*, u.full_name, u.index_number, u.email FROM students s JOIN users u ON s.user_id = u.id ORDER BY s.created_at DESC")->fetchAll();
    }

    public static function where(array $conditions): array {
        $db = Database::getConnection();
        $where = implode(' AND ', array_map(fn($k) => "s.$k = ?", array_keys($conditions)));
        $stmt = $db->prepare("SELECT s.*, u.full_name, u.index_number FROM students s JOIN users u ON s.user_id = u.id WHERE $where");
        $stmt->execute(array_values($conditions));
        return $stmt->fetchAll();
    }

    public function save(): bool {
        $db = Database::getConnection();
        if (isset($this->id)) {
            $stmt = $db->prepare("UPDATE students SET course=?, year_of_study=?, gender=?, date_of_birth=?, guardian_name=?, guardian_phone=?, guardian_occupation=?, guardian_monthly_income=?, family_size=?, photo_path=? WHERE id=?");
            return $stmt->execute([$this->course, $this->year_of_study, $this->gender, $this->date_of_birth, $this->guardian_name, $this->guardian_phone, $this->guardian_occupation, $this->guardian_monthly_income, $this->family_size, $this->photo_path, $this->id]);
        } else {
            $stmt = $db->prepare("INSERT INTO students (user_id, course, year_of_study, gender, date_of_birth, guardian_name, guardian_phone, guardian_occupation, guardian_monthly_income, family_size) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $result = $stmt->execute([$this->user_id, $this->course, $this->year_of_study, $this->gender, $this->date_of_birth, $this->guardian_name, $this->guardian_phone, $this->guardian_occupation, $this->guardian_monthly_income, $this->family_size]);
            $this->id = (int) $db->lastInsertId();
            return $result;
        }
    }

    public function delete(): bool {
        return Database::getConnection()->prepare("DELETE FROM students WHERE id = ?")->execute([$this->id]);
    }

    private static function fromArray(array $row): self {
        $obj = new self();
        foreach ($row as $k => $v) if (is_string($k) && property_exists($obj, $k)) $obj->$k = $v;
        return $obj;
    }
}
