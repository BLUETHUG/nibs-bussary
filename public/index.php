<?php
// public/index.php
declare(strict_types=1);

$appConfig = require __DIR__ . '/../config/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => $appConfig['session_lifetime'],
        'path' => '/',
        'secure' => $appConfig['session_secure'],
        'httponly' => $appConfig['session_httponly'],
        'samesite' => $appConfig['session_samesite'],
    ]);
    session_name($appConfig['session_name']);
    session_start();
}

date_default_timezone_set($appConfig['timezone']);

// Autoloading (Simple PSR-4 implementation)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

$routes = require __DIR__ . '/../routes/web.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove trailing slash (except root)
$uri = $uri !== '/' ? rtrim($uri, '/') : $uri;

// Simple Routing Logic
if (array_key_exists($uri, $routes)) {
    $route = $routes[$uri];
    $controllerName = "App\\Controllers\\" . $route['controller'];
    $action = $route['action'];
    
    if (!class_exists($controllerName)) {
        http_response_code(500);
        require __DIR__ . '/../app/Views/errors/404.php';
        exit;
    }
    
    $controller = new $controllerName();
    
    if (!method_exists($controller, $action)) {
        http_response_code(500);
        require __DIR__ . '/../app/Views/errors/404.php';
        exit;
    }
    
        $controller->$action();
} else {
    http_response_code(404);
    require __DIR__ . '/../app/Views/errors/404.php';
}
