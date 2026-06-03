<?php
declare(strict_types=1);
$pageTitle = 'Committee Scoring — NIBS Bursary';
$bodyClass = 'page-committee';
ob_start();
?>

<div class="dashboard-wrapper">
    <h2 class="section-title mb-4"><i class="fa-solid fa-gavel"></i> Committee Scoring</h2>

    <?php if (isset($_GET['scored'])): ?>
    <div class="alert-box alert-success">Score submitted successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
    <div class="alert-box alert-error">Invalid score values. Scores must be between 1 and 10.</div>
    <?php endif; ?>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
        <div class="card">
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--primary);margin:0 0 1rem;">Applications Pending Review (<?= count($pending) ?>)</h3>
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
                <details class="card" style="padding:1rem;border-left:3px solid <?= $alreadyScored ? '#22C55E' : '#F59E0B' ?>;">
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
            <h3 style="font-size:0.95rem;font-weight:600;color:var(--primary);margin:0 0 1rem;">My Recent Scores</h3>
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
