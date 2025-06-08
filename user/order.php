<?php
session_start();
include '../config/db.php';

// Check Customer Access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header('Location: ../login.php');
    exit();
}

// Place Order
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    // Fetch Cart Items
    $stmt = $conn->prepare("
        SELECT c.*, m.stock 
        FROM cart c 
        JOIN medicines m ON c.medicine_id = m.id 
        WHERE c.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cartItems)) {
        echo "Cart is empty!";
        exit();
    }

    foreach ($cartItems as $item) {
        if ($item['quantity'] > $item['stock']) {
            echo "Insufficient stock for {$item['medicine_id']}";
            exit();
        }
    }

    // Create Orders and Update Stock
    foreach ($cartItems as $item) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, medicine_id, quantity, date) VALUES (:user_id, :medicine_id, :quantity, NOW())");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':medicine_id', $item['medicine_id']);
        $stmt->bindParam(':quantity', $item['quantity']);
        $stmt->execute();

        // Deduct Stock
        $stmt = $conn->prepare("UPDATE medicines SET stock = stock - :quantity WHERE id = :id");
        $stmt->bindParam(':quantity', $item['quantity']);
        $stmt->bindParam(':id', $item['medicine_id']);
        $stmt->execute();
    }

    // Clear Cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();

    echo "Order placed successfully!";
    header('Location: view_products.php');
}
?>
