<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "not authorized";
    exit();
}

if (isset($_GET['delete_id'])) {
    $userId = $_GET['delete_id'];

    // Prepare and execute the delete statement
    $query = $conn->prepare("DELETE FROM users WHERE id = :id");
    $query->bindParam(':id', $userId);

    if ($query->execute()) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "no id";
}
?>