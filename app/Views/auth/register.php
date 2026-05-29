<?php
declare(strict_types=1);
$pageTitle = 'Register — NIBS Bursary Portal';
$bodyClass = 'page-register';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --navy: #1A237E; --navy-light: #283593; --navy-dark: #0D1442;
    --gold: #FFD54F; --gold-light: #FFE082; --gold-dark: #FFC107;
    --white: #FAFAFA; --bg-card: #FFFFFF;
    --text-primary: #1A237E; --text-secondary: #546E7A; --text-muted: #90A4AE;
    --border: #E8EAF6; --success: #43A047; --error: #E53935;
    --shadow-sm: 0 2px 8px rgba(26,35,126,0.08);
    --shadow-md: 0 4px 20px rgba(26,35,126,0.12);
    --shadow-lg: 0 8px 40px rgba(26,35,126,0.16);
    --radius: 12px; --radius-lg: 20px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.page-register {
    margin: 0; padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
.reg-nav {
    position: sticky; top: 0; z-index: 1000;
    background: rgba(255,255,255,0.92); backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 1.5rem; height: 60px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: var(--shadow-sm);
}
.reg-nav-brand {
    display: flex; align-items: center; gap: 0.6rem;
    text-decoration: none; font-weight: 700; font-size: 0.95rem; color: var(--navy);
}
.reg-theme-btn {
    background: none; border: 1px solid var(--border); border-radius: 8px;
    width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
    color: var(--text-secondary); cursor: pointer; transition: all var(--transition);
}
.reg-theme-btn:hover { border-color: var(--navy); color: var(--navy); }
.reg-layout {
    min-height: calc(100vh - 60px);
    display: flex; align-items: center; justify-content: center;
    padding: 2rem 1rem;
}
.reg-card {
    width: 100%; max-width: 680px;
    background: var(--bg-card); border-radius: var(--radius-lg);
    box-shadow: var(--shadow-lg); padding: 2.5rem;
    animation: regFadeUp 0.5s cubic-bezier(0.16,1,0.3,1) forwards;
}
@keyframes regFadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
.reg-header { text-align: center; margin-bottom: 2rem; }
.reg-header-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
    border-radius: 14px; display: inline-flex; align-items: center; justify-content: center;
    margin-bottom: 0.75rem;
}
.reg-header h1 { font-size: 1.4rem; font-weight: 700; color: var(--navy); margin: 0 0 0.25rem; }
.reg-header p { font-size: 0.85rem; color: var(--text-muted); margin: 0; }

.reg-alert {
    background: #FFEBEE; border: 1px solid #FFCDD2; border-radius: var(--radius);
    padding: 1rem; margin-bottom: 1.5rem; color: #C62828; font-size: 0.82rem;
}
.reg-alert div { margin-bottom: 0.25rem; }
.reg-alert div:last-child { margin-bottom: 0; }

.reg-form .reg-field {
    position: relative; margin-bottom: 1.25rem;
}
.reg-form label {
    position: absolute; left: 14px; top: 13px;
    font-size: 0.84rem; color: var(--text-muted); font-weight: 500;
    pointer-events: none; transition: all var(--transition);
    background: var(--bg-card); padding: 0 4px; z-index: 1;
}
.reg-form .reg-field.float label,
.reg-form .reg-field input:focus + label,
.reg-form .reg-field select:focus + label,
.reg-form .reg-field input:not(:placeholder-shown) + label {
    top: -9px; left: 10px; font-size: 0.68rem; color: var(--navy); font-weight: 600;
}
.reg-form input, .reg-form select {
    width: 100%; padding: 13px 14px 11px;
    border: 1.5px solid var(--border); border-radius: var(--radius);
    font-family: 'Poppins', sans-serif; font-size: 0.85rem; color: var(--text-primary);
    background: var(--bg-card); transition: all var(--transition); outline: none;
    box-sizing: border-box;
}
.reg-form input:focus, .reg-form select:focus {
    border-color: var(--navy); box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
}
.reg-form .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); z-index: 2; font-size: 0.85rem; }
.reg-form .reg-field.float .input-icon { top: 50%; }
.reg-form .toggle-pw {
    position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
    background: none; border: none; color: var(--text-muted); cursor: pointer; z-index: 2;
}
.reg-form .input-wrap { position: relative; }
.reg-form .input-wrap input { padding-left: 2.5rem; }

.reg-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.reg-divider { margin: 1.5rem 0; border: none; border-top: 1.5px solid var(--border); }
.reg-section-label {
    font-size: 0.82rem; font-weight: 600; color: var(--gold-dark);
    margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
}

