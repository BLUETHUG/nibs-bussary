<?php
$legacy_file = __DIR__ . '/bursary.sqlite';
$dsn = "sqlite:$legacy_file";

try {
    $legacy_pdo = new PDO($dsn);
    $legacy_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $legacy_pdo->exec('PRAGMA foreign_keys = ON');
} catch (PDOException $e) {
    die(json_encode(['error' => 'Legacy database connection failed: ' . $e->getMessage()]));
}
