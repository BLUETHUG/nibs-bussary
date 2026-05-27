<?php
declare(strict_types=1);
$pageTitle = '404 Not Found — NIBS Bursary';
$bodyClass = 'text-center';
ob_start();
?>
<div class="dashboard-wrapper float-in" style="text-align:center;padding:6rem 2rem;">
    <div style="font-size:5rem;margin-bottom:1.5rem;font-weight:900;color:var(--primary-red);line-height:1;">404</div>
    <h1 style="margin-bottom:0.5rem;">Page Not Found</h1>
    <p style="color:var(--text-muted);font-size:1.1rem;max-width:400px;margin:0 auto 2rem;">The page you're looking for doesn't exist or has been moved to a new location.</p>
    <a href="index.php" class="btn-primary">Return to Home</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
