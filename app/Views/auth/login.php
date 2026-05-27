<?php
declare(strict_types=1);
$pageTitle = 'Login — NIBS Bursary Portal';
$bodyClass = 'page-login';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<div class="auth-page">
<div class="auth-container float-in">
    <div class="auth-card">
        <div class="auth-header">
            <img src="https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png"
                 alt="NIBS Technical College"
                 class="auth-logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div style="display:none;font-size:2rem;font-weight:900;color:#dc2626;margin-bottom:1rem;">NIBS</div>
            <h1>Welcome Back</h1>
            <p>Sign in to your bursary portal</p>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="alert-box alert-error" role="alert">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
        <div class="alert-box alert-success" role="alert">Registration successful! Please log in.</div>
        <?php endif; ?>

        <?php if (isset($_GET['timeout'])): ?>
        <div class="alert-box alert-warning" role="alert">Session timed out. Please log in again.</div>
        <?php endif; ?>

        <form method="POST" action="/login" class="auth-form" id="login-form" aria-label="Login form">
            <?= CsrfMiddleware::field() ?>
            <div class="form-group">
                <label for="index_number">Index Number</label>
                <div class="input-wrap">
                    <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-id-card"></i></span>
                    <input type="text" id="index_number" name="index_number"
                           placeholder="e.g. STUD001"
                           value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                           required autocomplete="username"
                           aria-required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password" name="password"
                           placeholder="Your password" required autocomplete="current-password"
                           aria-required="true">
                    <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password visibility"><i class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <button type="submit" class="btn-auth" id="login-btn">
                <span>Sign In</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/register">Register here</a></p>
            <p class="mt-2">Support: +254 111 030 100</p>
            <p class="mt-2" style="margin-top:0.75rem;"><a href="index.php" style="color:rgba(148,163,184,0.6);font-size:0.85rem;text-decoration:none;"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Home</a></p>
        </div>
    </div>
</div>
</div>

<script>
function togglePassword(id) {
    const f = document.getElementById(id);
    if (f) f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
