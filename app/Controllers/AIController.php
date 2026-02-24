<?php
/**
 * AI Controller - For AJAX requests
 */
class AIController extends Controller {
    
    private $aiAnalyzer;
    private $transactionModel;
    
    public function __construct() {
        Session::requireLogin();
        $this->aiAnalyzer = new AIAnalyzer();
        $this->transactionModel = $this->model('Transaction');
    }
    
    public function analyze() {
        // Get transaction ID from POST
        $transactionId = $this->getPost('transaction_id');
        
        if (!$transactionId) {
            $this->json(['error' => 'Transaction ID required']);
            return;
        }
        
        // Get transaction
        $transaction = $this->transactionModel->findById($transactionId);
        
        if (!$transaction) {
            $this->json(['error' => 'Transaction not found']);
            return;
        }
        
        // Run analysis
        $analysis = $this->aiAnalyzer->analyzeTransaction($transactionId, $transaction);
        
        // Save to database
        $this->transactionModel->update($transactionId, [
            'risk_score' => $analysis['risk_score'],
            'ai_flagged' => $analysis['risk_score'] > 0.7 ? 1 : 0
        ]);
        
        // Return JSON
        $this->json([
            'success' => true,
            'analysis' => $analysis,
            'transaction' => [
                'id' => $transaction['id'],
                'ref_no' => $transaction['ref_no']
            ]
        ]);
    }
    
    public function batch() {
        // Get unanalyzed transactions
        $transactions = $this->transactionModel->query(
            "SELECT * FROM transactions WHERE risk_score = 0 ORDER BY id DESC LIMIT 10"
        )->fetchAll();
        
        $results = [];
        
        foreach ($transactions as $transaction) {
            $analysis = $this->aiAnalyzer->analyzeTransaction($transaction['id'], $transaction);
            
            $this->transactionModel->update($transaction['id'], [
                'risk_score' => $analysis['risk_score'],
                'ai_flagged' => $analysis['risk_score'] > 0.7 ? 1 : 0
            ]);
            
            $results[] = [
                'id' => $transaction['id'],
                'ref_no' => $transaction['ref_no'],
                'risk_score' => $analysis['risk_score'],
                'risk_level' => $analysis['risk_level']
            ];
        }
        
        $this->json([
            'success' => true,
            'processed' => count($results),
            'results' => $results
        ]);
    }
}