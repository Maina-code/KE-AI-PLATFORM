<?php
/**
 * Transaction Model
 */
class Transaction extends Model {
    protected $table = 'transactions';
    
    public function getStats() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN risk_score > 0.7 THEN 1 ELSE 0 END) as high_risk,
                    SUM(CASE WHEN procurement_type = 'single' THEN 1 ELSE 0 END) as single_source,
                    SUM(amount) as total_amount
                FROM transactions";
        
        return $this->db->query($sql)->fetch();
    }
    
    public function getHighRisk($limit = 10) {
        $sql = "SELECT * FROM transactions 
                WHERE risk_score > 0.4 OR procurement_type = 'single'
                ORDER BY risk_score DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
    
    public function getByDepartment($department) {
        $sql = "SELECT * FROM transactions WHERE department = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$department]);
        return $stmt->fetchAll();
    }
    
    public function search($keyword) {
        $sql = "SELECT * FROM transactions 
                WHERE ref_no LIKE ? OR description LIKE ? OR supplier LIKE ?
                ORDER BY created_at DESC";
        
        $search = "%$keyword%";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$search, $search, $search]);
        return $stmt->fetchAll();
    }
}