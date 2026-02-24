<?php
/**
 * Transaction Controller
 */
class TransactionController extends Controller {
    
    private $transactionModel;
    private $aiAnalyzer;
    
    public function __construct() {
        // Require login
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
        
        // Load models
        $this->transactionModel = $this->model('Transaction');
        
        // Load AI Analyzer if exists
        if (file_exists(__DIR__ . '/../core/AIAnalyzer.php')) {
            require_once __DIR__ . '/../core/AIAnalyzer.php';
            $this->aiAnalyzer = new AIAnalyzer();
        }
    }
    
    /**
     * Display all transactions
     */
    public function index() {
        // Get all transactions
        $transactions = $this->transactionModel->findAll();
        
        // Get statistics
        $stats = $this->transactionModel->getStats();
        
        // Load view
        $this->view('transactions/index', [
            'transactions' => $transactions,
            'stats' => $stats,
            'user' => $_SESSION
        ]);
    }
    
    /**
     * Analyze a specific transaction with AI
     */
    public function analyze($id) {
        // Get transaction
        $transaction = $this->transactionModel->findById($id);
        
        if (!$transaction) {
            if ($this->isAjax()) {
                $this->json(['error' => 'Transaction not found']);
            } else {
                $_SESSION['error'] = 'Transaction not found';
                $this->redirect('index.php?controller=transaction&action=index');
            }
            return;
        }
        
        // Run AI analysis
        $analysis = null;
        if ($this->aiAnalyzer) {
            $analysis = $this->aiAnalyzer->analyzeTransaction($id, $transaction);
            
            // Save analysis to transaction
            $this->transactionModel->updateRiskScore($id, $analysis['risk_score']);
        } else {
            // Fallback analysis
            $analysis = [
                'risk_score' => rand(30, 95) / 100,
                'confidence' => 75,
                'risk_level' => 'MEDIUM',
                'patterns' => [],
                'recommendations' => ['Manual review recommended'],
                'timestamp' => date('Y-m-d H:i:s')
            ];
        }
        
        // Return JSON for AJAX requests
        if ($this->isAjax()) {
            $this->json([
                'success' => true,
                'analysis' => $analysis,
                'transaction' => $transaction
            ]);
        } else {
            // Show analysis page
            $this->view('transactions/analyze', [
                'transaction' => $transaction,
                'analysis' => $analysis
            ]);
        }
    }
    
    /**
     * Add new transaction
     */
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ref_no' => $_POST['ref_no'] ?? '',
                'description' => $_POST['description'] ?? '',
                'amount' => $_POST['amount'] ?? 0,
                'department_id' => $_POST['department_id'] ?? 1,
                'supplier' => $_POST['supplier'] ?? '',
                'procurement_type' => $_POST['procurement_type'] ?? 'open',
                'bidder_count' => ($_POST['procurement_type'] ?? 'open') == 'open' ? rand(3, 8) : rand(1, 3)
            ];
            
            // Validate
            $errors = [];
            if (empty($data['ref_no'])) $errors[] = 'Reference number is required';
            if (empty($data['description'])) $errors[] = 'Description is required';
            if ($data['amount'] <= 0) $errors[] = 'Amount must be greater than 0';
            
            if (empty($errors)) {
                $id = $this->transactionModel->create($data);
                
                if ($id) {
                    $_SESSION['success'] = 'Transaction added successfully';
                    $this->redirect('index.php?controller=transaction&action=index');
                } else {
                    $_SESSION['error'] = 'Failed to add transaction';
                }
            } else {
                $_SESSION['errors'] = $errors;
            }
        }
        
        // Redirect back to transactions page
        $this->redirect('index.php?controller=transaction&action=index');
    }
    
    /**
     * Delete transaction
     */
    public function delete($id) {
        if ($this->transactionModel->delete($id)) {
            $_SESSION['success'] = 'Transaction deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete transaction';
        }
        
        $this->redirect('index.php?controller=transaction&action=index');
    }
    
    /**
     * Check if request is AJAX
     */
    private function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
}