<?php
/**
 * Transaction Controller
 */
class TransactionController extends Controller {
    
    private $transactionModel;
    private $aiAnalyzer;
    
    public function __construct() {
        Session::requireLogin();
        $this->transactionModel = $this->model('Transaction');
        $this->aiAnalyzer = new AIAnalyzer();
    }
    
    public function index() {
        $transactions = $this->transactionModel->findAll();
        
        $this->view('transactions/index', [
            'transactions' => $transactions,
            'user' => Session::getUser()
        ]);
    }
    
    public function analyze($id) {
        // Get transaction
        $transaction = $this->transactionModel->findById($id);
        
        if (!$transaction) {
            $this->json(['error' => 'Transaction not found']);
            return;
        }
        
        // Run AI analysis
        $analysis = $this->aiAnalyzer->analyzeTransaction($id, $transaction);
        
        // Save analysis to transaction
        $this->transactionModel->update($id, [
            'risk_score' => $analysis['risk_score'],
            'ai_flagged' => $analysis['risk_score'] > 0.7 ? 1 : 0
        ]);
        
        // Return JSON for AJAX requests
        if ($this->getQuery('format') === 'json') {
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
    
    public function add() {
        if ($this->isPost()) {
            $data = [
                'ref_no' => $this->getPost('ref_no'),
                'description' => $this->getPost('description'),
                'amount' => $this->getPost('amount'),
                'department' => $this->getPost('department'),
                'supplier' => $this->getPost('supplier'),
                'procurement_type' => $this->getPost('procurement_type'),
                'bidder_count' => $this->getPost('procurement_type') == 'open' ? rand(3, 8) : rand(1, 3)
            ];
            
            $id = $this->transactionModel->create($data);
            
            // Log action
            $logModel = $this->model('AuditLog');
            $logModel->create([
                'user_id' => Session::get('user_id'),
                'action' => 'add_transaction',
                'details' => "Added transaction: {$data['ref_no']}",
                'ip_address' => $_SERVER['REMOTE_ADDR']
            ]);
            
            $this->redirect('index.php?controller=Transaction&action=index');
        }
    }
}