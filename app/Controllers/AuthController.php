<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Helpers\Database;
use App\Helpers\Validator;
use App\Helpers\AuditLogger;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Models\User;

class AuthController {

    public function login(): void {
        AuthMiddleware::guest();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();
            
            $indexNumber = Validator::clean($_POST['index_number'] ?? '');
            $password    = $_POST['password'] ?? '';
            $errors      = Validator::validateRequired($_POST, ['index_number', 'password']);
            
            if (empty($errors)) {
                $user = User::findByIndex($indexNumber) ?? User::findByEmail($indexNumber);
                if ($user && password_verify($password, $user->password_hash)) {
                    session_regenerate_id(true);
                    $_SESSION['user_id']     = $user->id;
                    $_SESSION['role']        = $user->role;
                    $_SESSION['full_name']   = $user->full_name;
                    $_SESSION['last_activity'] = time();
                    
                    AuditLogger::log($user->id, 'LOGIN', 'users', $user->id);
                    
                    match ($user->role) {
                        'admin', 'officer' => header('Location: /admin/dashboard'),
                        'committee'        => header('Location: /committee/dashboard'),
                        'accountant'       => header('Location: /accountant/dashboard'),
                        default            => header('Location: /student/dashboard'),
                    };
                    exit;
                } else {
                    $errors[] = 'Invalid index number or password.';
                }
            }
            
            $this->renderLogin($errors);
            return;
        }
        
        $this->renderLogin();
    }

    public function register(): void {
        AuthMiddleware::guest();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            CsrfMiddleware::validate();
            
            $errors = Validator::validateRequired($_POST, ['full_name','index_number','email','phone','password','confirm_password']);
            
            if ($_POST['password'] !== $_POST['confirm_password']) {
                $errors[] = 'Passwords do not match.';
            }
            if (!Validator::validateEmail($_POST['email'] ?? '')) {
                $errors[] = 'Invalid email address.';
            }
            if (strlen($_POST['password'] ?? '') < 8) {
                $errors[] = 'Password must be at least 8 characters.';
            }
            
            if (empty($errors)) {
                $existing = User::where(['index_number' => $_POST['index_number']]);
                if (!empty($existing)) {
                    $errors[] = 'Index number already registered.';
                } else {
                    $user = new User();
                    $user->full_name     = Validator::clean($_POST['full_name']);
                    $user->index_number  = Validator::clean($_POST['index_number']);
                    $user->email         = Validator::clean($_POST['email']);
                    $user->phone         = Validator::clean($_POST['phone']);
                    $user->password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
                    $user->role          = 'student';
                    $user->is_active     = true;
                    $user->save();
                    
                    // Insert student profile record
                    $db = \App\Helpers\Database::getConnection();
                    $stmt = $db->prepare("INSERT INTO students (user_id, course, year_of_study, gender, date_of_birth, guardian_name, guardian_phone, guardian_monthly_income, family_size) VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->execute([
                        $user->id,
                        Validator::clean($_POST['course'] ?? 'Not specified'),
                        (int)($_POST['year_of_study'] ?? 1),
                        Validator::clean($_POST['gender'] ?? 'male'),
                        $_POST['dob'] ?? date('Y-m-d'),
                        Validator::clean($_POST['guardian_name'] ?? 'N/A'),
                        Validator::clean($_POST['guardian_phone'] ?? '0700000000'),
                        (float)($_POST['guardian_income'] ?? 0),
                        (int)($_POST['family_size'] ?? 1),
                    ]);
                    
                    session_regenerate_id(true);
                    $_SESSION['user_id']     = $user->id;
                    $_SESSION['role']        = 'student';
                    $_SESSION['full_name']   = $user->full_name;
                    $_SESSION['last_activity'] = time();
                    header('Location: /student/dashboard');
                    exit;
                }
            }
            
            require __DIR__ . '/../Views/auth/register.php';
            return;
        }
        
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function logout(): void {
        if (isset($_SESSION['user_id'])) {
            AuditLogger::log($_SESSION['user_id'], 'LOGOUT', 'users', $_SESSION['user_id']);
        }
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

    private function renderLogin(array $errors = []): void {
        require __DIR__ . '/../Views/auth/login.php';
    }
}
