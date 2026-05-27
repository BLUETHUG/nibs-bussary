<?php
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) session_start();

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    parse_str($raw, $data);
    if (empty($data)) $data = $_POST;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$token = $data['_csrf_token'] ?? '';
if (empty($_SESSION['_old_csrf_token']) || !hash_equals($_SESSION['_old_csrf_token'], $token)) {
    echo json_encode(['error' => 'Invalid security token']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Please log in first']);
    exit;
}

$student_id_number = trim($data['reg_number'] ?? '');
$course            = trim($data['course'] ?? '');
$amount_requested  = (float) ($data['fee_balance'] ?? 0);
$reason            = trim($data['hardship_statement'] ?? '');

if (empty($student_id_number) || empty($course) || $amount_requested <= 0 || empty($reason)) {
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO applications (user_id, student_id_number, course, amount_requested, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $student_id_number, $course, $amount_requested, $reason]);
    echo json_encode(['success' => 'Application submitted successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
