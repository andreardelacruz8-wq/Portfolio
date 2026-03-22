<?php
$conn = new mysqli('localhost', 'root', '', 'cozy_portfolio', 3306);
if ($conn->connect_error) {
    die("❌ MySQL not running: " . $conn->connect_error);
} else {
    echo "✅ MySQL is running and connected!";
    $conn->close();
}
?>