<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NIBS Technical College — Automated Bursary Management System">
    <title><?= $pageTitle ?? 'NIBS Bursary Portal' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='6' fill='%232563eb'/><text x='16' y='22' text-anchor='middle' font-size='18' font-weight='bold' fill='%23fff'>N</text></svg>">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    <?= $extraHead ?? '' ?>
</head>
<body class="<?= $bodyClass ?? '' ?>">
<a href="#page-content" class="skip-link">Skip to main content</a>

<div id="ui-overlay">
<?php if (!empty($_SESSION['user_id'])): ?>
<nav class="glass-nav" id="main-nav">
    <div class="nav-brand">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"><rect width="32" height="32" rx="6" fill="#2563eb"/><text x="16" y="22" text-anchor="middle" font-size="18" font-weight="bold" fill="#fff" font-family="Inter">N</text></svg>
        <span class="nav-title">Bursary Portal</span>
    </div>
    <div class="nav-links" id="nav-links">
        <?php if ($_SESSION['role'] === 'student'): ?>
            <a href="/student/dashboard" class="nav-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Dashboard</a>
            <a href="/student/apply" class="nav-link"><i class="fa-solid fa-file-circle-plus" aria-hidden="true"></i> Apply</a>
            <a href="/student/status" class="nav-link"><i class="fa-solid fa-list" aria-hidden="true"></i> Status</a>
        <?php elseif (in_array($_SESSION['role'], ['admin','officer'])): ?>
            <a href="/admin/dashboard" class="nav-link"><i class="fa-solid fa-chart-pie" aria-hidden="true"></i> Dashboard</a>
            <a href="/admin/applications" class="nav-link"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i> Applications</a>
            <a href="/admin/funds" class="nav-link"><i class="fa-solid fa-coins" aria-hidden="true"></i> Funds</a>
            <a href="/admin/reports" class="nav-link"><i class="fa-solid fa-file-lines" aria-hidden="true"></i> Reports</a>
            <a href="/admin/announcements" class="nav-link"><i class="fa-solid fa-bullhorn" aria-hidden="true"></i> Announcements</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="/admin/users" class="nav-link"><i class="fa-solid fa-users-gear" aria-hidden="true"></i> Users</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="nav-user">
        <span class="user-avatar"><?= strtoupper(substr($_SESSION['full_name'], 0, 1)) ?></span>
        <div class="user-info">
            <div class="user-name"><?= htmlspecialchars($_SESSION['full_name']) ?></div>
            <div class="user-role"><?= ucfirst($_SESSION['role']) ?></div>
        </div>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu"><i class="fa-solid fa-bars"></i></button>
</nav>
<?php endif; ?>

<main id="page-content">
<?= $content ?? '' ?>
</main>
</div>

<?= $extraScripts ?? '' ?>
<script>
document.getElementById('hamburger')?.addEventListener('click', function() {
    document.getElementById('nav-links')?.classList.toggle('open');
});
document.addEventListener('click', function(e) {
    var nav = document.getElementById('nav-links');
    var ham = document.getElementById('hamburger');
    if (nav && ham && !e.target.closest('#main-nav')) {
        nav.classList.remove('open');
    }
});
</script>
</body>
</html>
