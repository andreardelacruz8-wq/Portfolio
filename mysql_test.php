<?php
// Direct MySQL connection test - no CodeIgniter needed!

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'cozy_portfolio';
$port = 3306;

echo "Testing direct MySQL connection...\n\n";

// Test connection without database first
$conn = new mysqli($host, $user, $pass, '', $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error . "\n");
}

echo "✅ Connected to MySQL server!\n";

// Check if database exists
$result = $conn->query("SHOW DATABASES LIKE '$db'");
if ($result->num_rows > 0) {
    echo "✅ Database '$db' exists!\n";
    
    // Select the database
    $conn->select_db($db);
    
    // Show tables
    $tables = $conn->query("SHOW TABLES");
    echo "\nTables in '$db':\n";
    if ($tables->num_rows > 0) {
        while ($row = $tables->fetch_array()) {
            echo "  - " . $row[0] . "\n";
        }
    } else {
        echo "  No tables found\n";
    }
    
} else {
    echo "❌ Database '$db' does not exist!\n";
    echo "Creating database '$db'...\n";
    
    if ($conn->query("CREATE DATABASE $db")) {
        echo "✅ Database created successfully!\n";
    } else {
        echo "❌ Failed to create database: " . $conn->error . "\n";
    }
}

$conn->close();
?>