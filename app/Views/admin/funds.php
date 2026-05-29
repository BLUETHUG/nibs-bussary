<?php
declare(strict_types=1);
$pageTitle = 'Manage Bursary Funds — NIBS Bursary';
$bodyClass = 'page-admin-funds';
ob_start();
?>
<style>
.page-admin-funds {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-navy-dark: #0D1442;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-funds {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%);
}
.page-admin-funds .section-title { font-size: 1.05rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; margin: 0 0 1rem; }
[data-theme="dark"] .page-admin-funds .section-title { color: #fff; }
.page-admin-funds .section-title i { color: var(--admin-gold); }
.page-admin-funds .glass-card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-funds .glass-card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-admin-funds .data-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.page-admin-funds .data-table th {
    text-align: left; padding: 0.75rem 1rem; font-weight: 600; color: var(--admin-navy);
    border-bottom: 2px solid var(--admin-gold); white-space: nowrap; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
}
[data-theme="dark"] .page-admin-funds .data-table th { color: var(--admin-gold); }
.page-admin-funds .data-table td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
.page-admin-funds .data-table tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-admin-funds .data-table tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-admin-funds .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; background: #E8EAF6; color: var(--admin-navy); text-transform: capitalize; }
[data-theme="dark"] .page-admin-funds .badge { background: rgba(26,35,126,0.3); color: #9FA8DA; }
.page-admin-funds .form-group { margin-bottom: 1rem; }
.page-admin-funds .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.3rem; }
[data-theme="dark"] .page-admin-funds .form-group label { color: rgba(255,255,255,0.6); }
.page-admin-funds .form-group input,
.page-admin-funds .form-group select { width: 100%; padding: 0.55rem 0.85rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-family: 'Poppins', sans-serif; font-size: 0.85rem; }
.page-admin-funds .btn-primary {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
    padding: 0.6rem 1.25rem; background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff;
    transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; justify-content: center;
}
.page-admin-funds .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-admin-funds .w-100 { width: 100%; }
.page-admin-funds .fund-progress-container { height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; }
.page-admin-funds .fund-progress-bar { height: 100%; background: linear-gradient(90deg, var(--admin-navy), var(--admin-gold)); border-radius: 3px; transition: width 0.6s ease; }
[data-theme="dark"] .page-admin-funds .fund-progress-bar { background: linear-gradient(90deg, #3949AB, var(--admin-gold)); }
</style>
<div class="dashboard-wrapper">
    <div class="admin-grid" style="display:grid;grid-template-columns:1fr 350px;gap:2rem;">
        <div class="glass-card">
            <h2 class="section-title"><i class="fa-solid fa-coins"></i> Active Bursary Funds</h2>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Fund Name</th>
                            <th>Academic Year</th>
                            <th>Source</th>
                            <th>Total Amount</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($funds as $fund): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($fund->fund_name) ?></strong></td>
                            <td><?= htmlspecialchars($fund->academic_year) ?></td>
                            <td><span class="badge"><?= ucfirst($fund->source) ?></span></td>
                            <td>KES <?= number_format((float)$fund->total_amount, 2) ?></td>
                            <td>
                                <div style="display:flex;flex-direction:column;gap:0.3rem;">
                                    <span>KES <?= number_format((float)$fund->available_amount, 2) ?></span>
                                    <div class="fund-progress-container">
                                        <div class="fund-progress-bar" style="width: <?= ((float)$fund->available_amount / max((float)$fund->total_amount, 1)) * 100 ?>%;"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="glass-card">
            <h2 class="section-title"><i class="fa-solid fa-plus-circle"></i> Create New Fund</h2>
            <form action="/admin/funds/create" method="POST">
                <?= \App\Middleware\CsrfMiddleware::field() ?>
                <div class="form-group">
                    <label>Fund Name</label>
                    <input type="text" name="fund_name" required placeholder="e.g. Presidential Bursary 2024">
                </div>
                <div class="form-group">
                    <label>Total Amount (KES)</label>
                    <input type="number" name="total_amount" required step="0.01">
                </div>
                <div class="form-group">
                    <label>Academic Year</label>
                    <input type="text" name="academic_year" required placeholder="2024/2025">
                </div>
                <div class="form-group">
                    <label>Source</label>
                    <select name="source" required>
                        <option value="government">Government</option>
                        <option value="donor">Private Donor</option>
                        <option value="institution">Institution (NIBS)</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary w-100">Create Fund</button>
            </form>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
