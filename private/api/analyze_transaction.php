<?php
// api/analyze_transaction.php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://auditor.gok.ke');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once '../config/database.php';
require_once '../includes/Auth.php';
require_once '../includes/AIAnalyzer.php';
require_once '../includes/Blockchain.php';
require_once '../includes/AuditLogger.php';

// Verify authentication
$auth = new Auth();
if (!$auth->isAuthenticated() || $auth->getUserRole() !== 'auditor_general') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['transaction_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Transaction ID required']);
    exit();
}

try {
    // Get transaction details
    $db = Database::getInstance();
    $transaction = $db->query(
        "SELECT t.*, d.name as department_name, s.name as supplier_name,
                s.registration_date, s.risk_score as supplier_risk
         FROM transactions t
         JOIN departments d ON t.department_id = d.id
         JOIN suppliers s ON t.supplier_id = s.id
         WHERE t.id = ?",
        [$input['transaction_id']]
    )->fetch();
    
    if (!$transaction) {
        http_response_code(404);
        echo json_encode(['error' => 'Transaction not found']);
        exit();
    }
    
    // Run AI analysis
    $ai = new AIAnalyzer();
    $analysis = $ai->analyzeTransaction($transaction);
    
    // Check blockchain for related records
    $blockchain = new BlockchainVerifier();
    $blockchainRecord = $blockchain->verifyTransaction($transaction['id']);
    
    // Log the analysis
    AuditLogger::log('ai_analysis', [
        'transaction_id' => $transaction['id'],
        'risk_score' => $analysis['risk_score'],
        'user_id' => $auth->getUserId()
    ]);
    
    // Return results
    echo json_encode([
        'success' => true,
        'analysis' => $analysis,
        'blockchain' => $blockchainRecord,
        'timestamp' => date('c'),
        'analyzed_by' => 'NuruAI v2.0'
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Analysis failed',
        'message' => $e->getMessage()
    ]);
}

// includes/AIAnalyzer.php
class AIAnalyzer {
    private $pythonScript = '../ai_engine/analyze.py';
    private $modelEndpoint = 'http://localhost:5000/api/predict';
    
    public function analyzeTransaction($transaction) {
        // Prepare data for AI
        $data = [
            'transaction' => $transaction,
            'features' => $this->extractFeatures($transaction),
            'timestamp' => time()
        ];
        
        // Call Python AI service
        $result = $this->callAIService($data);
        
        // Enhance with rule-based checks
        $result = $this->applyBusinessRules($result, $transaction);
        
        return $result;
    }
    
    private function extractFeatures($transaction) {
        return [
            'amount' => $transaction['amount'],
            'supplier_age' => $this->calculateSupplierAge($transaction['supplier_registration_date']),
            'bidder_count' => $this->getBidderCount($transaction['id']),
            'price_variance' => $this->calculatePriceVariance($transaction),
            'single_source' => $transaction['procurement_type'] === 'single',
            'emergency' => $transaction['is_emergency'],
            'department_risk' => $this->getDepartmentRisk($transaction['department_id']),
            'supplier_risk' => $transaction['supplier_risk']
        ];
    }
    
    private function callAIService($data) {
        // Option 1: HTTP call to Python service
        $ch = curl_init($this->modelEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            return json_decode($response, true);
        }
        
        // Option 2: Fallback to Python script
        return $this->runPythonScript($data);
    }
    
    private function runPythonScript($data) {
        $inputFile = tempnam(sys_get_temp_dir(), 'ai_input_');
        $outputFile = tempnam(sys_get_temp_dir(), 'ai_output_');
        
        file_put_contents($inputFile, json_encode($data));
        
        $command = sprintf(
            'python3 %s --input %s --output %s 2>&1',
            escapeshellarg($this->pythonScript),
            escapeshellarg($inputFile),
            escapeshellarg($outputFile)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($outputFile)) {
            $result = json_decode(file_get_contents($outputFile), true);
            unlink($inputFile);
            unlink($outputFile);
            return $result;
        }
        
        // Fallback to rule-based analysis
        return $this->ruleBasedAnalysis($data);
    }
    
    private function ruleBasedAnalysis($data) {
        $transaction = $data['transaction'];
        $riskScore = 0;
        $flags = [];
        
        // Rule 1: High value transactions
        if ($transaction['amount'] > 10000000) { // Over 10M KES
            $riskScore += 0.2;
            $flags[] = 'high_value';
        }
        
        // Rule 2: Single source procurement
        if ($transaction['procurement_type'] === 'single') {
            $riskScore += 0.3;
            $flags[] = 'single_source';
        }
        
        // Rule 3: New supplier
        $supplierAge = $this->calculateSupplierAge($transaction['supplier_registration_date']);
        if ($supplierAge < 90) { // Less than 90 days old
            $riskScore += 0.15;
            $flags[] = 'new_supplier';
        }
        
        // Rule 4: Emergency procurement
        if ($transaction['is_emergency']) {
            $riskScore += 0.1;
            $flags[] = 'emergency';
        }
        
        return [
            'risk_score' => min(1.0, $riskScore),
            'flags' => $flags,
            'confidence' => 0.7,
            'method' => 'rule_based_fallback'
        ];
    }
    
