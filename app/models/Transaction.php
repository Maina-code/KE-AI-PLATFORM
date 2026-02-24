<?php
/**
 * Transaction Model
 */
class Transaction extends Model {
    protected $table = 'transactions';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Find all transactions
     */
    public function findAll() {
        $sql = "SELECT t.*, d.name as department_name 
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                ORDER BY t.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Find transaction by ID
     */
    public function findById($id) {
        $sql = "SELECT t.*, d.name as department_name,
                       s.name as supplier_name, s.risk_score as supplier_risk,
                       s.created_at as supplier_created_at
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                LEFT JOIN suppliers s ON t.supplier_id = s.id
                WHERE t.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Get dashboard statistics
     */
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total_transactions,
                    SUM(CASE WHEN risk_score >= 0.7 THEN 1 ELSE 0 END) as high_risk,
                    SUM(CASE WHEN risk_score >= 0.4 AND risk_score < 0.7 THEN 1 ELSE 0 END) as medium_risk,
                    SUM(CASE WHEN procurement_type = 'single' THEN 1 ELSE 0 END) as single_source,
                    SUM(amount) as total_amount,
                    SUM(CASE WHEN ai_flagged = 1 THEN 1 ELSE 0 END) as ai_flagged,
                    SUM(CASE WHEN status = 'recovered' THEN amount ELSE 0 END) as recovered_funds
                FROM {$this->table}
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
        
        return $this->db->query($sql)->fetch();
    }
    
    /**
     * Get high risk transactions
     */
    public function getHighRisk($limit = 10) {
        $sql = "SELECT t.*, d.name as department_name 
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                WHERE t.risk_score >= 0.6 OR t.procurement_type = 'single'
                ORDER BY t.risk_score DESC, t.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get recent transactions for AI analysis
     */
    public function getRecentForAI($limit = 50) {
        $sql = "SELECT t.*, d.name as department_name, 
                       d.risk_score as department_risk,
                       s.created_at as supplier_created_at,
                       s.risk_score as supplier_risk,
                       (SELECT COUNT(*) FROM violations WHERE supplier_id = t.supplier_id) as previous_violations
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                LEFT JOIN suppliers s ON t.supplier_id = s.id
                WHERE t.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ORDER BY t.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Get unanalyzed transactions
     */
    public function getUnanalyzed($limit = 100) {
        $sql = "SELECT t.*, d.name as department_name, 
                       d.risk_score as department_risk,
                       s.created_at as supplier_created_at,
                       s.risk_score as supplier_risk
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                LEFT JOIN suppliers s ON t.supplier_id = s.id
                WHERE (t.risk_score IS NULL OR t.risk_score = 0) AND t.ai_analyzed_at IS NULL
                ORDER BY t.created_at DESC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    /**
     * Update transaction risk score
     */
    public function updateRiskScore($id, $score) {
        $sql = "UPDATE {$this->table} 
                SET risk_score = ?, ai_analyzed_at = NOW() 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$score, $id]);
    }
    
    /**
     * Get transactions by department
     */
    public function getByDepartment($departmentId) {
        $sql = "SELECT * FROM {$this->table} WHERE department_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$departmentId]);
        return $stmt->fetchAll();
    }
    
    /**
     * Search transactions
     */
    public function search($keyword) {
        $sql = "SELECT t.*, d.name as department_name 
                FROM {$this->table} t
                LEFT JOIN departments d ON t.department_id = d.id
                WHERE t.ref_no LIKE ? 
                   OR t.description LIKE ? 
                   OR t.supplier LIKE ?
                   OR d.name LIKE ?
                ORDER BY t.created_at DESC";
        
        $search = "%$keyword%";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$search, $search, $search, $search]);
        return $stmt->fetchAll();
    }
    
    /**
     * Create new transaction
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (ref_no, description, amount, department_id, supplier, procurement_type, bidder_count, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['ref_no'],
            $data['description'],
            $data['amount'],
            $data['department_id'] ?? 1,
            $data['supplier'],
            $data['procurement_type'],
            $data['bidder_count'] ?? 1
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    /**
     * Update transaction
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
    
    /**
     * Delete transaction
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}