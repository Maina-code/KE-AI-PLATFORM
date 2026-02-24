<?php
public function getRecentForAI($limit = 50) {
    $sql = "SELECT t.*, d.name as department_name, 
                   d.risk_score as department_risk,
                   s.created_at as supplier_created_at,
                   s.risk_score as supplier_risk,
                   (SELECT COUNT(*) FROM violations WHERE supplier_id = t.supplier_id) as previous_violations
            FROM transactions t
            JOIN departments d ON t.department_id = d.id
            JOIN suppliers s ON t.supplier_id = s.id
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
            FROM transactions t
            JOIN departments d ON t.department_id = d.id
            JOIN suppliers s ON t.supplier_id = s.id
            WHERE t.risk_score IS NULL OR t.risk_score = 0
            ORDER BY t.created_at DESC
            LIMIT ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}
public function updateRiskScore($id, $score) {
    $sql = "UPDATE transactions 
            SET risk_score = ?, ai_analyzed_at = NOW() 
            WHERE id = ?";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$score, $id]);
}