<?php
declare(strict_types=1);
$pageTitle = 'User Management — NIBS Bursary';
$bodyClass = 'page-admin-users';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title"><i class="fa-solid fa-users-gear"></i> User Management</h2>
    </div>

    <div class="section-card glass-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Index Number</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="6" class="text-center py-4">No users found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($u['full_name']) ?></strong></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['index_number']) ?></td>
                            <td><span class="badge"><?= ucfirst($u['role']) ?></span></td>
                            <td><span class="status-badge status-<?= $u['is_active'] ? 'approved' : 'rejected' ?>"><?= $u['is_active'] ? 'Active' : 'Inactive' ?></span></td>
                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
