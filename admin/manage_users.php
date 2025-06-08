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
        /* Your existing styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #5e5e5e;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.1em;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    <h1>Manage Users</h1>

    <!-- Display success or error messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Users Table -->
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
                        <!-- Delete button with AJAX functionality -->
                        <button class="delete-link" data-id="<?= $user['id'] ?>">Delete</button>
                    <?php else: ?>
                        <span class="admin">Admin</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Attach click event to the delete buttons
            $(".delete-link").on("click", function() {
                var userId = $(this).data("id");

                // Ask for confirmation before deletion
                if (confirm("Are you sure you want to delete this user?")) {
                    // Send AJAX request to delete the user
                    $.ajax({
                        url: "delete_user.php", // File that handles the deletion
                        type: "GET",
                        data: { delete_id: userId },
                        success: function(response) {
                            // If the user was successfully deleted, remove the row from the table
                            if (response === "success") {
                                $("#user-" + userId).remove();
                                alert("User  successfully deleted.");
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