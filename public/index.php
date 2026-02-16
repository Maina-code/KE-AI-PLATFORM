<?php

// =====================================================
//  GLOBAL ERROR HANDLING & LOGGING
// =====================================================
// Display all errors on screen (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define a custom error log file inside your project root
$logDir = __DIR__ . '/../logs';          // for controllers, use __DIR__ . '/logs'
$logFile = $logDir . '/error_log.txt';

// Create the logs directory if it doesn't exist
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

// Create the error log file if it doesn't exist
if (!file_exists($logFile)) {
    file_put_contents($logFile, "[" . date('Y-m-d H:i:s') . "] Error log created.\n");
}

// Set PHP to use this file for all error logging
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

require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Core/Auth.php';

// Autoload Controllers (instead of manually requiring each one)
spl_autoload_register(function ($class) {
    $controllerPath = __DIR__ . '/../app/Controllers/' . $class . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    }
});

// Start session/auth
Auth::init();

// Default routing values
$controllerName = ucfirst(strtolower($_GET['controller'] ?? 'home')) . 'Controller';
$action = $_GET['action'] ?? 'index';

// Check if controller exists
if (class_exists($controllerName)) {
    $controller = new $controllerName();

    // Check if action exists
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "404 - Unknown action: <b>{$action}</b> in {$controllerName}";
    }
} else {
    http_response_code(404);
    echo "404 - Unknown controller: <b>{$controllerName}</b>";
}
