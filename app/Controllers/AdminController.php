<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Helpers\Validator;
use App\Helpers\AuditLogger;
use App\Helpers\NotificationHelper;
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
        
        // Chart data
        $byStatus = $db->query("SELECT status, COUNT(*) as count FROM applications GROUP BY status")->fetchAll();
        $byGender = $db->query("SELECT s.gender, COUNT(*) as count FROM applications a JOIN students s ON a.student_id = s.id GROUP BY s.gender")->fetchAll();
        $byCourse = $db->query("SELECT s.course, COUNT(*) as count FROM applications a JOIN students s ON a.student_id = s.id GROUP BY s.course ORDER BY count DESC LIMIT 8")->fetchAll();
        $monthlyApps = $db->query("SELECT strftime('%Y-%m', created_at) as month, COUNT(*) as count FROM applications GROUP BY month ORDER BY month ASC LIMIT 12")->fetchAll();
        $monthlyDisbursed = $db->query("SELECT strftime('%Y-%m', disbursed_at) as month, SUM(amount) as total FROM disbursements GROUP BY month ORDER BY month ASC LIMIT 12")->fetchAll();
        
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
            
            $db   = Database::getConnection();
            $stmt = $db->prepare("SELECT u.id FROM students s JOIN users u ON s.user_id = u.id WHERE s.id = ?");
            $stmt->execute([$app->student_id]);
            $userId = $stmt->fetchColumn();
            $msg = "Congratulations! Your bursary application has been approved for KSh " . number_format($amount, 2);
            NotificationHelper::send((int)$userId, 'Application Approved', $msg, ['database', 'email']);
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
            $msg = 'Unfortunately your bursary application was not successful. Reason: ' . $reason;
            NotificationHelper::send((int)$userId, 'Application Update', $msg, ['database', 'email']);
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
            $msg = "KSh " . number_format($app->amount_approved, 2) . " has been disbursed to you. Ref: $ref";
            NotificationHelper::send((int)$userId, 'Funds Disbursed', $msg, ['database', 'email']);
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

    public function createUser(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        CsrfMiddleware::validate();

        $errors = Validator::validateRequired($_POST, ['full_name','index_number','email','phone','password','role']);
        $allowedRoles = ['admin', 'officer', 'committee', 'accountant', 'student'];
        $role = $_POST['role'] ?? '';
        if (!in_array($role, $allowedRoles, true)) {
            $errors[] = 'Invalid role selected.';
        }

        if (empty($errors)) {
            $existing = User::where(['index_number' => $_POST['index_number']]);
            if (!empty($existing)) {
                $errors[] = 'Index number already registered.';
            } else {
                $existingEmail = User::where(['email' => $_POST['email']]);
                if (!empty($existingEmail)) {
                    $errors[] = 'Email already registered.';
                }
            }
        }

        if (empty($errors)) {
            $user = new User();
            $user->full_name     = Validator::clean($_POST['full_name']);
            $user->index_number  = Validator::clean($_POST['index_number']);
            $user->email         = Validator::clean($_POST['email']);
            $user->phone         = Validator::clean($_POST['phone']);
            $user->password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user->role          = $role;
            $user->is_active     = true;
            $user->save();

            $_SESSION['flash_message'] = 'User ' . htmlspecialchars($user->full_name) . ' (' . $role . ') created successfully.';
        } else {
            $_SESSION['flash_errors'] = $errors;
        }

        header('Location: /admin/users');
        exit;
    }

    // ─── Bursary Cycles ───
    public function cycles(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        
        $db     = Database::getConnection();
        $cycles = $db->query("SELECT * FROM bursary_cycles ORDER BY created_at DESC")->fetchAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();
            $errors = Validator::validateRequired($_POST, ['name','academic_year','application_start','application_end']);
            if (empty($errors)) {
                $stmt = $db->prepare("INSERT INTO bursary_cycles (name, academic_year, application_start, application_end, max_applications_per_student, created_by) VALUES (?,?,?,?,?,?)");
                $stmt->execute([
                    Validator::clean($_POST['name']),
                    Validator::clean($_POST['academic_year']),
                    $_POST['application_start'],
                    $_POST['application_end'],
                    (int)($_POST['max_applications'] ?? 1),
                    $_SESSION['user_id'],
                ]);
                AuditLogger::log($_SESSION['user_id'], 'CREATE_CYCLE', 'bursary_cycles', (int)$db->lastInsertId());
                header('Location: /admin/cycles?created=1');
                exit;
            }
        }
        
        require __DIR__ . '/../Views/admin/cycles.php';
    }

    public function toggleCycle(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin');
        CsrfMiddleware::validate();
        
        $id    = (int)($_GET['id'] ?? 0);
        $state = (int)($_GET['state'] ?? 0);
        $db    = Database::getConnection();
        $stmt  = $db->prepare("UPDATE bursary_cycles SET is_open = ? WHERE id = ?");
        $stmt->execute([$state, $id]);
        AuditLogger::log($_SESSION['user_id'], $state ? 'CYCLE_OPEN' : 'CYCLE_CLOSE', 'bursary_cycles', $id);
        
        header('Location: /admin/cycles');
        exit;
    }

    // ─── Committee Scoring ───
    public function committee(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'committee');
        
        $db = Database::getConnection();
        
        // Applications pending committee review
        $pending = $db->query("
            SELECT a.*, u.full_name, u.index_number, s.course, s.year_of_study,
                   COALESCE((SELECT AVG((cs.need_score + cs.academic_score + cs.circumstance_score)/3.0) FROM committee_scores cs WHERE cs.application_id = a.id), 0) as avg_score,
                   (SELECT COUNT(*) FROM committee_scores cs WHERE cs.application_id = a.id) as score_count
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE a.status IN ('pending','under_review')
            ORDER BY a.created_at ASC
        ")->fetchAll();
        
        // Already scored by this user
        $myScores = $db->prepare("SELECT application_id FROM committee_scores WHERE member_id = ?");
        $myScores->execute([$_SESSION['user_id']]);
        $scoredIds = array_column($myScores->fetchAll(), 'application_id');
        
        $myScored = $db->query("
            SELECT a.*, u.full_name, u.index_number, s.course,
                   cs.need_score, cs.academic_score, cs.circumstance_score, cs.recommendation, cs.scored_at
            FROM committee_scores cs
            JOIN applications a ON cs.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            WHERE cs.member_id = {$_SESSION['user_id']}
            ORDER BY cs.scored_at DESC LIMIT 20
        ")->fetchAll();
        
        require __DIR__ . '/../Views/admin/committee.php';
    }

    public function score(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'committee');
        CsrfMiddleware::validate();
        
        $appId      = (int)($_POST['application_id'] ?? 0);
        $needScore  = (int)($_POST['need_score'] ?? 0);
        $acadScore  = (int)($_POST['academic_score'] ?? 0);
        $circScore  = (int)($_POST['circumstance_score'] ?? 0);
        $recommend  = Validator::clean($_POST['recommendation'] ?? '');
        
        if ($needScore < 1 || $needScore > 10 || $acadScore < 1 || $acadScore > 10 || $circScore < 1 || $circScore > 10) {
            header('Location: /admin/committee?error=invalid_score');
            exit;
        }
        
        $db = Database::getConnection();
        
        // Upsert score
        $existing = $db->prepare("SELECT id FROM committee_scores WHERE application_id = ? AND member_id = ?");
        $existing->execute([$appId, $_SESSION['user_id']]);
        $row = $existing->fetch();
        
        if ($row) {
            $stmt = $db->prepare("UPDATE committee_scores SET need_score=?, academic_score=?, circumstance_score=?, recommendation=?, scored_at=datetime('now') WHERE id=?");
            $stmt->execute([$needScore, $acadScore, $circScore, $recommend, $row['id']]);
        } else {
            $stmt = $db->prepare("INSERT INTO committee_scores (application_id, member_id, need_score, academic_score, circumstance_score, recommendation) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$appId, $_SESSION['user_id'], $needScore, $acadScore, $circScore, $recommend]);
        }
        
        // Update application status to under_review if still pending
        $stmt = $db->prepare("UPDATE applications SET status = CASE WHEN status = 'pending' THEN 'under_review' ELSE status END WHERE id = ?");
        $stmt->execute([$appId]);
        
        AuditLogger::log($_SESSION['user_id'], 'SCORE', 'applications', $appId, null, ['need' => $needScore, 'academic' => $acadScore, 'circumstance' => $circScore]);
        
        header('Location: /admin/committee?scored=1');
        exit;
    }

    // ─── Finance Portal ───
    public function finance(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'accountant');
        
        $db = Database::getConnection();
        
        // Approved but not disbursed
        $pendingDisbursements = $db->query("
            SELECT a.*, u.full_name, u.index_number, s.course, s.bank_name, s.bank_account, s.mpesa_phone,
                   f.fund_name
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN bursary_funds f ON a.fund_id = f.id
            WHERE a.status = 'approved'
            ORDER BY a.updated_at ASC
        ")->fetchAll();
        
        // Recent disbursements
        $recent = $db->query("
            SELECT d.*, u.full_name, u.index_number
            FROM disbursements d
            JOIN applications a ON d.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            ORDER BY d.disbursed_at DESC LIMIT 20
        ")->fetchAll();
        
        // Summary
        $summary = [
            'approved_pending'     => $db->query("SELECT COUNT(*) FROM applications WHERE status='approved'")->fetchColumn(),
            'total_disbursed_today' => $db->query("SELECT COALESCE(SUM(amount),0) FROM disbursements WHERE date(disbursed_at) = date('now')")->fetchColumn(),
            'total_disbursed_month' => $db->query("SELECT COALESCE(SUM(amount),0) FROM disbursements WHERE strftime('%Y-%m', disbursed_at) = strftime('%Y-%m', 'now')")->fetchColumn(),
            'payment_methods'       => $db->query("SELECT payment_method, COUNT(*) as count, SUM(amount) as total FROM disbursements GROUP BY payment_method")->fetchAll(),
        ];
        
        require __DIR__ . '/../Views/admin/finance.php';
    }

    public function exportCommitteeCsv(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'officer', 'committee');
        
        $db = Database::getConnection();
        $rows = $db->query("
            SELECT u.full_name, u.index_number, s.course, s.year_of_study,
                   a.academic_year, a.amount_requested, a.status,
                   cs.need_score, cs.academic_score, cs.circumstance_score,
                   ROUND((cs.need_score + cs.academic_score + cs.circumstance_score) / 3.0, 2) as avg_score,
                   cs.recommendation, cs.scored_at
            FROM committee_scores cs
            JOIN applications a ON cs.application_id = a.id
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            ORDER BY cs.scored_at DESC
        ")->fetchAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=committee_scores_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Name','Index No','Course','Year','Acad Year','Amount Requested','Status','Need(1-10)','Academic(1-10)','Circumstance(1-10)','Avg Score','Recommendation','Scored At']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['full_name'],$r['index_number'],$r['course'],$r['year_of_study'],$r['academic_year'],$r['amount_requested'],$r['status'],$r['need_score'],$r['academic_score'],$r['circumstance_score'],$r['avg_score'],$r['recommendation'],$r['scored_at']]);
        }
        fclose($out);
        exit;
    }

    public function exportFinanceCsv(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('admin', 'accountant');
        
        $db = Database::getConnection();
        $rows = $db->query("
            SELECT u.full_name, u.index_number, s.course,
                   a.academic_year, a.amount_requested, a.amount_approved, a.status,
                   d.amount as disbursed_amount, d.payment_method, d.reference_number, d.disbursed_at, d.notes,
                   s.bank_name, s.bank_account, s.mpesa_phone
            FROM applications a
            JOIN students s ON a.student_id = s.id
            JOIN users u ON s.user_id = u.id
            LEFT JOIN disbursements d ON d.application_id = a.id
            ORDER BY COALESCE(d.disbursed_at, a.updated_at) DESC
        ")->fetchAll();
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=finance_report_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Name','Index No','Course','Acad Year','Requested(KES)','Approved(KES)','Status','Disbursed(KES)','Payment Method','Reference','Bank Name','Bank Account','M-Pesa','Disbursed At','Notes']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['full_name'],$r['index_number'],$r['course'],$r['academic_year'],$r['amount_requested'],$r['amount_approved'],$r['status'],$r['disbursed_amount'],$r['payment_method'],$r['reference_number'],$r['bank_name'],$r['bank_account'],$r['mpesa_phone'],$r['disbursed_at'],$r['notes']]);
        }
        fclose($out);
        exit;
    }
}
