<?php
declare(strict_types=1);
$pageTitle = 'Login — NIBS Bursary Portal';
$bodyClass = 'page-login';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<style>

/* ─── Nav ─── */
.login-nav {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 1.5rem;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-sm);
}
.login-nav-brand {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.95rem;
    color: var(--primary);
}

/* ─── Layout ─── */
.login-layout {
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

/* ─── Card ─── */
.login-card {
    width: 100%;
    max-width: 420px;
    background: var(--bg-card);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    padding: 2.5rem;
}
.login-header { text-align: center; margin-bottom: 2rem; }
.login-header-icon {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.5rem;
    color: var(--accent);
}
.login-header h1 { font-size: 1.35rem; color: var(--text); margin: 0 0 0.25rem; font-weight: 700; }
.login-header p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }

/* ─── Alerts ─── */
.login-alert {
    padding: 0.85rem 1rem;
    border-radius: var(--radius);
    margin-bottom: 1.5rem;
    font-size: 0.82rem;
}
.login-alert-error { background: #FFEBEE; color: #EF4444; border-left: 4px solid var(--error); }
.login-alert-success { background: #E8F5E9; color: #22C55E; border-left: 4px solid var(--success); }
.login-alert-warning { background: #EEF2FF; color: #F59E0B; border-left: 4px solid var(--accent-hover); }

/* ─── Floating Labels ─── */
.login-field {
    position: relative;
    margin-bottom: 1.25rem;
}
.login-field label {
    position: absolute;
    left: 14px;
    top: 13px;
    font-size: 0.82rem;
    color: var(--text-muted);
    font-weight: 500;
    pointer-events: none;
    transition: all var(--transition);
    background: var(--bg-card);
    padding: 0 4px;
    z-index: 1;
}
.login-field.float label,
.login-field input:focus + label,
.login-field input:not(:placeholder-shown) + label {
    top: -9px;
    left: 10px;
    font-size: 0.68rem;
    color: var(--primary);
    font-weight: 600;
}
.login-field .input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 0.9rem;
    z-index: 2;
    pointer-events: none;
}
.login-field .input-icon.float-icon {
    top: -9px;
    transform: none;
}
.login-field input {
    width: 100%;
    padding: 13px 14px 11px 40px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: var(--text);
    background: var(--bg-card);
    transition: all var(--transition);
    outline: none;
    box-sizing: border-box;
}
.login-field input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
}
.login-field .toggle-pw {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    padding: 0;
    font-size: 0.9rem;
    z-index: 2;
}
.login-field .toggle-pw:hover { color: var(--text); }

/* ─── Remember Me ─── */
.login-remember {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.82rem;
    color: var(--text-secondary);
    cursor: pointer;
    margin-top: 0.5rem;
}
.login-remember input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: var(--primary);
    cursor: pointer;
}

/* ─── Button ─── */
.login-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.85rem 2rem;
    border: none;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: #fff;
    margin-top: 1.25rem;
}
.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(14,165,233,0.3);
}
.login-btn.loading .btn-text { visibility: hidden; }
.login-btn.loading::after {
    content: '';
    position: absolute;
    width: 20px; height: 20px;
    border: 2px solid transparent;
    border-top-color: #fff;
    border-radius: 50%;
    animation: loginSpin 0.6s linear infinite;
}
@keyframes loginSpin { to { transform: rotate(360deg); } }

/* ─── Footer ─── */
.login-footer { text-align: center; margin-top: 1.5rem; }
.login-footer a { color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.82rem; }
.login-footer a:hover { text-decoration: underline; }
.login-footer p { color: var(--text-muted); margin: 0.25rem 0; font-size: 0.78rem; }

/* ─── Role Login Grid ─── */
.role-login-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    margin-top: 0.75rem;
}
.role-login-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 0.75rem;
    background: #F5F6FA;
    border: 1px solid var(--border);
    border-radius: 10px;
    color: var(--text-secondary);
    font-size: 0.75rem;
    text-decoration: none;
    transition: all var(--transition);
    font-weight: 500;
}
.role-login-btn:hover,
.role-login-btn.active {
    background: var(--primary);
    color: #fff;
    transform: translateY(-1px);
    border-color: var(--primary);
}
.role-login-btn i { font-size: 0.85rem; width: 1.1rem; text-align: center; }

/* ─── Animations ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeUp 0.4s 0.05s both; }
.anim-2 { animation: fadeUp 0.4s 0.15s both; }
.anim-3 { animation: fadeUp 0.4s 0.25s both; }
.anim-4 { animation: fadeUp 0.4s 0.35s both; }
.anim-5 { animation: fadeUp 0.4s 0.45s both; }

/* ─── Mobile ─── */
@media (max-width: 480px) {
    .login-card { padding: 1.5rem; border-radius: var(--radius); }
    .login-layout { padding: 1rem 0.75rem; }
}
</style>

