<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NIBS Technical College — Automated Bursary Management System">
    <title><?= $pageTitle ?? 'NIBS Bursary Portal' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&family=Roboto+Slab:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="/assets/css/three-overlay.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    <?= $extraHead ?? '' ?>
</head>
<body class="<?= $bodyClass ?? '' ?>">
<a href="#page-content" class="skip-link">Skip to main content</a>

<canvas id="three-canvas"></canvas>
<div id="fallback-2d" style="display:none; background:linear-gradient(135deg,#050A1A,#0a1f5c); min-height:100vh;"></div>

<div id="ui-overlay">
<?php if (!empty($_SESSION['user_id'])): ?>
<nav class="glass-nav" id="main-nav">
    <div class="nav-brand">
        <img src="https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png" alt="NIBS" class="nav-logo" onerror="this.style.display='none'">
        <span class="nav-title">Bursary Portal</span>
    </div>
    <div class="nav-links" id="nav-links">
        <?php if ($_SESSION['role'] === 'student'): ?>
            <a href="/student/dashboard" class="nav-link"><i class="fa-solid fa-house" aria-hidden="true"></i> Dashboard</a>
            <a href="/student/apply" class="nav-link"><i class="fa-solid fa-file-circle-plus" aria-hidden="true"></i> Apply</a>
            <a href="/student/status" class="nav-link"><i class="fa-solid fa-list" aria-hidden="true"></i> My Status</a>
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
            <a href="https://www.nibs.ac.ke" target="_blank" rel="noopener" class="nav-link" style="font-size:0.85rem;">NIBS Website <i class="fa-solid fa-external-link" style="font-size:0.75rem;"></i></a>
            <a href="/logout" class="btn-logout">Logout</a>
    </div>
    <button class="hamburger" id="hamburger"><i class="fa-solid fa-bars"></i></button>
</nav>
<?php endif; ?>

<main id="page-content">
<?= $content ?? '' ?>
</main>
</div>

<script type="importmap">{"imports":{"three":"https://unpkg.com/three@0.165.0/build/three.module.js","three/examples/jsm/loaders/GLTFLoader.js":"https://unpkg.com/three@0.165.0/examples/jsm/loaders/GLTFLoader.js","three/examples/jsm/renderers/CSS2DRenderer.js":"https://unpkg.com/three@0.165.0/examples/jsm/renderers/CSS2DRenderer.js", "gsap": "https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"}}</script>
<script type="module" src="/assets/js/app.js"></script>
<?= $extraScripts ?? '' ?>
<script>document.getElementById('hamburger')?.addEventListener('click',()=>document.getElementById('nav-links')?.classList.toggle('open'));</script>
</body>
</html>
