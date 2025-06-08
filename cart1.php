<?php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api_key='rzp_test_vloLLx4SVwjEyE';
$api_secret='YM02CRagpfwDM9eReAIochAA';

$api=new Api($api_key,$api_secret);

// Fetch total amount from cart1 table
$conn = new mysqli('localhost', 'root', '', 'homeopathic_store');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$total = 0;
$sql = "SELECT SUM(price * quantity) AS total FROM cart1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = (int)($row['total'] * 100); // Convert to paise
}
$conn->close();

$order_id = null;

if(isset($_POST['create_order'])) {
    if($total > 0) {
        $order = $api->order->create([
            'amount' => $total,
            'currency' => 'INR',
            'receipt' => 'order_' . time() . rand(1000, 9999)
        ]);
        
        $order_id = $order->id;
        
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            echo json_encode(['order_id' => $order_id]);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/script.js" defer></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cart {
            width: 80%;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        #product-details {
            margin-top: 20px;
            text-align: center;
            padding: 15px;
            background: #e9ecef;
            border-radius: 8px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Homeopathic Medical Store</h1>
    </div>

    <section class="cart">
        <h2>Your Cart</h2>
        <div id="product-details">
            <h3>Payment Details</h3>
            <p>Total Amount: ₹<?php echo $total / 100; ?></p>
            <button id="rzp-button" data-amount="<?php echo $total; ?>">Pay with Razorpay</button>
        </div>
    </section>

    <script>
        document.getElementById('rzp-button').addEventListener('click', function(e) {
            e.preventDefault();
            var amount = this.getAttribute('data-amount');
            if (!amount || amount <= 0) {
                alert('Your cart is empty');
                return;
            }
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.order_id) {
                        startPayment(response.order_id, amount);
                    } else {
                        alert('Error creating order. Please try again.');
                    }
                }
            };
            xhr.send('create_order=1');
        });

        function startPayment(orderId, amount) {
            var options = {
                key: "<?php echo $api_key; ?>",
                amount: amount,
                currency: "INR",
                name: "Homeopathic Medical Store",
                description: "Payment for your medicine order",
                order_id: orderId,
                theme: { color: "#28a745" },
                handler: function (response) {
                    alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                    window.location.href = "order-success.html";
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
</body>
</html>