.reg-btn {
    width: 100%; padding: 0.9rem; border: none; border-radius: var(--radius);
    font-family: 'Poppins', sans-serif; font-size: 0.95rem; font-weight: 600;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
    color: #fff; transition: all var(--transition); margin-top: 1.5rem;
}
.reg-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(26,35,126,0.3); }
.reg-btn.loading .btn-text { visibility: hidden; }
.reg-btn.loading::after {
    content: ''; position: absolute; width: 20px; height: 20px;
    border: 2px solid transparent; border-top-color: #fff; border-radius: 50%;
    animation: regSpin 0.6s linear infinite;
}
@keyframes regSpin { to { transform: rotate(360deg); } }

.reg-footer { text-align: center; margin-top: 1.5rem; font-size: 0.8rem; }
.reg-footer a { color: var(--navy); font-weight: 600; text-decoration: none; }
.reg-footer a:hover { text-decoration: underline; }
.reg-footer p { color: var(--text-muted); margin: 0.25rem 0; }

.reg-role-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.75rem;
}
.reg-role-link {
    display: flex; align-items: center; gap: 0.4rem;
    padding: 0.5rem 0.75rem; background: var(--border); border-radius: 8px;
    color: var(--text-secondary); font-size: 0.75rem; text-decoration: none;
    transition: all var(--transition);
}
.reg-role-link:hover { background: var(--navy); color: #fff; transform: translateY(-1px); }

.reg-pw-bar { margin-top: 0.4rem; height: 4px; border-radius: 2px; background: var(--border); overflow: hidden; }
.reg-pw-fill { height: 100%; width: 0%; border-radius: 2px; transition: width 0.3s; }
.reg-pw-text { font-size: 0.68rem; color: var(--text-muted); margin-top: 0.2rem; }

.anim-1 { animation: regFadeUp 0.4s 0.05s both; }
.anim-2 { animation: regFadeUp 0.4s 0.15s both; }
.anim-3 { animation: regFadeUp 0.4s 0.25s both; }
.anim-4 { animation: regFadeUp 0.4s 0.35s both; }
.anim-5 { animation: regFadeUp 0.4s 0.45s both; }

@media (max-width: 640px) {
    .reg-card { padding: 1.5rem; border-radius: var(--radius); }
    .reg-row-2 { grid-template-columns: 1fr; }
    .reg-layout { padding: 1rem 0.75rem; }
}
</style>

<nav class="reg-nav anim-1">
    <a href="/" class="reg-nav-brand">
        <svg width="28" height="28" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#rnav)"/>
            <defs><linearGradient id="rnav" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#1A237E"/><stop offset="1" stop-color="#283593"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#FFD54F" font-family="Poppins">N</text>
        </svg>
        NIBS Bursary Portal
    </a>
    <span style="font-size:0.78rem;color:var(--text-muted);">NIBS Technical College</span>
</nav>

<div class="reg-layout">
    <div class="reg-card anim-2">
        <div class="reg-header">
            <div class="reg-header-icon">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"><text x="14" y="20" text-anchor="middle" font-size="18" font-weight="bold" fill="#FFD54F" font-family="Poppins">N</text></svg>
            </div>
            <h1>Create Your Account</h1>
            <p>Join the NIBS Bursary Portal to apply for financial aid</p>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="reg-alert anim-3">
            <?php foreach ($errors as $e): ?>
                <div><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="/register" class="reg-form" id="register-form">
            <?= CsrfMiddleware::field() ?>

            <div class="anim-3">
                <div class="reg-row-2">
                    <div class="reg-field" id="reg-field-name">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" id="full_name" name="full_name"
                                   value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>"
                                   required autocomplete="name" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="full_name">Full Name</label>
                    </div>
                    <div class="reg-field" id="reg-field-index">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-id-card"></i></span>
                            <input type="text" id="index_number" name="index_number"
                                   value="<?= htmlspecialchars($_POST['index_number'] ?? '') ?>"
                                   required autocomplete="off" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="index_number">Index Number</label>
                    </div>
                </div>
            </div>

            <div class="anim-4" style="margin-top:0.5rem;">
                <div class="reg-row-2">
                    <div class="reg-field" id="reg-field-email">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" id="email" name="email"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required autocomplete="email" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="email">Email</label>
                    </div>
                    <div class="reg-field" id="reg-field-phone">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" id="phone" name="phone"
                                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                                   required autocomplete="tel" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="phone">Phone</label>
                    </div>
                </div>
            </div>

            <hr class="reg-divider anim-4">

            <div class="anim-4">
                <div class="reg-section-label"><i class="fa-solid fa-building-columns"></i> Banking Details (for disbursements)</div>
                <div class="reg-row-2">
                    <div class="reg-field" id="reg-field-bank">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-university"></i></span>
                            <input type="text" id="bank_name" name="bank_name"
                                   value="<?= htmlspecialchars($_POST['bank_name'] ?? '') ?>"
                                   autocomplete="off" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="bank_name">Bank Name</label>
                    </div>
                    <div class="reg-field" id="reg-field-account">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-hashtag"></i></span>
                            <input type="text" id="bank_account" name="bank_account"
                                   value="<?= htmlspecialchars($_POST['bank_account'] ?? '') ?>"
                                   autocomplete="off" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                        </div>
                        <label for="bank_account">Bank Account No.</label>
                    </div>
                </div>
                <div class="reg-field" id="reg-field-mpesa" style="margin-top:0.5rem;">
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fa-solid fa-mobile-screen"></i></span>
                        <input type="tel" id="mpesa_phone" name="mpesa_phone"
                               value="<?= htmlspecialchars($_POST['mpesa_phone'] ?? '') ?>"
                               autocomplete="tel" placeholder=" "
                               onfocus="this.closest('.reg-field').classList.add('float')"
                               onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                    </div>
                    <label for="mpesa_phone">M-Pesa Phone Number</label>
                </div>
            </div>

            <hr class="reg-divider anim-5">

            <div class="anim-5">
                <div class="reg-row-2">
                    <div class="reg-field" id="reg-field-pw">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="password" name="password"
                                   required autocomplete="new-password" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')"
                                   oninput="checkStrength(this.value)">
                            <button type="button" class="toggle-pw" onclick="togglePw('password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
                        </div>
                        <label for="password">Password</label>
                        <div class="reg-pw-bar"><div class="reg-pw-fill" id="pw-bar"></div></div>
                        <div class="reg-pw-text" id="pw-text"></div>
                    </div>
                    <div class="reg-field" id="reg-field-confirm">
                        <div class="input-wrap">
                            <span class="input-icon"><i class="fa-solid fa-check"></i></span>
                            <input type="password" id="confirm_password" name="confirm_password"
                                   required autocomplete="new-password" placeholder=" "
                                   onfocus="this.closest('.reg-field').classList.add('float')"
                                   onblur="if(!this.value)this.closest('.reg-field').classList.remove('float')">
                            <button type="button" class="toggle-pw" onclick="togglePw('confirm_password')" aria-label="Toggle password"><i class="fa-solid fa-eye"></i></button>
                        </div>
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="reg-btn anim-5" id="register-btn">
                <span class="btn-text">Create Account</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div class="reg-footer anim-5">
            <p>Already have an account? <a href="/login">Login here</a></p>
            <p>Support: +254 111 030 100</p>
            <div class="reg-role-grid">
                <a href="/login" class="reg-role-link"><i class="fa-solid fa-graduation-cap"></i>Student</a>
                <a href="/login" class="reg-role-link"><i class="fa-solid fa-shield-hooded"></i>Admin</a>
                <a href="/login" class="reg-role-link"><i class="fa-solid fa-users"></i>Committee</a>
                <a href="/login" class="reg-role-link"><i class="fa-solid fa-calculator"></i>Accountant</a>
            </div>
            <p style="margin-top:0.75rem;"><a href="/" style="color:var(--text-muted);font-size:0.78rem;"><i class="fa-solid fa-arrow-left"></i> Back to Home</a></p>
        </div>
    </div>
</div>

<script>
function togglePw(id) {
    var f = document.getElementById(id);
    if (f) f.type = f.type === 'password' ? 'text' : 'password';
}
document.getElementById('register-form')?.addEventListener('submit', function() {
    document.getElementById('register-btn').classList.add('loading');
});
function checkStrength(val) {
    var bar = document.getElementById('pw-bar');
    var txt = document.getElementById('pw-text');
    var score = 0;
    if (val.length >= 8) score += 25;
    if (/[A-Z]/.test(val)) score += 25;
    if (/[0-9]/.test(val)) score += 25;
    if (/[^a-zA-Z0-9]/.test(val)) score += 25;
    if (bar) {
        bar.style.width = score + '%';
        if (score < 25) { bar.style.background = '#E53935'; txt.textContent = 'Too weak'; }
        else if (score < 50) { bar.style.background = '#FFC107'; txt.textContent = 'Weak'; }
        else if (score < 75) { bar.style.background = '#1A237E'; txt.textContent = 'Good'; }
        else { bar.style.background = '#43A047'; txt.textContent = 'Strong'; }
    }
}
(function() {
    document.querySelectorAll('.reg-field input').forEach(function(el) {
        if (el.value) el.closest('.reg-field').classList.add('float');
    });
})();
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
