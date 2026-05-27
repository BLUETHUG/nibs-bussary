<?php
require_once __DIR__ . '/db.php';

try {
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        role TEXT DEFAULT 'student' CHECK(role IN ('student', 'admin', 'tech'))
    )");

    // Create contact_messages table
    $pdo->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        subject TEXT NOT NULL,
        message TEXT NOT NULL,
        status TEXT DEFAULT 'new' CHECK(status IN ('new', 'replied', 'archived')),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create notifications table
    $pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        title TEXT NOT NULL,
        message TEXT NOT NULL,
        is_read INTEGER DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // Create applications table
    $pdo->exec("CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        student_id_number TEXT NOT NULL,
        course TEXT NOT NULL,
        amount_requested REAL NOT NULL,
        reason TEXT NOT NULL,
        status TEXT DEFAULT 'pending' CHECK(status IN ('pending', 'approved', 'rejected')),
        application_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // Insert a default admin account
    $admin_password = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = 'admin@nibs.ac.ke'");
    $stmt->execute();
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Admin', 'admin@nibs.ac.ke', $admin_password, 'admin']);
    }

    echo "Database setup completed successfully.\n";
} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>
