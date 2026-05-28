<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NIBS Technical College — Automated Bursary Management System">
    <title><?= $pageTitle ?? 'NIBS Bursary Portal' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%234f46e5'/><text x='16' y='22' text-anchor='middle' font-size='18' font-weight='bold' fill='%23fff'>N</text></svg>">
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    <?= $extraHead ?? '' ?>
</head>
<body class="<?= $bodyClass ?? '' ?>">
<div id="page-loader"><div class="loader-spinner"></div></div>
<a href="#page-content" class="skip-link">Skip to main content</a>

<div id="ui-overlay">
<?php if (!empty($_SESSION['user_id'])): ?>
<nav class="glass-nav" id="main-nav">
    <div class="nav-brand">
        <svg width="34" height="34" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#nlogo)"/>
            <defs><linearGradient id="nlogo" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#4f46e5"/><stop offset="1" stop-color="#818cf8"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#fff" font-family="Inter">N</text>
        </svg>
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

<main id="page-content" class="page-enter">
<?= $content ?? '' ?>
</main>
</div>

<a href="#" id="scroll-top" role="button" aria-label="Scroll to top"><i class="fa-solid fa-arrow-up"></i></a>
<div id="toast-container" role="status" aria-live="polite"></div>

<?= $extraScripts ?? '' ?>
<script>
(function() {
    var loader = document.getElementById('page-loader');
    if (loader) { loader.classList.add('hidden'); }

    // Hamburger
    document.getElementById('hamburger')?.addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('nav-links')?.classList.toggle('open');
    });
    document.addEventListener('click', function(e) {
        var nav = document.getElementById('nav-links');
        var ham = document.getElementById('hamburger');
        if (nav && ham && !e.target.closest('#main-nav')) { nav.classList.remove('open'); }
    });

    // Active nav link
    var path = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(function(a) {
        if (a.getAttribute('href') === path) a.classList.add('active');
    });

    // Toast system
    window.showToast = function(msg, type) {
        type = type || 'success';
        var c = document.getElementById('toast-container');
        var t = document.createElement('div');
        t.className = 'toast ' + type;
        var icon = type === 'success' ? '<i class="fa-solid fa-check-circle" style="color:var(--success)"></i> ' :
                   type === 'error' ? '<i class="fa-solid fa-circle-exclamation" style="color:var(--error)"></i> ' :
                   '<i class="fa-solid fa-info-circle" style="color:var(--primary)"></i> ';
        t.innerHTML = icon + msg;
        c.appendChild(t);
        setTimeout(function() { t.style.opacity = '0'; t.style.transition = 'opacity 0.3s'; setTimeout(function() { t.remove(); }, 300); }, 4000);
    };

    // Auto-hide alerts
    document.querySelectorAll('.alert-box, .alert').forEach(function(a) {
        setTimeout(function() { a.style.opacity = '0'; a.style.transition = 'opacity 0.4s'; setTimeout(function() { a.remove(); }, 400); }, 6000);
    });

    // Scroll to top
    var st = document.getElementById('scroll-top');
    if (st) {
        window.addEventListener('scroll', function() {
            st.classList.toggle('visible', window.scrollY > 300);
        });
        st.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Button ripple effect
    document.addEventListener('mousedown', function(e) {
        var btn = e.target.closest('.btn, .btn-auth, .btn-action, .btn-small, .btn-icon');
        if (!btn) return;
        btn.style.transform = 'scale(0.97)';
    });
    document.addEventListener('mouseup', function(e) {
        var btn = e.target.closest('.btn, .btn-auth, .btn-action, .btn-small, .btn-icon');
        if (!btn) return;
        btn.style.transform = '';
    });

    // Reveal animations
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) { entry.target.classList.add('visible'); obs.unobserve(entry.target); }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach(function(el) { obs.observe(el); });
    } else {
        document.querySelectorAll('.reveal').forEach(function(el) { el.classList.add('visible'); });
    }

    // Progress bar animation
    document.querySelectorAll('.fund-progress-bar, .progress-fill').forEach(function(bar) {
        var w = bar.style.width;
        bar.style.width = '0%';
        setTimeout(function() { bar.style.width = w; }, 100);
    });
})();
</script>
</body>
</html>
