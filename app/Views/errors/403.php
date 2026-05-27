<?php
declare(strict_types=1);
$pageTitle = '403 Forbidden — NIBS Bursary';
$bodyClass = 'text-center';
ob_start();
?>
<div class="dashboard-wrapper float-in" style="text-align:center;padding:6rem 2rem;">
    <div style="font-size:5rem;margin-bottom:1.5rem;font-weight:900;color:var(--primary-red);line-height:1;">403</div>
    <h1 style="margin-bottom:0.5rem;">Access Denied</h1>
    <p style="color:var(--text-muted);font-size:1.1rem;max-width:400px;margin:0 auto 2rem;">You do not have permission to access this page. Please contact your administrator if you believe this is an error.</p>
    <a href="index.php" class="btn-primary">Return to Home</a>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/base.php';
