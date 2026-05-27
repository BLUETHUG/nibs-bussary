<?php
require __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact-us.php');
    exit;
}

$token = $_POST['_csrf_token'] ?? '';
if (empty($_SESSION['_old_csrf_token']) || !hash_equals($_SESSION['_old_csrf_token'], $token)) {
    header('Location: ../contact-us.php?error=1');
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    header('Location: ../contact-us.php?error=1');
    exit;
}

$sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$name, $email, $subject, $message])) {
    header('Location: ../contact-us.php?success=1');
} else {
    header('Location: ../contact-us.php?error=1');
}
exit;
