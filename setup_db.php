<?php
// setup_db.php
$config = require __DIR__ . '/config/database.php';
$dsn = "mysql:host={$config['host']};charset={$config['charset']}";
$pdo = new PDO($dsn, $config['username'], $config['password']);
$pdo->exec("CREATE DATABASE IF NOT EXISTS `{$config['dbname']}`");
$pdo->exec("USE `{$config['dbname']}`");

$schema = file_get_contents(__DIR__ . '/database/schema.sql');
$pdo->exec($schema);

echo "Database setup successful!\n";
