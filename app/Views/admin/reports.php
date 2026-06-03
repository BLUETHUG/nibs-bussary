<?php
declare(strict_types=1);
$pageTitle = 'Analytics & Reports — NIBS Bursary';
$bodyClass = 'page-admin-reports';
ob_start();
?>

<div class="dashboard-wrapper">
    <div class="card-header">
        <h2 class="section-title"><i class="fa-solid fa-chart-bar"></i> Analytics Overview</h2>
        <div class="header-actions">
            <a href="/admin/reports/pdf" class="btn btn-secondary"><i class="fa-solid fa-file-pdf"></i> PDF</a>
            <a href="/admin/reports/csv" class="btn btn-primary"><i class="fa-solid fa-file-csv"></i> CSV</a>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card glass-card">
            <h3>Total Apps</h3>
            <div class="stat-value"><?= $summary['total_applications'] ?></div>
        </div>
        <div class="stat-card glass-card">
            <h3>Approved</h3>
            <div class="stat-value"><?= $summary['total_approved'] ?></div>
        </div>
        <div class="stat-card glass-card">
            <h3>Disbursed</h3>
            <div class="stat-value">KES <?= number_format($summary['total_disbursed'], 0) ?></div>
        </div>
    </div>

    <div class="reports-grid">
        <div class="glass-card">
            <h3>Application Status Distribution</h3>
            <canvas id="statusChart"></canvas>
        </div>
        <div class="glass-card">
            <h3>Monthly Disbursements</h3>
            <canvas id="disbursementChart"></canvas>
        </div>
        <div class="glass-card">
            <h3>Applications by Gender</h3>
            <canvas id="genderChart"></canvas>
        </div>
        <div class="glass-card">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    var textColor = isDark ? '#cbd5e1' : '#475569';
    var gridColor = isDark ? 'rgba(255,255,255,0.06)' : '#e2e8f0';
    var navy = '#0EA5E9';
    var gold = '#6366F1';
    var navyLight = '#0284C7';

    function ch(el, type, data, opts) {
        if (!el) return;
        new Chart(el.getContext('2d'), { type: type, data: data, options: opts || { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: textColor } } } } });
    }

    ch(document.getElementById('statusChart'), 'doughnut', {
        labels: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'status') : []) ?>,
        datasets: [{ data: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'count') : []) ?>, backgroundColor: [navy, gold, '#22C55E', '#EF4444', '#94a3b8'], borderWidth: 0 }]
    });

    ch(document.getElementById('genderChart'), 'pie', {
        labels: <?= json_encode(!empty($summary['by_gender']) ? array_column($summary['by_gender'], 'gender') : []) ?>,
        datasets: [{ data: <?= json_encode(!empty($summary['by_gender']) ? array_column($summary['by_gender'], 'count') : []) ?>, backgroundColor: [navy, '#f472b6', '#94a3b8'], borderWidth: 0 }]
    });

    ch(document.getElementById('disbursementChart'), 'line', {
        labels: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'month')) : []) ?>,
        datasets: [{
            label: 'Disbursements (KES)', data: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'total')) : []) ?>,
            borderColor: navy, backgroundColor: 'rgba(14,165,233,0.1)', fill: true, tension: 0.4
        }]
    }, {
        responsive: true,
        scales: { y: { grid: { color: gridColor }, ticks: { color: textColor, callback: function(v) { return 'KES ' + v.toLocaleString(); } } }, x: { grid: { color: gridColor }, ticks: { color: textColor } } },
        plugins: { legend: { labels: { color: textColor } } }
    });
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
