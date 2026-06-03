<?php
declare(strict_types=1);
$pageTitle = '403 Forbidden — NIBS Bursary';
$bodyClass = 'text-center';
ob_start();
?>
<div class="dashboard-wrapper">
    <div class="empty-state" style="padding:6rem 2rem;">
        <div class="empty-icon" style="font-size:5rem;opacity:0.3;">403</div>
        <h3>Access Denied</h3>
        <p>You do not have permission to access this page. Please contact your administrator if you believe this is an error.</p>
        <a href="/" class="btn btn-primary">Return to Home</a>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
