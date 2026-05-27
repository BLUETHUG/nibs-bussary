<?php
declare(strict_types=1);
$pageTitle = 'Announcements — NIBS Bursary';
$bodyClass = 'page-admin-announcements';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<div class="dashboard-wrapper float-in">
    <div class="card-header mb-4">
        <h2 class="section-title">📢 Announcements</h2>
    </div>

    <div class="admin-grid" style="grid-template-columns: 1fr 350px; gap: 2rem;">
        <!-- Announcements List -->
        <div class="section-card glass-card">
            <h3>Published Announcements</h3>
            <?php if (empty($announcements)): ?>
            <p class="text-muted mt-4">No announcements yet.</p>
            <?php else: ?>
            <div class="announcements-list mt-4">
                <?php foreach ($announcements as $ann): ?>
                <div class="announcement-item">
                    <div class="ann-header">
                        <h4><?= htmlspecialchars($ann['title']) ?></h4>
                        <small class="text-muted">By <?= htmlspecialchars($ann['full_name']) ?> on <?= date('d M Y', strtotime($ann['created_at'])) ?></small>
                    </div>
                    <p><?= nl2br(htmlspecialchars($ann['body'])) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Create Announcement -->
        <div class="section-card glass-card">
            <h3>Post New Announcement</h3>
            <form method="POST" action="/admin/announcements" class="standard-form mt-4">
                <?= CsrfMiddleware::field() ?>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required placeholder="Announcement title">
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <textarea name="body" rows="6" required placeholder="Write announcement content..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-100">Publish</button>
            </form>
        </div>
    </div>
</div>

<style>
.announcements-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.announcement-item {
    padding: 1.5rem;
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
}
.ann-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.8rem;
}
.ann-header h4 {
    margin: 0;
}
</style>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
