<?php
require_once __DIR__ . '/../controllers/AuthController.php';

class AuditorController {
    
    public function __construct() {
        // Only allow auditor_general to access this controller
        AuthController::requireRole('auditor_general');
    }
    
    /**
     * Auditor General Dashboard
     */
    public function dashboard() {
        // Get user data from session
        $user_name = $_SESSION['user_name'] ?? 'Auditor General';
        $user_email = $_SESSION['user_email'] ?? '';
        
        // Load the auditor general dashboard view
        require_once __DIR__ . '/../views/auditor/dashboard.php';
    }
    
    /**
     * View all transactions
     */
    public function transactions() {
        // Load transactions view
        require_once __DIR__ . '/../views/auditor/transactions.php';
    }
    
    /**
     * View specific case
     */
    public function case($id) {
        // Load case view
        require_once __DIR__ . '/../views/auditor/case.php';
    }
}