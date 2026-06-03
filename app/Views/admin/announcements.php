<?php
declare(strict_types=1);
$pageTitle = 'Announcements — NIBS Bursary';
$bodyClass = 'page-admin-announcements';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<div class="dashboard-wrapper">
    <h2 class="section-title"><i class="fa-solid fa-bullhorn"></i> Announcements</h2>

    <div class="admin-split">
        <div class="glass-card">
            <h3>Published Announcements</h3>
            <?php if (empty($announcements)): ?>
            <p style="color:var(--text-muted);margin-top:1.5rem;">No announcements yet.</p>
            <?php else: ?>
            <div class="announcements-list" style="margin-top:1.25rem;">
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

        <div class="glass-card">
            <h3>Post New Announcement</h3>
            <form method="POST" action="/admin/announcements" style="margin-top:1.25rem;">
                <?= CsrfMiddleware::field() ?>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" required placeholder="Announcement title">
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <textarea name="body" rows="6" required placeholder="Write announcement content..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Publish</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';