<!-- ─── Nav ─── -->
<nav class="login-nav anim-1">
    <a href="/" class="login-nav-brand">
        <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#lnlogo)"/>
            <defs><linearGradient id="lnlogo" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#0EA5E9"/><stop offset="1" stop-color="#0284C7"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#6366F1" font-family="Poppins">N</text>
        </svg>
        NIBS Bursary Portal
    </a>
</nav>

<div class="login-layout">
    <div class="login-card anim-2">
        <div class="login-header">
            <div class="login-header-icon"><i class="fa-solid fa-graduation-cap"></i></div>
            <h1>Welcome Back</h1>
            <p>Sign in to your bursary portal</p>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="login-alert login-alert-error anim-3">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
        <div class="login-alert login-alert-success anim-3">Registration successful! Please log in.</div>
        <?php endif; ?>

        <?php if (isset($_GET['timeout'])): ?>
        <div class="login-alert login-alert-warning anim-3">Session timed out. Please log in again.</div>
        <?php endif; ?>

        <form method="POST" action="/login" id="login-form" aria-label="Login form">
            <?= CsrfMiddleware::field() ?>
            <div class="login-field anim-3" id="field-index">
                <span class="input-icon"><i class="fa-solid fa-id-card"></i></span>
                <input type="text" id="index_number" name="index_number"
                       placeholder=" "
                       value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                       required autocomplete="username">
                <label for="index_number">Index Number or Email</label>
            </div>
            <div class="login-field anim-4" id="field-password">
                <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                <input type="password" id="password" name="password"
                       placeholder=" " required autocomplete="current-password">
                <label for="password">Password</label>
                <button type="button" class="toggle-pw" onclick="togglePassword('password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
            </div>
            <label class="login-remember anim-4">
                <input type="checkbox" name="remember_me" value="1">
                Remember me for 30 days
            </label>
            <button type="submit" class="login-btn anim-4" id="login-btn">
                <span class="btn-text">Sign In</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer anim-5">
            <p>Don't have an account? <a href="/register">Register here</a></p>
            <p style="font-size:0.75rem;">Support: +254 111 030 100</p>

            <div style="margin-top:0.75rem;border-top:1px solid var(--border);padding-top:0.75rem;">
                <p style="font-size:0.7rem;color:var(--text-muted);margin-bottom:0.5rem;">Quick Login by Role</p>
                <div class="role-login-grid" id="role-login-grid">
                    <button type="button" class="role-login-btn" data-role="student" data-hint="student@nibs.ac.ke"><i class="fa-solid fa-graduation-cap" style="color:var(--primary);"></i> Student</button>
                    <button type="button" class="role-login-btn" data-role="admin" data-hint="admin@nibs.ac.ke"><i class="fa-solid fa-shield-hooded" style="color:#F59E0B;"></i> Admin</button>
                    <button type="button" class="role-login-btn" data-role="committee" data-hint="Committee member"><i class="fa-solid fa-users" style="color:var(--success);"></i> Committee</button>
                    <button type="button" class="role-login-btn" data-role="accountant" data-hint="Accountant"><i class="fa-solid fa-calculator" style="color:#1E88E5;"></i> Accountant</button>
                </div>
            </div>

            <p style="margin-top:0.75rem;"><a href="/" style="color:var(--text-muted);font-size:0.78rem;"><i class="fa-solid fa-arrow-left"></i> Back to Home</a></p>
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

// ─── Floating Labels ───
document.querySelectorAll('.login-field input').forEach(function(el) {
    el.addEventListener('focus', function() {
        this.closest('.login-field').classList.add('float');
    });
    el.addEventListener('blur', function() {
        if (!this.value || this.value === '') {
            this.closest('.login-field').classList.remove('float');
        }
    });
    if (el.value && el.value !== '') {
        el.closest('.login-field').classList.add('float');
    }
});

// ─── Role Selection ───
document.getElementById('role-login-grid')?.addEventListener('click', function(e) {
    var btn = e.target.closest('.role-login-btn');
    if (!btn) return;
    document.querySelectorAll('.role-login-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
    var input = document.getElementById('index_number');
    if (input) {
        input.value = btn.getAttribute('data-hint') || '';
        input.dispatchEvent(new Event('focus'));
        input.setSelectionRange(0, input.value.length);
    }
    document.getElementById('field-index')?.classList.add('float');
});
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
