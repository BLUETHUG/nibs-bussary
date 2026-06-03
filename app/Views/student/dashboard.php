<?php
declare(strict_types=1);
$pageTitle = 'Student Dashboard — NIBS Bursary';
$bodyClass = 'page-dashboard';
ob_start();

// Compute stats from applications
$totalApps = count($applications);
$pending = 0; $approved = 0; $rejected = 0; $disbursed = 0;
foreach ($applications as $app) {
    switch ($app['status']) {
        case 'pending': $pending++; break;
        case 'approved': $approved++; break;
        case 'rejected': $rejected++; break;
        case 'disbursed': $disbursed++; break;
    }
}
$hour = (int)date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
?>
<style>

/* ─── Container ─── */
.dash-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem 4rem;
}

/* ─── Cards ─── */
.dash-card {
    background: var(--bg-card);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    padding: 1.75rem;
    transition: box-shadow var(--transition);
}
.dash-card:hover { box-shadow: var(--shadow-lg); }

.dash-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.85rem;
    border-bottom: 2px solid var(--accent);
}
.dash-card-header i {
    width: 38px; height: 38px;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: var(--accent);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.dash-card-header h2 {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0;
}
.dash-card-header .badge-count {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 22px; height: 22px; padding: 0 6px;
    border-radius: 999px; background: var(--primary); color: var(--accent);
    font-size: 0.65rem; font-weight: 700; margin-left: auto;
}

/* ─── Hero ─── */
.dash-hero {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    border-radius: var(--radius-xl);
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}
.dash-hero::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 300px; height: 300px;
    background: rgba(255,213,79,0.08);
    border-radius: 50%;
}
.dash-hero-greeting {
    color: var(--accent-light);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 0.35rem;
}
.dash-hero-name {
    color: #fff;
    font-size: 1.65rem;
    margin: 0 0 0.25rem;
    font-weight: 700;
}
.dash-hero-tagline {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    margin: 0;
}
.dash-hero-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.12);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.dash-hero-icon svg { width: 56px; height: 56px; }

