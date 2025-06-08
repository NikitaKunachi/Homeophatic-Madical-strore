<?php
require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;

$api_key='rzp_test_vloLLx4SVwjEyE';
$api_secret='YM02CRagpfwDM9eReAIochAA';

$api=new Api($api_key,$api_secret);

// We'll only create the order if the form is submitted
$order_id = null;
$amount_paise = 0;

if(isset($_POST['create_order']) && isset($_POST['amount'])) {
    $amount_paise = (int)($_POST['amount'] * 100); // Convert to paise
    
    if($amount_paise > 0) {
        $order = $api->order->create([
            'amount' => $amount_paise,
            'currency' => 'INR',
            'receipt' => 'order_' . time() . rand(1000, 9999)
        ]);
        
        $order_id = $order->id;
        
        // Return JSON response for AJAX requests
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
        input[type='number'] {
            width: 50px;
            padding: 5px;
            text-align: center;
        }
        .remove-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }
        /* Basic header styling to replace the missing header.php */
        .header {
            width: 100%;
            background-color: #343a40;
            color: white;
            padding: 15px 0;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Replace the include with a basic header -->
    <div class="header">
        <h1>Homeopathic Medical Store</h1>
    </div>

    <section class="cart">
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Medicine Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be dynamically inserted here -->
            </tbody>
        </table>
        
        <div id="product-details">
            <h3>Payment Details</h3>
            <p id="total-amount"></p>
            <button id="rzp-button">Pay with Razorpay</button>
        </div>
    </section>

    <script>
        let stock = { "Medicine A": 5, "Medicine B": 10, "Medicine C": 2 }; // Example stock data

        document.addEventListener("DOMContentLoaded", function() {
            loadCart();
        });
        
        function addToCart(name, price, stock) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            let existingItem = cart.find(item => item.name === name);
            
            if (existingItem) {
                if (existingItem.quantity + 1 > stock) {
                    alert('Limited stock available! You cannot add more than ' + stock + ' items.');
                    return;
                }
                existingItem.quantity += 1;
            } else {
                cart.push({ name, price, stock, quantity: 1 });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Redirect to cart.html after adding to cart
            window.location.href = 'cart.html';
        }
            
        function loadCart() {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let cartTable = document.getElementById("cart-items");
            let totalAmount = 0;
            cartTable.innerHTML = "";

            cart.forEach((item, index) => {
                let row = `<tr>
                    <td>${item.name}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>
                        <input type='number' min='1' max='${item.stock}' value='${item.quantity}' onchange='updateQuantity(${index}, this.value)'>
                    </td>
                    <td id='total-${index}'>$${(item.quantity * item.price).toFixed(2)}</td>
                    <td><button class='remove-btn' onclick='removeFromCart(${index})'>Remove</button></td>
                </tr>`;
                cartTable.innerHTML += row;
                totalAmount += item.quantity * item.price;
            });
            document.getElementById("total-amount").innerText = "Total Amount: $" + totalAmount.toFixed(2);
            
            // Store totalAmount in a data attribute for Razorpay
            document.getElementById("rzp-button").setAttribute("data-amount", totalAmount);
        }
        
        function updateQuantity(index, quantity) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            if (quantity < 1) quantity = 1;
            if (quantity > cart[index].stock) {
                alert("Limited stock available!");
                return;
            }
            cart[index].quantity = parseInt(quantity);
            localStorage.setItem("cart", JSON.stringify(cart));
            loadCart();
        }
        
        function removeFromCart(index) {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            cart.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(cart));
            loadCart();
        }
        
        // Razorpay Implementation
        document.getElementById('rzp-button').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get amount from data attribute
            var amount = this.getAttribute('data-amount');
            if (!amount || amount <= 0) {
                alert('Your cart is empty');
                return;
            }
            
            // Create an AJAX request to create Razorpay order
            var xhr = new XMLHttpRequest();
            xhr.open('POST', window.location.href, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.order_id) {
                            // Initialize Razorpay with the order ID
                            startPayment(response.order_id, amount * 100);
                        } else {
                            alert('Error creating order. Please try again.');
                        }
                    } catch (e) {
                        alert('Invalid response from server. Please try again.');
                    }
                }
            };
            
            xhr.send('create_order=1&amount=' + amount);
        });
        
        function startPayment(orderId, amountPaise) {
            var options = {
                key: "<?php echo $api_key; ?>",
                amount: amountPaise,
                currency: "INR",
                name: "Homeopathic Medical Store",
                description: "Payment for your medicine order",
                image: "https://cdn.razorpay.com/logos/CMbV8jYm85Vf6g/medium.png",
                order_id: orderId,
                theme: {
                    "color": "#28a745"
                },
                handler: function (response) {
                    // Handle successful payment
                    alert('Payment successful! Payment ID: ' + response.razorpay_payment_id);
                    localStorage.removeItem("cart");
                    window.location.href = "order-success.html";
                },
                prefill: {
                    name: "",
                    email: "",
                    contact: ""
                },
                notes: {
                    address: ""
                },
                modal: {
                    ondismiss: function() {
                        console.log('Payment dismissed');
                    }
                }
            };
            
            var rzp = new Razorpay(options);
            rzp.open();
        }
    </script>
</body>
</html>