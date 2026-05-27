<?php
// Migrate users from legacy bursary.sqlite to unified storage/mvc.sqlite
$old_file = __DIR__ . '/backend/bursary.sqlite';
$new_file = __DIR__ . '/storage/mvc.sqlite';

if (!file_exists($old_file)) { die("No legacy database found at $old_file\n"); }
if (!file_exists($new_file)) { die("No MVC database found at $new_file\n"); }

$old = new PDO("sqlite:$old_file");
$old->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$new = new PDO("sqlite:$new_file");
$new->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Ensure MVC schema exists
$new->exec("CREATE TABLE IF NOT EXISTS users (
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

$oldUsers = $old->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$migrated = 0;
$skipped = 0;

foreach ($oldUsers as $u) {
    $check = $new->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$u['email']]);
    if ($check->fetch()) {
        $skipped++;
        continue;
    }
    $ins = $new->prepare("INSERT INTO users (full_name, index_number, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?, ?)");
    $ins->execute([
        $u['name'] ?? 'User',
        $u['email'],
        $u['email'],
        '0700000000',
        $u['password'],
        $u['role'] ?? 'student'
    ]);
    $migrated++;
}

echo "Migration complete: $migrated migrated, $skipped skipped (already existed).\n";
