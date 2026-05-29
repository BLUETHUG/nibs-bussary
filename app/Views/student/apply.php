<?php
declare(strict_types=1);
$pageTitle = 'Apply for Bursary — NIBS Bursary';
$bodyClass = 'page-student-apply';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --navy: #1A237E;
    --navy-light: #283593;
    --navy-dark: #0D1442;
    --gold: #FFD54F;
    --gold-light: #FFE082;
    --gold-dark: #FFC107;
    --white: #FAFAFA;
    --bg-card: #FFFFFF;
    --text-primary: #1A237E;
    --text-secondary: #546E7A;
    --text-muted: #90A4AE;
    --border: #E8EAF6;
    --success: #43A047;
    --error: #E53935;
    --shadow-sm: 0 2px 8px rgba(26,35,126,0.08);
    --shadow-md: 0 4px 20px rgba(26,35,126,0.12);
    --shadow-lg: 0 8px 40px rgba(26,35,126,0.16);
    --radius: 12px;
    --radius-lg: 20px;
    --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
html[data-theme="dark"] {
    --bg-card: #1a1a2e;
    --white: #16213e;
    --border: #2a2a4a;
    --text-primary: #E8EAF6;
    --text-secondary: #b0bec5;
    --text-muted: #78909c;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.3);
    --shadow-md: 0 4px 20px rgba(0,0,0,0.4);
}

.page-student-apply {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
html[data-theme="dark"] .page-student-apply {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%);
}

/* ─── Sticky Nav ─── */
.apply-nav {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--border);
    padding: 0 1.5rem;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-sm);
}
.apply-nav-brand {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    text-decoration: none;
    font-weight: 700;
    font-size: 1rem;
    color: var(--navy);
}
.apply-nav-brand svg { flex-shrink: 0; }
.apply-nav-links {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.apply-nav-link {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-secondary);
    font-size: 0.82rem;
    font-weight: 500;
    transition: all var(--transition);
}
.apply-nav-link:hover,
.apply-nav-link.active {
    background: var(--navy);
    color: #fff;
}
.apply-nav-link i { font-size: 0.9rem; }

/* ─── Main Layout ─── */
.apply-layout {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 2rem;
    align-items: start;
}

/* ─── Cards ─── */
.apply-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    padding: 2rem;
    transition: box-shadow var(--transition);
}
.apply-card:hover { box-shadow: var(--shadow-lg); }
.apply-card-header {
    margin-bottom: 1.75rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gold);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.apply-card-header i {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
    color: var(--gold);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.apply-card-header h2 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--navy);
    margin: 0;
}
.apply-card-header p {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin: 0.1rem 0 0;
}

