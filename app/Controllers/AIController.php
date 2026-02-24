<?php
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../core/AIAnalyzer.php';

class AIController {
    private $transactionModel;
    private $aiAnalyzer;
    
    public function __construct() {
        $this->transactionModel = new Transaction();
        $this->aiAnalyzer = new AIAnalyzer();
        
        // Require authentication
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
    }
    
    /**
     * Get AI insights for dashboard
     */
    public function getInsights() {
        header('Content-Type: application/json');
        
        try {
            // Get recent transactions for AI analysis
            $transactions = $this->transactionModel->getRecentForAI(50);
            
            // Run AI analysis
            $insights = $this->aiAnalyzer->analyzeBatch($transactions);
            
            // Get high priority alerts
            $alerts = $this->aiAnalyzer->getHighPriorityAlerts();
            
            // Get predictive trends
            $predictions = $this->aiAnalyzer->predictTrends();
            
            echo json_encode([
                'success' => true,
                'insights' => $insights,
                'alerts' => $alerts,
                'predictions' => $predictions,
                'timestamp' => date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Analyze a specific transaction
     */
    public function analyzeTransaction() {
        header('Content-Type: application/json');
        
        $transactionId = $_POST['transaction_id'] ?? $_GET['id'] ?? null;
        
        if (!$transactionId) {
            echo json_encode(['success' => false, 'error' => 'Transaction ID required']);
            return;
        }
        
        $transaction = $this->transactionModel->findById($transactionId);
        
        if (!$transaction) {
            echo json_encode(['success' => false, 'error' => 'Transaction not found']);
            return;
        }
        
        $analysis = $this->aiAnalyzer->analyzeTransaction($transaction);
        
        // Save analysis to database
        $this->transactionModel->updateRiskScore($transactionId, $analysis['risk_score']);
        
        echo json_encode([
            'success' => true,
            'analysis' => $analysis
        ]);
    }
    
    /**
     * Run batch AI analysis
     */
    public function runBatchAnalysis() {
        header('Content-Type: application/json');
        
        // Only Auditor General can run batch analysis
        if ($_SESSION['user_role'] !== 'auditor_general') {
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            return;
        }
        
        // Get unanalyzed transactions
        $transactions = $this->transactionModel->getUnanalyzed(100);
        
        $results = [];
        foreach ($transactions as $transaction) {
            $analysis = $this->aiAnalyzer->analyzeTransaction($transaction);
            $this->transactionModel->updateRiskScore($transaction['id'], $analysis['risk_score']);
            $results[] = [
                'id' => $transaction['id'],
                'risk_score' => $analysis['risk_score'],
                'risk_level' => $analysis['risk_level']
            ];
        }
        
        echo json_encode([
            'success' => true,
            'analyzed' => count($results),
            'results' => $results
        ]);
    }
    
    /**
     * Get corruption patterns
     */
    public function getPatterns() {
        header('Content-Type: application/json');
        
        $patterns = $this->aiAnalyzer->getDetectedPatterns();
        
        echo json_encode([
            'success' => true,
            'patterns' => $patterns
        ]);
    }
    
    /**
     * Get AI confidence metrics
     */
    public function getConfidenceMetrics() {
        header('Content-Type: application/json');
        
        $metrics = $this->aiAnalyzer->getConfidenceMetrics();
        
        echo json_encode([
            'success' => true,
            'metrics' => $metrics
        ]);
    }
}