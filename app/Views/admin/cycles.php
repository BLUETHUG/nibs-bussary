<?php
declare(strict_types=1);
$pageTitle = 'Bursary Cycles — NIBS Bursary';
$bodyClass = 'page-admin-cycles';
ob_start();
?>
<div class="dashboard-wrapper">
    <div class="flex justify-between items-center mb-4">
        <h2 class="section-title" style="margin:0;"><i class="fa-solid fa-calendar-cycle"></i> Bursary Cycles</h2>
    </div>

    <?php if (isset($_GET['created'])): ?>
    <div class="alert-box alert-success mb-4">Cycle created successfully.</div>
    <?php endif; ?>

    <div class="grid" style="grid-template-columns: 1fr 380px; gap: 2rem;">
        <!-- Existing Cycles -->
        <div class="card">
            <h3 class="mb-3">All Cycles</h3>
            <?php if (empty($cycles)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-calendar"></i></div>
                <h3>No cycles yet</h3>
                <p>Create your first bursary cycle to start accepting applications.</p>
            </div>
            <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Academic Year</th>
                            <th>Applications Open</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
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
                                <a href="/admin/cycles/toggle?id=<?= $c['id'] ?>&state=0" class="btn btn-sm btn-danger" onclick="return confirm('Close this cycle? Students will not be able to submit new applications.')">Close</a>
                                <?php else: ?>
                                <a href="/admin/cycles/toggle?id=<?= $c['id'] ?>&state=1" class="btn btn-sm btn-success">Open</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Create New Cycle -->
        <div class="card">
            <h3 class="mb-3">Create New Cycle</h3>
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
                <button type="submit" class="btn btn-primary btn-full">Create Cycle</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
