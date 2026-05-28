<?php
declare(strict_types=1);
$pageTitle = 'Finance Portal — NIBS Bursary';
$bodyClass = 'page-finance';
ob_start();
?>
<div class="dashboard-wrapper">
    <h2 class="section-title mb-4"><i class="fa-solid fa-coins"></i> Finance Portal</h2>

    <!-- Stats Row -->
    <div class="grid grid-4 gap-2 mb-4">
        <div class="card">
            <p class="text-sm text-muted">Pending Disbursements</p>
            <p class="stat-value"><?= number_format($summary['approved_pending']) ?></p>
        </div>
        <div class="card">
            <p class="text-sm text-muted">Disbursed Today</p>
            <p class="stat-value">KES <?= number_format((float)$summary['total_disbursed_today'], 0) ?></p>
        </div>
        <div class="card">
            <p class="text-sm text-muted">Disbursed This Month</p>
            <p class="stat-value">KES <?= number_format((float)$summary['total_disbursed_month'], 0) ?></p>
        </div>
        <div class="card">
            <p class="text-sm text-muted">Payment Methods</p>
            <div>
                <?php foreach ($summary['payment_methods'] as $pm): ?>
                <div class="flex justify-between text-sm">
                    <span><?= ucfirst($pm['payment_method']) ?> (<?= $pm['count'] ?>)</span>
                    <strong>KES <?= number_format((float)$pm['total'], 0) ?></strong>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1.5fr 1fr; gap: 2rem;">
        <!-- Pending Disbursements -->
        <div class="card">
            <h3 class="mb-3">Pending Disbursements (<?= count($pendingDisbursements) ?>)</h3>
            <?php if (empty($pendingDisbursements)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-check-double"></i></div>
                <h3>All Clear</h3>
                <p>All approved applications have been disbursed.</p>
            </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Fund</th>
                            <th>Amount</th>
                            <th>Bank/M-Pesa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingDisbursements as $pd): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($pd['full_name']) ?></strong><br>
                                <span class="text-sm text-muted"><?= htmlspecialchars($pd['index_number']) ?></span>
                            </td>
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
                                <button class="btn btn-sm btn-success"
                                        onclick="disburse(<?= $pd['id'] ?>, '<?= $pd['mpesa_phone'] ? 'mpesa' : 'bank' ?>')">
                                    Disburse
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Recent Disbursements -->
        <div class="card">
            <h3 class="mb-3">Recent Disbursements</h3>
            <?php if (empty($recent)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-clock"></i></div>
                <h3>No disbursements yet</h3>
                <p>Disbursed payments will appear here.</p>
            </div>
            <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                <?php foreach ($recent as $r): ?>
                <div class="card" style="padding:0.75rem 1rem;">
                    <div class="flex justify-between items-center">
                        <div>
                            <strong class="text-sm"><?= htmlspecialchars($r['full_name']) ?></strong>
                            <div class="text-xs text-muted">Ref: <?= htmlspecialchars($r['reference_number']) ?></div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold">KES <?= number_format((float)$r['amount'], 0) ?></div>
                            <div class="text-xs text-muted"><?= date('d M Y', strtotime($r['disbursed_at'])) ?></div>
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
