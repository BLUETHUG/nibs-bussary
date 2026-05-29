<?php
declare(strict_types=1);
$pageTitle = 'Finance Portal — NIBS Bursary';
$bodyClass = 'page-finance';
ob_start();
?>
<style>
.page-finance {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-finance { background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%); }
.page-finance .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; }
[data-theme="dark"] .page-finance .section-title { color: #fff; }
.page-finance .section-title i { color: var(--admin-gold); }
.page-finance .card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-finance .card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-finance .text-muted { color: var(--text-muted); }
.page-finance .text-sm { font-size: 0.82rem; }
.page-finance .text-xs { font-size: 0.72rem; }
.page-finance .stat-value { font-size: 1.4rem; font-weight: 800; color: var(--admin-navy); margin: 0.3rem 0 0; }
[data-theme="dark"] .page-finance .stat-value { color: var(--admin-gold); }
.page-finance .empty-state { text-align: center; padding: 2rem 1rem; }
.page-finance .empty-icon { font-size: 2.5rem; color: var(--admin-gold); margin-bottom: 0.75rem; }
[data-theme="dark"] .page-finance .empty-icon { color: rgba(255,213,79,0.6); }
.page-finance .empty-state h3 { font-size: 1.1rem; color: var(--admin-navy); margin: 0 0 0.3rem; }
[data-theme="dark"] .page-finance .empty-state h3 { color: #fff; }
.page-finance .empty-state p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }
.page-finance .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
.page-finance .badge-info, .page-finance .badge-primary { background: #E8EAF6; color: var(--admin-navy); }
.page-finance .badge-warning { background: #FFF8E1; color: #F57F17; }
[data-theme="dark"] .page-finance .badge-info,
[data-theme="dark"] .page-finance .badge-primary { background: rgba(26,35,126,0.3); color: #9FA8DA; }
[data-theme="dark"] .page-finance .badge-warning { background: rgba(245,127,23,0.15); color: #FFB74D; }
.page-finance .btn {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600;
    padding: 0.4rem 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s; font-size: 0.78rem;
}
.page-finance .btn-success { background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff; }
.page-finance .btn-success:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-finance table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.page-finance th { text-align: left; padding: 0.6rem 0.75rem; font-weight: 600; color: var(--admin-navy); border-bottom: 2px solid var(--admin-gold); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
[data-theme="dark"] .page-finance th { color: var(--admin-gold); }
.page-finance td { padding: 0.6rem 0.75rem; border-bottom: 1px solid var(--border); }
.page-finance tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-finance tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-finance .mb-3 { margin-bottom: 1rem; }
.page-finance .mb-4 { margin-bottom: 1.5rem; }
.page-finance .grid { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem; }
@media (max-width: 900px) { .page-finance .stats-row { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 500px) { .page-finance .stats-row { grid-template-columns: 1fr; } }
</style>
<div class="dashboard-wrapper">
    <h2 class="section-title mb-4"><i class="fa-solid fa-coins"></i> Finance Portal</h2>

    <div class="stats-row" style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
        <div class="card">
            <p style="font-size:0.78rem;color:var(--text-muted);font-weight:500;">Pending Disbursements</p>
            <div class="stat-value"><?= number_format($summary['approved_pending']) ?></div>
        </div>
        <div class="card">
            <p style="font-size:0.78rem;color:var(--text-muted);font-weight:500;">Disbursed Today</p>
            <div class="stat-value">KES <?= number_format((float)$summary['total_disbursed_today'], 0) ?></div>
        </div>
        <div class="card">
            <p style="font-size:0.78rem;color:var(--text-muted);font-weight:500;">Disbursed This Month</p>
            <div class="stat-value">KES <?= number_format((float)$summary['total_disbursed_month'], 0) ?></div>
        </div>
        <div class="card">
            <p style="font-size:0.78rem;color:var(--text-muted);font-weight:500;">Payment Methods</p>
            <div style="margin-top:0.5rem;">
                <?php foreach ($summary['payment_methods'] as $pm): ?>
                <div style="display:flex;justify-content:space-between;font-size:0.82rem;">
                    <span><?= ucfirst($pm['payment_method']) ?> (<?= $pm['count'] ?>)</span>
                    <strong style="color:var(--admin-navy);">KES <?= number_format((float)$pm['total'], 0) ?></strong>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:2rem;">
        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">Pending Disbursements (<?= count($pendingDisbursements) ?>)</h3>
            <?php if (empty($pendingDisbursements)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-check-double"></i></div>
                <h3>All Clear</h3>
                <p>All approved applications have been disbursed.</p>
            </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr><th>Student</th><th>Fund</th><th>Amount</th><th>Bank/M-Pesa</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingDisbursements as $pd): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($pd['full_name']) ?></strong><br><span style="color:var(--text-muted);font-size:0.82rem;"><?= htmlspecialchars($pd['index_number']) ?></span></td>
                            <td><?= htmlspecialchars($pd['fund_name']) ?></td>
                            <td><strong>KES <?= number_format((float)$pd['amount_approved'], 0) ?></strong></td>
                            <td>
                                <?php if ($pd['mpesa_phone']): ?>
                                <span class="badge badge-info">M-Pesa: <?= htmlspecialchars($pd['mpesa_phone']) ?></span>
                                <?php elseif ($pd['bank_name'] && $pd['bank_account']): ?>
                                <span class="badge badge-primary"><?= htmlspecialchars($pd['bank_name']) ?>: <?= htmlspecialchars($pd['bank_account']) ?></span>
                                <?php else: ?>
                                <span class="badge badge-warning">No details</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-success" onclick="disburse(<?= $pd['id'] ?>, '<?= $pd['mpesa_phone'] ? 'mpesa' : 'bank' ?>')">Disburse</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">Recent Disbursements</h3>
            <?php if (empty($recent)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-clock"></i></div>
                <h3>No disbursements yet</h3>
                <p>Disbursed payments will appear here.</p>
            </div>
            <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                <?php foreach ($recent as $r): ?>
                <div style="padding:0.75rem 1rem;background:var(--bg-off);border-radius:10px;border:1px solid var(--border);">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <strong style="font-size:0.85rem;"><?= htmlspecialchars($r['full_name']) ?></strong>
                            <div style="font-size:0.72rem;color:var(--text-muted);">Ref: <?= htmlspecialchars($r['reference_number']) ?></div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--admin-navy);">KES <?= number_format((float)$r['amount'], 0) ?></div>
                            <div style="font-size:0.72rem;color:var(--text-muted);"><?= date('d M Y', strtotime($r['disbursed_at'])) ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function disburse(appId, method) {
    if (!confirm('Confirm disbursement of this amount?')) return;
    var method = prompt('Payment method (mpesa/bank/cash):', method);
    if (!method) return;
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/disburse';
    form.innerHTML = '<?= \App\Middleware\CsrfMiddleware::field() ?>' +
        '<input name="application_id" value="' + appId + '">' +
        '<input name="payment_method" value="' + method + '">' +
        '<input name="notes" value="Disbursed via finance portal">';
    document.body.appendChild(form);
    form.submit();
}
</script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';