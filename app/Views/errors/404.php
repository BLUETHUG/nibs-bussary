<?php
declare(strict_types=1);
$pageTitle = '404 Not Found — NIBS Bursary';
$bodyClass = 'text-center';
ob_start();
?>
<div class="dashboard-wrapper">
    <div class="empty-state" style="padding:6rem 2rem;">
        <div class="empty-icon" style="font-size:5rem;opacity:0.3;">404</div>
        <h3>Page Not Found</h3>
        <p>The page you're looking for doesn't exist or has been moved to a new location.</p>
        <a href="/" class="btn btn-primary">Return to Home</a>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
