<?php
$host = "localhost";
$dbname = "homeopathic_store3";
$username = "root";
$password = "";

$conn = mysqli_connect("localhost", "root", "", "homeopathic_store3");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
