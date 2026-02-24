<?php
/**
 * Dashboard Controller
 */
class DashboardController extends Controller {
    
    private $transactionModel;
    
    public function __construct() {
        Session::requireLogin();
        $this->transactionModel = $this->model('Transaction');
    }
    
    public function index() {
        // Get dashboard statistics
        $stats = $this->transactionModel->getStats();
        $highRiskTransactions = $this->transactionModel->getHighRisk(10);
        
        $data = [
            'user' => Session::getUser(),
            'stats' => $stats,
            'transactions' => $highRiskTransactions,
            'pageTitle' => 'Dashboard'
        ];
        
        $this->view('dashboard/index', $data);
    }
}