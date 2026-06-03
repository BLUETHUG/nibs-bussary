<?php
declare(strict_types=1);
$pageTitle = 'Finance Portal — NIBS Bursary';
$bodyClass = 'page-finance';
ob_start();
?>

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
                    <strong style="color:var(--primary);">KES <?= number_format((float)$pm['total'], 0) ?></strong>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:2rem;">
        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--primary);margin:0 0 1rem;">Pending Disbursements (<?= count($pendingDisbursements) ?>)</h3>
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
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--primary);margin:0 0 1rem;">Recent Disbursements</h3>
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
                            <div style="font-size:0.85rem;font-weight:700;color:var(--primary);">KES <?= number_format((float)$r['amount'], 0) ?></div>
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