<?php
require_once "../includes/db.php";

class Order {
    public static function placeOrder($retailer_id, $medicine_id, $quantity, $total_price, $payment_method) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO orders (retailer_id, medicine_id, quantity, total_price, payment_method) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$retailer_id, $medicine_id, $quantity, $total_price, $payment_method]);
    }
}
?>
