<?php
/**
 * Session Management Class
 */
class Session {
    
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    public static function delete($key) {
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: index.php?controller=Auth&action=login');
            exit();
        }
    }
    
    public static function getUser() {
        return [
            'id' => self::get('user_id'),
            'username' => self::get('username'),
            'name' => self::get('user_name'),
            'role' => self::get('user_role')
        ];
    }
}