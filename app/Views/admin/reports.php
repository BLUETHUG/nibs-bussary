<?php
declare(strict_types=1);
$pageTitle = 'Analytics & Reports — NIBS Bursary';
$bodyClass = 'page-admin-reports';
ob_start();
?>
<style>
.page-admin-reports {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-reports {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%);
}
.page-admin-reports .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; margin: 0; }
[data-theme="dark"] .page-admin-reports .section-title { color: #fff; }
.page-admin-reports .section-title i { color: var(--admin-gold); }
.page-admin-reports .glass-card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-reports .glass-card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-admin-reports .card-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
.page-admin-reports .header-actions { display: flex; gap: 0.75rem; }
.page-admin-reports .btn {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600; font-size: 0.82rem;
    padding: 0.5rem 1.25rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;
}
.page-admin-reports .btn-primary { background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff; }
.page-admin-reports .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-admin-reports .btn-secondary { background: var(--bg-off); color: var(--text-secondary); border: 1px solid var(--border); }
.page-admin-reports .btn-secondary:hover { background: var(--admin-navy); color: #fff; }
.page-admin-reports .stats-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.5rem; margin-bottom: 1.5rem; }
@media (max-width:768px) { .page-admin-reports .stats-grid { grid-template-columns: 1fr; } }
.page-admin-reports .stat-card { text-align: center; }
.page-admin-reports .stat-card h3 { font-size: 0.78rem; color: var(--text-muted); font-weight: 500; margin: 0 0 0.3rem; text-transform: uppercase; letter-spacing: 0.5px; }
.page-admin-reports .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--admin-navy); }
[data-theme="dark"] .page-admin-reports .stat-value { color: var(--admin-gold); }
.page-admin-reports .reports-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media (max-width:900px) { .page-admin-reports .reports-grid { grid-template-columns: 1fr; } }
.page-admin-reports .reports-grid h3 { font-size: 0.9rem; font-weight: 600; color: var(--admin-navy); margin: 0 0 1rem; }
[data-theme="dark"] .page-admin-reports .reports-grid h3 { color: #fff; }
.page-admin-reports .course-stats { display: flex; flex-direction: column; gap: 0.5rem; }
.page-admin-reports .course-item { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border); font-size: 0.85rem; }
.page-admin-reports .course-item:last-child { border-bottom: none; }
.page-admin-reports .course-item strong { color: var(--admin-navy); }
[data-theme="dark"] .page-admin-reports .course-item strong { color: var(--admin-gold); }
.page-admin-reports .mt-4 { margin-top: 1.5rem; }
</style>
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
    var navy = '#1A237E';
    var gold = '#FFD54F';
    var navyLight = '#283593';

    function ch(el, type, data, opts) {
        if (!el) return;
        new Chart(el.getContext('2d'), { type: type, data: data, options: opts || { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: textColor } } } } });
    }

    ch(document.getElementById('statusChart'), 'doughnut', {
        labels: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'status') : []) ?>,
        datasets: [{ data: <?= json_encode(!empty($summary['by_status']) ? array_column($summary['by_status'], 'count') : []) ?>, backgroundColor: [navy, gold, '#10b981', '#ef4444', '#94a3b8'], borderWidth: 0 }]
    });

    ch(document.getElementById('genderChart'), 'pie', {
        labels: <?= json_encode(!empty($summary['by_gender']) ? array_column($summary['by_gender'], 'gender') : []) ?>,
        datasets: [{ data: <?= json_encode(!empty($summary['by_gender']) ? array_column($summary['by_gender'], 'count') : []) ?>, backgroundColor: [navy, '#f472b6', '#94a3b8'], borderWidth: 0 }]
    });

    ch(document.getElementById('disbursementChart'), 'line', {
        labels: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'month')) : []) ?>,
        datasets: [{
            label: 'Disbursements (KES)', data: <?= json_encode(!empty($summary['monthly_disbursed']) ? array_reverse(array_column($summary['monthly_disbursed'], 'total')) : []) ?>,
            borderColor: navy, backgroundColor: navy.replace(')', ',0.1)').replace('#1A237E', 'rgba(26,35,126'), fill: true, tension: 0.4
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