/* ─── Alerts ─── */
.dash-alert {
    margin-top: 1rem;
    padding: 0.85rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    font-size: 0.85rem;
}
.dash-alert-success { border-left: 4px solid var(--success); }
.dash-alert-success i { color: var(--success); font-size: 1.1rem; }
.dash-alert-info { border-left: 4px solid #1E88E5; }
.dash-alert-info i { color: #1E88E5; font-size: 1.1rem; }
.dash-alert-text { flex: 1; color: var(--text-secondary); margin: 0; }
.dash-alert-link { font-weight: 600; font-size: 0.82rem; color: var(--primary); text-decoration: none; }
.dash-alert-link:hover { text-decoration: underline; }
.dash-alert-close {
    background: none; border: none; color: var(--text-muted);
    cursor: pointer; font-size: 1rem; padding: 0.25rem; line-height: 1;
}

/* ─── Stats ─── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin: 1.5rem 0;
}
.dash-stat-card {
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all var(--transition);
}
.dash-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}
.dash-stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.dash-stat-icon-total { background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: var(--accent); }
.dash-stat-icon-pending { background: linear-gradient(135deg, #EEF2FF, #C7D2FE); color: #F59E0B; }
.dash-stat-icon-approved { background: linear-gradient(135deg, #E8F5E9, #A5D6A7); color: var(--success); }
.dash-stat-icon-disbursed { background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: var(--accent); }
.dash-stat-label { margin: 0; font-size: 0.72rem; color: var(--text-muted); font-weight: 500; }
.dash-stat-value { margin: 0; font-size: 1.5rem; font-weight: 800; color: var(--text); letter-spacing: -0.03em; }
.dash-stat-value-pending { color: #F59E0B; }
.dash-stat-value-approved { color: var(--success); }

/* ─── Quick Actions ─── */
.dash-quick-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.dash-action-card {
    text-decoration: none;
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-md);
    padding: 1.5rem;
    text-align: center;
    transition: all var(--transition);
    display: block;
}
.dash-action-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}
.dash-action-icon {
    width: 52px; height: 52px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.75rem;
    font-size: 1.3rem;
    transition: transform var(--transition);
}
.dash-action-card:hover .dash-action-icon { transform: scale(1.1); }
.dash-action-icon-apply { background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: var(--accent); }
.dash-action-icon-status { background: linear-gradient(135deg, #E8F5E9, #A5D6A7); color: var(--success); }
.dash-action-icon-letter { background: linear-gradient(135deg, #EEF2FF, #C7D2FE); color: #F59E0B; }
.dash-action-title { font-size: 0.9rem; margin: 0 0 0.25rem; color: var(--text); font-weight: 600; }
.dash-action-desc { font-size: 0.78rem; color: var(--text-muted); margin: 0; }

/* ─── Two Column ─── */
.dash-two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

/* ─── Announcement Items ─── */
.dash-ann-item {
    display: flex;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: var(--radius);
    background: #F5F6FA;
    transition: background var(--transition);
    margin-bottom: 0.5rem;
}
.dash-ann-item:hover { background: #EEF0F6; }
.dash-ann-icon { color: var(--accent-hover); font-size: 0.9rem; padding-top: 0.15rem; flex-shrink: 0; }
.dash-ann-title { font-size: 0.85rem; display: block; margin-bottom: 0.15rem; color: var(--text); font-weight: 600; }
.dash-ann-body { font-size: 0.8rem; color: var(--text-secondary); margin: 0 0 0.25rem; }
.dash-ann-date { font-size: 0.7rem; color: var(--text-muted); }
.dash-no-ann { color: var(--text-muted); font-size: 0.85rem; margin: 0; }

/* ─── Notification Items ─── */
.dash-notif-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem;
    border-bottom: 1px solid var(--border);
}
.dash-notif-item:last-child { border-bottom: none; }
.dash-notif-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--accent-hover);
    flex-shrink: 0; margin-top: 0.4rem;
}
.dash-notif-title { font-size: 0.85rem; color: var(--text); font-weight: 600; }
.dash-notif-msg { font-size: 0.78rem; color: var(--text-secondary); margin: 0.1rem 0 0; }

/* ─── Payment Details Accordion ─── */
.dash-summary-header {
    cursor: pointer;
    padding: 0.5rem 0;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--text);
    font-size: 0.95rem;
}
.dash-summary-header i { color: var(--accent-hover); margin-right: 0.5rem; }
.dash-summary-sub {
    font-size: 0.72rem;
    color: var(--text-muted);
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.dash-summary-sub i { font-size: 0.65rem; color: var(--text-muted); margin: 0; }
.dash-summary-body { padding: 0.75rem 0 0; }
.dash-payment-summary {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: #F5F6FA;
    border-radius: var(--radius);
}
.dash-payment-summary-item {
    color: var(--text-secondary);
    font-size: 0.78rem;
}
.dash-payment-summary-item strong { color: var(--text); }

/* ─── Floating Labels (for payment form) ─── */
.dash-field {
    position: relative;
    margin-bottom: 1.25rem;
}
.dash-field label {
    position: absolute;
    left: 14px;
    top: 12px;
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 500;
    pointer-events: none;
    transition: all var(--transition);
    background: var(--bg-card);
    padding: 0 4px;
    z-index: 1;
}
.dash-field.float label,
.dash-field input:focus + label,
.dash-field input:not(:placeholder-shown) + label {
    top: -9px;
    left: 10px;
    font-size: 0.65rem;
    color: var(--primary);
    font-weight: 600;
}
.dash-field input {
    width: 100%;
    padding: 12px 14px 10px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.82rem;
    color: var(--text);
    background: var(--bg-card);
    transition: all var(--transition);
    outline: none;
    box-sizing: border-box;
}
.dash-field input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(14,165,233,0.1);
}
.dash-payment-form {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 1rem;
    align-items: end;
}
.dash-payment-form .dash-save-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.6rem 1.25rem;
    border: none;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: #fff;
    transition: all var(--transition);
    white-space: nowrap;
}
.dash-payment-form .dash-save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(14,165,233,0.3);
}

