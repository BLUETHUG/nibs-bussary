<?php
declare(strict_types=1);
$pageTitle = 'Manage Applications — NIBS Bursary';
$bodyClass = 'page-admin-applications';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="section-card glass-card">
        <div class="card-header">
            <h2 class="section-title">📋 Bursary Applications</h2>
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
                    <button type="submit" class="btn-small">Filter</button>
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
                    <tr><td colspan="7" class="text-center py-4">No applications found matching your criteria.</td></tr>
                    <?php else: ?>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($app['full_name']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($app['index_number']) ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($app['course']) ?><br>
                                <small>Year <?= $app['year_of_study'] ?></small>
                            </td>
                            <td>KES <?= number_format((float)$app['amount_requested'], 2) ?></td>
                            <td>KES <?= number_format((float)$app['amount_approved'], 2) ?></td>
                            <td><span class="status-badge status-<?= $app['status'] ?>"><?= ucfirst($app['status']) ?></span></td>
                            <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="/admin/review?id=<?= $app['id'] ?>" class="btn-icon" title="Review">👁️</a>
                                    <?php if ($app['status'] === 'approved' && $_SESSION['role'] === 'accountant'): ?>
                                    <button class="btn-icon btn-disburse" data-id="<?= $app['id'] ?>" title="Disburse">💰</button>
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

<!-- Disburse Modal (Simple Example) -->
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
                <textarea name="notes" placeholder="Transaction ref, etc."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-primary">Confirm & Disburse</button>
            </div>
        </form>
    </div>
</div>

<style>
.header-actions {
    display: flex;
    gap: 1rem;
}
.search-form {
    display: flex;
    gap: 0.5rem;
}
.search-form input, .search-form select {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
}
.btn-small {
    padding: 0.5rem 1rem;
    background: var(--primary-red);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
.action-buttons {
    display: flex;
    gap: 0.5rem;
}
.btn-icon {
    text-decoration: none;
    font-size: 1.2rem;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
}
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0; top: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(10px);
    align-items: center;
    justify-content: center;
}
.modal.open { display: flex; }
.modal-content {
    width: 100%;
    max-width: 500px;
    padding: 2rem;
}
.modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

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
