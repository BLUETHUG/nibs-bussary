<?php
// routes/web.php
declare(strict_types=1);

return [
    '/' => ['controller' => 'AuthController', 'action' => 'login'],
    '/login' => ['controller' => 'AuthController', 'action' => 'login'],
    '/register' => ['controller' => 'AuthController', 'action' => 'register'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    
    '/student/dashboard' => ['controller' => 'StudentController', 'action' => 'dashboard'],
    '/student/apply' => ['controller' => 'StudentController', 'action' => 'apply'],
    '/student/status' => ['controller' => 'StudentController', 'action' => 'status'],
    
    '/admin/dashboard' => ['controller' => 'AdminController', 'action' => 'dashboard'],
    '/admin/applications' => ['controller' => 'AdminController', 'action' => 'applications'],
    '/admin/funds' => ['controller' => 'AdminController', 'action' => 'funds'],
    '/admin/funds/create' => ['controller' => 'AdminController', 'action' => 'createFund'],
    '/admin/review' => ['controller' => 'AdminController', 'action' => 'review'],
    '/admin/approve' => ['controller' => 'AdminController', 'action' => 'approve'],
    '/admin/reject' => ['controller' => 'AdminController', 'action' => 'reject'],
    '/admin/disburse' => ['controller' => 'AdminController', 'action' => 'disburse'],
    '/admin/reports' => ['controller' => 'ReportController', 'action' => 'index'],
    '/admin/reports/pdf' => ['controller' => 'ReportController', 'action' => 'exportPdf'],
    '/admin/reports/csv' => ['controller' => 'ReportController', 'action' => 'exportExcel'],
    '/admin/announcements' => ['controller' => 'AdminController', 'action' => 'announcements'],
    '/admin/users' => ['controller' => 'AdminController', 'action' => 'users'],
];
