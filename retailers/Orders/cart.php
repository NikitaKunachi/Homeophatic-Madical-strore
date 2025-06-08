<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
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
        <div class="cart-actions">
            <button onclick="proceedToCheckout()">Proceed to Checkout</button>
        </div>
    </section>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
