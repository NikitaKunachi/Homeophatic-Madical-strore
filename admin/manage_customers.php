<?php
session_start();
include '../config/db.php';

// Check if the user is logged in and has admin rights
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Fetch the list of users
try {
    $users = $conn->query("SELECT id, username, role FROM users")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://www.shutterstock.com/image-illustration/blue-white-pills-falling-on-600nw-2103322769.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 5px solid #007bff;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #5e5e5e;
        }

        .logout-btn {
            display: inline-block;
            margin: 10px 0 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.8);
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .admin {
            color: #28a745;
            font-weight: bold;
        }

        .delete-link {
            display: inline-block;
            margin-top: 5px;
            padding: 5px 15px;
            border: 1px solid #dc3545;
            color: #dc3545;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-link:hover {
            background-color: #dc3545;
            color: white;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Manage Users</h1>
        
        <!-- Logout button placed below "Manage Users" heading -->
        <a href="dashboard.php" class="logout-btn">Logout</a>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr id="user-<?= $user['id'] ?>">
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <?php if ($user['role'] !== 'admin'): ?>
                            <button class="delete-link" data-id="<?= $user['id'] ?>">Delete</button>
                        <?php else: ?>
                            <span class="admin">Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $(".delete-link").on("click", function() {
                var userId = $(this).data("id");

                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        url: "delete_user.php",
                        type: "GET",
                        data: { delete_id: userId },
                        success: function(response) {
                            if (response === "success") {
                                $("#user-" + userId).remove();
                                alert("User successfully deleted.");
                            } else {
                                alert("Error deleting user.");
                            }
                        },
                        error: function() {
                            alert("An error occurred.");
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
