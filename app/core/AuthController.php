<?php
/**
 * Authentication Controller
 */
class AuthController extends Controller {
    
    private $userModel;
    
    public function __construct() {
        $this->userModel = $this->model('User');
    }
    
    public function login() {
        // If already logged in, redirect to dashboard
        if (Session::isLoggedIn()) {
            $this->redirect('index.php?controller=Dashboard&action=index');
        }
        
        // Handle login form submission
        if ($this->isPost()) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            
            $user = $this->userModel->findByUsername($username);
            
            // Simple password check (use password_verify in production)
            if ($user && $password === 'admin123') {
                // Set session
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::set('user_name', $user['full_name']);
                Session::set('user_role', $user['role']);
                
                // Log login
                $logModel = $this->model('AuditLog');
                $logModel->create([
                    'user_id' => $user['id'],
                    'action' => 'login',
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                ]);
                
                $this->redirect('index.php?controller=Dashboard&action=index');
            } else {
                $error = "Invalid username or password";
            }
        }
        
        // Show login form
        $this->view('auth/login', ['error' => $error ?? null]);
    }
    
    public function logout() {
        // Log logout
        if (Session::isLoggedIn()) {
            $logModel = $this->model('AuditLog');
            $logModel->create([
                'user_id' => Session::get('user_id'),
                'action' => 'logout',
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
        }
        
        Session::destroy();
        $this->redirect('index.php?controller=Auth&action=login');
    }
}