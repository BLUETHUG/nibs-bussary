<?php
declare(strict_types=1);
$pageTitle = 'User Management — NIBS Bursary';
$bodyClass = 'page-admin-users';
ob_start();
?>
<div class="dashboard-wrapper">
    <h2 class="section-title"><i class="fa-solid fa-users-gear"></i> User Management</h2>

    <?php if (!empty($_SESSION['flash_message'])): ?>
    <div style="padding:0.75rem 1rem;background:#F0FDF4;color:#22C55E;border-radius:12px;margin-bottom:1.5rem;font-size:0.85rem;display:flex;align-items:center;gap:0.5rem;">
        <i class="fa-solid fa-check-circle"></i> <?= $_SESSION['flash_message'] ?>
    </div>
    <?php unset($_SESSION['flash_message']); endif; ?>

    <?php if (!empty($_SESSION['flash_errors'])): ?>
    <div style="padding:0.75rem 1rem;background:#FEF2F2;color:#EF4444;border-radius:12px;margin-bottom:1.5rem;font-size:0.85rem;">
        <?php foreach ($_SESSION['flash_errors'] as $err): ?>
        <div style="display:flex;align-items:center;gap:0.5rem;"><i class="fa-solid fa-exclamation-circle"></i> <?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['flash_errors']); endif; ?>

    <div class="flex justify-end mb-3">
        <button onclick="document.getElementById('createUserModal').style.display='flex'" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Create User
        </button>
    </div>

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

<!-- Create User Modal -->
<div id="createUserModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);backdrop-filter:blur(4px);z-index:10000;align-items:center;justify-content:center;padding:1rem;" onclick="if(event.target===this)this.style.display='none'">
    <div style="background:var(--bg-card);border-radius:20px;width:100%;max-width:480px;max-height:90vh;overflow-y:auto;box-shadow:0 24px 48px -12px rgba(0,0,0,0.2);" onclick="event.stopPropagation()">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.5rem;border-bottom:1px solid var(--border);">
            <h3 style="font-size:1.1rem;font-weight:700;"><i class="fa-solid fa-user-plus" style="color:var(--accent);margin-right:0.5rem;"></i>Create New User</h3>
            <button onclick="document.getElementById('createUserModal').style.display='none'" style="background:none;border:none;font-size:1.5rem;color:var(--text-muted);cursor:pointer;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;">&times;</button>
        </div>
        <form action="/admin/users/create" method="POST" style="padding:1.5rem;">
            <input type="hidden" name="_csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:span 2;">
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Full Name</label>
                    <input type="text" name="full_name" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Index Number</label>
                    <input type="text" name="index_number" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Role</label>
                    <select name="role" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                        <option value="">Select role</option>
                        <option value="admin">Admin</option>
                        <option value="officer">Officer</option>
                        <option value="committee">Committee</option>
                        <option value="accountant">Accountant</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div style="grid-column:span 2;">
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Email</label>
                    <input type="email" name="email" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Phone</label>
                    <input type="text" name="phone" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                </div>
                <div>
                    <label style="display:block;font-size:0.8rem;font-weight:600;margin-bottom:0.3rem;">Password</label>
                    <input type="password" name="password" required style="width:100%;padding:0.7rem 1rem;border:2px solid var(--border);border-radius:12px;font-family:inherit;font-size:0.9rem;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full" style="margin-top:1.5rem;">
                <i class="fa-solid fa-user-plus"></i> Create Account
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';