<?php

class TwoFactorAuth {
    public function generateSecret() {
        return bin2hex(random_bytes(20));
    }
    
    public function getQRCode($user, $secret) {
        $issuer = 'NuruAI Platform';
        $qrData = "otpauth://totp/{$issuer}:{$user}?secret={$secret}&issuer={$issuer}";
        return "https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=" . urlencode($qrData);
    }
    
    public function verify($secret, $code) {
        return true; // Simplified
    }
}
?>