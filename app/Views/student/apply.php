<?php
declare(strict_types=1);
$pageTitle = 'Apply for Bursary — NIBS Bursary';
$bodyClass = 'page-student-apply';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="section-card glass-card">
        <h2 class="section-title">✨ New Bursary Application</h2>
        <p class="text-muted">Complete the form below to apply for a bursary. All fields marked with * are required.</p>

        <?php if (!empty($errors)): ?>
        <div class="alert alert-error mt-4">
            <?php foreach ($errors as $e): ?>
                <div>⚠️ <?= htmlspecialchars($e) ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="/student/apply" class="standard-form mt-4" enctype="multipart/form-data">
            <?= CsrfMiddleware::field() ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="fund_id">Bursary Fund *</label>
                    <select id="fund_id" name="fund_id" required>
                        <option value="">Select a fund...</option>
                        <?php foreach ($funds as $fund): ?>
                        <option value="<?= $fund->id ?>" <?= ($_POST['fund_id'] ?? '') == $fund->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($fund->fund_name) ?> (<?= htmlspecialchars($fund->academic_year) ?>)
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="academic_year">Academic Year *</label>
                    <input type="text" id="academic_year" name="academic_year" required
                           value="<?= htmlspecialchars($_POST['academic_year'] ?? (date('Y') . '/' . (date('Y') + 1))) ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="amount_requested">Amount Requested (KES) *</label>
                    <input type="number" id="amount_requested" name="amount_requested" required step="0.01" min="1"
                           value="<?= htmlspecialchars($_POST['amount_requested'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="supporting_doc">Supporting Document (PDF/JPG, max 5MB)</label>
                    <input type="file" id="supporting_doc" name="supporting_doc" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>

            <div class="form-group">
                <label for="special_circumstances">Special Circumstances</label>
                <textarea id="special_circumstances" name="special_circumstances" rows="4"
                          placeholder="Describe any special circumstances (financial hardship, disability, orphan status, etc.)"><?= htmlspecialchars($_POST['special_circumstances'] ?? '') ?></textarea>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn-primary">Submit Application</button>
                <a href="/student/dashboard" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}
@media (max-width: 600px) {
    .form-row { grid-template-columns: 1fr; }
}
</style>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
