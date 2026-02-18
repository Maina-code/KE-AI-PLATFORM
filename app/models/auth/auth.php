<?php
// Check if class already exists before declaring
if (!class_exists('Auth')) {
    require_once __DIR__ . '/../../config/config.php';
    
    class Auth {
        private $db;
        private $conn;
        
        public function __construct() {
            $this->db = new Database();
            $this->conn = $this->db->getConnection();
        }
        
        /**
         * Create a new user
         */
        public function create($user_data) {
            try {
                $query = "INSERT INTO users (full_name, email, phone, password, created_at) 
                          VALUES (:full_name, :email, :phone, :password, :created_at)";
                
                $stmt = $this->conn->prepare($query);
                
                $stmt->bindParam(':full_name', $user_data['full_name']);
                $stmt->bindParam(':email', $user_data['email']);
                $stmt->bindParam(':phone', $user_data['phone']);
                $stmt->bindParam(':password', $user_data['password']);
                $stmt->bindParam(':created_at', $user_data['created_at']);
                
                if ($stmt->execute()) {
                    return $this->conn->lastInsertId();
                }
                
                return false;
            } catch (PDOException $e) {
                $this->logError("Database error in create(): " . $e->getMessage(), $user_data);
                return false;
            }
        }
        
        /**
         * Get user by email
         */
        public function getUserByEmail($email) {
            try {
                $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->logError("Database error in getUserByEmail(): " . $e->getMessage(), ['email' => $email]);
                return false;
            }
        }
        
        /**
         * Get user by ID
         */
        public function getUserById($id) {
            try {
                $query = "SELECT id, full_name, email, phone, created_at, last_login FROM users WHERE id = :id LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->logError("Database error in getUserById(): " . $e->getMessage(), ['id' => $id]);
                return false;
            }
        }
        
        /**
         * Check if email exists
         */
        public function emailExists($email) {
            try {
                $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                return $stmt->rowCount() > 0;
            } catch (PDOException $e) {
                $this->logError("Database error in emailExists(): " . $e->getMessage(), ['email' => $email]);
                return false;
            }
        }
        
        /**
         * Update last login time
         */
        public function updateLastLogin($user_id) {
            try {
                $query = "UPDATE users SET last_login = NOW() WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $user_id);
                return $stmt->execute();
            } catch (PDOException $e) {
                $this->logError("Database error in updateLastLogin(): " . $e->getMessage(), ['user_id' => $user_id]);
                return false;
            }
        }
        
        /**
         * Log errors to file
         */
        private function logError($message, $data = []) {
            $log_file = 'C:/xampp/htdocs/KE-AI-PLATFORM/private/error_log.txt';
            
            // Create directory if it doesn't exist
            $log_dir = dirname($log_file);
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
            
            $log_message = "[" . date('Y-m-d H:i:s') . "] ERROR: " . $message;
            
            if (!empty($data)) {
                // Mask sensitive data
                $masked_data = $data;
                if (isset($masked_data['password'])) {
                    $masked_data['password'] = '***MASKED***';
                }
                $log_message .= " | Data: " . json_encode($masked_data);
            }
            
            $log_message .= PHP_EOL;
            error_log($log_message, 3, $log_file);
        }
    }
    
    // Log that Auth class was loaded
    error_log("Auth class loaded successfully from: " . __FILE__);
}