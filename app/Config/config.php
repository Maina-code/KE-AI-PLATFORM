<?php
// Database configuration
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'nuru_ai');

// Site configuration
define('SITE_NAME', 'Nuru AI');
define('SITE_URL', 'http://localhost/nuru-ai');
define('SITE_VERSION', '1.0.0');

// Session configuration
// ini_set('session.cookie_httponly', 1);
// ini_set('session.use_only_cookies', 1);
// ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('Africa/Nairobi');

// Database connection
// try {
//     $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
// } catch(PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }
?>