<?php
declare(strict_types=1);
$pageTitle = 'Manage Applications — NIBS Bursary';
$bodyClass = 'page-admin-applications';
ob_start();
?>
<style>
.page-admin-applications {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-navy-dark: #0D1442;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-applications {
    background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%);
}
.page-admin-applications .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; margin: 0; }
[data-theme="dark"] .page-admin-applications .section-title { color: #fff; }
.page-admin-applications .section-title i { color: var(--admin-gold); }
.page-admin-applications .glass-card,
.page-admin-applications .card {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-applications .glass-card,
[data-theme="dark"] .page-admin-applications .card {
    background: rgba(26,35,62,0.85);
    border-color: rgba(255,255,255,0.06);
}
.page-admin-applications .card-header {
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
}
.page-admin-applications .header-actions { display: flex; gap: 1rem; }
.page-admin-applications .search-form { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.page-admin-applications .search-form input,
.page-admin-applications .search-form select {
    padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 0.82rem; font-family: 'Poppins', sans-serif;
}
.page-admin-applications .data-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.page-admin-applications .data-table th {
    text-align: left; padding: 0.75rem 1rem; font-weight: 600; color: var(--admin-navy); border-bottom: 2px solid var(--admin-gold); white-space: nowrap; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
}
[data-theme="dark"] .page-admin-applications .data-table th { color: var(--admin-gold); }
.page-admin-applications .data-table td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
.page-admin-applications .data-table tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-admin-applications .data-table tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-admin-applications .action-buttons { display: flex; gap: 0.4rem; }
.page-admin-applications .btn-icon {
    text-decoration: none; font-size: 1rem; padding: 0.4rem 0.6rem; border-radius: 8px; background: var(--bg-off); border: 1px solid var(--border); color: var(--text-secondary); cursor: pointer; transition: all 0.2s;
}
.page-admin-applications .btn-icon:hover { background: var(--admin-navy); color: #fff; border-color: var(--admin-navy); }
.page-admin-applications .btn { font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600; font-size: 0.82rem; transition: all 0.2s; padding: 0.5rem 1.25rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; }
.page-admin-applications .btn-primary { background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff; }
.page-admin-applications .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-admin-applications .btn-secondary { background: var(--bg-off); color: var(--text-secondary); border: 1px solid var(--border); }
.page-admin-applications .btn-secondary:hover { background: var(--admin-navy); color: #fff; }
.page-admin-applications .btn-sm { padding: 0.4rem 1rem; font-size: 0.78rem; }
.page-admin-applications .text-muted { color: var(--text-muted); }
.page-admin-applications .text-center { text-align: center; }
[data-theme="dark"] .page-admin-applications .text-center { color: var(--text-secondary); }
.page-admin-applications .py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
.page-admin-applications .modal {
    display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.6); backdrop-filter: blur(6px); align-items: center; justify-content: center;
}
.page-admin-applications .modal.open { display: flex; }
.page-admin-applications .modal-content { width: 100%; max-width: 460px; padding: 2rem; }
.page-admin-applications .modal-content h3 { color: var(--admin-navy); margin: 0 0 1rem; font-size: 1.1rem; }
[data-theme="dark"] .page-admin-applications .modal-content h3 { color: #fff; }
.page-admin-applications .modal-actions { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; }
.page-admin-applications .form-group { margin-bottom: 1rem; }
.page-admin-applications .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.3rem; }
[data-theme="dark"] .page-admin-applications .form-group label { color: rgba(255,255,255,0.6); }
.page-admin-applications .form-group select,
.page-admin-applications .form-group textarea {
    width: 100%; padding: 0.55rem 0.85rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-family: 'Poppins', sans-serif; font-size: 0.85rem;
}
.page-admin-applications .status-badge { display: inline-block; padding: 0.25rem 0.7rem; border-radius: 999px; font-size: 0.72rem; font-weight: 600; text-transform: capitalize; }
.page-admin-applications .status-pending { background: #FFF8E1; color: #F57F17; }
.page-admin-applications .status-approved { background: #E8F5E9; color: #2E7D32; }
.page-admin-applications .status-rejected { background: #FFEBEE; color: #C62828; }
.page-admin-applications .status-disbursed { background: #E8EAF6; color: var(--admin-navy); }
[data-theme="dark"] .page-admin-applications .status-pending { background: rgba(245,127,23,0.15); color: #FFB74D; }
[data-theme="dark"] .page-admin-applications .status-approved { background: rgba(46,125,50,0.15); color: #81C784; }
[data-theme="dark"] .page-admin-applications .status-rejected { background: rgba(198,40,40,0.15); color: #E57373; }
[data-theme="dark"] .page-admin-applications .status-disbursed { background: rgba(26,35,126,0.2); color: #9FA8DA; }
</style>
<div class="dashboard-wrapper">
    <div class="glass-card">
        <div class="card-header">
            <h2 class="section-title"><i class="fa-solid fa-clipboard-list"></i> Bursary Applications</h2>
            <div class="header-actions">
                <form action="/admin/applications" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Search name, index or course..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    <select name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= ($_GET['status'] ?? '') === 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= ($_GET['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        <option value="disbursed" <?= ($_GET['status'] ?? '') === 'disbursed' ? 'selected' : '' ?>>Disbursed</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Student Details</th>
                        <th>Course & Year</th>
                        <th>Requested</th>
                        <th>Approved</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                    <tr><td colspan="7" class="text-center" style="padding:2rem 1rem;color:var(--text-muted);">No applications found matching your criteria.</td></tr>
                    <?php else: ?>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($app['full_name']) ?></strong><br>
                                <small style="color:var(--text-muted);"><?= htmlspecialchars($app['index_number']) ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($app['course']) ?><br>
                                <small style="color:var(--text-muted);">Year <?= $app['year_of_study'] ?></small>
                            </td>
                            <td>KES <?= number_format((float)$app['amount_requested'], 2) ?></td>
                            <td>KES <?= number_format((float)$app['amount_approved'], 2) ?></td>
                            <td><span class="status-badge status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></td>
                            <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/admin/review?id=<?= $app['id'] ?>" class="btn-icon" title="Review"><i class="fa-solid fa-eye"></i></a>
                                    <?php if ($app['status'] === 'approved' && $_SESSION['role'] === 'accountant'): ?>
                                    <button class="btn-icon btn-disburse" data-id="<?= $app['id'] ?>" title="Disburse"><i class="fa-solid fa-hand-holding-dollar"></i></button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="disburse-modal" class="modal">
    <div class="modal-content glass-card">
        <h3>Confirm Disbursement</h3>
        <form action="/admin/disburse" method="POST">
            <?= \App\Middleware\CsrfMiddleware::field() ?>
            <input type="hidden" name="application_id" id="modal-app-id">
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="mpesa">M-Pesa</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cash">Cash</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes (Optional)</label>
                <textarea name="notes" placeholder="Transaction ref, etc." rows="3"></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm & Disburse</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById('modal-app-id').value = id;
    document.getElementById('disburse-modal').classList.add('open');
}
function closeModal() {
    document.getElementById('disburse-modal').classList.remove('open');
}
document.querySelectorAll('.btn-disburse').forEach(btn => {
    btn.addEventListener('click', () => openModal(btn.dataset.id));
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
