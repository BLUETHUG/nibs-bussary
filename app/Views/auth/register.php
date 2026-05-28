<?php
declare(strict_types=1);
$pageTitle = 'Register — NIBS Bursary Portal';
$bodyClass = 'page-register';
use App\Middleware\CsrfMiddleware;
ob_start();
?>

<div style="min-height:100vh;display:flex;flex-direction:column;background:var(--bg);">
    <!-- Floating nav (always visible) -->
    <nav class="glass-nav" style="margin-top:0.75rem;justify-content:center;">
        <a href="/" style="display:flex;align-items:center;gap:0.6rem;text-decoration:none;">
            <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
                <rect width="34" height="34" rx="8" fill="url(#rnlogo)"/>
                <defs><linearGradient id="rnlogo" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#fff" font-family="Inter">N</text>
            </svg>
            <span style="font-weight:700;font-size:0.95rem;color:var(--text);">NIBS Bursary Portal</span>
        </a>
    </nav>

    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
        <div style="width:100%;max-width:600px;animation: fadeInUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards;">
            <div class="glass-card" style="padding:2.5rem;">
                <div style="text-align:center;margin-bottom:2rem;">
                    <svg width="52" height="52" viewBox="0 0 56 56" fill="none" style="margin-bottom:0.75rem;">
                        <rect width="56" height="56" rx="14" fill="url(#areg2)"/>
                        <defs><linearGradient id="areg2" x1="0" y1="0" x2="56" y2="56"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                        <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#fff" font-family="Inter">N</text>
                    </svg>
                    <h1 style="font-size:1.4rem;margin-bottom:0.25rem;">Create Account</h1>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">Join the NIBS Bursary Portal</p>
                </div>

                <?php if (!empty($errors)): ?>
                <div class="alert-box alert-error" role="alert" style="margin-bottom:1.5rem;">
                    <?php foreach ($errors as $e): ?>
                        <div><?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="/register" class="auth-form" id="register-form" aria-label="Registration form">
                    <?= CsrfMiddleware::field() ?>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="full_name">Full Name</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                                <input type="text" id="full_name" name="full_name"
                                       placeholder="John Doe"
                                       value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>"
                                       required autocomplete="name">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="index_number">Index Number</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-id-card"></i></span>
                                <input type="text" id="index_number" name="index_number"
                                       placeholder="e.g. STUD001"
                                       value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                                       required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:1rem;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="email">Email</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" id="email" name="email"
                                       placeholder="name@nibs.ac.ke"
                                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                       required autocomplete="email">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="phone">Phone</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                                <input type="tel" id="phone" name="phone"
                                       placeholder="+254 7XX XXX XXX"
                                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                       required autocomplete="tel">
                            </div>
                        </div>
                    </div>

                    <hr style="margin:1.25rem 0;border:none;border-top:1px solid var(--border);">

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" id="password" name="password"
                                       placeholder="Min. 8 characters" required
                                       autocomplete="new-password">
                                <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="input-wrap">
                                <span class="input-icon"><i class="fa-solid fa-check"></i></span>
                                <input type="password" id="confirm_password" name="confirm_password"
                                       placeholder="Repeat password" required
                                       autocomplete="new-password">
                                <button type="button" class="toggle-pw" onclick="togglePassword('confirm_password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-auth" id="register-btn" style="margin-top:1.5rem;">
                        <span class="btn-text">Create Account</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <div style="text-align:center;margin-top:1.5rem;font-size:0.8rem;color:var(--text-muted);">
                    <p style="margin:0 0 0.25rem 0;">Already have an account? <a href="/login" style="font-weight:600;">Login here</a></p>
                    <p style="margin:0;">Support: +254 111 030 100</p>
                    <p style="margin-top:0.75rem;"><a href="index.php" style="color:var(--text-muted);font-size:0.8rem;text-decoration:none;"><i class="fa-solid fa-arrow-left"></i> Back to Home</a></p>
                </div>
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
    document.getElementById('register-btn').classList.add('loading');
});
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
