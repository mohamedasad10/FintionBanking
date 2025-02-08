<?php
// db.php - Database connection script
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";  // Default XAMPP password (empty)
$dbname = "mini_bank";  // Name of the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
