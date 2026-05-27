<?php
declare(strict_types=1);
$pageTitle = 'Analytics & Reports — NIBS Bursary';
$bodyClass = 'page-admin-reports';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title">📊 Analytics Overview</h2>
        <div class="header-actions">
            <a href="/admin/reports/pdf" class="btn-secondary">Download PDF</a>
            <a href="/admin/reports/csv" class="btn-primary">Export CSV</a>
        </div>
    </div>

    <!-- Summary Widgets -->
    <div class="stats-grid">
        <div class="stat-card glass-card">
            <div class="stat-info">
                <h3>Total Apps</h3>
                <div class="stat-value"><?= $summary['total_applications'] ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-info">
                <h3>Approved</h3>
                <div class="stat-value"><?= $summary['total_approved'] ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-info">
                <h3>Disbursed</h3>
                <div class="stat-value">KES <?= number_format($summary['total_disbursed'], 0) ?></div>
            </div>
        </div>
    </div>

    <div class="reports-grid mt-4">
        <!-- Application Status Chart -->
        <div class="section-card glass-card">
            <h3>Application Status Distribution</h3>
            <canvas id="statusChart"></canvas>
        </div>

        <!-- Monthly Disbursement Chart -->
        <div class="section-card glass-card">
            <h3>Monthly Disbursements</h3>
            <canvas id="disbursementChart"></canvas>
        </div>

        <!-- Applications by Course -->
        <div class="section-card glass-card">
            <h3>Top Courses by Applications</h3>
            <div class="course-stats">
                <?php foreach ($summary['by_course'] as $course): ?>
                <div class="course-item">
                    <span><?= htmlspecialchars($course['course']) ?></span>
                    <strong><?= $course['count'] ?></strong>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
.reports-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}
.reports-grid .section-card:last-child {
    grid-column: span 2;
}
@media (max-width: 768px) {
    .reports-grid { grid-template-columns: 1fr; }
    .reports-grid .section-card:last-child { grid-column: span 1; }
}
.course-stats {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}
.course-item {
    background: rgba(255,255,255,0.05);
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'status') : []) ?>,
            datasets: [{
                data: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'count') : []) ?>,
                backgroundColor: ['#10b981', '#1d73be', '#34d399', '#28a745', '#6c757d'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#fff' } } }
        }
    });

    // Disbursement Chart
    const disburseCtx = document.getElementById('disbursementChart').getContext('2d');
    new Chart(disburseCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'month')) : []) ?>,
            datasets: [{
                label: 'Disbursements (KES)',
                data: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'total')) : []) ?>,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#fff' } },
                x: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#fff' } }
            },
            plugins: { legend: { labels: { color: '#fff' } } }
        }
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
