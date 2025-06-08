<?php
session_start();
include '../config/db.php';

// Check User Access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

// Fetch Categories
$categories = $conn->query("SELECT DISTINCT category FROM medicines")->fetchAll(PDO::FETCH_ASSOC);

// Handle Category Filter
$categoryFilter = '';
if (isset($_GET['category']) && $_GET['category'] !== 'all') {
    $categoryFilter = "WHERE category = :category";
}

// Handle Search
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = "WHERE name LIKE :search";
    $categoryFilter = ''; // Ignore category filter when searching
}

// Fetch Medicines
$sql = "SELECT * FROM medicines $categoryFilter $searchQuery";
$stmt = $conn->prepare($sql);

if ($categoryFilter) {
    $stmt->bindParam(':category', $_GET['category']);
}
if ($searchQuery) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt->bindParam(':search', $searchTerm);
}

$stmt->execute();
$medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Available Medicines</h1>

    <!-- Search and Filter -->
    <form method="GET" action="">
        <select name="category">
            <option value="all">All Categories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category'] ?>" <?= (isset($_GET['category']) && $_GET['category'] === $category['category']) ? 'selected' : '' ?>>
                    <?= ucfirst($category['category']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="search" placeholder="Search products" value="<?= $_GET['search'] ?? '' ?>">
        <button type="submit">Filter</button>
    </form>

    <!-- Product Table -->
    <table>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
        <?php foreach ($medicines as $medicine): ?>
        <tr>
            <td><?= $medicine['name'] ?></td>
            <td><?= ucfirst($medicine['category']) ?></td>
            <td><?= $medicine['price'] ?></td>
            <td><?= $medicine['stock'] ?></td>
            <td>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="medicine_id" value="<?= $medicine['id'] ?>">
                    <input type="number" name="quantity" min="1" max="<?= $medicine['stock'] ?>" required>
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
