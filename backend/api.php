<?php
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($action === 'apply' && $role === 'student') {
        apply($data, $user_id, $pdo);
    } elseif ($action === 'update_status' && $role === 'admin') {
        update_status($data, $pdo);
    } else {
        echo json_encode(['error' => 'Invalid action or unauthorized']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($action === 'get_applications') {
        get_applications($user_id, $role, $pdo);
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
}

function apply($data, $user_id, $pdo) {
    if (empty($data['student_id_number']) || empty($data['course']) || empty($data['amount_requested']) || empty($data['reason'])) {
        echo json_encode(['error' => 'All fields are required']);
        return;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO applications (user_id, student_id_number, course, amount_requested, reason) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $data['student_id_number'], $data['course'], $data['amount_requested'], $data['reason']]);
        echo json_encode(['success' => 'Application submitted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function update_status($data, $pdo) {
    if (empty($data['application_id']) || empty($data['status'])) {
        echo json_encode(['error' => 'Application ID and status are required']);
        return;
    }

    if (!in_array($data['status'], ['approved', 'rejected'])) {
        echo json_encode(['error' => 'Invalid status']);
        return;
    }

    try {
        $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->execute([$data['status'], $data['application_id']]);
        echo json_encode(['success' => 'Application status updated successfully']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}

function get_applications($user_id, $role, $pdo) {
    try {
        if ($role === 'admin') {
            // Admin sees all applications
            $stmt = $pdo->query("SELECT applications.*, users.name as student_name FROM applications JOIN users ON applications.user_id = users.id ORDER BY application_date DESC");
            $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Student sees only their applications
            $stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY application_date DESC");
            $stmt->execute([$user_id]);
            $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode(['applications' => $applications]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
