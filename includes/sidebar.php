<?php 
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'student'; 
    $current = basename($_SERVER['PHP_SELF']);
    function isActive($pages): string {
        $current = basename($_SERVER['PHP_SELF']);
        $pages = is_array($pages) ? $pages : [$pages];
        return in_array($current, $pages, true) ? 'active' : '';
    }
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">NIBS<span>Portal</span></div>
    </div>
    
    <nav class="sidebar-nav">
        <?php if($role == 'student'): ?>
            <a href="student-dashboard.php" class="<?= isActive('student-dashboard.php') ?>"><i class="fa-solid fa-house"></i> Home</a>
            <a href="apply.php" class="<?= isActive('apply.php') ?>"><i class="fa-solid fa-file-signature"></i> New Application</a>
            <a href="my-applications.php" class="<?= isActive('my-applications.php') ?>"><i class="fa-solid fa-folder-open"></i> My Status</a>
            <a href="profile.php" class="<?= isActive('profile.php') ?>"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="documents.php" class="<?= isActive('documents.php') ?>"><i class="fa-solid fa-file-lines"></i> Documents</a>
            <a href="messages.php" class="<?= isActive('messages.php') ?>"><i class="fa-solid fa-envelope"></i> Messages</a>
            <a href="notifications.php" class="<?= isActive('notifications.php') ?>"><i class="fa-solid fa-bell"></i> Notifications</a>
            <a href="contact-us.php" class="<?= isActive('contact-us.php') ?>"><i class="fa-solid fa-headset"></i> Contact Support</a>

        <?php elseif($role == 'admin'): ?>
            <a href="admin-dashboard.php" class="<?= isActive('admin-dashboard.php') ?>"><i class="fa-solid fa-chart-line"></i> Command Center</a>
            <a href="admin-review.php" class="<?= isActive('admin-review.php') ?>"><i class="fa-solid fa-list-check"></i> Review Queue</a>
            <a href="admin-students.php" class="<?= isActive('admin-students.php') ?>"><i class="fa-solid fa-users"></i> Students</a>
            <a href="admin-messages.php" class="<?= isActive('admin-messages.php') ?>"><i class="fa-solid fa-headset"></i> Support Queue</a>
            <a href="admin-funds.php" class="<?= isActive('admin-funds.php') ?>"><i class="fa-solid fa-sack-dollar"></i> Fund Control</a>
            <a href="admin-analytics.php" class="<?= isActive('admin-analytics.php') ?>"><i class="fa-solid fa-magnifying-glass-chart"></i> Reports</a>

        <?php elseif($role == 'tech'): ?>
            <a href="tech-dashboard.php" class="<?= isActive('tech-dashboard.php') ?>"><i class="fa-solid fa-microchip"></i> System Health</a>
            <a href="tech-db-explorer.php" class="<?= isActive('tech-db-explorer.php') ?>"><i class="fa-solid fa-database"></i> Database Explorer</a>
        <?php endif; ?>
    </nav>
    
    <div class="sidebar-footer">
        <a href="https://www.nibs.ac.ke" target="_blank" rel="noopener" class="logout-link" style="margin-bottom:2px;"><i class="fa-solid fa-globe"></i> NIBS Website</a>
        <a href="backend/auth.php?action=logout" class="logout-link"><i class="fa-solid fa-power-off"></i> Sign Out</a>
    </div>
</aside>

<style>
.sidebar {
    background: var(--primary-dark);
    height: 100vh;
    position: sticky;
    top: 0;
    width: 260px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}
.sidebar-brand {
    padding: 1.5rem 1.5rem 2rem;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}
.sidebar-logo {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--white);
}
.sidebar-logo span {
    color: var(--accent);
    font-weight: 300;
}
.sidebar-nav {
    flex: 1;
    padding: 0.5rem 0;
}
.sidebar-nav a {
    color: rgba(255,255,255,0.55);
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.9rem 1.5rem;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.25s ease;
    border-left: 3px solid transparent;
}
.sidebar-nav a.active {
    background: rgba(16, 185, 129, 0.08);
    color: var(--accent);
    border-left-color: var(--accent);
    font-weight: 600;
}
.sidebar-nav a:hover:not(.active) {
    background: rgba(255,255,255,0.03);
    color: rgba(255,255,255,0.8);
}
.sidebar-nav i {
    font-size: 1rem;
    width: 20px;
    text-align: center;
}
.sidebar-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(255,255,255,0.08);
}
.logout-link {
    color: rgba(255,255,255,0.4) !important;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1rem;
    border-radius: 8px;
    transition: all 0.25s ease;
}
.logout-link:hover {
    background: rgba(16,185,129,0.15);
    color: #10b981 !important;
}
</style>
