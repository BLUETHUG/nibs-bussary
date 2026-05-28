<?php
declare(strict_types=1);
$pageTitle = 'Register — NIBS Bursary Portal';
$bodyClass = 'page-register';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<div class="auth-page">
<div class="auth-container wide float-in">
    <div class="auth-card">
        <div class="auth-header">
            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" class="auth-logo">
                <rect width="56" height="56" rx="14" fill="url(#areg)"/>
                <defs><linearGradient id="areg" x1="0" y1="0" x2="56" y2="56"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#fff" font-family="Inter">N</text>
            </svg>
            <h1>Create Account</h1>
            <p>Join the NIBS Bursary Portal</p>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="alert-box alert-error" role="alert">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="/register" class="auth-form" id="register-form" aria-label="Registration form">
            <?= CsrfMiddleware::field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-user"></i></span>
                        <input type="text" id="full_name" name="full_name"
                               placeholder="John Doe"
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>"
                               required autocomplete="name" aria-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="index_number">Index Number</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-id-card"></i></span>
                        <input type="text" id="index_number" name="index_number"
                               placeholder="e.g. STUD001"
                               value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                               required autocomplete="off" aria-required="true">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               placeholder="name@nibs.ac.ke"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               required autocomplete="email" aria-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" id="phone" name="phone"
                               placeholder="+254 7XX XXX XXX"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                               required autocomplete="tel" aria-required="true">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="password" name="password"
                               placeholder="Min. 6 characters" required
                               autocomplete="new-password" aria-required="true">
                        <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password visibility"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-check"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Repeat password" required
                               autocomplete="new-password" aria-required="true">
                        <button type="button" class="toggle-pw" onclick="togglePassword('confirm_password')" aria-label="Toggle password visibility"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-auth" id="register-btn">
                <span class="btn-text">Create Account</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/login">Login here</a></p>
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

document.getElementById('register-form')?.addEventListener('submit', function() {
    var btn = document.getElementById('register-btn');
    btn.classList.add('loading');
});
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