/* ─── Table ─── */
.dash-table-wrap {
    overflow-x: auto;
    border-radius: var(--radius);
    border: 1px solid var(--border);
}
.dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.82rem;
}
.dash-table th {
    text-align: left;
    padding: 0.75rem 1rem;
    color: #fff;
    font-weight: 600;
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
}
.dash-table td {
    padding: 0.7rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-secondary);
}
.dash-table tbody tr:nth-child(even) td {
    background: #FFFDF5;
}
.dash-table tbody tr:hover td {
    background: #F0F0FF;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table strong { color: var(--text); }

/* ─── Empty State ─── */
.dash-empty-state {
    text-align: center;
    padding: 2.5rem 1rem;
}
.dash-empty-icon { font-size: 2.5rem; margin-bottom: 0.75rem; color: var(--text-muted); opacity: 0.4; }
.dash-empty-title { margin-bottom: 0.5rem; color: var(--text); font-size: 1.05rem; }
.dash-empty-desc { color: var(--text-muted); margin-bottom: 1.25rem; font-size: 0.82rem; }

.dash-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
.dash-view-all {
    color: var(--primary);
    font-size: 0.82rem;
    font-weight: 600;
    text-decoration: none;
}
.dash-view-all:hover { text-decoration: underline; }

/* ─── Buttons ─── */
.dash-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.75rem;
    border: none;
    border-radius: var(--radius);
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    text-decoration: none;
    box-shadow: var(--shadow-sm);
}
.dash-btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    color: #fff;
}
.dash-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(14,165,233,0.3);
}
.dash-btn-gold {
    background: linear-gradient(135deg, var(--accent), var(--accent-hover));
    color: var(--bg-dark);
}
.dash-btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(255,213,79,0.4);
}

