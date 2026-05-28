<?php
$dbPath = __DIR__ . '/storage/mvc.sqlite';
$dir = dirname($dbPath);
if (!is_dir($dir)) mkdir($dir, 0777, true);

$pdo = new PDO("sqlite:$dbPath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    full_name TEXT NOT NULL,
    index_number TEXT UNIQUE NOT NULL,
    email TEXT UNIQUE NOT NULL,
    phone TEXT NOT NULL,
    password_hash TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'student',
    is_active INTEGER DEFAULT 1,
    email_verified_at TEXT,
    last_login_at TEXT,
    login_attempts INTEGER DEFAULT 0,
    locked_until TEXT,
    created_at TEXT DEFAULT (datetime('now')),
    updated_at TEXT DEFAULT (datetime('now'))
)");

// Migration: add columns if upgrading from older schema
try { $pdo->exec("ALTER TABLE users ADD COLUMN email_verified_at TEXT"); } catch (PDOException $e) {}
try { $pdo->exec("ALTER TABLE users ADD COLUMN last_login_at TEXT"); } catch (PDOException $e) {}
try { $pdo->exec("ALTER TABLE users ADD COLUMN login_attempts INTEGER DEFAULT 0"); } catch (PDOException $e) {}
try { $pdo->exec("ALTER TABLE users ADD COLUMN locked_until TEXT"); } catch (PDOException $e) {}
// Migration: add user_agent column to audit_logs
try { $pdo->exec("ALTER TABLE audit_logs ADD COLUMN user_agent TEXT"); } catch (PDOException $e) {}
// Migration: add bank details to students
try { $pdo->exec("ALTER TABLE students ADD COLUMN bank_name TEXT"); } catch (PDOException $e) {}
try { $pdo->exec("ALTER TABLE students ADD COLUMN bank_account TEXT"); } catch (PDOException $e) {}
try { $pdo->exec("ALTER TABLE students ADD COLUMN mpesa_phone TEXT"); } catch (PDOException $e) {}

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
    photo_path TEXT,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

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
    user_agent TEXT,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
)");

// Auth security tables
$pdo->exec("CREATE TABLE IF NOT EXISTS login_attempts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL,
    ip_address TEXT NOT NULL,
    attempted_at TEXT DEFAULT (datetime('now')),
    success INTEGER DEFAULT 0
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS email_verifications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    token TEXT NOT NULL,
    expires_at TEXT NOT NULL,
    verified_at TEXT,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS remember_tokens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    token_hash TEXT NOT NULL,
    expires_at TEXT NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS bursary_cycles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    academic_year TEXT NOT NULL,
    application_start TEXT NOT NULL,
    application_end TEXT NOT NULL,
    is_open INTEGER DEFAULT 0,
    max_applications_per_student INTEGER DEFAULT 1,
    created_by INTEGER NOT NULL,
    created_at TEXT DEFAULT (datetime('now')),
    FOREIGN KEY (created_by) REFERENCES users(id)
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

// Seed test users
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
if ($stmt->fetchColumn() == 0) {
    $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
    $adminPw = password_hash('admin123', $algo);
    $studentPw = password_hash('student123', $algo);
    $testPw = password_hash('password123', $algo);

    $pdo->exec("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES
        ('System Admin', 'ADM001', 'admin@nibs.ac.ke', '0712345678', '$adminPw', 'admin'),
        ('John Doe', 'STUD001', 'student001@nibs.ac.ke', '0752345678', '$studentPw', 'student'),
        ('Jane Smith', 'STUD002', 'student002@nibs.ac.ke', '0762345678', '$studentPw', 'student'),
        ('Test Student', 'TEST001', 'test@nibs.ac.ke', '0700000000', '$testPw', 'student')
    ");

    $pdo->exec("INSERT INTO students (user_id, course, year_of_study, gender, date_of_birth, guardian_name, guardian_phone, guardian_monthly_income, family_size) VALUES
        (2, 'Computer Science', 2, 'male', '2004-05-15', 'Mark Doe', '0711111111', 15000.00, 4),
        (3, 'Business Management', 1, 'female', '2005-08-20', 'Mary Smith', '0722222222', 12000.00, 5),
        (4, 'Information Technology', 2, 'male', '2003-05-20', 'Parent Test', '0700000000', 15000.00, 4)
    ");

    $pdo->exec("INSERT INTO bursary_funds (fund_name, total_amount, available_amount, academic_year, source, created_by) VALUES
        ('Government Helb Supplement', 500000.00, 500000.00, '2024/2025', 'government', 1),
        ('NIBS Excellence Fund', 200000.00, 200000.00, '2024/2025', 'institution', 1)
    ");

    echo "Database initialized and seeded successfully.\n";
} else {
    echo "Database already has data, skipping seed.\n";
}
