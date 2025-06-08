<?php
session_start();
include '../config/db.php';

// Check User Access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

// Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $medicine_id = $_POST['medicine_id'];
    $quantity = $_POST['quantity'];

    // Check if the medicine already exists in the cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = :user_id AND medicine_id = :medicine_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':medicine_id', $medicine_id);
    $stmt->execute();
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // Update the quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE id = :id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':id', $cartItem['id']);
    } else {
        // Add new item to cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, medicine_id, quantity) VALUES (:user_id, :medicine_id, :quantity)");
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->bindParam(':medicine_id', $medicine_id);
        $stmt->bindParam(':quantity', $quantity);
    }
    $stmt->execute();
}

// Fetch Cart Items
$stmt = $conn->prepare("
    SELECT c.*, m.name, m.price 
    FROM cart c 
    JOIN medicines m ON c.medicine_id = m.id 
    WHERE c.user_id = :user_id
");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Remove from Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location: cart.php");
    exit();
}

// Total Price Calculation
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Your Cart</h1>
    <table>
        <tr>
            <th>Medicine</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php foreach ($cartItems as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['price'] * $item['quantity'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" name="remove">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3>Total Price: ₹<?= $totalPrice ?></h3>
    <form method="POST" action="checkout.php">
        <button type="submit" name="checkout">Proceed to Checkout</button>
    </form>
</body>
</html>
