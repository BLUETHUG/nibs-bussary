<?php
declare(strict_types=1);
$pageTitle = 'Student Dashboard — NIBS Bursary';
$bodyClass = 'page-dashboard';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <!-- Hero Banner -->
    <div class="dash-hero glass-card" style="background-image: url('https://www.nibs.ac.ke/wp-content/uploads/2024/01/nibs-campus-aerial.jpg');">
        <div class="dash-hero-overlay">
            <img src="https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png" alt="NIBS" class="dash-logo" onerror="this.style.display='none'">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?></h1>
            <p>Manage your bursary applications for NIBS Technical College</p>
        </div>
    </div>

    <!-- Announcements -->
    <?php if (!empty($announcements)): ?>
    <div class="section-card glass-card">
        <h2 class="section-title"><i class="fa-solid fa-bullhorn" aria-hidden="true"></i> Announcements</h2>
        <div class="announcements-list">
            <?php foreach ($announcements as $ann): ?>
            <div class="announcement-item">
                <div class="ann-icon"><i class="fa-solid fa-thumbtack"></i></div>
                <div>
                    <strong><?= htmlspecialchars($ann['title']) ?></strong>
                    <p><?= htmlspecialchars($ann['body']) ?></p>
                    <span class="ann-date"><?= date('d M Y', strtotime($ann['created_at'])) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Notifications -->
    <?php if (!empty($notifications)): ?>
    <div class="section-card glass-card notif-card">
        <h2 class="section-title"><i class="fa-solid fa-bell" aria-hidden="true"></i> Notifications <span class="badge-count"><?= count($notifications) ?></span></h2>
        <?php foreach ($notifications as $n): ?>
        <div class="notif-item">
            <span class="notif-dot"></span>
            <div>
                <strong><?= htmlspecialchars($n['title']) ?></strong>
                <p><?= htmlspecialchars($n['message']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="/student/apply" class="action-card glass-card action-apply">
            <div class="action-icon"><i class="fa-solid fa-file-circle-plus"></i></div>
            <h3>New Application</h3>
            <p>Apply for bursary funding</p>
        </a>
        <a href="/student/status" class="action-card glass-card action-status">
            <div class="action-icon"><i class="fa-solid fa-list-check"></i></div>
            <h3>My Applications</h3>
            <p>Track your application status</p>
        </a>
        <a href="/student/status?download=1" class="action-card glass-card action-download" id="download-letter">
            <div class="action-icon"><i class="fa-solid fa-file-lines"></i></div>
            <h3>Award Letter</h3>
            <p>Download your bursary letter</p>
        </a>
    </div>

    <!-- Recent Applications -->
    <?php if (!empty($applications)): ?>
    <div class="section-card glass-card">
        <h2 class="section-title"><i class="fa-solid fa-folder-open" aria-hidden="true"></i> Recent Applications</h2>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr><th>Academic Year</th><th>Amount Requested</th><th>Amount Approved</th><th>Status</th><th>Date</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['academic_year']) ?></td>
                        <td>KES <?= number_format((float)$app['amount_requested'], 2) ?></td>
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
    <div class="section-card glass-card text-center">
        <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-inbox" style="font-size:3rem;opacity:0.3;"></i></div>
            <h3>No Applications Yet</h3>
            <p>Start by submitting your first bursary application.</p>
            <a href="/student/apply" class="btn-auth" style="width:auto;display:inline-flex;padding:0.7rem 1.5rem;text-decoration:none;">Apply Now</a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$extraScripts = '<script type="module" src="/assets/js/scene-dashboard.js"></script>';
require __DIR__ . '/../layouts/base.php';
