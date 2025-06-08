<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$query = $conn->prepare("SELECT * FROM orders");
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_order_status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        $query = $conn->prepare("UPDATE orders SET status = :status WHERE order_id = :order_id");
        $query->bindParam(':order_id', $order_id);
        $query->bindParam(':status', $status);

        if ($query->execute()) {
            echo "<div class='success'>Order status updated successfully!</div>";
        } else {
            echo "<div class='error'>Failed to update order status.</div>";
        }
    } elseif (isset($_POST['delete_order'])) {
        $order_id = $_POST['order_id'];

        $query = $conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $query->bindParam(':order_id', $order_id);

        if ($query->execute()) {
            echo "<div class='success'>Order deleted successfully!</div>";
        } else {
            echo "<div class='error'>Failed to delete order.</div>";
        }
    }
}
$query = $conn->prepare("SELECT * FROM orders");
$query->execute();
$orders = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://png.pngtree.com/background/20230617/original/pngtree-assorted-pharmaceutical-pills-tablets-and-capsules-on-blue-background-3d-rendering-picture-image_3700317.jpg');
            background-size: cover;
            background-position: center;
            color: #333;
        }

        header {
            background-color: rgba(0, 35, 102, 0.8);
            padding: 20px;
            text-align: center;
            color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .container {
            padding: 40px;
            text-align: center;
        }

        form {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form h2 {
            margin-bottom: 15px;
            color: #333;
        }

        form input,
        form select,
        form button,
        form textarea {
            display: block;
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #002366;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        form button:hover {
            background-color: #001a4d;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #002366;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .success {
            margin: 10px auto;
            padding: 10px;
            background-color: #d9edf7;
            color: #31708f;
            max-width: 500px;
            text-align: center;
            border-radius: 4px;
        }

        .error {
            margin: 10px auto;
            padding: 10px;
            background-color: #f2dede;
            color: #a94442;
            max-width: 500px;
            text-align: center;
            border-radius: 4px;
        }

        nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            color: #002366;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.2rem;
            padding: 10px 15px;
            border: 2px solid #002366;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: #002366;
            color: white;
        }
    </style>
</head>

<body>
<header>
        <h1>Manage Orders</h1>
    </header>
    <div class="container">
        <!-- Update Order Status Form -->
        <form method="POST">
            <h2>Update Order Status</h2>
            <select name="order_id" required>
                <option value="" disabled selected>Select Order</option>
                <?php foreach ($orders as $order) { ?>
                    <option value="<?php echo $order['order_id']; ?>">
                        Order #<?php echo $order['order_id']; ?> (<?php echo $order['status']; ?>)
                    </option>
                <?php } ?>
            </select>
            <select name="status" required>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <button type="submit" name="update_order_status">Update Status</button>
        </form>

        <!-- Delete Order Form -->
        <form method="POST">
            <h2>Delete Order</h2>
            <select name="order_id" required>
                <option value="" disabled selected>Select Order</option>
                <?php foreach ($orders as $order) { ?>
                    <option value="<?php echo $order['order_id']; ?>">
                        Order #<?php echo $order['order_id']; ?> (<?php echo $order['status']; ?>)
                    </option>
                <?php } ?>
            </select>
            <button type="submit" name="delete_order">Delete Order</button>
        </form>


    <h2>Orders List</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>view order</th>
            
            <th>Total Amount</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>City</th>
            <th>Postal Code</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        <?php foreach ($orders as $order) { ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><a href="view_order.php?order_id=<?php echo $order['order_id']; ?>">View</a></td>
                <td><?php echo $order['total_amount']; ?></td>
                <td><?php echo $order['order_date']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td><?php echo $order['payment_method']; ?></td>
                <td><?php echo $order['first_name']; ?></td>
                <td><?php echo $order['last_name']; ?></td>
                <td><?php echo $order['address']; ?></td>
                <td><?php echo $order['city']; ?></td>
                <td><?php echo $order['postal_code']; ?></td>
                <td><?php echo $order['email']; ?></td>
                <td><?php echo $order['phone']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
