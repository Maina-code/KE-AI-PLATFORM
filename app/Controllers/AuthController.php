<?php
require_once __DIR__ . '/../models/auth/auth.php';

class AuthController {
    private $auth;
    
    public function __construct() {
        $this->auth = new Auth();
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
 * Handle user registration
 */
public function register() {
    // If already logged in, redirect to dashboard
    if (isset($_SESSION['user_id'])) {
        $this->redirectToDashboard($_SESSION['user_role']);
        return;
    }
    
    $errors = [];
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $username = trim($_POST['username'] ?? '');
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $role = $_POST['role'] ?? 'auditor'; // Default role
        
        // Validate inputs
        if (empty($username)) {
            $errors[] = "Username is required";
        } elseif (strlen($username) < 3) {
            $errors[] = "Username must be at least 3 characters";
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = "Username can only contain letters, numbers, and underscores";
        }
        
        if (empty($full_name)) {
            $errors[] = "Full name is required";
        }
        
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        if (empty($phone)) {
            $errors[] = "Phone number is required";
        } elseif (!preg_match('/^[0-9\+\-\(\)\s]+$/', $phone)) {
            $errors[] = "Invalid phone number format";
        }
        
        if (empty($password)) {
            $errors[] = "Password is required";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        } elseif (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        } elseif (!preg_match('/[0-9]/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }
        
        // Check if username already exists
        if (empty($errors) && $this->auth->usernameExists($username)) {
            $errors[] = "Username already taken";
        }
        
        // Check if email already exists
        if (empty($errors) && $this->auth->emailExists($email)) {
            $errors[] = "Email already registered";
        }
        
        // If no errors, create user
        if (empty($errors)) {
            $user_data = [
                'username' => $username,
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password, // Will be hashed in create() method
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $user_id = $this->auth->create($user_data);
            
            if ($user_id) {
                $success = "Registration successful! You can now login.";
                
                // Clear form data
                $_POST = [];
                
                // Optional: Auto login after registration
                // $user = $this->auth->authenticate($email, $password);
                // if ($user) {
                //     $_SESSION['user_id'] = $user['id'];
                //     $_SESSION['user_name'] = $user['full_name'];
                //     $_SESSION['user_email'] = $user['email'];
                //     $_SESSION['user_role'] = $user['role'];
                //     $this->redirectToDashboard($user['role']);
                // }
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
    
    // Load registration view
    require_once __DIR__ . '/../views/auth/register.php';
}
/**
 * Check if username exists (AJAX endpoint)
 */
public function checkUsername() {
    $username = $_GET['username'] ?? '';
    
    if (empty($username)) {
        $this->json(['exists' => false]);
        return;
    }
    
    $exists = $this->auth->usernameExists($username);
    
    header('Content-Type: application/json');
    echo json_encode(['exists' => $exists]);
    exit();
}

/**
 * Helper method to return JSON response
 */
private function json($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
}
    
    /**
     * Handle login
     */
    public function login() {
        // If already logged in, redirect to appropriate dashboard
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
            $this->redirectToDashboard($_SESSION['user_role']);
            return;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = "Please enter both email and password";
            } else {
                $user = $this->auth->authenticate($email, $password);
                
                if ($user) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role']; // THIS IS CRITICAL
                    
                    // Debug - log successful login
                    error_log("Login successful for user: " . $email . " with role: " . $user['role']);
                    
                    // Redirect based on role
                    $this->redirectToDashboard($user['role']);
                    return;
                } else {
                    $error = "Invalid email or password";
                    error_log("Login failed for email: " . $email);
                }
            }
        }
        
        // Load login view
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Redirect user to their specific dashboard based on role
     */
    private function redirectToDashboard($role) {
        switch ($role) {
            case 'auditor_general':
                header('Location: /KE-AI-PLATFORM/public/index.php?controller=auditor&action=dashboard');
                break;
            case 'auditor':
                header('Location: /KE-AI-PLATFORM/public/index.php?controller=dashboard&action=index');
                break;
            case 'admin':
                header('Location: /KE-AI-PLATFORM/public/index.php?controller=admin&action=dashboard');
                break;
            default:
                header('Location: /KE-AI-PLATFORM/public/index.php?controller=dashboard&action=index');
        }
        exit();
    }
    
    /**
     * Handle logout
     */
    public function logout() {
        // Clear all session variables
        $_SESSION = array();
        
        // Destroy the session
        session_destroy();
        
        // Redirect to login page
        header('Location: /KE-AI-PLATFORM/public/index.php?controller=auth&action=login');
        exit();
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Get current user role
     */
    public static function getUserRole() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Require authentication - redirect to login if not authenticated
     */
    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header('Location: /KE-AI-PLATFORM/public/index.php?controller=auth&action=login');
            exit();
        }
    }
    
    /**
     * Require specific role - redirect if wrong role
     */
    public static function requireRole($required_role) {
        self::requireAuth();
        
        if ($_SESSION['user_role'] !== $required_role) {
            // Redirect to appropriate dashboard based on actual role
            switch ($_SESSION['user_role']) {
                case 'auditor_general':
                    header('Location: /KE-AI-PLATFORM/public/index.php?controller=auditor&action=dashboard');
                    break;
                case 'auditor':
                    header('Location: /KE-AI-PLATFORM/public/index.php?controller=dashboard&action=index');
                    break;
                default:
                    header('Location: /KE-AI-PLATFORM/public/index.php?controller=auth&action=login');
            }
            exit();
        }
    }
}