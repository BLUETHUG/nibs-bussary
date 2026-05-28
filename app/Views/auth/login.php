<?php
declare(strict_types=1);
$pageTitle = 'Login — NIBS Bursary Portal';
$bodyClass = 'page-login';
use App\Middleware\CsrfMiddleware;
ob_start();
?>

<div style="min-height:100vh;display:flex;flex-direction:column;background:var(--bg);">
    <nav class="glass-nav" style="margin-top:0.75rem;justify-content:space-between;padding:0.75rem 1.5rem;">
        <a href="/" style="display:flex;align-items:center;gap:0.6rem;text-decoration:none;">
            <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
                <rect width="34" height="34" rx="8" fill="url(#lnlogo)"/>
                <defs><linearGradient id="lnlogo" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#fff" font-family="Inter">N</text>
            </svg>
            <span style="font-weight:700;font-size:0.95rem;color:var(--text);">NIBS Bursary Portal</span>
        </a>
        <button class="theme-toggle" id="theme-toggle-login" aria-label="Toggle dark mode">
            <i class="fa-solid fa-moon" id="theme-icon-login"></i>
        </button>
    </nav>

    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;">
        <div style="width:100%;max-width:420px;animation: scaleIn 0.5s var(--spring) forwards;">
            <div class="glass-card" style="padding:2.5rem;">
                <div style="text-align:center;margin-bottom:2rem;">
                    <svg width="52" height="52" viewBox="0 0 56 56" fill="none" style="margin-bottom:0.75rem;">
                        <rect width="56" height="56" rx="14" fill="url(#alogin2)"/>
                        <defs><linearGradient id="alogin2" x1="0" y1="0" x2="56" y2="56"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
                        <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#fff" font-family="Inter">N</text>
                    </svg>
                    <h1 style="font-size:1.4rem;margin-bottom:0.25rem;">Welcome Back</h1>
                    <p style="font-size:0.85rem;color:var(--text-muted);margin:0;">Sign in to your bursary portal</p>
                </div>

                <?php if (!empty($errors)): ?>
                <div class="alert-box alert-error" role="alert" style="margin-bottom:1.5rem;">
                    <?php foreach ($errors as $e): ?>
                        <div><?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['registered'])): ?>
                <div class="alert-box alert-success" role="alert" style="margin-bottom:1.5rem;">Registration successful! Please log in.</div>
                <?php endif; ?>

                <?php if (isset($_GET['timeout'])): ?>
                <div class="alert-box alert-warning" role="alert" style="margin-bottom:1.5rem;">Session timed out. Please log in again.</div>
                <?php endif; ?>

                <form method="POST" action="/login" class="auth-form" id="login-form" aria-label="Login form">
                    <?= CsrfMiddleware::field() ?>
                    <div class="form-group">
                        <label for="index_number">Index Number</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-id-card"></i></span>
                            <input type="text" id="index_number" name="index_number"
                                   placeholder="e.g. STUD001"
                                   value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                                   required autocomplete="username">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="password" name="password"
                                   placeholder="Your password" required autocomplete="current-password">
                            <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <label style="display:flex;align-items:center;gap:0.5rem;margin-top:1rem;font-size:0.85rem;color:var(--text-secondary);cursor:pointer;">
                        <input type="checkbox" name="remember_me" value="1" style="width:auto;accent-color:var(--primary);">
                        Remember me for 30 days
                    </label>
                    <button type="submit" class="btn-auth" id="login-btn" style="margin-top:1rem;">
                        <span class="btn-text">Sign In</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </form>

                <div style="text-align:center;margin-top:1.5rem;font-size:0.8rem;color:var(--text-muted);">
                    <p style="margin:0 0 0.25rem 0;">Don't have an account? <a href="/register" style="font-weight:600;">Register here</a></p>
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
document.getElementById('login-form')?.addEventListener('submit', function() {
    document.getElementById('login-btn').classList.add('loading');
});
(function() {
    var saved = localStorage.getItem('nibs-theme');
    if (saved === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    function updateIcon() {
        var icon = document.getElementById('theme-icon-login');
        if (icon) icon.className = 'fa-solid ' + (document.documentElement.getAttribute('data-theme') === 'dark' ? 'fa-sun' : 'fa-moon');
    }
    updateIcon();
    document.getElementById('theme-toggle-login')?.addEventListener('click', function() {
        var html = document.documentElement;
        var isDark = html.getAttribute('data-theme') === 'dark';
        html.setAttribute('data-theme', isDark ? '' : 'dark');
        localStorage.setItem('nibs-theme', isDark ? '' : 'dark');
        updateIcon();
    });
})();
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
