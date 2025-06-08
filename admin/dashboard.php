<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch Medicines
$query = $conn->prepare("SELECT * FROM medicines");
$query->execute();
$medicines = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicines</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://png.pngtree.com/thumb_back/fh260/background/20230526/pngtree-some-pills-and-white-capsules-on-a-blue-background-image_2642935.jpg') no-repeat center center fixed; /* Set background image */
            background-size: cover; /* Ensure the image covers the full screen */
            color: #ffffff;
        }

        header {
            background-color: rgba(0, 31, 77, 0.8); /* Semi-transparent for blending */
            padding: 20px;
            text-align: center;
            color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            letter-spacing: 1px;
        }

        nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2rem;
            padding: 10px 15px;
            border: 2px solid #0056b3;
            border-radius: 5px;
            background-color: rgba(0, 86, 179, 0.9); /* Semi-transparent button */
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: rgba(0, 68, 148, 0.9);
            color: white;
        }

        .container {
            padding: 40px;
            text-align: center;
            background-color: rgba(18, 18, 18, 0.8); /* Semi-transparent container */
            margin: 40px auto;
            border-radius: 10px;
            max-width: 1200px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        .container h2 {
            color: #007bff;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #1e1e1e;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }

        table th {
            background-color: #0056b3;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #2c2c2c;
        }

        table tr:hover {
            background-color: #3a3a3a;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <div class="container">
        <nav>
            <a href="manage_medicine.php">Manage Medicines</a>
            <a href="manage_orders.php">Manage Orders</a>
            <a href="manage_sales.php">View Sales</a>
            <a href="manage_customers.php">Manage Customers</a>
            <a href="../logout.php">Logout</a>
        </nav>

        <!-- Display Medicines -->
        <h2>Medicines List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
            <?php foreach ($medicines as $medicine) { ?>
            <tr>
                <td><?php echo $medicine['medicine_id']; ?></td>
                <td><?php echo $medicine['name']; ?></td>
                <td><?php echo $medicine['price']; ?></td>
                <td><?php echo $medicine['stock']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
