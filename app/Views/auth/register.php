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
            <img src="https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png"
                 alt="NIBS Technical College"
                 class="auth-logo"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div style="display:none;font-size:2rem;font-weight:900;color:#c084fc;margin-bottom:1rem;">NIBS</div>
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
                               value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>"
                               placeholder="John Doe" required aria-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="index_number">Index Number</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-hashtag"></i></span>
                        <input type="text" id="index_number" name="index_number"
                               value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                               placeholder="e.g. STUD001" required aria-required="true">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" id="email" name="email"
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                               placeholder="name@nibs.ac.ke" required aria-required="true"
                               autocomplete="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-phone"></i></span>
                        <input type="tel" id="phone" name="phone"
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                               placeholder="+254 700 000 000" required aria-required="true"
                               autocomplete="tel">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="password" name="password"
                               placeholder="Min. 8 characters" required minlength="8" aria-required="true"
                               autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password visibility"><i class="fa-solid fa-eye"></i></button>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <div class="input-wrap">
                        <span class="input-icon" aria-hidden="true"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Repeat password" required minlength="8" aria-required="true"
                               autocomplete="new-password">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-auth" id="register-btn">
                <span>Create Account</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </form>

        <div class="auth-footer">
            <p>Already have an account? <a href="/login">Login here</a></p>
            <p class="mt-2">Support: +254 111 030 100</p>
            <p class="mt-2" style="margin-top:0.75rem;"><a href="index.php" style="color:rgba(255,255,255,0.4);font-size:0.85rem;text-decoration:none;"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back to Home</a></p>
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
