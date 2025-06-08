<?php
session_start();
include '../config/db.php';

// Check Admin Access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Handle Financial Entries
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO financials (type, amount, description, date) VALUES (:type, :amount, :description, NOW())");
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':amount', $amount);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
}

// Fetch Financial Records
$financials = $conn->query("SELECT * FROM financials ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Management</title>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.6;
        }

        /* Header */
        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-top: 50px;
        }

        /* Form */
        form {
            background-color: #fff;
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form select, form input, form textarea, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        form select:focus, form input:focus, form textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        form textarea {
            resize: vertical;
            min-height: 100px;
        }

        form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 14px;
            border-radius: 8px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #2980b9;
        }

        /* Table */
        table {
            width: 90%;
            margin: 40px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #f2f2f2;
        }

        table th {
            background-color: #3498db;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        table td {
            background-color: #f9f9f9;
            color: #333;
            font-size: 16px;
        }

        table tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                width: 90%;
                margin: 20px auto;
            }

            table {
                width: 100%;
                font-size: 14px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <h1>Financial Management</h1>
    <form method="POST">
        <select name="type" required>
            <option value="income">Income</option>
            <option value="expense">Expense</option>
        </select>
        <input type="number" name="amount" placeholder="Amount" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Add Entry</button>
    </form>
    <table>
        <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
        <?php foreach ($financials as $entry): ?>
        <tr>
            <td><?= ucfirst($entry['type']) ?></td>
            <td><?= $entry['amount'] ?></td>
            <td><?= $entry['description'] ?></td>
            <td><?= $entry['date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
