<?php
declare(strict_types=1);
$pageTitle = 'Announcements — NIBS Bursary';
$bodyClass = 'page-admin-announcements';
use App\Middleware\CsrfMiddleware;
ob_start();
?>
<style>
.page-admin-announcements {
    --admin-navy: #1A237E;
    --admin-navy-light: #283593;
    --admin-gold: #FFD54F;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #E8EAF6 0%, #FAFAFA 50%, #FFF8E1 100%);
    min-height: 100vh;
}
[data-theme="dark"] .page-admin-announcements { background: linear-gradient(135deg, #0D1442 0%, #1a1a2e 50%, #16213e 100%); }
.page-admin-announcements .section-title { font-size: 1.15rem; font-weight: 700; color: var(--admin-navy); display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.5rem; }
[data-theme="dark"] .page-admin-announcements .section-title { color: #fff; }
.page-admin-announcements .section-title i { color: var(--admin-gold); }
.page-admin-announcements .glass-card {
    background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.3);
    border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04);
}
[data-theme="dark"] .page-admin-announcements .glass-card { background: rgba(26,35,62,0.85); border-color: rgba(255,255,255,0.06); }
.page-admin-announcements .glass-card h3 { font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); margin: 0; }
[data-theme="dark"] .page-admin-announcements .glass-card h3 { color: #fff; }
.page-admin-announcements .text-muted { color: var(--text-muted); }
.page-admin-announcements .mt-4 { margin-top: 1.5rem; }
.page-admin-announcements .announcements-list { display: flex; flex-direction: column; gap: 1.25rem; }
.page-admin-announcements .announcement-item {
    padding: 1.25rem; background: rgba(255,255,255,0.5); border-radius: 12px; border: 1px solid var(--border);
}
[data-theme="dark"] .page-admin-announcements .announcement-item { background: rgba(0,0,0,0.15); border-color: rgba(255,255,255,0.06); }
.page-admin-announcements .ann-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem; flex-wrap: wrap; gap: 0.5rem; }
.page-admin-announcements .ann-header h4 { margin: 0; font-size: 0.95rem; font-weight: 600; color: var(--admin-navy); }
[data-theme="dark"] .page-admin-announcements .ann-header h4 { color: #fff; }
.page-admin-announcements .ann-header small { color: var(--text-muted); font-size: 0.75rem; }
.page-admin-announcements .announcement-item p { font-size: 0.85rem; color: var(--text-secondary); line-height: 1.7; margin: 0; }
.page-admin-announcements .form-group { margin-bottom: 1rem; }
.page-admin-announcements .form-group label { display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.3rem; }
[data-theme="dark"] .page-admin-announcements .form-group label { color: rgba(255,255,255,0.6); }
.page-admin-announcements .form-group input,
.page-admin-announcements .form-group textarea { width: 100%; padding: 0.55rem 0.85rem; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-family: 'Poppins', sans-serif; font-size: 0.85rem; }
.page-admin-announcements .btn-primary {
    font-family: 'Poppins', sans-serif; cursor: pointer; border: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem;
    padding: 0.6rem 1.25rem; background: linear-gradient(135deg, var(--admin-navy), var(--admin-navy-light)); color: #fff;
    transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; justify-content: center;
}
.page-admin-announcements .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,35,126,0.3); }
.page-admin-announcements .w-100 { width: 100%; }
</style>
<div class="dashboard-wrapper">
    <h2 class="section-title"><i class="fa-solid fa-bullhorn"></i> Announcements</h2>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:2rem;">
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
                <button type="submit" class="btn-primary w-100">Publish</button>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';