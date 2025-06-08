<?php
include('../config/db.php');

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    //echo $order_id . '<br>';

    // Fetch order and cart details using JOIN
    $query = "SELECT 
                o.order_id, o.first_name, o.last_name, o.address, o.city, o.email, o.phone, 
                o.total_amount, o.payment_method, o.status, o.order_date,
                oi.medicine_id, oi.quantity, oi.price, m.name AS medicine_name
              FROM orders o
              LEFT JOIN order_items oi ON o.order_id = oi.order_id
              LEFT JOIN medicines m ON oi.medicine_id = m.medicine_id
              WHERE o.order_id = :order_id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt->execute();
    $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($orderDetails) > 0) {
        echo "<h2>Order Details</h2>";
        $order = $orderDetails[0]; // Fetch common details from the first row
        echo "Order ID: " . $order['order_id'] . "<br>";
        echo "Customer Name: " . $order['first_name'] . " " . $order['last_name'] . "<br>";
        echo "Address: " . $order['address'] . ", " . $order['city'] . "<br>";
        echo "Email: " . $order['email'] . "<br>";
        echo "Phone: " . $order['phone'] . "<br>";
        echo "Total Amount: $" . $order['total_amount'] . "<br>";
        echo "Payment Method: " . $order['payment_method'] . "<br>";
        echo "Order Status: " . $order['status'] . "<br>";
        echo "Order Date: " . $order['order_date'] . "<br>";
        echo "<h3>Medicine List:</h3>";

        // Loop through each medicine in the order
        foreach ($orderDetails as $medicine) {
            if (!empty($medicine['medicine_name'])) { // Ensure the medicine exists
                echo "Medicine Name: " . $medicine['medicine_name'] . "<br>";
                echo "Quantity: " . $medicine['quantity'] . "<br>";
                echo "Price: $" . $medicine['price'] . "<br>";
                echo "<hr>";
            }
        }
    } else {
        echo "No order found with the given Order ID.";
    }

} else {
    echo "Invalid request!";
}
?>