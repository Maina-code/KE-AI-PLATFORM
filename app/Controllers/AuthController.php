<?php
// Use require_once to prevent multiple inclusions
require_once __DIR__ . '/../models/auth/Auth.php';

class AuthController {
    private $authModel;
    
    public function __construct() {
        $this->authModel = new Auth();
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * Display landing page with register/login options
     */
    public function landing() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=dashboard&action=index');
            exit();
        }
        
        // Generate CSRF token for forms
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        // Generate simple math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $_SESSION['math_answer'] = $num1 + $num2;
        
        // Pass captcha values to view
        $captcha_num1 = $num1;
        $captcha_num2 = $num2;
        
        // Include the landing page view
        require_once 'app/views/landing.php';
    }
    
    /**
     * Display registration form
     */
    public function register() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=dashboard&action=index');
            exit();
        }
        
        // Generate CSRF token if not exists
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        // Generate simple math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $_SESSION['math_answer'] = $num1 + $num2;
        
        // Pass captcha values to view
        $captcha_num1 = $num1;
        $captcha_num2 = $num2;
        
        // Include the registration view
       require_once __DIR__ . '/../views/auth/register.php';

        }
    
    /**
     * Process registration form submission
     */
    public function register_process() {
        // Set header for JSON response
        header('Content-Type: application/json');
        
        try {
            // Check if it's a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }
            
            // Validate CSRF token
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('Invalid security token');
            }
            
            // Validate required fields
            $required_fields = ['full_name', 'email', 'password', 'confirm', 'captcha'];
            foreach ($required_fields as $field) {
                if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                    throw new Exception('All fields are required');
                }
            }
            
            // Validate captcha
            if (!isset($_POST['captcha']) || (int)$_POST['captcha'] !== (int)$_SESSION['math_answer']) {
                throw new Exception('Incorrect math answer. Please try again.');
            }
            
            // Sanitize inputs
            $full_name = trim(htmlspecialchars($_POST['full_name']));
            $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
            $phone = isset($_POST['phone']) ? trim(htmlspecialchars($_POST['phone'])) : '';
            $password = $_POST['password'];
            $confirm = $_POST['confirm'];
            
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format');
            }
            
            // Validate password strength
            $password_errors = $this->validatePassword($password);
            if (!empty($password_errors)) {
                throw new Exception(implode(' ', $password_errors));
            }
            
            // Check if passwords match
            if ($password !== $confirm) {
                throw new Exception('Passwords do not match');
            }
            
            // Check if email already exists
            if ($this->authModel->emailExists($email)) {
                throw new Exception('Email already registered');
            }
            
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Prepare user data
            $user_data = [
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'password' => $hashed_password,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Register user
            $user_id = $this->authModel->create($user_data);
            
            if (!$user_id) {
                throw new Exception('Registration failed. Please try again.');
            }
            
            // Clear captcha from session
            unset($_SESSION['math_answer']);
            
            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Registration successful! You can now login.',
                'user_id' => $user_id
            ]);
            
        } catch (Exception $e) {
            // Log error
            $this->logError($e->getMessage(), $_POST);
            
            // Return error response
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Display login form
     */
    public function login() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=dashboard&action=index');
            exit();
        }
        
        // Generate CSRF token if not exists
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        // Generate simple math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        $_SESSION['math_answer'] = $num1 + $num2;
        
        // Pass captcha values to view
        $captcha_num1 = $num1;
        $captcha_num2 = $num2;
        
        // Include the login view
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Process login form submission
     */
    public function login_process() {
        // Set header for JSON response
        header('Content-Type: application/json');
        
        try {
            // Check if it's a POST request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method');
            }
            
            // Validate CSRF token
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('Invalid security token');
            }
            
            // Validate captcha
            if (!isset($_POST['captcha']) || (int)$_POST['captcha'] !== (int)$_SESSION['math_answer']) {
                throw new Exception('Incorrect math answer. Please try again.');
            }
            
            // Validate required fields
            if (!isset($_POST['email']) || !isset($_POST['password'])) {
                throw new Exception('Email and password are required');
            }
            
            // Sanitize inputs
            $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
            $password = $_POST['password'];
            
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email format');
            }
            
            // Get user by email
            $user = $this->authModel->getUserByEmail($email);
            
            if (!$user) {
                throw new Exception('Invalid email or password');
            }
            
            // Verify password
            if (!password_verify($password, $user['password'])) {
                throw new Exception('Invalid email or password');
            }
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Regenerate session ID for security
            session_regenerate_id(true);
            
            // Update last login time
            $this->authModel->updateLastLogin($user['id']);
            
            // Clear captcha from session
            unset($_SESSION['math_answer']);
            
            // Generate new CSRF token
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            
            // Return success response
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful! Redirecting...',
                'redirect' => 'index.php?controller=dashboard&action=index'
            ]);
            
        } catch (Exception $e) {
            // Log error
            $this->logError($e->getMessage(), ['email' => $_POST['email'] ?? '']);
            
            // Return error response
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Clear all session variables
        $_SESSION = array();
        
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to landing page
        header('Location: index.php?controller=auth&action=landing');
        exit();
    }
    
    /**
     * Log errors to file
     */
    private function logError($message, $data = []) {
        $log_file = 'C:/xampp/htdocs/KE-AI-PLATFORM/private/error_logs/login_error_log.txt';
        
        // Create directory if it doesn't exist
        $log_dir = dirname($log_file);
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0777, true);
        }
        
        $log_message = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $message;
        
        if (!empty($data)) {
            // Mask sensitive data
            $masked_data = $data;
            if (isset($masked_data['password'])) {
                $masked_data['password'] = '***MASKED***';
            }
            if (isset($masked_data['confirm'])) {
                $masked_data['confirm'] = '***MASKED***';
            }
            if (isset($masked_data['csrf_token'])) {
                $masked_data['csrf_token'] = '***MASKED***';
            }
            $log_message .= " | Data: " . json_encode($masked_data);
        }
        
        $log_message .= " | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $log_message .= " | Session ID: " . (session_id() ?: 'no_session');
        $log_message .= PHP_EOL;
        
        error_log($log_message, 3, $log_file);
    }
    
    /**
     * Validate password strength
     */
    private function validatePassword($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }
        
        return $errors;
    }
    
    /**
     * Log client-side errors
     */
    public function log_error() {
        header('Content-Type: application/json');
        
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if ($input && isset($input['error'])) {
                $this->logError('Client Error: ' . $input['error'], $input);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No error data received']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}