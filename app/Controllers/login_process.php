<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/tsfreighters/error_log.txt');

// Function to log login errors
function logLoginError($message, $data = []) {
    $logMessage = "[" . date('Y-m-d H:i:s') . "] LOGIN ERROR: " . $message;
    
    // Mask sensitive data
    $maskedData = $data;
    $sensitiveFields = ['password', 'csrf_token', 'math_answer'];
    
    foreach ($sensitiveFields as $field) {
        if (isset($maskedData[$field])) {
            $maskedData[$field] = '***MASKED***';
        }
    }
    
    if (!empty($maskedData)) {
        $logMessage .= " | Data: " . json_encode($maskedData);
    }
    
    $logMessage .= " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $logMessage .= " | Session ID: " . (session_id() ?: 'no_session');
    $logMessage .= PHP_EOL;
    
    error_log($logMessage);
}

// Always return JSON
header('Content-Type: application/json');

// Log the POST data for debugging
logLoginError('Login attempt received', $_POST);

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logLoginError('Invalid request method', ['method' => $_SERVER['REQUEST_METHOD']]);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Validate CSRF
if (!isset($_POST['csrf_token'])) {
    logLoginError('CSRF token missing in POST');
    echo json_encode(['status' => 'error', 'message' => 'CSRF token missing.']);
    exit;
}

if (!isset($_SESSION['csrf_token'])) {
    logLoginError('CSRF token missing in SESSION');
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please refresh the page.']);
    exit;
}

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    logLoginError('CSRF token mismatch', [
        'post_token' => substr($_POST['csrf_token'], 0, 10) . '...',
        'session_token' => substr($_SESSION['csrf_token'], 0, 10) . '...'
    ]);
    echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
    exit;
}

// Validate math captcha
if (!isset($_POST['captcha'])) {
    logLoginError('Captcha missing');
    echo json_encode(['status' => 'error', 'message' => 'Captcha answer required.']);
    exit;
}

if (!isset($_SESSION['math_answer'])) {
    logLoginError('Math answer missing in session');
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please refresh the page.']);
    exit;
}

$captcha = intval($_POST['captcha']);
if ($captcha !== $_SESSION['math_answer']) {
    logLoginError('Captcha mismatch', [
        'expected' => $_SESSION['math_answer'],
        'received' => $captcha
    ]);
    echo json_encode(['status' => 'error', 'message' => 'Incorrect math answer.']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$remember = isset($_POST['remember']);

// Validation
if (empty($email) || empty($password)) {
    logLoginError('Email or password empty', ['email_provided' => !empty($email)]);
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    logLoginError('Invalid email format', ['email' => $email]);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

try {
    // Database connection
    require_once __DIR__ . '/../Core/Database.php';
    $db = Database::getInstance()->getConnection();
    
    // Check if user exists
    $stmt = $db->prepare("SELECT id, full_name, email, password, role, is_active FROM users WHERE email = ?");
    
    if (!$stmt) {
        $errorInfo = $db->errorInfo();
        logLoginError('SQL prepare failed', ['error' => $errorInfo[2] ?? 'Unknown error']);
        throw new Exception("Database error");
    }
    
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        logLoginError('User not found', ['email' => $email]);
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        exit;
    }

    // Check if account is active
    if (!$user['is_active']) {
        logLoginError('Account inactive', ['email' => $email, 'user_id' => $user['id']]);
        echo json_encode(['status' => 'error', 'message' => 'Your account is deactivated. Please contact support.']);
        exit;
    }

    // Verify password
    if (!password_verify($password, $user['password'])) {
        logLoginError('Password verification failed', ['email' => $email, 'user_id' => $user['id']]);
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        exit;
    }

    // Login successful - set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['logged_in'] = true;
    
    // Regenerate session ID for security
    session_regenerate_id(true);

    // If remember me is checked, set cookie for 30 days
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60); // 30 days
        
        // Store token in database
        $updateStmt = $db->prepare("UPDATE users SET remember_token = ?, token_expiry = ? WHERE id = ?");
        $updateStmt->execute([$token, date('Y-m-d H:i:s', $expiry), $user['id']]);
        
        // Set cookie
        setcookie('remember_token', $token, [
            'expires' => $expiry,
            'path' => '/',
            'secure' => false, // Set to true if using HTTPS
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    // Clear captcha answer
    unset($_SESSION['math_answer']);
    
    // Generate new CSRF token for next request
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Determine redirect URL
    $redirect = '/tsfreighters/public/index.php?controller=customer&action=dashboard';
    
    if ($user['role'] === 'admin' || $user['role'] === 'staff') {
        $redirect = '/tsfreighters/public/index.php?controller=admin&action=dashboard';
    }

    // Log successful login
    $logMessage = "[" . date('Y-m-d H:i:s') . "] LOGIN SUCCESS: " .
                 "User logged in: " . $user['email'] . 
                 " | Role: " . $user['role'] . 
                 " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . 
                 " | Session ID: " . session_id() . PHP_EOL;
    error_log($logMessage);
    
    echo json_encode([
        'status' => 'success', 
        'message' => 'Login successful!',
        'redirect' => $redirect,
        'role' => $user['role'],
        'user' => [
            'id' => $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email']
        ]
    ]);
    
} catch (Exception $e) {
    logLoginError('Exception occurred', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    
    // Don't expose detailed error to users
    echo json_encode([
        'status' => 'error', 
        'message' => 'An unexpected error occurred. Please try again later.'
    ]);
}
exit;