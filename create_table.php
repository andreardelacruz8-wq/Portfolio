<?php
// Direct table creation

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'cozy_portfolio';
$port = 3306;

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error . "\n");
}

echo "✅ Connected to database '$db'\n";

// Create contacts table
$sql = "CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(128) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ipaddress VARCHAR(32) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($sql) === TRUE) {
    echo "✅ Table 'contacts' created successfully!\n";
} else {
    echo "❌ Error creating table: " . $conn->error . "\n";
}

// Show tables to confirm
$result = $conn->query("SHOW TABLES");
echo "\nTables in database:\n";
while ($row = $result->fetch_array()) {
    echo "  - " . $row[0] . "\n";
}

$conn->close();
?>