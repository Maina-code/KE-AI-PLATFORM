<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$logDir = __DIR__ . '/../logs';          // for controllers, use __DIR__ . '/logs'
$logFile = $logDir . '/error_log.txt';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
if (!file_exists($logFile)) {
    file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Error log created.\n");
}
ini_set('error_log', $logFile);

// Optional: catch fatal errors via shutdown function
register_shutdown_function(function() use ($logFile) {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $message = sprintf(
            "[%s] FATAL: %s in %s on line %d\n",
            date('Y-m-d H:i:s'),
            $error['message'],
            $error['file'],
            $error['line']
        );
        error_log($message, 3, $logFile);
        // If you want to display a friendly message to the user:
        if (ini_get('display_errors')) {
            echo "<pre>FATAL ERROR: {$error['message']}</pre>";
        }
    }
});
require_once __DIR__ . '/../app/config/database.php';

// Autoloader for classes
spl_autoload_register(function ($className) {
    $paths = [
        __DIR__ . '/../app/core/',
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Start session
Session::start();

// Initialize router
$router = new Router();

// Define routes
$router->add('', ['controller' => 'Auth', 'action' => 'login']);
$router->add('login', ['controller' => 'Auth', 'action' => 'login']);
$router->add('dashboard', ['controller' => 'Dashboard', 'action' => 'index']);
$router->add('transactions', ['controller' => 'Transaction', 'action' => 'index']);
$router->add('transaction/analyze', ['controller' => 'Transaction', 'action' => 'analyze']);
$router->add('ai/analyze', ['controller' => 'AI', 'action' => 'analyze']);
$router->add('logout', ['controller' => 'Auth', 'action' => 'logout']);

// Get URL parameters
$controllerName = $_GET['controller'] ?? 'Auth';
$action = $_GET['action'] ?? 'login';
$id = $_GET['id'] ?? null;

// Dispatch to appropriate controller
$router->dispatch($controllerName, $action, $id);