<?php
class Auth
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function login($user_id, $email, $name, $role)
    {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        $_SESSION['logged_in'] = true;
    }
    
    public static function logout()
    {
        // Clear session
        $_SESSION = array();
        
        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
        
        // Clear remember me cookie
        setcookie('remember_token', '', time() - 3600, '/');
    }
    
    public static function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function getUser()
    {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'] ?? null,
                'email' => $_SESSION['user_email'] ?? null,
                'name' => $_SESSION['user_name'] ?? null,
                'role' => $_SESSION['user_role'] ?? null
            ];
        }
        return null;
    }
    
    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: index.php?controller=customer&action=login');
            exit;
        }
    }
    
    public static function requireRole($allowed_roles)
    {
        self::requireLogin();
        
        $user = self::getUser();
        if (!in_array($user['role'], $allowed_roles)) {

            header('Location: index.php?controller=customer&action=dash');
            exit;
        }
    }
    
    public static function verifyCsrfToken($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public static function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}