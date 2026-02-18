<?php
require_once __DIR__ . '/../models/auth/Auth.php';

class DashboardController {
    private $authModel;
    
    public function __construct() {
        $this->authModel = new Auth();
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // TEMPORARY: Comment out session check for development
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: /KE-AI-PLATFORM/public/index.php?controller=auth&action=login');
        //     exit();
        // }
    }
    
    /**
     * Display auditor dashboard
     */
    public function index() {
        // Get user data from session (temporary dummy data for development)
        $user_data = [
            'name' => $_SESSION['user_name'] ?? 'Auditor General',
            'email' => $_SESSION['user_email'] ?? 'auditor@gov.ke',
            'role' => 'Auditor General',
            'department' => 'Office of the Auditor General'
        ];
        
        // Include the dashboard view
     
        require_once __DIR__ . '/../views/dashboard/auditor_dashboard.php';
    }
    
    /**
     * Get dashboard statistics (AJAX endpoint)
     */
    public function getStats() {
        header('Content-Type: application/json');
        
        // TODO: Fetch real statistics from database
        $stats = [
            'total_transactions' => 1284,
            'suspicious_cases' => 47,
            'pending_review' => 23,
            'resolved_cases' => 156,
            'high_priority' => 12,
            'medium_priority' => 24,
            'low_priority' => 11,
            'monthly_trend' => [65, 59, 80, 81, 56, 55, 40, 60, 75, 85, 70, 90]
        ];
        
        echo json_encode(['status' => 'success', 'data' => $stats]);
    }
    
    /**
     * Get recent transactions (AJAX endpoint)
     */
    public function getTransactions() {
        header('Content-Type: application/json');
        
        // TODO: Fetch real transactions from database
        $transactions = [
            [
                'id' => 'TR-2024-001',
                'date' => '2024-02-15',
                'description' => 'Tender for Office Supplies',
                'amount' => 1250000,
                'department' => 'Procurement',
                'status' => 'pending',
                'priority' => 'high'
            ],
            [
                'id' => 'TR-2024-002',
                'date' => '2024-02-14',
                'description' => 'Consultancy Services',
                'amount' => 3750000,
                'department' => 'Finance',
                'status' => 'investigating',
                'priority' => 'high'
            ],
            [
                'id' => 'TR-2024-003',
                'date' => '2024-02-13',
                'description' => 'Infrastructure Project',
                'amount' => 12500000,
                'department' => 'Infrastructure',
                'status' => 'resolved',
                'priority' => 'medium'
            ],
            [
                'id' => 'TR-2024-004',
                'date' => '2024-02-12',
                'description' => 'IT Equipment Supply',
                'amount' => 890000,
                'department' => 'ICT',
                'status' => 'pending',
                'priority' => 'low'
            ]
        ];
        
        echo json_encode(['status' => 'success', 'data' => $transactions]);
    }
    
    /**
     * Get cases by priority (AJAX endpoint)
     */
    public function getCases() {
        header('Content-Type: application/json');
        
        // TODO: Fetch real cases from database
        $cases = [
            'high' => [
                [
                    'id' => 'CASE-2024-001',
                    'title' => 'Irregular Tender Award - Ministry of Health',
                    'description' => 'Suspected bid rigging in medical equipment procurement worth KES 45M',
                    'department' => 'Health',
                    'amount' => 45000000,
                    'status' => 'investigating',
                    'deadline' => '2024-02-20'
                ],
                [
                    'id' => 'CASE-2024-004',
                    'title' => 'Road Construction Contract',
                    'description' => 'Inflated costs in highway construction project',
                    'department' => 'Infrastructure',
                    'amount' => 120000000,
                    'status' => 'pending',
                    'deadline' => '2024-02-22'
                ]
            ],
            'medium' => [
                [
                    'id' => 'CASE-2024-002',
                    'title' => 'Overpriced Consultancy Contract',
                    'description' => 'Consultancy fees 40% above market rate at KRA',
                    'department' => 'KRA',
                    'amount' => 3750000,
                    'status' => 'pending',
                    'deadline' => '2024-02-25'
                ]
            ],
            'low' => [
                [
                    'id' => 'CASE-2024-003',
                    'title' => 'Duplicate Payment - Ministry of Education',
                    'description' => 'Double payment for same invoice worth KES 230K',
                    'department' => 'Education',
                    'amount' => 230000,
                    'status' => 'resolved',
                    'deadline' => '2024-02-28'
                ]
            ]
        ];
        
        echo json_encode(['status' => 'success', 'data' => $cases]);
    }
    
    /**
     * Get audit trail (AJAX endpoint)
     */
    public function getAuditTrail() {
        header('Content-Type: application/json');
        
        // TODO: Fetch real audit trail from database
        $audit_trail = [
            [
                'timestamp' => '2024-02-15 09:23:45',
                'user' => 'auditor@gov.ke',
                'action' => 'Case Review',
                'resource' => 'CASE-2024-001',
                'ip' => '192.168.1.45',
                'status' => 'success'
            ],
            [
                'timestamp' => '2024-02-15 08:45:12',
                'user' => 'auditor@gov.ke',
                'action' => 'Login',
                'resource' => 'System',
                'ip' => '192.168.1.45',
                'status' => 'success'
            ],
            [
                'timestamp' => '2024-02-14 16:30:22',
                'user' => 'auditor@gov.ke',
                'action' => 'Export Report',
                'resource' => 'Monthly Audit',
                'ip' => '192.168.1.45',
                'status' => 'success'
            ]
        ];
        
        echo json_encode(['status' => 'success', 'data' => $audit_trail]);
    }
    
    /**
     * Update user settings (AJAX endpoint)
     */
    public function updateSettings() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
            return;
        }
        
        // TODO: Update user settings in database
        $settings = json_decode(file_get_contents('php://input'), true);
        
        echo json_encode(['status' => 'success', 'message' => 'Settings updated successfully']);
    }
    
    /**
     * Generate report (AJAX endpoint)
     */
    public function generateReport() {
        header('Content-Type: application/json');
        
        $report_type = $_GET['type'] ?? 'monthly';
        $period = $_GET['period'] ?? 'last_month';
        
        // TODO: Generate actual report data
        $report_data = [
            'type' => $report_type,
            'period' => $period,
            'generated_at' => date('Y-m-d H:i:s'),
            'summary' => [
                'total_transactions' => 1284,
                'suspicious_cases' => 47,
                'resolved_cases' => 156,
                'amount_involved' => 456000000
            ],
            'download_url' => '/reports/' . $report_type . '_' . date('Ymd') . '.pdf'
        ];
        
        echo json_encode(['status' => 'success', 'data' => $report_data]);
    }
}