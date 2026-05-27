<?php
declare(strict_types=1);
// config/app.php – Application settings
return [
    'app_name' => 'NIBS Bursary Management System',
    'base_url' => getenv('BASE_URL') ?: 'http://localhost/nibs-bursary',
    'logo_url' => 'https://nibs.ac.ke/wp-content/themes/nibs/assets/images/logo.png',
    'timezone' => 'Africa/Nairobi',
    'debug' => false,
    // Session settings
    'session_name' => 'nibs_session',
    'session_lifetime' => 1800, // 30 minutes
    'session_secure' => false, // set true if HTTPS
    'session_httponly' => true,
    'session_samesite' => 'Strict',
];
?>
