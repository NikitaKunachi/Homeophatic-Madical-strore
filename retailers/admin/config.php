<?php
// Database configuration
$host = "localhost";  // Database host (XAMPP default is "localhost")
$username = "root";   // Default MySQL username in XAMPP
$password = "";       // Default MySQL password (empty in XAMPP)
$database = "homeopathic_store3"; // Change this to your actual database name

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character encoding to utf8
$conn->set_charset("utf8");
?>