/* ─── Status Badges ─── */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.65rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 600;
}
.status-pending { background: #EEF2FF; color: #F59E0B; }
.status-approved { background: #E8F5E9; color: var(--success); }
.status-rejected { background: #FFEBEE; color: var(--error); }
.status-disbursed { background: #E0F2FE; color: var(--primary); }
[data-theme="dark"] .status-pending { background: rgba(245,158,11,0.15); color: #FBBF24; }
[data-theme="dark"] .status-approved { background: rgba(34,197,94,0.15); color: var(--success); }
[data-theme="dark"] .status-rejected { background: rgba(239,68,68,0.15); color: var(--error); }
[data-theme="dark"] .status-disbursed { background: rgba(14,165,233,0.15); color: var(--primary); }

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
@media (max-width: 900px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-quick-actions { grid-template-columns: 1fr; }
    .dash-two-col { grid-template-columns: 1fr; }
    .dash-hero { padding: 1.5rem; }
    .dash-container { padding: 1rem 1rem 5rem; }
    .dash-payment-form { grid-template-columns: 1fr; }
    .dash-nav-links .dash-nav-link span { display: none; }
    .dash-nav-link { padding: 0.5rem 0.65rem; }
    .dash-nav-link i { font-size: 1.1rem; }
}
@media (max-width: 480px) {
    .dash-stats { grid-template-columns: 1fr; }
    .dash-payment-form { grid-template-columns: 1fr; }
}
</style>

<!-- ─── Sticky Nav ─── -->
<nav class="dash-nav anim-1">
    <a href="/student/dashboard" class="dash-nav-brand">
        <svg width="30" height="30" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#dnav)"/>
            <defs><linearGradient id="dnav" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#0EA5E9"/><stop offset="1" stop-color="#0284C7"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#6366F1" font-family="Poppins">N</text>
        </svg>
        NIBS Bursary
    </a>
    <div class="dash-nav-links">
        <a href="/student/dashboard" class="dash-nav-link active"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
        <a href="/student/apply" class="dash-nav-link"><i class="fa-solid fa-file-pen"></i><span>Apply</span></a>
        <a href="/student/status" class="dash-nav-link"><i class="fa-solid fa-list-check"></i><span>Status</span></a>
        <a href="javascript:void(0)" class="dash-nav-link" onclick="openProfile()"><i class="fa-solid fa-user-gear"></i><span>Profile</span></a>
        <a href="/student/dashboard" class="dash-nav-link" style="position:relative;"><i class="fa-solid fa-bell"></i><span>Alerts</span><?php if (!empty($unreadCount) && $unreadCount > 0): ?><span style="position:absolute;top:2px;right:2px;background:var(--error);color:#fff;font-size:0.6rem;font-weight:700;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 4px;"><?= $unreadCount > 9 ? '9+' : $unreadCount ?></span><?php endif; ?></a>
        <button class="theme-toggle dash-nav-link" id="theme-toggle-dash" aria-label="Toggle dark mode" title="Toggle dark mode" style="border:none;cursor:pointer;font-size:0.82rem;display:inline-flex;align-items:center;gap:0.35rem;padding:0.5rem 0.85rem;border-radius:8px;color:var(--text-secondary);transition:all var(--transition);font-weight:500;font-family:inherit;"><i class="fa-solid fa-moon" id="theme-icon-dash"></i><span>Theme</span></button>
        <a href="/logout" class="dash-nav-link" style="color:var(--error);"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
    </div>
</nav>

<div class="dash-container">

    <!-- Welcome Hero -->
    <div class="dash-hero anim-2">
        <div>
            <p class="dash-hero-greeting"><?= $greeting ?></p>
            <h1 class="dash-hero-name"><?= htmlspecialchars($_SESSION['full_name']) ?></h1>
            <p class="dash-hero-tagline">Manage your bursary applications at NIBS Technical College</p>
        </div>
        <div class="dash-hero-icon">
            <svg width="56" height="56" viewBox="0 0 56 56" fill="none">
                <rect width="56" height="56" rx="14" fill="rgba(255,255,255,0.12)"/>
                <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#6366F1" font-family="Poppins">N</text>
            </svg>
        </div>
    </div>

    <?php if (isset($_GET['saved'])): ?>
    <div class="dash-alert dash-alert-success anim-3">
        <i class="fa-solid fa-circle-check"></i>
        <p class="dash-alert-text">Bank/M-Pesa details saved successfully!</p>
    </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['verify_prompt']) || (isset($_GET['resent']) && $_GET['resent'] === '1')): ?>
    <div class="dash-alert dash-alert-info anim-3">
        <i class="fa-solid fa-envelope-circle-check"></i>
        <p class="dash-alert-text">
            <?= isset($_GET['resent']) ? 'A new verification link has been sent.' : 'Please verify your email address to unlock all features.' ?>
            <a href="/resend-verification" class="dash-alert-link">Resend verification</a>
        </p>
        <button class="dash-alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
    <?php elseif (isset($_GET['verified'])): ?>
    <div class="dash-alert dash-alert-success anim-3">
        <i class="fa-solid fa-circle-check"></i>
        <p class="dash-alert-text">Email verified successfully!</p>
    </div>
    <?php endif; ?>

    <!-- Stats Row -->
    <div class="dash-stats anim-3">
        <div class="dash-stat-card">
            <div class="dash-stat-icon dash-stat-icon-total"><i class="fa-solid fa-folder"></i></div>
            <div>
                <p class="dash-stat-label">Total</p>
                <p class="dash-stat-value"><?= $totalApps ?></p>
            </div>
        </div>
        <div class="dash-stat-card">
            <div class="dash-stat-icon dash-stat-icon-pending"><i class="fa-solid fa-hourglass-half"></i></div>
            <div>
                <p class="dash-stat-label">Pending</p>
                <p class="dash-stat-value dash-stat-value-pending"><?= $pending ?></p>
            </div>
        </div>
        <div class="dash-stat-card">
            <div class="dash-stat-icon dash-stat-icon-approved"><i class="fa-solid fa-check-circle"></i></div>
            <div>
                <p class="dash-stat-label">Approved</p>
                <p class="dash-stat-value dash-stat-value-approved"><?= $approved ?></p>
            </div>
        </div>
        <div class="dash-stat-card">
            <div class="dash-stat-icon dash-stat-icon-disbursed"><i class="fa-solid fa-coins"></i></div>
            <div>
                <p class="dash-stat-label">Disbursed</p>
                <p class="dash-stat-value"><?= $disbursed ?></p>
            </div>
        </div>
    </div>

    <!-- Bank Details -->
    <div class="dash-card anim-4" style="margin-bottom:1.5rem;">
        <details>
            <summary class="dash-summary-header">
                <span><i class="fa-solid fa-building-columns"></i> Payment Details</span>
                <span class="dash-summary-sub">
                    <?= ($bankDetails['bank_name'] ?? $bankDetails['mpesa_phone'] ?? '') ? 'Update' : 'Add' ?>
                    <i class="fa-solid fa-chevron-down"></i>
                </span>
            </summary>
            <div class="dash-summary-body">
                <?php if ($bankDetails && ($bankDetails['bank_name'] || $bankDetails['mpesa_phone'])): ?>
                <div class="dash-payment-summary">
                    <?php if ($bankDetails['bank_name'] && $bankDetails['bank_account']): ?>
                    <div class="dash-payment-summary-item"><span>Bank:</span> <strong><?= htmlspecialchars($bankDetails['bank_name']) ?> — <?= htmlspecialchars($bankDetails['bank_account']) ?></strong></div>
                    <?php endif; ?>
                    <?php if ($bankDetails['mpesa_phone']): ?>
                    <div class="dash-payment-summary-item"><span>M-Pesa:</span> <strong><?= htmlspecialchars($bankDetails['mpesa_phone']) ?></strong></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <form method="POST" action="/student/bank-details" class="dash-payment-form">
                    <?= \App\Middleware\CsrfMiddleware::field() ?>
                    <div class="dash-field">
                        <input type="text" id="dash-bank-name" name="bank_name" value="<?= htmlspecialchars($bankDetails['bank_name'] ?? '') ?>" placeholder=" ">
                        <label for="dash-bank-name">Bank Name</label>
                    </div>
                    <div class="dash-field">
                        <input type="text" id="dash-bank-account" name="bank_account" value="<?= htmlspecialchars($bankDetails['bank_account'] ?? '') ?>" placeholder=" ">
                        <label for="dash-bank-account">Bank Account</label>
                    </div>
                    <div class="dash-field">
                        <input type="text" id="dash-mpesa-phone" name="mpesa_phone" value="<?= htmlspecialchars($bankDetails['mpesa_phone'] ?? '') ?>" placeholder=" ">
                        <label for="dash-mpesa-phone">M-Pesa Phone</label>
                    </div>
                    <button type="submit" class="dash-save-btn">Save Payment Details</button>
                </form>
            </div>
        </details>
    </div>

    <!-- Quick Actions -->
    <div class="dash-quick-actions anim-4">
        <a href="/student/apply" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon-apply"><i class="fa-solid fa-file-circle-plus"></i></div>
            <h3 class="dash-action-title">New Application</h3>
            <p class="dash-action-desc">Apply for bursary funding</p>
        </a>
        <a href="/student/status" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon-status"><i class="fa-solid fa-list-check"></i></div>
            <h3 class="dash-action-title">My Applications</h3>
            <p class="dash-action-desc">Track your application status</p>
        </a>
        <a href="/student/status?download=1" class="dash-action-card">
            <div class="dash-action-icon dash-action-icon-letter"><i class="fa-solid fa-file-lines"></i></div>
            <h3 class="dash-action-title">Award Letter</h3>
            <p class="dash-action-desc">Download your bursary letter</p>
        </a>
    </div>

    <div class="dash-two-col anim-4">
        <!-- Announcements -->
        <div class="dash-card">
            <div class="dash-card-header">
                <i class="fa-solid fa-bullhorn"></i>
                <h2>Announcements</h2>
            </div>
            <?php if (!empty($announcements)): ?>
            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                <?php foreach ($announcements as $ann): ?>
                <div class="dash-ann-item">
                    <div class="dash-ann-icon"><i class="fa-solid fa-thumbtack"></i></div>
                    <div>
                        <strong class="dash-ann-title"><?= htmlspecialchars($ann['title']) ?></strong>
                        <p class="dash-ann-body"><?= htmlspecialchars($ann['body']) ?></p>
                        <span class="dash-ann-date"><?= date('d M Y', strtotime($ann['created_at'])) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="dash-no-ann">No announcements at this time.</p>
            <?php endif; ?>
        </div>

        <!-- Notifications -->
        <div class="dash-card">
            <div class="dash-card-header">
                <i class="fa-solid fa-bell"></i>
                <h2>Notifications <?php if (!empty($notifications)): ?><span class="badge-count"><?= count($notifications) ?></span><?php endif; ?></h2>
            </div>
            <?php if (!empty($notifications)): ?>
            <div style="display:flex;flex-direction:column;">
                <?php foreach ($notifications as $n): ?>
                <div class="dash-notif-item">
                    <span class="dash-notif-dot"></span>
                    <div>
                        <strong class="dash-notif-title"><?= htmlspecialchars($n['title']) ?></strong>
                        <p class="dash-notif-msg"><?= htmlspecialchars($n['message']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="dash-no-ann">No new notifications.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Applications -->
    <?php if (!empty($applications)): ?>
    <div class="dash-card anim-5">
        <div class="dash-section-header">
            <div class="dash-card-header" style="margin-bottom:0;padding-bottom:0;border-bottom:none;">
                <i class="fa-solid fa-folder-open"></i>
                <h2>Recent Applications</h2>
            </div>
            <a href="/student/status" class="dash-view-all">View All →</a>
        </div>
        <div class="dash-table-wrap">
            <table class="dash-table">
                <thead>
                    <tr><th>Academic Year</th><th>Amount Requested</th><th>Amount Approved</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['academic_year']) ?></td>
                        <td><strong>KES <?= number_format((float)$app['amount_requested'], 2) ?></strong></td>
                        <td>KES <?= number_format((float)$app['amount_approved'], 2) ?></td>
                        <td><span class="status-badge status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></td>
                        <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="dash-card anim-5">
        <div class="dash-empty-state">
            <div class="dash-empty-icon"><i class="fa-solid fa-inbox"></i></div>
            <h3 class="dash-empty-title">No Applications Yet</h3>
            <p class="dash-empty-desc">Start by submitting your first bursary application.</p>
            <a href="/student/apply" class="dash-btn dash-btn-primary">Apply Now →</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<div id="profile-modal" class="dash-modal">
    <div class="dash-modal-bg" onclick="closeProfile()"></div>
    <div class="dash-modal-content">
        <button type="button" class="dash-modal-close" onclick="closeProfile()">&times;</button>
        <h3 style="color:var(--primary);margin:0 0 1.5rem;font-size:1.15rem;"><i class="fa-solid fa-user-gear"></i> My Profile</h3>
        <form method="POST" action="/student/profile">
            <?= \App\Middleware\CsrfMiddleware::field() ?>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="dash-field">
                    <input type="text" id="pf_name" name="full_name" placeholder=" " value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required>
                    <label for="pf_name">Full Name</label>
                </div>
                <div class="dash-field">
                    <input type="email" id="pf_email" name="email" placeholder=" " value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required>
                    <label for="pf_email">Email</label>
                </div>
                <div class="dash-field">
                    <input type="text" id="pf_phone" name="phone" placeholder=" " value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" required>
                    <label for="pf_phone">Phone</label>
                </div>
                <div class="dash-field">
                    <input type="text" id="pf_bank" name="bank_name" placeholder=" " value="<?= htmlspecialchars($profile['bank_name'] ?? '') ?>">
                    <label for="pf_bank">Bank Name</label>
                </div>
                <div class="dash-field">
                    <input type="text" id="pf_account" name="bank_account" placeholder=" " value="<?= htmlspecialchars($profile['bank_account'] ?? '') ?>">
                    <label for="pf_account">Bank Account</label>
                </div>
                <div class="dash-field">
                    <input type="text" id="pf_mpesa" name="mpesa_phone" placeholder=" " value="<?= htmlspecialchars($profile['mpesa_phone'] ?? '') ?>">
                    <label for="pf_mpesa">M-Pesa Phone</label>
                </div>
            </div>
            <div style="margin-top:1.5rem;display:flex;gap:0.75rem;justify-content:flex-end;">
                <button type="button" class="dash-btn dash-btn-secondary" onclick="closeProfile()">Cancel</button>
                <button type="submit" class="dash-btn dash-btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
.dash-modal { display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; }
.dash-modal.open { display:flex; }
.dash-modal-bg { position:absolute; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); }
.dash-modal-content { position:relative; background:var(--bg-card); border-radius:16px; padding:2rem; max-width:580px; width:90%; box-shadow:0 24px 48px rgba(0,0,0,0.15); max-height:90vh; overflow-y:auto; }
.dash-modal-close { position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; cursor:pointer; color:var(--text-muted); padding:0.25rem; line-height:1; }
.dash-modal-close:hover { color:var(--text); }
[data-theme="dark"] .dash-modal-content { background:var(--bg-card); }
</style>

<script>
function openProfile() { document.getElementById('profile-modal')?.classList.add('open'); }
function closeProfile() { document.getElementById('profile-modal')?.classList.remove('open'); }
document.querySelectorAll('.dash-field input').forEach(function(el) {
    el.addEventListener('focus', function() { this.closest('.dash-field').classList.add('float'); });
    el.addEventListener('blur', function() { if (!this.value || this.value === '') { this.closest('.dash-field').classList.remove('float'); } });
    if (el.value && el.value !== '') { el.closest('.dash-field').classList.add('float'); }
});
</script>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
