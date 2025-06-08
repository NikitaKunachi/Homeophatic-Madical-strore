<?php
require __DIR__ . "/../../config.php"; // ✅ Ensure correct path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine = $_POST['medicine'];
    $quantity = intval($_POST['quantity']);
    $total_price = floatval($_POST['total_price']);
    $payment_method = $_POST['payment_method'];
    $order_status = ($payment_method === 'cod') ? 'Pending' : 'Paid';

    // Validate data
    if (empty($medicine) || $quantity <= 0 || $total_price <= 0) {
        die(json_encode(["status" => "error", "message" => "Invalid order details."]));
    }

    // Handle Online Payment Verification
    if ($payment_method === "online") {
        // ✅ Fix for PHP 5.6: Use isset() instead of ??
        $razorpay_payment_id = isset($_POST['razorpay_payment_id']) ? $_POST['razorpay_payment_id'] : null;

        if (!$razorpay_payment_id) {
            die(json_encode(["status" => "error", "message" => "Payment failed."]));
        }

        // Verify payment using Razorpay API
        $razorpay_secret = "YOUR_RAZORPAY_SECRET_KEY";   
        $webhook_signature = isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']) ? $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] : '';
        $payload = file_get_contents("php://input");

        if (hash_hmac('sha256', $payload, $razorpay_secret) !== $webhook_signature) {
            die(json_encode(["status" => "error", "message" => "Payment verification failed."]));
        }

        $order_status = "Paid"; // Confirm order after successful payment
    }

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (medicine, quantity, total_price, payment_method, order_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sids", $medicine, $quantity, $total_price, $payment_method, $order_status);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Order placed successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Order processing failed."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
