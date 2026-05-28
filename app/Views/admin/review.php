<?php
declare(strict_types=1);
$pageTitle = 'Review Application — NIBS Bursary';
$bodyClass = 'page-admin-review';
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title"><i class="fa-solid fa-magnifying-glass"></i> Review Application #<?= $application->id ?></h2>
        <a href="/admin/applications" class="btn-secondary">← Back to List</a>
    </div>

    <div class="admin-grid" style="grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Student & Application Details -->
        <div class="section-card glass-card">
            <h3>Student Information</h3>
            <div class="details-grid mt-3">
                <div class="detail-item"><strong>Full Name:</strong> <span><?= htmlspecialchars($student['full_name']) ?></span></div>
                <div class="detail-item"><strong>Index Number:</strong> <span><?= htmlspecialchars($student['index_number']) ?></span></div>
                <div class="detail-item"><strong>Course:</strong> <span><?= htmlspecialchars($student['course']) ?></span></div>
                <div class="detail-item"><strong>Year of Study:</strong> <span>Year <?= $student['year_of_study'] ?></span></div>
                <div class="detail-item"><strong>Gender:</strong> <span><?= ucfirst($student['gender']) ?></span></div>
                <div class="detail-item"><strong>Guardian:</strong> <span><?= htmlspecialchars($student['guardian_name']) ?> (<?= htmlspecialchars($student['guardian_phone']) ?>)</span></div>
                <div class="detail-item"><strong>Monthly Income:</strong> <span>KES <?= number_format($student['guardian_monthly_income'], 2) ?></span></div>
            </div>

            <h3 class="mt-4">Application Details</h3>
            <div class="details-grid mt-3">
                <div class="detail-item"><strong>Requested Amount:</strong> <span>KES <?= number_format($application->amount_requested, 2) ?></span></div>
                <div class="detail-item"><strong>Status:</strong> <span class="status-badge status-<?= $application->status ?>"><?= ucfirst($application->status) ?></span></div>
                <div class="detail-item" style="grid-column: span 2;">
                    <strong>Special Circumstances:</strong>
                    <p class="mt-2 text-muted"><?= nl2br(htmlspecialchars($application->special_circumstances ?? 'None provided.')) ?></p>
                </div>
            </div>

            <?php if ($application->supporting_doc_path): ?>
            <div class="mt-4">
                <a href="<?= htmlspecialchars($application->supporting_doc_path) ?>" target="_blank" class="btn-primary">View Supporting Documents</a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Action Panel -->
        <div class="section-card glass-card">
            <?php if ($application->status === 'pending' || $application->status === 'under_review'): ?>
            <h3>Adjudication</h3>
            <div class="mt-4">
                <form action="/admin/approve" method="POST" class="standard-form">
                    <?= \App\Middleware\CsrfMiddleware::field() ?>
                    <input type="hidden" name="id" value="<?= $application->id ?>">
                    <div class="form-group">
                        <label>Amount to Approve (KES)</label>
                        <input type="number" name="amount_approved" required step="0.01" max="<?= $application->amount_requested ?>" value="<?= $application->amount_requested ?>">
                    </div>
                    <button type="submit" class="btn-primary w-100">Approve Application</button>
                </form>

                <hr class="my-4" style="opacity: 0.1;">

                <form action="/admin/reject" method="POST" class="standard-form">
                    <?= \App\Middleware\CsrfMiddleware::field() ?>
                    <input type="hidden" name="id" value="<?= $application->id ?>">
                    <div class="form-group">
                        <label>Rejection Reason</label>
                        <textarea name="reason" required placeholder="Explain why this application was rejected..."></textarea>
                    </div>
                    <button type="submit" class="btn-danger w-100">Reject Application</button>
                </form>
            </div>
            <?php else: ?>
            <h3>Review History</h3>
            <div class="mt-3">
                <p>This application has already been processed.</p>
                <div class="detail-item mt-2"><strong>Decision:</strong> <span class="status-badge status-<?= $application->status ?>"><?= ucfirst($application->status) ?></span></div>
                <?php if ($application->status === 'approved'): ?>
                <div class="detail-item mt-2"><strong>Approved Amount:</strong> <span>KES <?= number_format($application->amount_approved, 2) ?></span></div>
                <?php elseif ($application->status === 'rejected'): ?>
                <div class="detail-item mt-2"><strong>Reason:</strong> <p class="text-muted"><?= htmlspecialchars($application->rejection_reason ?? '') ?></p></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
