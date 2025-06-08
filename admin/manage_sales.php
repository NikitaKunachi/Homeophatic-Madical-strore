<?php
session_start();
include '../config/db.php';

// Check Admin Access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch Sales Data
try {
    $sales = $conn->query("
        SELECT s.*, m.name AS medicine_name, u.username AS customer_name, 
               (s.quantity * m.price) AS total_amount
        FROM sales s
        JOIN medicines m ON s.medicine_id = m.medicine_id
        JOIN users u ON s.user_id = u.id
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Calculate daily, weekly, and monthly totals and profit
    $totals = $conn->query("
        SELECT 
            DATE(s.date) AS sale_date,
            SUM(s.quantity) AS total_quantity,
            SUM(s.quantity * m.price) AS total_amount,
            SUM(s.quantity * (m.price - m.cost)) AS total_profit
        FROM sales s
        JOIN medicines m ON s.medicine_id = m.medicine_id
        GROUP BY DATE(s.date)
    ")->fetchAll(PDO::FETCH_ASSOC);

    $weeklyTotals = $conn->query("
        SELECT 
            WEEK(s.date) AS sale_week,
            SUM(s.quantity) AS total_quantity,
            SUM(s.quantity * m.price) AS total_amount,
            SUM(s.quantity * (m.price - m.cost)) AS total_profit
        FROM sales s
        JOIN medicines m ON s.medicine_id = m.medicine_id
        GROUP BY WEEK(s.date)
    ")->fetchAll(PDO::FETCH_ASSOC);

    $monthlyTotals = $conn->query("
        SELECT 
            MONTH(s.date) AS sale_month,
            SUM(s.quantity) AS total_quantity,
            SUM(s.quantity * m.price) AS total_amount,
            SUM(s.quantity * (m.price - m.cost)) AS total_profit
        FROM sales s
        JOIN medicines m ON s.medicine_id = m.medicine_id
        GROUP BY MONTH(s.date)
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}

// Prepare data for charts
$medicineNames = [];
$quantities = [];
foreach ($sales as $sale) {
    $medicineNames[] = $sale['medicine_name'];
    $quantities[] = $sale['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
         .logout-container {
            display: flex;
            justify-content: flex-end; /* Align button to the right */
            margin-bottom: 20px;
        }

        .logout-btn {
            background-color:rgb(17, 32, 147); /* Red color */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .logout-btn:hover {
            background-color: #cc0000; /* Darker red */
            transform: scale(1.05);
        }

        .logout-btn:active {
            background-color: #990000;
            transform: scale(0.98);
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-image: url('https://t3.ftcdn.net/jpg/08/18/80/84/360_F_818808443_64s9Qrqy8vmJ0InxphzDbdn0q2OGEpq3.jpg'); /* Set your background image */
            background-size: cover;
            background-position: center;
            color: white;
        }
        h1, h2 {
            text-align: center;
            color: #fff;
        }
        .totals {
            text-align: center;
            margin-bottom: 20px;
        }
        .chart-container {
            width: 80%;
            margin: auto;
            margin-top: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for table */
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    <center>
    <a href="dashboard.php" class="logout-btn">Logout</a>
    </center>
   

    <!-- Totals Section -->
    <div class="totals">
        <h2>Daily, Weekly, and Monthly Totals</h2>
        <p>Daily Sales: 
            <?php if (!empty($totals) && isset($totals[0]['total_amount'])) { 
                echo number_format($totals[0]['total_amount'], 2) . " (Profit: " . number_format($totals[0]['total_profit'], 2) . ")"; 
            } else {
                echo "0.00 (Profit: 0.00)";
            } ?>
        </p>
        <p>Weekly Sales: 
            <?php if (!empty($weeklyTotals) && isset($weeklyTotals[0]['total_amount'])) { 
                echo number_format($weeklyTotals[0]['total_amount'], 2) . " (Profit: " . number_format($weeklyTotals[0]['total_profit'], 2) . ")"; 
            } else {
                echo "0.00 (Profit: 0.00)";
            } ?>
        </p>
        <p>Monthly Sales: 
            <?php if (!empty($monthlyTotals) && isset($monthlyTotals[0]['total_amount'])) { 
                echo number_format($monthlyTotals[0]['total_amount'], 2) . " (Profit: " . number_format($monthlyTotals[0]['total_profit'], 2) . ")"; 
            } else {
                echo "0.00 (Profit: 0.00)";
            } ?>
        </p>
    </div>

    <!-- Sales Table -->
    <table>
        <tr>
            <th>Customer</th>
            <th>Medicine</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
        <?php foreach ($sales as $sale): ?>
        <tr>
            <td><?= htmlspecialchars($sale['customer_name']) ?></td>
            <td><?= htmlspecialchars($sale['medicine_name']) ?></td>
            <td><?= htmlspecialchars($sale['quantity']) ?></td>
            <td><?= htmlspecialchars($sale['date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Charts Section -->
    <div class="chart-container">
        <canvas id="salesChart"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="profitChart"></canvas>
    </div>

    <script>
        // Prepare data for charts
        const medicineNames = <?= json_encode($medicineNames) ?>;
        const quantities = <?= json_encode($quantities) ?>;
        const dailySales = <?= json_encode(array_column($totals, 'total_amount')) ?>;
        const dailyProfits = <?= json_encode(array_column($totals, 'total_profit')) ?>;

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: medicineNames,
                datasets: [{
                    label: 'Sales Quantity',
                    data: quantities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Profit Chart
        const profitCtx = document.getElementById('profitChart').getContext('2d');
        new Chart(profitCtx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_column($totals, 'sale_date')) ?>,
                datasets: [{
                    label: 'Daily Profits',
                    data: dailyProfits,
                    borderColor: 'rgba(255, 255, 255, 1)',  // Set the border color to white
                    backgroundColor: 'rgba(255, 255, 255, 0.2)',  // Set the background color to a lighter white
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
