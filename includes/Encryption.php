<?php
// includes/Encryption.php
class Encryption {
    private $key;
    private $cipher = 'aes-256-gcm';
    
    public function __construct($key = null) {
        if ($key === null) {
            $key = ENCRYPTION_KEY; // Defined in config
        }
        $this->key = hash('sha256', $key, true);
    }
    
    public function encrypt($data) {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $tag = null;
        
        $ciphertext = openssl_encrypt(
            $data,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );
        
        return base64_encode($iv . $tag . $ciphertext);
    }
    
    public function decrypt($data) {
        $data = base64_decode($data);
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $ivlen);
        $tag = substr($data, $ivlen, 16);
        $ciphertext = substr($data, $ivlen + 16);
        
        return openssl_decrypt(
            $ciphertext,
            $this->cipher,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
    }
}

// includes/AuditLogger.php
class AuditLogger {
    public static function log($action, $details = []) {
        $db = Database::getInstance();
        
        $logEntry = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'action' => $action,
            'details' => json_encode($details),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        // Log to database
        $db->insert('audit_log', $logEntry);
        
        // Also log to system logger for redundancy
        if (defined('SYSLOG_ENABLED') && SYSLOG_ENABLED) {
            openlog('NuruAI', LOG_PID | LOG_PERROR, LOG_LOCAL0);
            syslog(LOG_INFO, "{$action}: " . json_encode($details));
            closelog();
        }
        
        // If critical, send alert
        if (in_array($action, ['failed_login', 'data_breach', 'unauthorized_access'])) {
            self::sendAlert($action, $details);
        }
    }
    
    private static function sendAlert($action, $details) {
        // Send email/SMS to security team
        $message = "Security Alert: {$action}\n";
        $message .= "Details: " . json_encode($details) . "\n";
        $message .= "Time: " . date('Y-m-d H:i:s') . "\n";
        $message .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        
        mail(SECURITY_EMAIL, "NuruAI Security Alert", $message);
    }
}