/* ─── Progress Bar ─── */
.apply-progress-wrap {
    margin-bottom: 2rem;
}
.apply-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.4rem;
}
.apply-progress-bar {
    height: 6px;
    background: var(--border);
    border-radius: 999px;
    overflow: hidden;
}
.apply-progress-fill {
    height: 100%;
    width: 14%;
    background: linear-gradient(90deg, var(--navy), var(--gold));
    border-radius: 999px;
    transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ─── Floating Labels ─── */
.apply-field {
    position: relative;
    margin-bottom: 1.5rem;
}
.apply-field label {
    position: absolute;
    left: 14px;
    top: 14px;
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 500;
    pointer-events: none;
    transition: all var(--transition);
    background: var(--bg-card);
    padding: 0 4px;
    z-index: 1;
}
.apply-field.float label,
.apply-field input:focus + label,
.apply-field select:focus + label,
.apply-field textarea:focus + label,
.apply-field input:not(:placeholder-shown) + label,
.apply-field select:not([value=""]):valid + label,
.apply-field textarea:not(:placeholder-shown) + label {
    top: -9px;
    left: 10px;
    font-size: 0.7rem;
    color: var(--navy);
    font-weight: 600;
}
.apply-field input,
.apply-field select,
.apply-field textarea {
    width: 100%;
    padding: 14px 14px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: var(--text-primary);
    background: var(--bg-card);
    transition: all var(--transition);
    outline: none;
    box-sizing: border-box;
}
.apply-field input:focus,
.apply-field select:focus,
.apply-field textarea:focus {
    border-color: var(--navy);
    box-shadow: 0 0 0 3px rgba(26,35,126,0.1);
}
.apply-field input.error,
.apply-field select.error,
.apply-field textarea.error {
    border-color: var(--error);
    box-shadow: 0 0 0 3px rgba(229,57,53,0.1);
}
.apply-field .field-error {
    font-size: 0.7rem;
    color: var(--error);
    margin-top: 0.25rem;
    display: none;
}
.apply-field.error .field-error { display: block; }
.apply-field select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2390A4AE' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; }
.apply-field select option { color: var(--text-primary); }
.apply-field textarea { resize: vertical; min-height: 100px; }

/* ─── Tooltip ─── */
.apply-tooltip {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px; height: 18px;
    border-radius: 50%;
    background: var(--border);
    color: var(--text-muted);
    font-size: 0.6rem;
    display: flex; align-items: center; justify-content: center;
    cursor: help;
    transition: all var(--transition);
    z-index: 2;
}
.apply-tooltip:hover { background: var(--navy); color: #fff; }
.apply-tooltip:hover::after {
    content: attr(data-tip);
    position: absolute;
    bottom: calc(100% + 6px);
    right: -40px;
    background: var(--navy-dark);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 400;
    padding: 6px 10px;
    border-radius: 6px;
    white-space: nowrap;
    z-index: 100;
    box-shadow: var(--shadow-md);
    font-family: 'Poppins', sans-serif;
}
.apply-tooltip:hover::before {
    content: '';
    position: absolute;
    bottom: calc(100% - 2px);
    right: 28px;
    border: 5px solid transparent;
    border-top-color: var(--navy-dark);
}
.apply-field textarea ~ .apply-tooltip { top: 14px; transform: none; }

/* ─── File Upload ─── */
.apply-file-zone {
    border: 2px dashed var(--border);
    border-radius: var(--radius);
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all var(--transition);
    position: relative;
}
.apply-file-zone:hover,
.apply-file-zone.dragover {
    border-color: var(--navy);
    background: rgba(26,35,126,0.03);
}
.apply-file-zone i { font-size: 2rem; color: var(--text-muted); margin-bottom: 0.5rem; }
.apply-file-zone p { margin: 0; font-size: 0.82rem; color: var(--text-secondary); }
.apply-file-zone small { font-size: 0.7rem; color: var(--text-muted); }
.apply-file-zone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
}
.apply-file-preview {
    display: none;
    margin-top: 0.75rem;
    padding: 0.75rem 1rem;
    background: #F1F8E9;
    border: 1px solid #C8E6C9;
    border-radius: 8px;
    font-size: 0.82rem;
    color: var(--success);
    align-items: center;
    gap: 0.5rem;
}
.apply-file-preview.visible { display: flex; }
.apply-file-preview i { font-size: 1.2rem; }
.apply-file-preview .file-size { margin-left: auto; font-size: 0.7rem; color: var(--text-muted); }

/* ─── Sidebar ─── */
.apply-sidebar-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.apply-sidebar-card:last-child { margin-bottom: 0; }
.apply-sidebar-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--navy);
    margin: 0 0 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.apply-sidebar-title i { color: var(--gold-dark); }
.apply-sidebar-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.8rem;
    border-bottom: 1px solid var(--border);
}
.apply-sidebar-item:last-child { border-bottom: none; }
.apply-sidebar-item span:first-child { color: var(--text-secondary); }
.apply-sidebar-item span:last-child { font-weight: 600; color: var(--text-primary); }

/* ─── Cycle Info Pill ─── */
.apply-cycle-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    background: linear-gradient(135deg, #FFF8E1, #FFF3CD);
    border: 1px solid var(--gold-light);
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
    color: #F57F17;
    margin-bottom: 1.25rem;
}
.apply-cycle-pill i { font-size: 0.8rem; }

/* ─── Buttons ─── */
.apply-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.85rem 2rem;
    border: none;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
    box-shadow: var(--shadow-sm);
}
.apply-btn-primary {
    background: linear-gradient(135deg, var(--navy), var(--navy-light));
    color: #fff;
}
.apply-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(26,35,126,0.3);
}
.apply-btn-primary:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}
.apply-btn-gold {
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: var(--navy-dark);
}
.apply-btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(255,213,79,0.4);
}
.apply-btn-secondary {
    background: var(--border);
    color: var(--text-secondary);
}
.apply-btn-secondary:hover {
    background: #D1D5F0;
    transform: translateY(-1px);
}
.apply-btn-sm { padding: 0.5rem 1rem; font-size: 0.78rem; }
.apply-btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

