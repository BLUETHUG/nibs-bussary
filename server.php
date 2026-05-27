<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 1. Serve root index.php (public homepage) directly
if ($uri === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// 2. Serve existing root files directly
$rootFile = __DIR__ . $uri;
if (is_file($rootFile)) {
    return false;
}

// 3. Serve files from public/ directly
$publicFile = __DIR__ . '/public' . $uri;
if (is_file($publicFile)) {
    readfile($publicFile);
    return true;
}

// 4. Route everything else through MVC front controller
require __DIR__ . '/public/index.php';
