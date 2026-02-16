<?php
class AuthController {

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Clear session
        $_SESSION = [];
        session_destroy();

        // Remove session cookies
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Redirect to login with a message
        $message = urlencode("You have been logged out successfully.");
        header("Location: /tsfreighters/app/views/auth/alogin.php?message=$message");
        exit();
    }

    public function login() {
        // For now, just load the login page directly
        include __DIR__ . '/../views/auth/alogin.php';
    }
}
?>
