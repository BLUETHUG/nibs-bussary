<?php
declare(strict_types=1);
$pageTitle = 'Admin Dashboard — NIBS Bursary';
$bodyClass = 'page-admin-dashboard';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card glass-card">
            <div class="stat-icon"><i class="fa-solid fa-folder"></i></div>
            <div class="stat-info">
                <h3>Total Applications</h3>
                <div class="stat-value"><?= number_format((float)$stats['total']) ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="color: var(--warning-yellow);"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <h3>Pending Review</h3>
                <div class="stat-value"><?= number_format((float)$stats['pending']) ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="color: var(--success-green);"><i class="fa-solid fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>Approved</h3>
                <div class="stat-value"><?= number_format((float)$stats['approved']) ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="color: var(--primary-blue);"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <h3>Total Disbursed</h3>
                <div class="stat-value">KES <?= number_format((float)$stats['total_disbursed'], 0) ?></div>
            </div>
        </div>
    </div>

    <div class="admin-grid mt-4">
        <!-- Recent Applications -->
        <div class="section-card glass-card">
            <div class="card-header">
                <h2 class="section-title"><i class="fa-solid fa-clock"></i> Recent Applications</h2>
                <a href="/admin/applications" class="btn-text">View All →</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentApps as $app): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($app['full_name']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($app['index_number']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($app['course']) ?></td>
                            <td><span class="status-badge status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></td>
                            <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                            <td><a href="/admin/review?id=<?= $app['id'] ?>" class="btn-action">Review</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Available Funds -->
        <div class="section-card glass-card">
            <div class="card-header">
                <h2 class="section-title"><i class="fa-solid fa-coins"></i> Available Funds</h2>
                <a href="/admin/funds" class="btn-text">Manage →</a>
            </div>
            <div class="funds-list">
                <?php foreach ($funds as $fund): ?>
                <div class="fund-item">
                    <div class="fund-info">
                        <strong><?= htmlspecialchars($fund->fund_name) ?></strong>
                        <small><?= htmlspecialchars($fund->academic_year) ?> - <?= ucfirst($fund->source) ?></small>
                    </div>
                    <div class="fund-progress-container">
                        <div class="fund-progress-bar" style="width: <?= ($fund->available_amount / $fund->total_amount) * 100 ?>%;"></div>
                    </div>
                    <div class="fund-amounts">
                        <span>KES <?= number_format($fund->available_amount, 0) ?> left</span>
                        <span class="text-muted">of KES <?= number_format($fund->total_amount, 0) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}
.stat-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
}
.stat-icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
}
.stat-value {
    font-size: 1.8rem;
    font-weight: 800;
    font-family: 'Roboto Slab', serif;
}
.admin-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}
@media (max-width: 1024px) {
    .admin-grid { grid-template-columns: 1fr; }
}
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.fund-item {
    margin-bottom: 1.5rem;
}
.fund-progress-container {
    height: 8px;
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
    margin: 0.5rem 0;
    overflow: hidden;
}
.fund-progress-bar {
    height: 100%;
    background: var(--primary-red);
    border-radius: 4px;
}
.fund-amounts {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
}
.btn-action {
    background: var(--primary-red);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
}
</style>

<?php
$content = ob_get_clean();
$extraScripts = '<script type="module" src="/assets/js/scene-admin.js"></script>';
require __DIR__ . '/../layouts/base.php';
