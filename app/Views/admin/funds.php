<?php
declare(strict_types=1);
$pageTitle = 'Manage Bursary Funds — NIBS Bursary';
$bodyClass = 'page-admin-funds';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="admin-grid" style="grid-template-columns: 1fr 350px; gap: 2rem;">
        <!-- Funds List -->
        <div class="section-card glass-card">
            <h2 class="section-title">💰 Active Bursary Funds</h2>
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
                            <td>KES <?= number_format($fund->total_amount, 2) ?></td>
                            <td>
                                <div style="display:flex; flex-direction:column; gap:0.3rem;">
                                    <span>KES <?= number_format($fund->available_amount, 2) ?></span>
                                    <div class="fund-progress-container">
                                        <div class="fund-progress-bar" style="width: <?= ($fund->available_amount / $fund->total_amount) * 100 ?>%;"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create New Fund -->
        <div class="section-card glass-card">
            <h2 class="section-title">➕ Create New Fund</h2>
            <form action="/admin/funds/create" method="POST" class="standard-form">
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

<style>
.badge {
    background: rgba(255,255,255,0.1);
    padding: 0.2rem 0.6rem;
    border-radius: 4px;
    font-size: 0.8rem;
}
.fund-progress-container {
    height: 6px;
    background: rgba(255,255,255,0.1);
    border-radius: 3px;
    overflow: hidden;
}
.fund-progress-bar {
    height: 100%;
    background: var(--primary-red);
}
.standard-form .form-group { margin-bottom: 1.2rem; }
.standard-form label { display: block; margin-bottom: 0.4rem; font-size: 0.9rem; opacity: 0.8; }
.standard-form input, .standard-form select {
    width: 100%;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 0.7rem 1rem;
    border-radius: 8px;
}
</style>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
