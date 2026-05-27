<?php
$db_file = __DIR__ . '/../storage/mvc.sqlite';
$dsn = "sqlite:$db_file";

try {
    $pdo = new PDO($dsn);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Enable foreign keys
    $pdo->exec('PRAGMA foreign_keys = ON');
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}
?>
