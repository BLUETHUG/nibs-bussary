<?php
// app/Helpers/Database.php
declare(strict_types=1);

namespace App\Helpers;

use PDO;
use Exception;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
            
            try {
                self::$instance = new PDO($dsn, $config['username'], $config['password'], $config['options']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                error_log("MySQL connection failed: " . $e->getMessage() . ". Falling back to SQLite.");
                $storage = __DIR__ . '/../../storage';
                if (!is_dir($storage)) mkdir($storage, 0777, true);
                $sqlitePath = $storage . '/mvc.sqlite';
                self::$instance = new PDO("sqlite:$sqlitePath");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('PRAGMA foreign_keys = ON');
                self::initSqliteSchema(self::$instance);
            }
        }
        return self::$instance;
    }

    private static function initSqliteSchema(PDO $pdo): void {
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            full_name TEXT NOT NULL,
            index_number TEXT UNIQUE NOT NULL,
            email TEXT UNIQUE NOT NULL,
            phone TEXT NOT NULL,
            password_hash TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'student',
            is_active INTEGER DEFAULT 1,
            created_at TEXT DEFAULT (datetime('now')),
            updated_at TEXT DEFAULT (datetime('now'))
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS students (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            course TEXT NOT NULL,
            year_of_study INTEGER NOT NULL,
            gender TEXT NOT NULL,
            date_of_birth TEXT NOT NULL,
            guardian_name TEXT NOT NULL,
            guardian_phone TEXT NOT NULL,
            guardian_occupation TEXT,
            guardian_monthly_income REAL NOT NULL,
            family_size INTEGER NOT NULL,
            bank_name TEXT,
            bank_account TEXT,
            mpesa_phone TEXT,
            photo_path TEXT,
            created_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");
        // Migration: add bank details to students for databases created without them
        try { $pdo->exec("ALTER TABLE students ADD COLUMN bank_name TEXT"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE students ADD COLUMN bank_account TEXT"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE students ADD COLUMN mpesa_phone TEXT"); } catch (PDOException $e) {}

        $pdo->exec("CREATE TABLE IF NOT EXISTS bursary_funds (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            fund_name TEXT NOT NULL,
            total_amount REAL NOT NULL,
            available_amount REAL NOT NULL,
            academic_year TEXT NOT NULL,
            source TEXT NOT NULL,
            created_by INTEGER NOT NULL,
            created_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (created_by) REFERENCES users(id)
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS applications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            student_id INTEGER NOT NULL,
            fund_id INTEGER NOT NULL,
            academic_year TEXT NOT NULL,
            application_date TEXT DEFAULT (datetime('now')),
            status TEXT NOT NULL DEFAULT 'pending',
            amount_requested REAL NOT NULL,
            amount_approved REAL DEFAULT 0,
            special_circumstances TEXT,
            supporting_doc_path TEXT,
            reviewed_by INTEGER,
            review_date TEXT,
            rejection_reason TEXT,
            created_at TEXT DEFAULT (datetime('now')),
            updated_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
            FOREIGN KEY (fund_id) REFERENCES bursary_funds(id)
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS committee_scores (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            application_id INTEGER NOT NULL,
            member_id INTEGER NOT NULL,
            need_score INTEGER NOT NULL CHECK (need_score BETWEEN 1 AND 10),
            academic_score INTEGER NOT NULL CHECK (academic_score BETWEEN 1 AND 10),
            circumstance_score INTEGER NOT NULL CHECK (circumstance_score BETWEEN 1 AND 10),
            recommendation TEXT,
            scored_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE,
            FOREIGN KEY (member_id) REFERENCES users(id)
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS disbursements (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            application_id INTEGER NOT NULL,
            amount REAL NOT NULL,
            payment_method TEXT NOT NULL,
            disbursed_by INTEGER NOT NULL,
            disbursed_at TEXT DEFAULT (datetime('now')),
            reference_number TEXT UNIQUE NOT NULL,
            notes TEXT,
            FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE,
            FOREIGN KEY (disbursed_by) REFERENCES users(id)
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            title TEXT NOT NULL,
            message TEXT NOT NULL,
            is_read INTEGER DEFAULT 0,
            created_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS audit_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            action TEXT NOT NULL,
            table_affected TEXT,
            record_id INTEGER,
            old_value TEXT,
            new_value TEXT,
            ip_address TEXT,
            created_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )");

        $pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            body TEXT NOT NULL,
            posted_by INTEGER NOT NULL,
            is_active INTEGER DEFAULT 1,
            created_at TEXT DEFAULT (datetime('now')),
            FOREIGN KEY (posted_by) REFERENCES users(id)
        )");

        self::seedSqlite($pdo);
    }

    private static function seedSqlite(PDO $pdo): void {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        if ($stmt->fetchColumn() > 0) return;

        $adminPw = password_hash('admin123', PASSWORD_BCRYPT);
        $studentPw = password_hash('student123', PASSWORD_BCRYPT);

        $pdo->exec("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES
            ('System Admin', 'ADM001', 'admin@nibs.ac.ke', '0712345678', '$adminPw', 'admin'),
            ('John Doe', 'STUD001', 'student001@nibs.ac.ke', '0752345678', '$studentPw', 'student'),
            ('Jane Smith', 'STUD002', 'student002@nibs.ac.ke', '0762345678', '$studentPw', 'student')
        ");

        $pdo->exec("INSERT INTO students (user_id, course, year_of_study, gender, date_of_birth, guardian_name, guardian_phone, guardian_monthly_income, family_size) VALUES
            (2, 'Computer Science', 2, 'male', '2004-05-15', 'Mark Doe', '0711111111', 15000.00, 4),
            (3, 'Business Management', 1, 'female', '2005-08-20', 'Mary Smith', '0722222222', 12000.00, 5)
        ");

        $pdo->exec("INSERT INTO bursary_funds (fund_name, total_amount, available_amount, academic_year, source, created_by) VALUES
            ('Government Helb Supplement', 500000.00, 500000.00, '2024/2025', 'government', 1),
            ('NIBS Excellence Fund', 200000.00, 200000.00, '2024/2025', 'institution', 1)
        ");
    }

    private function __construct() {}
    private function __clone() {}
}
