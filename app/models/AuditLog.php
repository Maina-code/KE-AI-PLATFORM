<?php
/**
 * Audit Log Model
 */
class AuditLog extends Model {
    protected $table = 'audit_log';
    
    public function getUserLogs($userId, $limit = 50) {
        $sql = "SELECT * FROM audit_log 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    }
    
    public function getRecent($limit = 100) {
        $sql = "SELECT al.*, u.full_name 
                FROM audit_log al
                LEFT JOIN users u ON al.user_id = u.id
                ORDER BY al.created_at DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}