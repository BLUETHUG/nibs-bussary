<?php
declare(strict_types=1);
$pageTitle = 'My Applications — NIBS Bursary';
$bodyClass = 'page-student-status';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title"><i class="fa-solid fa-list"></i> My Applications</h2>
        <a href="/student/apply" class="btn-primary">New Application</a>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success"><i class="fa-solid fa-check-circle" aria-hidden="true"></i> Application submitted successfully!</div>
    <?php endif; ?>

    <div class="section-card glass-card">
        <?php if (empty($applications)): ?>
        <div class="empty-state text-center">
            <div class="empty-icon"><i class="fa-solid fa-inbox" style="font-size:3rem;opacity:0.3;"></i></div>
            <h3>No Applications Yet</h3>
            <p class="text-muted">You haven't submitted any applications. Start your bursary journey today.</p>
            <a href="/student/apply" class="btn-primary mt-4">Apply Now</a>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Amount Requested</th>
                        <th>Amount Approved</th>
                        <th>Status</th>
                        <th>Submitted</th>
                    </tr>
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
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
