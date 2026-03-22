<?php
// Generate password hash for 'cozy2025'
$password = 'cozy2025';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Password: $password\n";
echo "Hash: $hash\n";
echo "\nCopy this SQL command:\n";
echo "INSERT INTO admin_users (username, password_hash, email, full_name, role) VALUES \n";
echo "('andrea_dc', '$hash', 'andrea@example.com', 'Andrea Dela Cruz', 'super_admin');\n";