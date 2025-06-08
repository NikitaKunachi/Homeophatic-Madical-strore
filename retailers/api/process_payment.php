<?php
require_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = $_POST["order_id"];
    $amount = $_POST["amount"];
    $payment_method = $_POST["payment_method"];
    $status = ($payment_method == "online") ? "successful" : "pending";

    $stmt = $pdo->prepare("INSERT INTO transactions (order_id, amount, payment_method, status) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$order_id, $amount, $payment_method, $status])) {
        echo json_encode(["status" => "success", "message" => "Payment processed successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Payment failed."]);
    }
}
?>
