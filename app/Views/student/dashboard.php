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
<div class="dashboard-wrapper float-in">

    <!-- Welcome Hero -->
    <div class="dash-hero" style="background:linear-gradient(135deg,#312e81 0%,#4f46e5 40%,#6366f1 100%);border-radius:var(--radius-xl);">
        <div style="padding:2rem 2.5rem;display:flex;align-items:center;justify-content:space-between;gap:2rem;flex-wrap:wrap;">
            <div>
                <p style="color:rgba(255,255,255,0.5);font-size:0.8rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin:0 0 0.35rem 0;"><?= $greeting ?></p>
                <h1 style="color:#fff;font-size:1.65rem;margin:0 0 0.25rem 0;"><?= htmlspecialchars($_SESSION['full_name']) ?></h1>
                <p style="color:rgba(255,255,255,0.55);font-size:0.9rem;margin:0;">Manage your bursary applications at NIBS Technical College</p>
            </div>
            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" style="flex-shrink:0;">
                <rect width="56" height="56" rx="14" fill="#fff" fill-opacity="0.1"/>
                <rect x="3" y="3" width="50" height="50" rx="11" fill="url(#dashhero)"/>
                <defs><linearGradient id="dashhero" x1="0" y1="0" x2="56" y2="56"><stop stop-color="#818cf8"/><stop offset="1" stop-color="#a5b4fc"/></linearGradient></defs>
                <text x="28" y="37" text-anchor="middle" font-size="28" font-weight="bold" fill="#312e81" font-family="Inter">N</text>
            </svg>
        </div>
    </div>

    <!-- Stats Row -->
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin:1.5rem 0;">
        <div class="glass-card" style="padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;border-radius:var(--radius);background:var(--primary-light);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--primary);flex-shrink:0;"><i class="fa-solid fa-folder"></i></div>
            <div>
                <p style="margin:0;font-size:0.75rem;color:var(--text-muted);font-weight:500;">Total</p>
                <p style="margin:0;font-size:1.5rem;font-weight:800;color:var(--text);letter-spacing:-0.03em;"><?= $totalApps ?></p>
            </div>
        </div>
        <div class="glass-card" style="padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;border-radius:var(--radius);background:#fffbeb;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#d97706;flex-shrink:0;"><i class="fa-solid fa-hourglass-half"></i></div>
            <div>
                <p style="margin:0;font-size:0.75rem;color:var(--text-muted);font-weight:500;">Pending</p>
                <p style="margin:0;font-size:1.5rem;font-weight:800;color:#d97706;letter-spacing:-0.03em;"><?= $pending ?></p>
            </div>
        </div>
        <div class="glass-card" style="padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;border-radius:var(--radius);background:#ecfdf5;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#059669;flex-shrink:0;"><i class="fa-solid fa-check-circle"></i></div>
            <div>
                <p style="margin:0;font-size:0.75rem;color:var(--text-muted);font-weight:500;">Approved</p>
                <p style="margin:0;font-size:1.5rem;font-weight:800;color:#059669;letter-spacing:-0.03em;"><?= $approved ?></p>
            </div>
        </div>
        <div class="glass-card" style="padding:1.25rem;display:flex;align-items:center;gap:1rem;">
            <div style="width:44px;height:44px;border-radius:var(--radius);background:#eef2ff;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#4f46e5;flex-shrink:0;"><i class="fa-solid fa-coins"></i></div>
            <div>
                <p style="margin:0;font-size:0.75rem;color:var(--text-muted);font-weight:500;">Disbursed</p>
                <p style="margin:0;font-size:1.5rem;font-weight:800;color:#4f46e5;letter-spacing:-0.03em;"><?= $disbursed ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
        <a href="/student/apply" class="glass-card action-apply" style="text-decoration:none;padding:1.5rem;text-align:center;cursor:pointer;transition:var(--transition);">
            <div style="width:52px;height:52px;border-radius:var(--radius);background:var(--primary-light);color:var(--primary);display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;font-size:1.3rem;transition:var(--transition);"><i class="fa-solid fa-file-circle-plus"></i></div>
            <h3 style="font-size:0.95rem;margin:0 0 0.25rem 0;">New Application</h3>
            <p style="font-size:0.8rem;color:var(--text-muted);margin:0;">Apply for bursary funding</p>
        </a>
        <a href="/student/status" class="glass-card action-status" style="text-decoration:none;padding:1.5rem;text-align:center;cursor:pointer;transition:var(--transition);">
            <div style="width:52px;height:52px;border-radius:var(--radius);background:#ecfdf5;color:#059669;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;font-size:1.3rem;transition:var(--transition);"><i class="fa-solid fa-list-check"></i></div>
            <h3 style="font-size:0.95rem;margin:0 0 0.25rem 0;">My Applications</h3>
            <p style="font-size:0.8rem;color:var(--text-muted);margin:0;">Track your application status</p>
        </a>
        <a href="/student/status?download=1" class="glass-card action-download" style="text-decoration:none;padding:1.5rem;text-align:center;cursor:pointer;transition:var(--transition);">
            <div style="width:52px;height:52px;border-radius:var(--radius);background:#fffbeb;color:#d97706;display:flex;align-items:center;justify-content:center;margin:0 auto 0.75rem;font-size:1.3rem;transition:var(--transition);"><i class="fa-solid fa-file-lines"></i></div>
            <h3 style="font-size:0.95rem;margin:0 0 0.25rem 0;">Award Letter</h3>
            <p style="font-size:0.8rem;color:var(--text-muted);margin:0;">Download your bursary letter</p>
        </a>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
        <!-- Announcements -->
        <div class="glass-card reveal">
            <h2 class="section-title" style="margin-bottom:1rem;"><i class="fa-solid fa-bullhorn" style="color:var(--primary);"></i> Announcements</h2>
            <?php if (!empty($announcements)): ?>
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                <?php foreach ($announcements as $ann): ?>
                <div style="display:flex;gap:0.75rem;padding:0.75rem;border-radius:var(--radius);background:var(--bg);transition:var(--transition);">
                    <div style="color:var(--primary);font-size:1rem;padding-top:0.15rem;flex-shrink:0;"><i class="fa-solid fa-thumbtack"></i></div>
                    <div>
                        <strong style="font-size:0.9rem;display:block;margin-bottom:0.15rem;"><?= htmlspecialchars($ann['title']) ?></strong>
                        <p style="font-size:0.85rem;color:var(--text-secondary);margin:0 0 0.25rem 0;"><?= htmlspecialchars($ann['body']) ?></p>
                        <span style="font-size:0.75rem;color:var(--text-muted);"><?= date('d M Y', strtotime($ann['created_at'])) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color:var(--text-muted);font-size:0.85rem;margin:0;">No announcements at this time.</p>
            <?php endif; ?>
        </div>

        <!-- Notifications -->
        <div class="glass-card reveal">
            <h2 class="section-title" style="margin-bottom:1rem;"><i class="fa-solid fa-bell" style="color:var(--accent);"></i> Notifications <?php if (!empty($notifications)): ?><span class="badge-count"><?= count($notifications) ?></span><?php endif; ?></h2>
            <?php if (!empty($notifications)): ?>
            <div style="display:flex;flex-direction:column;">
                <?php foreach ($notifications as $n): ?>
                <div style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem;border-bottom:1px solid var(--border-light);transition:var(--transition);">
                    <span style="width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0;margin-top:0.4rem;"></span>
                    <div>
                        <strong style="font-size:0.875rem;"><?= htmlspecialchars($n['title']) ?></strong>
                        <p style="font-size:0.8rem;color:var(--text-secondary);margin:0.1rem 0 0;"><?= htmlspecialchars($n['message']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color:var(--text-muted);font-size:0.85rem;margin:0;">No new notifications.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recent Applications -->
    <?php if (!empty($applications)): ?>
    <div class="glass-card reveal">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
            <h2 class="section-title" style="margin:0;"><i class="fa-solid fa-folder-open" style="color:var(--primary);"></i> Recent Applications</h2>
            <a href="/student/status" class="btn-text">View All →</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
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
    <div class="glass-card text-center reveal">
        <div style="padding:2.5rem 1rem;">
            <div style="font-size:3rem;margin-bottom:1rem;opacity:0.3;color:var(--text-muted);"><i class="fa-solid fa-inbox"></i></div>
            <h3 style="margin-bottom:0.5rem;">No Applications Yet</h3>
            <p style="color:var(--text-muted);margin-bottom:1.5rem;">Start by submitting your first bursary application.</p>
            <a href="/student/apply" class="btn-primary" style="text-decoration:none;display:inline-flex;padding:0.7rem 1.5rem;">Apply Now →</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.action-apply:hover, .action-status:hover, .action-download:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}
</style>
<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
