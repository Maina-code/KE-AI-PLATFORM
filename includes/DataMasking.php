<?php
class DataMasking {
    public static function maskEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
        
        list($local, $domain) = explode('@', $email);
        $maskedLocal = substr($local, 0, 2) . str_repeat('*', max(0, strlen($local) - 4)) . substr($local, -2);
        
        return $maskedLocal . '@' . $domain;
    }
    
    public static function maskPhone($phone) {
        return substr($phone, 0, 4) . '****' . substr($phone, -4);
    }
    
    public static function maskAmount($amount) {
        if ($amount > 10000000) {
            return '********';
        }
        return number_format($amount);
    }
}
?>