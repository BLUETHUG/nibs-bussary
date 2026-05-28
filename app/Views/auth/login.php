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
            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" class="auth-logo">
                <rect width="56" height="56" rx="14" fill="url(#alogin)"/>
                <defs><linearGradient id="alogin" x1="0" y1="0" x2="56" y2="56"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#fff" font-family="Inter">N</text>
            </svg>
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
                <span class="btn-text">Sign In</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <div class="auth-footer">
            <p>Don't have an account? <a href="/register">Register here</a></p>
            <p class="mt-2">Support: +254 111 030 100</p>
            <p class="mt-2" style="margin-top:0.75rem;"><a href="index.php" style="color:rgba(168,162,158,0.6);font-size:0.85rem;text-decoration:none;"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Home</a></p>
        </div>
    </div>
</div>
</div>

<script>
function togglePassword(id) {
    var f = document.getElementById(id);
    if (f) f.type = f.type === 'password' ? 'text' : 'password';
}

// Loading state on submit
document.getElementById('login-form')?.addEventListener('submit', function() {
    var btn = document.getElementById('login-btn');
    btn.classList.add('loading');
});
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
