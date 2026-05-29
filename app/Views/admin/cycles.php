<?php
declare(strict_types=1);
$pageTitle = 'Bursary Cycles — NIBS Bursary';
$bodyClass = 'page-admin-cycles';
ob_start();
?>
<style>
.page-admin-cycles {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-cycles { background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%); }
.page-admin-cycles .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; }
[data-theme="dark"] .page-admin-cycles .section-title { color: #fff; }
.page-admin-cycles .section-title i { color: var(--admin-gold); }
.page-admin-cycles .card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-cycles .card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-admin-cycles .alert-box { padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem; }
.page-admin-cycles .alert-success { background: #E8F5E9; color: #2E7D32; }
[data-theme="dark"] .page-admin-cycles .alert-success { background: rgba(46,125,50,0.15); color: #81C784; }
.page-admin-cycles .empty-state { text-align: center; padding: 2rem 1rem; }
.page-admin-cycles .empty-icon { font-size: 2.5rem; color: var(--admin-gold); margin-bottom: 0.75rem; }
[data-theme="dark"] .page-admin-cycles .empty-icon { color: rgba(255,213,79,0.6); }
.page-admin-cycles .empty-state h3 { font-size: 1.1rem; color: var(--admin-navy); margin: 0 0 0.3rem; }
[data-theme="dark"] .page-admin-cycles .empty-state h3 { color: #fff; }
.page-admin-cycles .empty-state p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }
.page-admin-cycles .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
.page-admin-cycles .badge-success { background: #E8F5E9; color: #2E7D32; }
.page-admin-cycles .badge-error { background: #FFEBEE; color: #C62828; }
[data-theme="dark"] .page-admin-cycles .badge-success { background: rgba(46,125,50,0.15); color: #81C784; }
[data-theme="dark"] .page-admin-cycles .badge-error { background: rgba(198,40,40,0.15); color: #E57373; }
.page-admin-cycles .btn {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600;
    padding: 0.4rem 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s; font-size: 0.82rem;
}
.page-admin-cycles .btn-success { background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff; }
.page-admin-cycles .btn-success:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-admin-cycles .btn-danger { background: #C62828; color: #fff; }
.page-admin-cycles .btn-danger:hover { background: #B71C1C; transform: translateY(-1px); }
.page-admin-cycles .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.78rem; }
.page-admin-cycles .btn-full { width: 100%; justify-content: center; padding: 0.6rem; font-size: 0.85rem; }
.page-admin-cycles table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.page-admin-cycles th { text-align: left; padding: 0.6rem 0.75rem; font-weight: 600; color: var(--admin-navy); border-bottom: 2px solid var(--admin-gold); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
[data-theme="dark"] .page-admin-cycles th { color: var(--admin-gold); }
.page-admin-cycles td { padding: 0.6rem 0.75rem; border-bottom: 1px solid var(--border); }
.page-admin-cycles tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-admin-cycles tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-admin-cycles .form-group { margin-bottom: 1rem; }
.page-admin-cycles .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.25rem; }
[data-theme="dark"] .page-admin-cycles .form-group label { color: rgba(255,255,255,0.6); }
.page-admin-cycles .form-group input,
.page-admin-cycles .form-group select { width: 100%; padding: 0.5rem 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-family: 'Poppins', sans-serif; font-size: 0.85rem; }
.page-admin-cycles .mb-3 { margin-bottom: 1rem; }
.page-admin-cycles .mb-4 { margin-bottom: 1.5rem; }
@media (max-width: 768px) { .page-admin-cycles .grid-wrap { grid-template-columns: 1fr !important; } }
</style>
<div class="dashboard-wrapper">
    <h2 class="section-title mb-4"><i class="fa-solid fa-calendar-cycle"></i> Bursary Cycles</h2>

    <?php if (isset($_GET['created'])): ?>
    <div class="alert-box alert-success">Cycle created successfully.</div>
    <?php endif; ?>

    <div class="grid-wrap" style="display:grid;grid-template-columns:1fr 380px;gap:2rem;">
        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">All Cycles</h3>
            <?php if (empty($cycles)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-calendar"></i></div>
                <h3>No cycles yet</h3>
                <p>Create your first bursary cycle to start accepting applications.</p>
            </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr><th>Name</th><th>Academic Year</th><th>Applications Open</th><th>Deadline</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cycles as $c): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                            <td><?= htmlspecialchars($c['academic_year']) ?></td>
                            <td><?= date('d M Y', strtotime($c['application_start'])) ?></td>
                            <td><?= date('d M Y', strtotime($c['application_end'])) ?></td>
                            <td>
                                <?php if ($c['is_open']): ?>
                                <span class="badge badge-success">Open</span>
                                <?php else: ?>
                                <span class="badge badge-error">Closed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($c['is_open']): ?>
                                <a href="/admin/cycles/toggle?id=<?= $c['id'] ?>&state=0" class="btn btn-danger btn-sm" onclick="return confirm('Close this cycle? Students will not be able to submit new applications.')">Close</a>
                                <?php else: ?>
                                <a href="/admin/cycles/toggle?id=<?= $c['id'] ?>&state=1" class="btn btn-success btn-sm">Open</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">Create New Cycle</h3>
            <form method="POST" action="/admin/cycles">
                <?= \App\Middleware\CsrfMiddleware::field() ?>
                <div class="form-group">
                    <label>Cycle Name</label>
                    <input type="text" name="name" required placeholder="e.g. 2025/2026 Main Bursary">
                </div>
                <div class="form-group">
                    <label>Academic Year</label>
                    <input type="text" name="academic_year" required placeholder="2025/2026" value="<?= date('Y') . '/' . (date('Y')+1) ?>">
                </div>
                <div class="form-group">
                    <label>Application Start Date</label>
                    <input type="date" name="application_start" required>
                </div>
                <div class="form-group">
                    <label>Application End Date</label>
                    <input type="date" name="application_end" required>
                </div>
                <div class="form-group">
                    <label>Max Applications Per Student</label>
                    <input type="number" name="max_applications" value="1" min="1" max="10">
                </div>
                <button type="submit" class="btn btn-success btn-full">Create Cycle</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';