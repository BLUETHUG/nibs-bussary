<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Helpers\Validator;
use App\Helpers\AuditLogger;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Models\Application;
use App\Models\BursaryFund;

class AdminController {

    public function dashboard(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        
        $db = Database::getConnection();
        
        $stats = [
            'total'      => $db->query("SELECT COUNT(*) FROM applications")->fetchColumn(),
            'pending'    => $db->query("SELECT COUNT(*) FROM applications WHERE status='pending'")->fetchColumn(),
            'approved'   => $db->query("SELECT COUNT(*) FROM applications WHERE status='approved'")->fetchColumn(),
            'disbursed'  => $db->query("SELECT COUNT(*) FROM applications WHERE status='disbursed'")->fetchColumn(),
            'rejected'   => $db->query("SELECT COUNT(*) FROM applications WHERE status='rejected'")->fetchColumn(),
            'total_disbursed' => $db->query("SELECT COALESCE(SUM(amount),0) FROM disbursements")->fetchColumn(),
        ];
        
        $recentApps = $db->query("
            SELECT a.*, u.full_name, u.index_number, s.course
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            ORDER BY a.created_at DESC LIMIT 10
        ")->fetchAll();
        
        $funds = BursaryFund::all();
        
        require __DIR__ . '/../Views/admin/dashboard.php';
    }

    public function applications(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        
        $db     = Database::getConnection();
        $search = Validator::clean($_GET['search'] ?? '');
        $status = Validator::clean($_GET['status'] ?? '');
        
        $sql = "
            SELECT a.*, u.full_name, u.index_number, s.course, s.year_of_study
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE 1=1
        ";
        $params = [];
        
        if ($search) {
            $sql .= " AND (u.full_name LIKE ? OR u.index_number LIKE ? OR s.course LIKE ?)";
            $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
        }
        if ($status) {
            $sql .= " AND a.status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY a.created_at DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $applications = $stmt->fetchAll();
        
        require __DIR__ . '/../Views/admin/applications.php';
    }

    public function review(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        
        $id          = (int) ($_GET['id'] ?? 0);
        $application = Application::find($id);
        if (!$application) { http_response_code(404); die('Application not found'); }
        
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT s.*, u.full_name, u.email, u.index_number FROM students s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
        $stmt->execute([$application->student_id]);
        $student = $stmt->fetch();
        
        $stmt = $db->prepare("SELECT cs.*, u.full_name as member_name FROM committee_scores cs JOIN users u ON cs.member_id = u.id WHERE cs.application_id = ?");
        $stmt->execute([$id]);
        $scores = $stmt->fetchAll();
        
        require __DIR__ . '/../Views/admin/review.php';
    }

    public function approve(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        CsrfMiddleware::validate();
        
        $id     = (int) ($_POST['id'] ?? 0);
        $amount = (float) ($_POST['amount_approved'] ?? 0);
        $app    = Application::find($id);
        
        if ($app && $amount > 0) {
            $app->status         = 'approved';
            $app->amount_approved = $amount;
            $app->reviewed_by    = $_SESSION['user_id'];
            $app->save();
            
            // Notify student
            $db   = Database::getConnection();
            $stmt = $db->prepare("SELECT u.id FROM students s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
            $stmt->execute([$app->student_id]);
            $userId = $stmt->fetchColumn();
            $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?,?,?)")
               ->execute([$userId, 'Application Approved', "Congratulations! Your bursary application has been approved for KSh " . number_format($amount, 2)]);
        }
        
        header('Location: /admin/applications?approved=1');
        exit;
    }

    public function reject(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        CsrfMiddleware::validate();
        
        $id     = (int) ($_POST['id'] ?? 0);
        $reason = Validator::clean($_POST['reason'] ?? '');
        $app    = Application::find($id);
        
        if ($app) {
            $app->status           = 'rejected';
            $app->rejection_reason = $reason;
            $app->reviewed_by      = $_SESSION['user_id'];
            $app->save();
            
            $db   = Database::getConnection();
            $stmt = $db->prepare("SELECT u.id FROM students s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
            $stmt->execute([$app->student_id]);
            $userId = $stmt->fetchColumn();
            $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?,?,?)")
               ->execute([$userId, 'Application Update', 'Unfortunately your bursary application was not successful. Reason: ' . $reason]);
        }
        
        header('Location: /admin/applications?rejected=1');
        exit;
    }

    public function disburse(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'accountant');
        CsrfMiddleware::validate();
        
        $id     = (int) ($_POST['application_id'] ?? 0);
        $method = Validator::clean($_POST['payment_method'] ?? 'cash');
        $notes  = Validator::clean($_POST['notes'] ?? '');
        $app    = Application::find($id);
        
        if ($app && $app->status === 'approved') {
            $db  = Database::getConnection();
            $ref = strtoupper(bin2hex(random_bytes(6)));
            
            $db->prepare("INSERT INTO disbursements (application_id, amount, payment_method, disbursed_by, reference_number, notes) VALUES (?,?,?,?,?,?)")
               ->execute([$id, $app->amount_approved, $method, $_SESSION['user_id'], $ref, $notes]);
            
            $app->status = 'disbursed';
            $app->save();
            
            $stmt = $db->prepare("SELECT u.id FROM students s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
            $stmt->execute([$app->student_id]);
            $userId = $stmt->fetchColumn();
            $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?,?,?)")
               ->execute([$userId, 'Funds Disbursed', "KSh " . number_format($app->amount_approved, 2) . " has been disbursed to you. Ref: $ref"]);
        }
        
        header('Location: /admin/applications?disbursed=1');
        exit;
    }

    public function funds(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        
        $funds = BursaryFund::all();
        require __DIR__ . '/../Views/admin/funds.php';
    }

    public function createFund(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        CsrfMiddleware::validate();
        
        $errors = Validator::validateRequired($_POST, ['fund_name','total_amount','academic_year','source']);
        if (empty($errors)) {
            $fund = new BursaryFund();
            $fund->fund_name       = Validator::clean($_POST['fund_name']);
            $fund->total_amount    = (float) $_POST['total_amount'];
            $fund->available_amount = $fund->total_amount;
            $fund->academic_year   = Validator::clean($_POST['academic_year']);
            $fund->source          = Validator::clean($_POST['source']);
            $fund->created_by      = $_SESSION['user_id'];
            $fund->save();
        }
        
        header('Location: /admin/funds');
        exit;
    }

    public function announcements(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer');
        
        $db            = Database::getConnection();
        $announcements = $db->query("SELECT a.*, u.full_name FROM announcements a JOIN users u ON a.posted_by = u.id ORDER BY a.created_at DESC")->fetchAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();
            $db->prepare("INSERT INTO announcements (title, body, posted_by) VALUES (?,?,?)")
               ->execute([Validator::clean($_POST['title']), Validator::clean($_POST['body']), $_SESSION['user_id']]);
            header('Location: /admin/announcements');
            exit;
        }
        
        require __DIR__ . '/../Views/admin/announcements.php';
    }

    public function users(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        
        $db    = Database::getConnection();
        $users = $db->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
        require __DIR__ . '/../Views/admin/users.php';
    }
}
