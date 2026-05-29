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
    <style>
    .cinema-loader {
        position: fixed; inset: 0; z-index: 99999;
        background: var(--bg-dark); display: flex;
        align-items: center; justify-content: center;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    .cinema-loader.hidden { opacity: 0; visibility: hidden; }
    .cinema-loader .bar { width: 120px; height: 2px; background: rgba(255,255,255,0.1); border-radius: 2px; overflow: hidden; }
    .cinema-loader .bar-inner { height: 100%; width: 0; background: linear-gradient(90deg, #4f46e5, #818cf8); border-radius: 2px; animation: loadBar 0.8s cubic-bezier(0.16,1,0.3,1) forwards; }
    @keyframes loadBar { 0% { width: 0; } 100% { width: 100%; } }
    </style>
</head>
<body class="<?= $bodyClass ?? '' ?>">
<div id="cinema-loader" class="cinema-loader"><div class="bar"><div class="bar-inner"></div></div></div>
<a href="#page-content" class="skip-link">Skip to main content</a>

<div id="ui-overlay">
<?php if (!empty($_SESSION['user_id']) && $_SESSION['role'] !== 'student'): ?>
<nav class="glass-nav" id="main-nav">
    <div class="nav-brand">
        <svg width="30" height="30" viewBox="0 0 34 34" fill="none">
            <rect width="34" height="34" rx="8" fill="url(#nlogo)"/>
            <defs><linearGradient id="nlogo" x1="0" y1="0" x2="34" y2="34"><stop stop-color="#1A237E"/><stop offset="1" stop-color="#283593"/></linearGradient></defs>
            <text x="17" y="23" text-anchor="middle" font-size="18" font-weight="bold" fill="#FFD54F" font-family="Poppins">N</text>
        </svg>
        <span class="nav-title">NIBS Bursary</span>
    </div>
    <div class="nav-links" id="nav-links">
        <?php if (in_array($_SESSION['role'], ['admin','officer'])): ?>
            <a href="/admin/dashboard" class="nav-link"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="/admin/applications" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> Applications</a>
            <a href="/admin/committee" class="nav-link"><i class="fa-solid fa-gavel"></i> Scoring</a>
            <a href="/admin/funds" class="nav-link"><i class="fa-solid fa-coins"></i> Funds</a>
            <a href="/admin/reports" class="nav-link"><i class="fa-solid fa-file-lines"></i> Reports</a>
            <a href="/admin/announcements" class="nav-link"><i class="fa-solid fa-bullhorn"></i> Announcements</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="/admin/cycles" class="nav-link"><i class="fa-solid fa-calendar-cycle"></i> Cycles</a>
            <a href="/admin/users" class="nav-link"><i class="fa-solid fa-users-gear"></i> Users</a>
            <?php endif; ?>
        <?php elseif ($_SESSION['role'] === 'committee'): ?>
            <a href="/admin/committee" class="nav-link"><i class="fa-solid fa-gavel"></i> Score Applications</a>
        <?php elseif ($_SESSION['role'] === 'accountant'): ?>
            <a href="/admin/finance" class="nav-link"><i class="fa-solid fa-coins"></i> Finance Portal</a>
            <a href="/admin/reports" class="nav-link"><i class="fa-solid fa-file-lines"></i> Reports</a>
        <?php endif; ?>
    </div>
    <div class="nav-user">
        <button class="theme-toggle" id="theme-toggle-admin" aria-label="Toggle dark mode" title="Toggle dark mode" style="margin-right:0.5rem;border:none;cursor:pointer;background:none;font-size:0.9rem;">
            <i class="fa-solid fa-moon" id="theme-icon-admin"></i>
        </button>
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

<?php if (!empty($_SESSION['user_id'])): ?>
<!-- Mobile Bottom Navigation (Duolingo-style) -->
<nav class="mobile-bottom-nav" aria-label="Mobile navigation">
    <?php if ($_SESSION['role'] === 'student'): ?>
    <a href="/student/dashboard" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/student/dashboard') === 0 ? 'active' : '' ?>">
        <i class="fa-solid fa-house"></i><span>Home</span>
    </a>
    <a href="/student/apply" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/student/apply') === 0 ? 'active' : '' ?>">
        <i class="fa-solid fa-file-circle-plus"></i><span>Apply</span>
    </a>
    <a href="/student/status" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/student/status') === 0 ? 'active' : '' ?>">
        <i class="fa-solid fa-list"></i><span>Status</span>
    </a>
    <?php elseif (in_array($_SESSION['role'], ['admin','officer'])): ?>
        <a href="/admin/dashboard" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/dashboard') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
        </a>
        <a href="/admin/applications" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/applications') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-clipboard-list"></i><span>Apps</span>
        </a>
        <a href="/admin/committee" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/committee') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-gavel"></i><span>Score</span>
        </a>
        <a href="/admin/reports" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/reports') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-file-lines"></i><span>Reports</span>
        </a>
    <?php elseif ($_SESSION['role'] === 'committee'): ?>
        <a href="/admin/committee" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/committee') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-gavel"></i><span>Score</span>
        </a>
    <?php elseif ($_SESSION['role'] === 'accountant'): ?>
        <a href="/admin/finance" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/finance') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-coins"></i><span>Finance</span>
        </a>
        <a href="/admin/reports" class="mobile-nav-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/admin/reports') === 0 ? 'active' : '' ?>">
            <i class="fa-solid fa-file-lines"></i><span>Reports</span>
        </a>
    <?php endif; ?>
    <a href="/logout" class="mobile-nav-link">
        <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
    </a>
</nav>
<?php endif; ?>

<a href="#" id="scroll-top" role="button" aria-label="Scroll to top"><i class="fa-solid fa-arrow-up"></i></a>
<div id="toast-container" role="status" aria-live="polite"></div>

<?= $extraScripts ?? '' ?>
<script>
(function() {
    var loader = document.getElementById('cinema-loader');
    if (loader) setTimeout(function() { loader.classList.add('hidden'); }, 600);

    // ─── Dark Mode ───
    var saved = localStorage.getItem('nibs-theme');
    if (saved === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
    updateThemeIcons();

    function updateThemeIcons() {
        var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        var cls = isDark ? 'fa-sun' : 'fa-moon';
        document.querySelectorAll('[id^="theme-icon"]').forEach(function(el) { el.className = 'fa-solid ' + cls; });
    }

    function toggleTheme() {
        var html = document.documentElement;
        var isDark = html.getAttribute('data-theme') === 'dark';
        html.setAttribute('data-theme', isDark ? '' : 'dark');
        localStorage.setItem('nibs-theme', isDark ? '' : 'dark');
        updateThemeIcons();
    }

    document.querySelectorAll('[id^="theme-toggle"]').forEach(function(el) {
        el.addEventListener('click', toggleTheme);
    });

    // Hamburger (admin nav)
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
    document.querySelectorAll('.nav-link').forEach(function(a) {
        if (a.getAttribute('href') === window.location.pathname) a.classList.add('active');
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
        }, { passive: true });
        st.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Button press effect
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
