<?php
declare(strict_types=1);
$pageTitle = 'Admin Dashboard — NIBS Bursary';
$bodyClass = 'page-admin-dashboard';
ob_start();
?>
<style>
html[data-theme="dark"] .page-admin-dashboard {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%) !important;
}
</style>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title"><i class="fa-solid fa-chart-pie"></i> Admin Overview</h2>
        <div class="header-actions">
            <a href="/admin/reports" class="btn btn-secondary btn-sm"><i class="fa-solid fa-chart-simple"></i> Full Reports</a>
        </div>
    </div>

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
            <div class="stat-icon" style="color: var(--warning);"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <h3>Pending Review</h3>
                <div class="stat-value"><?= number_format((float)$stats['pending']) ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="color: var(--success);"><i class="fa-solid fa-check-circle"></i></div>
            <div class="stat-info">
                <h3>Approved</h3>
                <div class="stat-value"><?= number_format((float)$stats['approved']) ?></div>
            </div>
        </div>
        <div class="stat-card glass-card">
            <div class="stat-icon" style="color: var(--primary);"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <h3>Total Disbursed</h3>
                <div class="stat-value">KES <?= number_format((float)$stats['total_disbursed'], 0) ?></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="admin-grid mt-4" style="grid-template-columns: 1fr 1fr;">
        <div class="section-card glass-card">
            <h3 class="section-title" style="font-size:0.95rem;"><i class="fa-solid fa-chart-donut"></i> Applications by Status</h3>
            <canvas id="statusChart" height="200"></canvas>
        </div>
        <div class="section-card glass-card">
            <h3 class="section-title" style="font-size:0.95rem;"><i class="fa-solid fa-venus-mars"></i> By Gender</h3>
            <canvas id="genderChart" height="200"></canvas>
        </div>
    </div>

    <div class="admin-grid mt-4" style="grid-template-columns: 1fr 1fr;">
        <div class="section-card glass-card">
            <h3 class="section-title" style="font-size:0.95rem;"><i class="fa-solid fa-chart-line"></i> Monthly Applications</h3>
            <canvas id="monthlyAppsChart" height="180"></canvas>
        </div>
        <div class="section-card glass-card">
            <h3 class="section-title" style="font-size:0.95rem;"><i class="fa-solid fa-chart-line"></i> Monthly Disbursements</h3>
            <canvas id="monthlyDisburseChart" height="180"></canvas>
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
                        <div class="fund-progress-bar" style="width: <?= ($fund->available_amount / max($fund->total_amount, 1)) * 100 ?>%;"></div>
                    </div>
                    <div class="fund-amounts">
                        <span>KES <?= number_format((float)$fund->available_amount, 0) ?> left</span>
                        <span class="text-muted">of KES <?= number_format((float)$fund->total_amount, 0) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function getChartColors() {
        var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        return {
            text: isDark ? '#cbd5e1' : '#475569',
            grid: isDark ? 'rgba(255,255,255,0.06)' : '#e2e8f0',
            border: isDark ? 'rgba(255,255,255,0.1)' : '#e2e8f0'
        };
    }

    var colors = getChartColors();

    // Status Chart
    var statusEl = document.getElementById('statusChart');
    if (statusEl) {
        new Chart(statusEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(!empty($byStatus) ? array_column($byStatus, 'status') : []) ?>,
                datasets: [{
                    data: <?= json_encode(!empty($byStatus) ? array_column($byStatus, 'count') : []) ?>,
                    backgroundColor: ['#2563eb', '#f59e0b', '#10b981', '#ef4444', '#94a3b8'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: colors.text, boxWidth: 12, padding: 12 } }
                }
            }
        });
    }

    // Gender Chart
    var genderEl = document.getElementById('genderChart');
    if (genderEl) {
        new Chart(genderEl.getContext('2d'), {
            type: 'pie',
            data: {
                labels: <?= json_encode(!empty($byGender) ? array_column($byGender, 'gender') : []) ?>,
                datasets: [{
                    data: <?= json_encode(!empty($byGender) ? array_column($byGender, 'count') : []) ?>,
                    backgroundColor: ['#818cf8', '#f472b6', '#94a3b8'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: colors.text, boxWidth: 12, padding: 12 } }
                }
            }
        });
    }

    // Monthly Applications
    var monthlyAppsEl = document.getElementById('monthlyAppsChart');
    if (monthlyAppsEl) {
        new Chart(monthlyAppsEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode(!empty($monthlyApps) ? array_column($monthlyApps, 'month') : []) ?>,
                datasets: [{
                    label: 'Applications',
                    data: <?= json_encode(!empty($monthlyApps) ? array_column($monthlyApps, 'count') : []) ?>,
                    backgroundColor: 'rgba(79,70,229,0.6)',
                    borderColor: '#4f46e5',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, grid: { color: colors.grid }, ticks: { color: colors.text } },
                    x: { grid: { display: false }, ticks: { color: colors.text, maxRotation: 45 } }
                },
                plugins: { legend: { labels: { color: colors.text } } }
            }
        });
    }

    // Monthly Disbursements
    var mdEl = document.getElementById('monthlyDisburseChart');
    if (mdEl) {
        new Chart(mdEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: <?= json_encode(!empty($monthlyDisbursed) ? array_column($monthlyDisbursed, 'month') : []) ?>,
                datasets: [{
                    label: 'Disbursed (KES)',
                    data: <?= json_encode(!empty($monthlyDisbursed) ? array_column($monthlyDisbursed, 'total') : []) ?>,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, grid: { color: colors.grid }, ticks: { color: colors.text, callback: function(v) { return 'KES ' + v.toLocaleString(); } } },
                    x: { grid: { display: false }, ticks: { color: colors.text, maxRotation: 45 } }
                },
                plugins: { legend: { labels: { color: colors.text } } }
            }
        });
    }
});
</script>

<?php
$content = ob_get_clean();
$extraScripts = '';
require __DIR__ . '/../layouts/base.php';
