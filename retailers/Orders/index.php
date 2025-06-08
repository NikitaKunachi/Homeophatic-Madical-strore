<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homeopathic Medical Store</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <section class="medicines">
        <h2>Available Medicines</h2>
        <table>
            <thead>
                <tr>
                    <th>Medicine Name</th>
                    <th>Price</th>
                    <th>Discount on Bulk</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row -->
                <tr>
                    <td>Arnica Montana</td>
                    <td>$10</td>
                    <td>10% off on 10+</td>
                    <td>50</td>
                    <td><button onclick="addToCart('Arnica Montana', 10)">Add to Cart</button></td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
    </section>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