/* ─── Alert / Toast ─── */
.apply-toast-container {
    position: fixed;
    top: 80px;
    right: 1.5rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.apply-toast {
    padding: 0.85rem 1.25rem;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.82rem;
    font-weight: 500;
    box-shadow: var(--shadow-md);
    display: flex;
    align-items: center;
    gap: 0.6rem;
    animation: toastSlide 0.4s cubic-bezier(0.16,1,0.3,1) forwards;
    max-width: 380px;
}
.apply-toast-success { background: #E8F5E9; color: #2E7D32; border-left: 4px solid var(--success); }
.apply-toast-error { background: #FFEBEE; color: #C62828; border-left: 4px solid var(--error); }
.apply-toast-info { background: #E3F2FD; color: #1565C0; border-left: 4px solid #1E88E5; }
@keyframes toastSlide {
    from { opacity: 0; transform: translateX(100px); }
    to { opacity: 1; transform: translateX(0); }
}

/* ─── Success Overlay ─── */
.apply-success-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9998;
    background: rgba(26,35,126,0.6);
    backdrop-filter: blur(8px);
    align-items: center;
    justify-content: center;
}
.apply-success-overlay.visible { display: flex; }
.apply-success-modal {
    background: #fff;
    border-radius: var(--radius-lg);
    padding: 3rem 2.5rem;
    text-align: center;
    max-width: 420px;
    box-shadow: var(--shadow-lg);
    animation: successPop 0.5s cubic-bezier(0.16,1,0.3,1) forwards;
}
@keyframes successPop {
    from { opacity: 0; transform: scale(0.8) translateY(20px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.apply-success-modal .success-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #43A047, #66BB6A);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem; color: #fff;
    animation: successIcon 0.6s 0.3s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes successIcon {
    0% { transform: scale(0) rotate(-30deg); }
    100% { transform: scale(1) rotate(0); }
}
.apply-success-modal h2 { color: var(--navy); margin: 0 0 0.5rem; font-size: 1.3rem; }
.apply-success-modal p { color: var(--text-secondary); margin: 0 0 1.5rem; font-size: 0.88rem; }

/* ─── Collapsible Sections ─── */
.apply-collapse-toggle {
    display: none;
    background: none;
    border: none;
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--navy);
    cursor: pointer;
    padding: 0.5rem 0;
    width: 100%;
    text-align: left;
}
.apply-collapse-toggle i { transition: transform var(--transition); }
.apply-collapse-toggle.open i { transform: rotate(180deg); }

/* ─── Empty State ─── */
.apply-empty-funds {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
}
.apply-empty-funds i { font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.5; }
.apply-empty-funds p { font-size: 0.85rem; margin: 0; }

/* ─── Responsive ─── */
@media (max-width: 900px) {
    .apply-layout { grid-template-columns: 1fr; }
    .apply-nav-links .apply-nav-link span { display: none; }
    .apply-nav-link { padding: 0.5rem 0.65rem; }
}
@media (max-width: 600px) {
    .apply-layout { padding: 1rem 0.75rem 5rem; }
    .apply-card { padding: 1.25rem; border-radius: var(--radius); }
    .apply-collapse-toggle { display: flex; align-items: center; justify-content: space-between; }
    .apply-collapse-body { display: none; }
    .apply-collapse-body.open { display: block; }
    .apply-btn-group { flex-direction: column; }
    .apply-btn { width: 100%; justify-content: center; }
    .apply-nav-link i { font-size: 1.1rem; }
}

/* ─── Animation ─── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
.anim-1 { animation: fadeUp 0.4s 0.05s both; }
.anim-2 { animation: fadeUp 0.4s 0.15s both; }
.anim-3 { animation: fadeUp 0.4s 0.25s both; }
.anim-4 { animation: fadeUp 0.4s 0.35s both; }
.anim-5 { animation: fadeUp 0.4s 0.45s both; }
</style>

<!-- ─── Toast Container ─── -->
<div class="apply-toast-container" id="apply-toast-container"></div>

<!-- ─── Success Overlay ─── -->
<div class="apply-success-overlay" id="apply-success">
    <div class="apply-success-modal">
        <div class="success-icon"><i class="fa-solid fa-check"></i></div>
        <h2>Application Submitted!</h2>
        <p>Your bursary application has been received and is pending review. You will be notified once it's processed.</p>
        <a href="/student/status" class="apply-btn apply-btn-primary">View My Applications</a>
        <a href="/student/dashboard" class="apply-btn apply-btn-secondary" style="margin-top:0.75rem;">Back to Dashboard</a>
    </div>
</div>

<!-- ─── Sticky Nav ─── -->
<nav class="apply-nav anim-1">
    <a href="/student/dashboard" class="apply-nav-brand">
        <svg width="30" height="30" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#anav)"/>
            <defs><linearGradient id="anav" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#1A237E"/><stop offset="1" stop-color="#283593"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#FFD54F" font-family="Poppins">N</text>
        </svg>
        NIBS Bursary
    </a>
    <div class="apply-nav-links">
        <a href="/student/dashboard" class="apply-nav-link"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
        <a href="/student/apply" class="apply-nav-link active"><i class="fa-solid fa-file-pen"></i><span>Apply</span></a>
        <a href="/student/status" class="apply-nav-link"><i class="fa-solid fa-list-check"></i><span>Status</span></a>
        <button class="theme-toggle apply-nav-link" id="theme-toggle-apply" aria-label="Toggle dark mode" title="Toggle dark mode" style="border:none;cursor:pointer;font-size:0.82rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.5rem 0.85rem;border-radius:8px;color:var(--text-secondary);transition:all var(--transition);font-weight:500;font-family:inherit;"><i class="fa-solid fa-moon" id="theme-icon-apply"></i><span>Theme</span></button>
        <a href="/logout" class="apply-nav-link" style="color:var(--error);"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
    </div>
</nav>

<!-- ─── Main Layout ─── -->
<div class="apply-layout">

    <!-- Left Column: Form -->
    <div class="apply-card anim-2">
        <div class="apply-card-header">
            <i class="fa-solid fa-file-pen"></i>
            <div>
                <h2>Bursary Application</h2>
                <p>Complete all fields below to submit your application</p>
            </div>
        </div>

        <?php if ($activeCycle): ?>
        <div class="apply-cycle-pill">
            <i class="fa-solid fa-calendar-check"></i>
            Active Cycle: <?= htmlspecialchars($activeCycle['name']) ?> &middot; Closes <?= date('d M Y', strtotime($activeCycle['application_end'])) ?>
        </div>
        <?php endif; ?>

        <!-- Progress Bar -->
        <div class="apply-progress-wrap">
            <div class="apply-progress-label">
                <span>Application Progress</span>
                <span id="progress-pct">14%</span>
            </div>
            <div class="apply-progress-bar">
                <div class="apply-progress-fill" id="progress-fill" style="width:14%;"></div>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
        <div class="apply-toast" style="margin-bottom:1.5rem;animation:none;max-width:none;" id="server-errors">
            <?php foreach ($errors as $e): ?>
            <div style="background:#FFEBEE;padding:0.5rem 0.75rem;border-radius:6px;font-size:0.8rem;color:#C62828;margin-bottom:0.25rem;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($e) ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Collapse Toggle (mobile) -->
        <button class="apply-collapse-toggle" id="collapse-toggle" onclick="toggleCollapse()">
            <span><i class="fa-solid fa-sliders"></i> Form Sections</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>

        <form method="POST" action="/student/apply" id="apply-form" enctype="multipart/form-data">
            <?= CsrfMiddleware::field() ?>
            <div class="apply-collapse-body open" id="collapse-body">

                <!-- Row: Fund + Year -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;" class="anim-3">
                    <div class="apply-field" id="field-fund">
                        <select id="fund_id" name="fund_id" required onchange="updateProgress();validateField(this)">
                            <option value=""></option>
                            <?php foreach ($funds as $fund): ?>
                            <option value="<?= $fund->id ?>" <?= ($_POST['fund_id'] ?? '') == $fund->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($fund->fund_name) ?> (KES <?= number_format($fund->available_amount, 0) ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="fund_id">Bursary Fund *</label>
                        <div class="apply-tooltip" data-tip="Select the fund you wish to apply for">?</div>
                        <div class="field-error">Please select a bursary fund</div>
                    </div>
                    <div class="apply-field" id="field-year">
                        <input type="text" id="academic_year" name="academic_year" required
                               value="<?= htmlspecialchars($_POST['academic_year'] ?? ($activeCycle ? $activeCycle['academic_year'] : (date('Y') . '/' . (date('Y') + 1)))) ?>"
                               <?= $activeCycle ? 'readonly' : '' ?>
                               placeholder=" " onchange="updateProgress();validateField(this)">
                        <label for="academic_year">Academic Year *</label>
                        <div class="apply-tooltip" data-tip="e.g. 2024/2025">?</div>
                        <div class="field-error">Academic year is required</div>
                    </div>
                </div>

                <!-- Row: Amount + File -->
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:0.5rem;" class="anim-4">
                    <div class="apply-field" id="field-amount">
                        <input type="number" id="amount_requested" name="amount_requested" required step="0.01" min="1"
                               value="<?= htmlspecialchars($_POST['amount_requested'] ?? '') ?>"
                               placeholder=" " oninput="updateProgress();validateField(this)">
                        <label for="amount_requested">Amount Requested (KES) *</label>
                        <div class="apply-tooltip" data-tip="How much funding do you need?">?</div>
                        <div class="field-error">Enter a valid amount (min KES 1)</div>
                    </div>
                    <div class="apply-field" style="margin-bottom:0;">
                        <label style="position:static;margin-bottom:0.4rem;font-size:0.82rem;color:var(--text-secondary);font-weight:500;display:block;padding:0;">Supporting Document</label>
                        <div class="apply-file-zone" id="file-zone">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Drop file here or click to browse</p>
                            <small>PDF, JPG, PNG — max 5MB</small>
                            <input type="file" id="supporting_doc" name="supporting_doc" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFile(this)">
                        </div>
                        <div class="apply-file-preview" id="file-preview">
                            <i class="fa-solid fa-file-circle-check"></i>
                            <span id="file-name">No file chosen</span>
                            <span class="file-size" id="file-size"></span>
                        </div>
                        <div style="font-size:0.7rem;color:var(--error);margin-top:0.25rem;display:none;" id="file-error">File too large or invalid type. Max 5MB, PDF/JPG/PNG only.</div>
                    </div>
                </div>

                <!-- Special Circumstances -->
                <div class="apply-field anim-5" id="field-circ" style="margin-top:1.5rem;">
                    <textarea id="special_circumstances" name="special_circumstances" rows="4"
                              placeholder=" " oninput="updateProgress()"><?= htmlspecialchars($_POST['special_circumstances'] ?? '') ?></textarea>
                    <label for="special_circumstances">Special Circumstances (optional)</label>
                    <div class="apply-tooltip" data-tip="Mention any financial hardship, disability, or orphancy">?</div>
                </div>

                <!-- Submit -->
                <div class="apply-btn-group anim-5">
                    <button type="submit" class="apply-btn apply-btn-primary" id="submit-btn" <?= !$activeCycle ? 'disabled' : '' ?>>
                        <i class="fa-solid fa-paper-plane"></i> Submit Application
                    </button>
                    <a href="/student/dashboard" class="apply-btn apply-btn-secondary">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </a>
                </div>

                <?php if (!$activeCycle): ?>
                <div style="margin-top:1rem;padding:0.75rem 1rem;background:#FFF3E0;border-radius:8px;font-size:0.82rem;color:#E65100;display:flex;align-items:center;gap:0.5rem;">
                    <i class="fa-solid fa-triangle-exclamation"></i> No active application cycle is currently open. Please check back later.
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Right Column: Sidebar -->
    <div class="apply-sidebar anim-3">
        <!-- Cycle Info -->
        <div class="apply-sidebar-card">
            <h3 class="apply-sidebar-title"><i class="fa-solid fa-calendar-circle-info"></i> Application Cycle</h3>
            <?php if ($activeCycle): ?>
            <div class="apply-sidebar-item"><span>Cycle</span><span><?= htmlspecialchars($activeCycle['name']) ?></span></div>
            <div class="apply-sidebar-item"><span>Academic Year</span><span><?= htmlspecialchars($activeCycle['academic_year']) ?></span></div>
            <div class="apply-sidebar-item"><span>Opened</span><span><?= date('d M Y', strtotime($activeCycle['application_start'])) ?></span></div>
            <div class="apply-sidebar-item"><span>Deadline</span><span style="color:var(--error);"><?= date('d M Y', strtotime($activeCycle['application_end'])) ?></span></div>
            <div class="apply-sidebar-item"><span>Max Applications</span><span><?= (int)$activeCycle['max_applications_per_student'] ?></span></div>
            <?php else: ?>
            <p style="font-size:0.82rem;color:var(--text-muted);margin:0;">No active cycle. Contact the admin to open one.</p>
            <?php endif; ?>
        </div>

        <!-- Quick Tips -->
        <div class="apply-sidebar-card">
            <h3 class="apply-sidebar-title"><i class="fa-solid fa-lightbulb"></i> Tips</h3>
            <ul style="margin:0;padding-left:1.25rem;font-size:0.78rem;color:var(--text-secondary);line-height:1.8;">
                <li>Double-check your index number before submitting</li>
                <li>Attach clear, legible supporting documents</li>
                <li>Describe your circumstances honestly for fair assessment</li>
                <li>You can track your application status anytime</li>
            </ul>
        </div>

        <!-- Available Funds Summary -->
        <div class="apply-sidebar-card">
            <h3 class="apply-sidebar-title"><i class="fa-solid fa-coins"></i> Available Funds</h3>
            <?php if (!empty($funds)): ?>
                <?php foreach ($funds as $fund): ?>
                <div class="apply-sidebar-item">
                    <span><?= htmlspecialchars($fund->fund_name) ?></span>
                    <span>KES <?= number_format($fund->available_amount, 0) ?></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <p style="font-size:0.82rem;color:var(--text-muted);margin:0;">No funds available for this cycle.</p>
            <?php endif; ?>
        </div>

        <!-- Need Help? -->
        <div class="apply-sidebar-card" style="background:linear-gradient(135deg, #1A237E, #283593);color:#fff;">
            <h3 class="apply-sidebar-title" style="color:var(--gold);"><i class="fa-solid fa-headset" style="color:var(--gold);"></i> Need Help?</h3>
            <p style="font-size:0.8rem;opacity:0.85;margin:0 0 0.75rem;">Contact the bursary office for assistance with your application.</p>
            <a href="tel:+254111030100" style="display:flex;align-items:center;gap:0.5rem;color:var(--gold);text-decoration:none;font-size:0.85rem;font-weight:600;">
                <i class="fa-solid fa-phone"></i> +254 111 030 100
            </a>
            <a href="mailto:bursary@nibs.ac.ke" style="display:flex;align-items:center;gap:0.5rem;color:var(--gold);text-decoration:none;font-size:0.82rem;margin-top:0.4rem;">
                <i class="fa-solid fa-envelope"></i> bursary@nibs.ac.ke
            </a>
        </div>
    </div>
</div>

<script>
// ─── Toast System ───
function showToast(msg, type) {
    type = type || 'success';
    var c = document.getElementById('apply-toast-container');
    var t = document.createElement('div');
    t.className = 'apply-toast apply-toast-' + type;
    var icon = type === 'success' ? '<i class="fa-solid fa-check-circle"></i>' :
               type === 'error' ? '<i class="fa-solid fa-circle-exclamation"></i>' :
               '<i class="fa-solid fa-info-circle"></i>';
    t.innerHTML = icon + ' ' + msg;
    c.appendChild(t);
    setTimeout(function() { t.style.opacity = '0'; t.style.transition = 'opacity 0.3s'; setTimeout(function() { t.remove(); }, 300); }, 4000);
}

<?php if (isset($_GET['success'])): ?>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('apply-success').classList.add('visible');
});
<?php endif; ?>

// ─── Progress Bar ───
function updateProgress() {
    var fields = [
        document.getElementById('fund_id'),
        document.getElementById('academic_year'),
        document.getElementById('amount_requested'),
    ];
    var filled = 0;
    fields.forEach(function(f) {
        if (f && f.value && f.value.trim() !== '') filled++;
    });
    var circ = document.getElementById('special_circumstances');
    if (circ && circ.value && circ.value.trim() !== '') filled++;
    var file = document.getElementById('supporting_doc');
    if (file && file.files && file.files.length > 0) filled++;

    var total = fields.length + 1 + 1; // 3 required + circumstances + file
    var pct = Math.round((filled / total) * 100);
    var bar = document.getElementById('progress-fill');
    var pctLabel = document.getElementById('progress-pct');
    if (bar) bar.style.width = Math.min(pct, 100) + '%';
    if (pctLabel) pctLabel.textContent = Math.min(pct, 100) + '%';
}

// ─── Field Validation ───
function validateField(el) {
    var field = el.closest('.apply-field');
    if (!field) return;
    if (el.hasAttribute('required') && (!el.value || el.value.trim() === '')) {
        field.classList.add('error');
    } else if (el.type === 'number' && el.value && parseFloat(el.value) < 1) {
        field.classList.add('error');
    } else {
        field.classList.remove('error');
    }
}

// ─── Real-time validation on blur ───
document.querySelectorAll('#apply-form [required]').forEach(function(el) {
    el.addEventListener('blur', function() { validateField(this); });
    el.addEventListener('change', function() { validateField(this); });
});

// ─── File Upload ───
function handleFile(input) {
    var preview = document.getElementById('file-preview');
    var nameEl = document.getElementById('file-name');
    var sizeEl = document.getElementById('file-size');
    var errorEl = document.getElementById('file-error');
    var zone = document.getElementById('file-zone');

    if (!input.files || !input.files[0]) {
        preview.classList.remove('visible');
        errorEl.style.display = 'none';
        updateProgress();
        return;
    }

    var file = input.files[0];
    var maxSize = 5 * 1024 * 1024;
    var allowed = ['application/pdf', 'image/jpeg', 'image/png'];

    if (file.size > maxSize || !allowed.includes(file.type)) {
        errorEl.style.display = 'block';
        preview.classList.remove('visible');
        input.value = '';
        updateProgress();
        return;
    }

    errorEl.style.display = 'none';
    nameEl.textContent = file.name;
    sizeEl.textContent = (file.size / 1024).toFixed(1) + ' KB';
    preview.classList.add('visible');
    updateProgress();
}

// Drag & drop highlight
var zone = document.getElementById('file-zone');
if (zone) {
    ['dragenter', 'dragover'].forEach(function(e) {
        zone.addEventListener(e, function(ev) { ev.preventDefault(); zone.classList.add('dragover'); });
    });
    ['dragleave', 'drop'].forEach(function(e) {
        zone.addEventListener(e, function(ev) { ev.preventDefault(); zone.classList.remove('dragover'); });
    });
    zone.addEventListener('drop', function(ev) {
        var files = ev.dataTransfer.files;
        if (files.length) {
            document.getElementById('supporting_doc').files = files;
            handleFile(document.getElementById('supporting_doc'));
        }
    });
}

// ─── Floating Labels ───
document.querySelectorAll('.apply-field input, .apply-field select, .apply-field textarea').forEach(function(el) {
    el.addEventListener('focus', function() {
        this.closest('.apply-field').classList.add('float');
    });
    el.addEventListener('blur', function() {
        if (!this.value || this.value === '') {
            this.closest('.apply-field').classList.remove('float');
        }
    });
    // Init float state
    if (el.value && el.value !== '') {
        el.closest('.apply-field').classList.add('float');
    }
});

// ─── Mobile Collapse ───
function toggleCollapse() {
    var body = document.getElementById('collapse-body');
    var btn = document.getElementById('collapse-toggle');
    if (body && btn) {
        body.classList.toggle('open');
        btn.classList.toggle('open');
    }
}

// ─── Form Submit ───
document.getElementById('apply-form')?.addEventListener('submit', function(e) {
    var btn = document.getElementById('submit-btn');
    if (btn && !btn.disabled) {
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
        btn.disabled = true;
    }
});

// ─── Smooth Scroll ───
document.querySelectorAll('a[href^="#"]').forEach(function(a) {
    a.addEventListener('click', function(e) {
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
