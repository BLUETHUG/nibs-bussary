<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Helpers\Validator;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Models\Application;
use App\Models\BursaryFund;

class StudentController {

    public function dashboard(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('student');
        
        $db        = Database::getConnection();
        $studentId = $this->getStudentId();
        
        $stmt = $db->prepare("SELECT * FROM applications WHERE student_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$studentId]);
        $applications = $stmt->fetchAll();
        
        $stmt = $db->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $notifications = $stmt->fetchAll();
        
        $stmt = $db->prepare("SELECT * FROM announcements WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3");
        $stmt->execute();
        $announcements = $stmt->fetchAll();
        
        $stmt = $db->prepare("SELECT bank_name, bank_account, mpesa_phone FROM students WHERE id = ?");
        $stmt->execute([$studentId]);
        $bankDetails = $stmt->fetch();
        
        require __DIR__ . '/../Views/student/dashboard.php';
    }

    public function saveBankDetails(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('student');
        CsrfMiddleware::validate();
        
        $db        = Database::getConnection();
        $studentId = $this->getStudentId();
        
        $bankName    = Validator::clean($_POST['bank_name'] ?? '');
        $bankAccount = Validator::clean($_POST['bank_account'] ?? '');
        $mpesaPhone  = Validator::clean($_POST['mpesa_phone'] ?? '');
        
        $stmt = $db->prepare("UPDATE students SET bank_name = ?, bank_account = ?, mpesa_phone = ? WHERE id = ?");
        $stmt->execute([$bankName, $bankAccount, $mpesaPhone, $studentId]);
        
        header('Location: /student/dashboard?saved=1');
        exit;
    }

    public function apply(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('student');
        
        $db        = Database::getConnection();
        $studentId = $this->getStudentId();
        
        // Check for active bursary cycle
        $stmt = $db->prepare("SELECT * FROM bursary_cycles WHERE is_open = 1 AND application_start <= date('now') AND application_end >= date('now') ORDER BY application_end ASC LIMIT 1");
        $stmt->execute();
        $activeCycle = $stmt->fetch();
        
        if ($activeCycle) {
            $academicYear = $activeCycle['academic_year'];
        } else {
            $academicYear = date('Y') . '/' . (date('Y') + 1);
        }
        
        $funds = BursaryFund::where(['academic_year' => $academicYear]);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();
            
            // Re-check cycle on submit
            if (!$activeCycle) {
                $errors[] = 'No active application cycle is open at this time. Please check back during the application period.';
                require __DIR__ . '/../Views/student/apply.php';
                return;
            }
            
            // Check max applications per student
            $stmt = $db->prepare("SELECT COUNT(*) FROM applications WHERE student_id = ? AND academic_year = ?");
            $stmt->execute([$studentId, $academicYear]);
            $appCount = (int)$stmt->fetchColumn();
            if ($appCount >= (int)$activeCycle['max_applications_per_student']) {
                $errors[] = 'You have reached the maximum number of applications (' . $activeCycle['max_applications_per_student'] . ') for this cycle.';
                require __DIR__ . '/../Views/student/apply.php';
                return;
            }
            
            $errors = Validator::validateRequired($_POST, ['fund_id','amount_requested','academic_year']);
            
            if (empty($errors)) {
                $docPath = null;
                if (!empty($_FILES['supporting_doc']['name'])) {
                    $docPath = $this->uploadDoc($_FILES['supporting_doc']);
                    if (!$docPath) $errors[] = 'Document upload failed. Max 5MB PDF/JPG only.';
                }
            }
            
            if (empty($errors)) {
                $app = new Application();
                $app->student_id          = $studentId;
                $app->fund_id             = (int) $_POST['fund_id'];
                $app->academic_year       = Validator::clean($_POST['academic_year']);
                $app->amount_requested    = (float) $_POST['amount_requested'];
                $app->special_circumstances = Validator::clean($_POST['special_circumstances'] ?? '');
                $app->supporting_doc_path = $docPath;
                $app->amount_approved     = 0;
                $app->status              = 'pending';
                $app->save();
                
                // Send notification
                $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], 'Application Received', 'Your bursary application has been submitted and is pending review.']);
                
                header('Location: /student/status?success=1');
                exit;
            }
        }
        
        require __DIR__ . '/../Views/student/apply.php';
    }

    public function status(): void {
        AuthMiddleware::require();
        RoleMiddleware::require('student');
        
        $studentId    = $this->getStudentId();
        $applications = Application::byStudent($studentId);
        
        require __DIR__ . '/../Views/student/status.php';
    }

    private function getStudentId(): int {
        $db   = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM students WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $row  = $stmt->fetch();
        return $row ? (int)$row['id'] : 0;
    }

    private function uploadDoc(array $file): ?string {
        $maxSize  = 5 * 1024 * 1024;
        $allowed  = ['image/jpeg','image/png','application/pdf'];
        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if ($file['size'] > $maxSize || !in_array($mimeType, $allowed, true)) return null;
        
        $ext      = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = bin2hex(random_bytes(16)) . '.' . $ext;
        $dest     = __DIR__ . '/../../storage/uploads/' . $filename;
        
        if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
        
        return move_uploaded_file($file['tmp_name'], $dest) ? $filename : null;
    }
}
