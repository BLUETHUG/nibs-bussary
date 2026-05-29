<?php
declare(strict_types=1);
$pageTitle = 'User Management — NIBS Bursary';
$bodyClass = 'page-admin-users';
ob_start();
?>
<style>
.page-admin-users {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-users { background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%); }
.page-admin-users .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.5rem; }
[data-theme="dark"] .page-admin-users .section-title { color: #fff; }
.page-admin-users .section-title i { color: var(--admin-gold); }
.page-admin-users .glass-card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-users .glass-card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-admin-users .data-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
.page-admin-users .data-table th {
    text-align: left; padding: 0.75rem 1rem; font-weight: 600; color: var(--admin-navy);
    border-bottom: 2px solid var(--admin-gold); white-space: nowrap; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px;
}
[data-theme="dark"] .page-admin-users .data-table th { color: var(--admin-gold); }
.page-admin-users .data-table td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); }
.page-admin-users .data-table tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-admin-users .data-table tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-admin-users .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; background: #E8EAF6; color: var(--admin-navy); text-transform: capitalize; }
[data-theme="dark"] .page-admin-users .badge { background: rgba(26,35,126,0.3); color: #9FA8DA; }
.page-admin-users .status-badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
.page-admin-users .status-approved { background: #E8F5E9; color: #2E7D32; }
.page-admin-users .status-rejected { background: #FFEBEE; color: #C62828; }
[data-theme="dark"] .page-admin-users .status-approved { background: rgba(46,125,50,0.15); color: #81C784; }
[data-theme="dark"] .page-admin-users .status-rejected { background: rgba(198,40,40,0.15); color: #E57373; }
.page-admin-users .text-muted { color: var(--text-muted); }
.page-admin-users .text-center { text-align: center; }
@media (max-width: 768px) { .page-admin-users .data-table { font-size: 0.78rem; } }
</style>
<div class="dashboard-wrapper">
    <h2 class="section-title"><i class="fa-solid fa-users-gear"></i> User Management</h2>

    <div class="glass-card">
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
                    <tr><td colspan="6" style="padding:2rem 1rem;text-align:center;color:var(--text-muted);">No users found.</td></tr>
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