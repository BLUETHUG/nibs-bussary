<?php
declare(strict_types=1);
$pageTitle = 'Committee Scoring — NIBS Bursary';
$bodyClass = 'page-committee';
ob_start();
?>
<style>
.page-committee {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-committee { background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%); }
.page-committee .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; }
[data-theme="dark"] .page-committee .section-title { color: #fff; }
.page-committee .section-title i { color: var(--admin-gold); }
.page-committee .card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-committee .card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-committee .empty-state { text-align: center; padding: 2rem 1rem; }
.page-committee .empty-icon { font-size: 2.5rem; color: var(--admin-gold); margin-bottom: 0.75rem; }
[data-theme="dark"] .page-committee .empty-icon { color: rgba(255,213,79,0.6); }
.page-committee .empty-state h3 { font-size: 1.1rem; color: var(--admin-navy); margin: 0 0 0.3rem; }
[data-theme="dark"] .page-committee .empty-state h3 { color: #fff; }
.page-committee .empty-state p { font-size: 0.82rem; color: var(--text-muted); margin: 0; }
.page-committee .alert-box { padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem; }
.page-committee .alert-success { background: #E8F5E9; color: #2E7D32; }
.page-committee .alert-error { background: #FFEBEE; color: #C62828; }
[data-theme="dark"] .page-committee .alert-success { background: rgba(46,125,50,0.15); color: #81C784; }
[data-theme="dark"] .page-committee .alert-error { background: rgba(198,40,40,0.15); color: #E57373; }
.page-committee .badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.7rem; font-weight: 600; }
.page-committee .badge-info { background: #E8EAF6; color: var(--admin-navy); }
.page-committee .badge-success { background: #E8F5E9; color: #2E7D32; }
.page-committee .badge-warning { background: #FFF8E1; color: #F57F17; }
[data-theme="dark"] .page-committee .badge-info { background: rgba(26,35,126,0.3); color: #9FA8DA; }
[data-theme="dark"] .page-committee .badge-success { background: rgba(46,125,50,0.15); color: #81C784; }
[data-theme="dark"] .page-committee .badge-warning { background: rgba(245,127,23,0.15); color: #FFB74D; }
.page-committee .btn {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600; font-size: 0.82rem;
    padding: 0.5rem 1.25rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;
}
.page-committee .btn-primary { background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff; }
.page-committee .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-committee .btn-sm { padding: 0.4rem 1rem; font-size: 0.78rem; }
.page-committee .form-group { margin-bottom: 0.75rem; }
.page-committee .form-group label { display: block; font-size: 0.78rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.25rem; }
[data-theme="dark"] .page-committee .form-group label { color: rgba(255,255,255,0.6); }
.page-committee .form-group input,
.page-committee .form-group select { width: 100%; padding: 0.5rem 0.75rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-family: 'Poppins', sans-serif; font-size: 0.82rem; }
.page-committee .text-muted { color: var(--text-muted); }
.page-committee .text-sm { font-size: 0.82rem; }
.page-committee table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
.page-committee th { text-align: left; padding: 0.6rem 0.75rem; font-weight: 600; color: var(--admin-navy); border-bottom: 2px solid var(--admin-gold); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
[data-theme="dark"] .page-committee th { color: var(--admin-gold); }
.page-committee td { padding: 0.6rem 0.75rem; border-bottom: 1px solid var(--border); }
.page-committee tbody tr:hover { background: rgba(26,35,126,0.03); }
[data-theme="dark"] .page-committee tbody tr:hover { background: rgba(255,213,79,0.04); }
.page-committee .mb-3 { margin-bottom: 1rem; }
.page-committee .mb-4 { margin-bottom: 1.5rem; }
.page-committee .mt-2 { margin-top: 0.75rem; }
.page-committee .flex { display: flex; }
.page-committee .justify-between { justify-content: space-between; }
.page-committee .items-center { align-items: center; }
.page-committee .gap-2 { gap: 0.75rem; }
.page-committee .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; }
@media (max-width: 768px) { .page-committee .grid-3 { grid-template-columns: 1fr; } }
</style>
<div class="dashboard-wrapper">
    <h2 class="section-title mb-4"><i class="fa-solid fa-gavel"></i> Committee Scoring</h2>

    <?php if (isset($_GET['scored'])): ?>
    <div class="alert-box alert-success">Score submitted successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="alert-box alert-error">Invalid score values. Scores must be between 1 and 10.</div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">Applications Pending Review (<?= count($pending) ?>)</h3>
            <?php if (empty($pending)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-check-circle"></i></div>
                <h3>All Reviewed</h3>
                <p>All applications have been scored. Great work!</p>
            </div>
            <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:0.75rem;">
                <?php foreach ($pending as $app): ?>
                <?php $alreadyScored = in_array($app['id'], $scoredIds ?? []); ?>
                <details class="card" style="padding:1rem;border-left:3px solid <?= $alreadyScored ? '#2E7D32' : '#F57F17' ?>;">
                    <summary style="cursor:pointer;font-weight:600;display:flex;justify-content:space-between;align-items:center;font-size:0.85rem;">
                        <span><?= htmlspecialchars($app['full_name']) ?> — <?= htmlspecialchars($app['course']) ?></span>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <?php if ($app['score_count'] > 0): ?>
                            <span class="badge badge-info">Avg: <?= number_format($app['avg_score'], 1) ?>/10</span>
                            <?php endif; ?>
                            <span class="badge <?= $alreadyScored ? 'badge-success' : 'badge-warning' ?>"><?= $alreadyScored ? 'Scored' : 'Pending' ?></span>
                        </div>
                    </summary>
                    <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid var(--border);">
                        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.5rem;">
                            <span style="color:var(--text-muted);">Index: <?= htmlspecialchars($app['index_number']) ?></span>
                            <span style="color:var(--text-muted);">Year: <?= $app['year_of_study'] ?></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.5rem;">
                            <span style="color:var(--text-muted);">Amount: KES <?= number_format((float)$app['amount_requested'], 0) ?></span>
                            <span style="color:var(--text-muted);">Applied: <?= date('d M Y', strtotime($app['created_at'])) ?></span>
                        </div>
                        <?php if ($app['special_circumstances']): ?>
                        <p style="font-size:0.82rem;color:var(--text-muted);margin-bottom:0.5rem;"><em>"<?= htmlspecialchars($app['special_circumstances']) ?>"</em></p>
                        <?php endif; ?>
                        <form method="POST" action="/admin/committee/score">
                            <?= \App\Middleware\CsrfMiddleware::field() ?>
                            <input type="hidden" name="application_id" value="<?= $app['id'] ?>">
                            <div class="grid-3 gap-2">
                                <div class="form-group">
                                    <label>Need (1-10)</label>
                                    <input type="number" name="need_score" min="1" max="10" required value="<?= $alreadyScored ? ($myScores[$app['id']]['need_score'] ?? '') : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Academic (1-10)</label>
                                    <input type="number" name="academic_score" min="1" max="10" required value="<?= $alreadyScored ? ($myScores[$app['id']]['academic_score'] ?? '') : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Circumstance (1-10)</label>
                                    <input type="number" name="circumstance_score" min="1" max="10" required value="<?= $alreadyScored ? ($myScores[$app['id']]['circumstance_score'] ?? '') : '' ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Recommendation</label>
                                <select name="recommendation">
                                    <option value="">Select...</option>
                                    <option value="strongly_recommend" <?= ($alreadyScored && ($myScores[$app['id']]['recommendation'] ?? '') === 'strongly_recommend') ? 'selected' : '' ?>>Strongly Recommend</option>
                                    <option value="recommend" <?= ($alreadyScored && ($myScores[$app['id']]['recommendation'] ?? '') === 'recommend') ? 'selected' : '' ?>>Recommend</option>
                                    <option value="not_recommend" <?= ($alreadyScored && ($myScores[$app['id']]['recommendation'] ?? '') === 'not_recommend') ? 'selected' : '' ?>>Not Recommended</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm"><?= $alreadyScored ? 'Update Score' : 'Submit Score' ?></button>
                        </form>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--admin-navy);margin:0 0 1rem;">My Recent Scores</h3>
            <?php if (empty($myScored)): ?>
            <div class="empty-state">
                <div class="empty-icon"><i class="fa-solid fa-pen"></i></div>
                <h3>No scores yet</h3>
                <p>Score your first application from the pending list.</p>
            </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr><th>Student</th><th>Course</th><th>Scores</th><th>Avg</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($myScored as $s): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($s['full_name']) ?></strong></td>
                            <td><?= htmlspecialchars($s['course']) ?></td>
                            <td><?= $s['need_score'] ?>/<?= $s['academic_score'] ?>/<?= $s['circumstance_score'] ?></td>
                            <td><strong><?= number_format(($s['need_score']+$s['academic_score']+$s['circumstance_score'])/3, 1) ?></strong></td>
                            <td style="color:var(--text-muted);font-size:0.82rem;"><?= date('d M', strtotime($s['scored_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
