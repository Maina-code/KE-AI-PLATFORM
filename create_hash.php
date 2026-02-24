<?php
// create_hash.php - Run this file once to generate a hash
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: $password\n";
echo "Hash: $hash\n";
echo "\nCopy this SQL:\n";
echo "UPDATE users SET password = '$hash' WHERE email = 'auditor@gok.ke';\n";
?>