    private function applyBusinessRules($analysis, $transaction) {
        // Override if specific conditions met
        if ($transaction['amount'] > 50000000 && $transaction['procurement_type'] === 'single') {
            $analysis['risk_score'] = max($analysis['risk_score'], 0.9);
            $analysis['flags'][] = 'critical_override';
            $analysis['confidence'] = min(1.0, $analysis['confidence'] + 0.1);
        }
        
        return $analysis;
    }
    
    private function calculateSupplierAge($registrationDate) {
        $regDate = new DateTime($registrationDate);
        $now = new DateTime();
        return $now->diff($regDate)->days;
    }
    
    private function getBidderCount($transactionId) {
        // Query database for bid count
        $db = Database::getInstance();
        $result = $db->query(
            "SELECT COUNT(*) as count FROM bids WHERE transaction_id = ?",
            [$transactionId]
        )->fetch();
        
        return $result['count'] ?? 0;
    }
    
    private function calculatePriceVariance($transaction) {
        // Get market average for similar items
        $db = Database::getInstance();
        $avgPrice = $db->query(
            "SELECT AVG(amount) as avg_price 
             FROM transactions 
             WHERE category = ? AND amount > 0",
            [$transaction['category']]
        )->fetchColumn();
        
        if ($avgPrice && $avgPrice > 0) {
            return abs($transaction['amount'] - $avgPrice) / $avgPrice;
        }
        
        return 0;
    }
    
    private function getDepartmentRisk($departmentId) {
        // Get historical risk score for department
        $db = Database::getInstance();
        $result = $db->query(
            "SELECT AVG(risk_score) as avg_risk 
             FROM transactions 
             WHERE department_id = ? AND risk_score IS NOT NULL",
            [$departmentId]
        )->fetchColumn();
        
        return $result ?: 0.5;
    }
    
    public function getHighRiskTransactions($limit = 50) {
        $db = Database::getInstance();
        return $db->query(
            "SELECT t.*, d.name as department_name, 
                    s.name as supplier_name,
                    ai.risk_score, ai.confidence, ai.flags
             FROM transactions t
             JOIN departments d ON t.department_id = d.id
             JOIN suppliers s ON t.supplier_id = s.id
             JOIN ai_analysis ai ON t.id = ai.transaction_id
             WHERE ai.risk_score >= 0.7
             ORDER BY ai.risk_score DESC
             LIMIT ?",
            [$limit]
        )->fetchAll();
    }
    
    public function getOverallAnomalyScore() {
        $db = Database::getInstance();
        $result = $db->query(
            "SELECT AVG(risk_score) as avg_risk,
                    COUNT(CASE WHEN risk_score >= 0.7 THEN 1 END) as high_risk_count,
                    COUNT(*) as total
             FROM ai_analysis
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)"
        )->fetch();
        
        return [
            'avg_risk' => round($result['avg_risk'] * 100, 1),
            'high_risk_percentage' => round(($result['high_risk_count'] / $result['total']) * 100, 1),
            'total_analyzed' => $result['total']
        ];
    }
    
    public function getPredictiveAlerts() {
        // Get transactions that match predictive patterns
        $db = Database::getInstance();
        return $db->query(
            "SELECT t.*, ai.risk_score, ai.patterns
             FROM transactions t
             JOIN ai_analysis ai ON t.id = ai.transaction_id
             WHERE ai.risk_score >= 0.8
               AND ai.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
               AND t.status != 'resolved'
             ORDER BY ai.risk_score DESC
             LIMIT 10"
        )->fetchAll();
    }
}

// includes/Auth.php
class Auth {
    private $sessionKey = 'nuru_ai_auth';
    private $user = null;
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION[$this->sessionKey])) {
            $this->user = $_SESSION[$this->sessionKey];
        }
    }
    
    public function authenticate($username, $password, $otp = null) {
        // Verify credentials against database
        $db = Database::getInstance();
        $user = $db->query(
            "SELECT * FROM users WHERE username = ? AND status = 'active'",
            [$username]
        )->fetch();
        
        if (!$user || !password_verify($password, $user['password_hash'])) {
            AuditLogger::log('failed_login', ['username' => $username]);
            return false;
        }
        
        // Verify OTP if enabled
        if ($user['two_factor_enabled']) {
            if (!$otp || !$this->verifyOTP($user['id'], $otp)) {
                return false;
            }
        }
        
        // Set session
        $_SESSION[$this->sessionKey] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
            'name' => $user['full_name'],
            'last_login' => date('c')
        ];
        
        // Log successful login
        AuditLogger::log('login', [
            'user_id' => $user['id'],
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        
        return true;
    }
    
    public function isAuthenticated() {
        return $this->user !== null;
    }
    
    public function getUserRole() {
        return $this->user['role'] ?? null;
    }
    
    public function getUserId() {
        return $this->user['id'] ?? null;
    }
    
    public function logout() {
        AuditLogger::log('logout', ['user_id' => $this->getUserId()]);
        unset($_SESSION[$this->sessionKey]);
        session_destroy();
    }
    
    private function verifyOTP($userId, $otp) {
        // Implement OTP verification
        // Could use Google Authenticator, SMS, etc.
        return true; // Simplified for example
    }
}