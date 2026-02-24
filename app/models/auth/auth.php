<?php
if (!class_exists('Auth')) {
    require_once __DIR__ . '/../../config/database.php';
    
    class Auth {
        private $db;
        private $conn;
        
        public function __construct() {
            // Use singleton pattern
            $this->db = Database::getInstance();
            $this->conn = $this->db;
        }
        
        /**
         * Authenticate user and return user data with role
         */
        public function authenticate($email, $password) {
            try {
                $query = "SELECT id, full_name, email, phone, password, role, created_at 
                          FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($user && password_verify($password, $user['password'])) {
                    // Remove password from array
                    unset($user['password']);
                    
                    // Update last login
                    $this->updateLastLogin($user['id']);
                    
                    return $user; // Returns user with role
                }
                
                return false;
            } catch (PDOException $e) {
                $this->logError("Authentication error: " . $e->getMessage());
                return false;
            }
        }
        
        /**
         * Get user by email
         */
        public function getUserByEmail($email) {
            try {
                $query = "SELECT id, full_name, email, phone, role, created_at, last_login 
                          FROM users WHERE email = :email LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->logError("Database error in getUserByEmail(): " . $e->getMessage());
                return false;
            }
        }
        
        /**
         * Get user by ID
         */
        public function getUserById($id) {
            try {
                $query = "SELECT id, full_name, email, phone, role, created_at, last_login 
                          FROM users WHERE id = :id LIMIT 1";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $this->logError("Database error in getUserById(): " . $e->getMessage());
                return false;
            }
        }
        
        /**
         * Create a new user
         */
        public function create($user_data) {
            try {
                // Hash password
                $hashed_password = password_hash($user_data['password'], PASSWORD_DEFAULT);
                
                $query = "INSERT INTO users (full_name, email, phone, password, role, created_at) 
                          VALUES (:full_name, :email, :phone, :password, :role, :created_at)";
                
                $stmt = $this->conn->prepare($query);
                
                $stmt->bindParam(':full_name', $user_data['full_name']);
                $stmt->bindParam(':email', $user_data['email']);
                $stmt->bindParam(':phone', $user_data['phone']);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':role', $user_data['role']);
                $stmt->bindParam(':created_at', $user_data['created_at']);
                
                if ($stmt->execute()) {
                    return $this->conn->lastInsertId();
                }
                
                return false;
            } catch (PDOException $e) {
                $this->logError("Database error in create(): " . $e->getMessage());
                return false;
            }
        }
        /**
 * Check if username exists
 */
public function usernameExists($username) {
    try {
        $query = "SELECT id FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        $this->logError("Database error in usernameExists(): " . $e->getMessage());
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
                $this->logError("Database error in emailExists(): " . $e->getMessage());
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
                $this->logError("Database error in updateLastLogin(): " . $e->getMessage());
                return false;
            }
        }
        
        /**
         * Log errors to file
         */
        private function logError($message) {
            $log_file = __DIR__ . '/../../../logs/auth_errors.log';
            $log_dir = dirname($log_file);
            
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
            
            $log_message = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
            file_put_contents($log_file, $log_message, FILE_APPEND);
        }
    }
}