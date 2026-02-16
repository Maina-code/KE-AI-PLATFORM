<?php
// reset_admin.php - Emergency password reset
require_once __DIR__ . '/Core/Database.php';

$db = Database::getInstance()->getConnection();

// New password
$new_password = 'NewAdminPass123!';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Reset admin password
$stmt = $db->prepare("UPDATE users SET password = ? WHERE email = ? AND role = 'admin'");
$result = $stmt->execute([$hashed_password, 'admin@tsfreighters.com']);

if ($result && $stmt->rowCount() > 0) {
    echo "✅ Admin password reset successfully!<br>";
    echo "🔐 New Password: " . htmlspecialchars($new_password);
} else {
    echo "❌ Admin user not found or reset failed";
}