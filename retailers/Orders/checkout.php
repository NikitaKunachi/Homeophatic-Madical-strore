<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <section class="checkout">
        <h2>Checkout</h2>
        <form action="api/process_order.php" method="post">
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery
                </label>
                <label>
                    <input type="radio" name="payment_method" value="online"> Online Payment
                </label>
            </div>
            <button type="submit">Place Order</button>
        </form>
    </section>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
