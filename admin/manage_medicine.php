<?php
    session_start();
    include('../config/db.php');

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../login.php');
        exit();
    }

    // Handle Adding, Updating, Deleting, and Searching Medicines
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_medicine'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $dosage = $_POST['dosage'];
            $description = $_POST['description'];
            $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        function uploadFile($file, $upload_dir, $allowed_types, $max_size)
        {
            $filename = basename($file['name']);
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $new_filename = time() . '_' . $filename;
            $target_path = $upload_dir . $new_filename;

            if (!in_array($file_ext, $allowed_types) || $file['size'] > $max_size) {
                return false;
            }
            return move_uploaded_file($file['tmp_name'], $target_path) ? $new_filename : false;
        }

        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'];
        $max_file_size = 2 * 1024 * 1024; // 2MB

        if (isset($_FILES['id_proof']) && $_FILES['id_proof']['error'] == UPLOAD_ERR_OK) {
            $image = uploadFile($_FILES['id_proof'], $upload_dir, $allowed_types, $max_file_size);
        } else {
            die("File upload failed or no file selected.");
        }        

            $query = $conn->prepare("INSERT INTO medicines (name, price, stock, dosage, description, image) VALUES (:name, :price, :stock, :dosage, :description, :image)");
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':stock', $stock);
            $query->bindParam(':dosage', $dosage);
            $query->bindParam(':description', $description);
            $query->bindParam(':image', $image);

            if ($query->execute()) {
                echo "<div class='success'>Medicine added successfully!</div>";
            } else {
                echo "<div class='error'>Failed to add medicine.</div>";
            }
        } elseif (isset($_POST['update_medicine'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];

            $query = $conn->prepare("UPDATE medicines SET name = :name, price = :price, stock = :stock WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':price', $price);
            $query->bindParam(':stock', $stock);

            if ($query->execute()) {
                echo "<div class='success'>Medicine updated successfully!</div>";
            } else {
                echo "<div class='error'>Failed to update medicine.</div>";
            }
        } elseif (isset($_POST['delete_medicine'])) {
            $id = $_POST['id'];

            $query = $conn->prepare("DELETE FROM medicines WHERE medicine_id = :id");
            $query->bindParam(':id', $id);

            if ($query->execute()) {
                echo "<div class='success'>Medicine deleted successfully!</div>";
            } else {
                echo "<div class='error'>Failed to delete medicine.</div>";
            }
        } elseif (isset($_POST['search_medicine'])) {
            $search_term = $_POST['search_term'];

            $query = $conn->prepare("SELECT * FROM medicines WHERE name LIKE :search OR id = :search_exact");
            $query->bindValue(':search', "%" . $search_term . "%");
            $query->bindValue(':search_exact', $search_term);
            $query->execute();
            $search_results = $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Fetch Medicines
    $query = $conn->prepare("SELECT * FROM medicines");
    $query->execute();
    $medicines = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Manage Medicines</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-image: url('https://png.pngtree.com/background/20230617/original/pngtree-assorted-pharmaceutical-pills-tablets-and-capsules-on-blue-background-3d-rendering-picture-image_3700317.jpg');
                /* Add the path to your background image */
                background-size: cover;
                background-position: center;
                color: #333;
            }

            header {
                background-color: rgba(0, 35, 102, 0.8);
                /* Adding some transparency to the header for contrast */
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

            .search-results {
                margin: 20px auto;
                max-width: 90%;
            }

            .search-results h3 {
                margin-bottom: 10px;
            }

            .search-results table {
                width: 100%;
                border-collapse: collapse;
            }

            .search-results th,
            .search-results td {
                padding: 12px;
                border: 1px solid #ddd;
            }

            .search-results th {
                background-color: #002366;
                color: white;
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
            <h1>Manage Medicines</h1>
        </header>
        <div class="container">
            <!-- Search Medicine Form -->
            <form method="POST">
                <h2>Search Medicine</h2>
                <input type="text" name="search_term" placeholder="Enter Medicine Name or ID" required>
                <button type="submit" name="search_medicine">Search</button>
            </form>

            <!-- Search Results -->
            <?php if (isset($search_results)) { ?>
                <div class="search-results">
                    <h3>Search Results:</h3>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Dosage</th>
                            <th>Description</th>
                        </tr>
                        <?php if (count($search_results) > 0) { ?>
                            <?php foreach ($search_results as $medicine) { ?>
                                <tr>
                                    <td><?php echo $medicine['id']; ?></td>
                                    <td><?php echo $medicine['name']; ?></td>
                                    <td><?php echo $medicine['price']; ?></td>
                                    <td><?php echo $medicine['stock']; ?></td>
                                    <td><?php echo $medicine['dosage']; ?></td>
                                    <td><?php echo $medicine['description']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6">No medicines found.</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            <?php } ?>

            <!-- Add Medicine Form -->
            <form method="POST" enctype="multipart/form-data">
                <h2>Add Medicine</h2>
                <input type="text" name="name" placeholder="Medicine Name" required>
                <input type="number" name="price" placeholder="Price" required>
                <input type="number" name="stock" placeholder="Stock" required>
                <input type="text" name="dosage" placeholder="Dosage" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input
                    type="file"
                    id="id-proof"
                    name="id_proof"
                    accept="image/*"
                    required />
                <button type="submit" name="add_medicine">Add Medicine</button>
            </form>

            <!-- Update Medicine Form -->
            <form method="POST">
                <h2>Update Medicine</h2>
                <select name="id" required>
                    <option value="" disabled selected>Select Medicine</option>
                    <?php foreach ($medicines as $medicine) { ?>
                        <option value="<?php echo $medicine['medicine_id']; ?>">
                            <?php echo $medicine['name']; ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="text" name="name" placeholder="Medicine Name" required>
                <input type="number" name="price" placeholder="Price" required>
                <input type="number" name="stock" placeholder="Stock" required>
                <button type="submit" name="update_medicine">Update Medicine</button>
            </form>

            <!-- Delete Medicine Form -->
            <form method="POST">
                <h2>Delete Medicine</h2>
                <select name="id" required>
                    <option value="" disabled selected>Select Medicine</option>
                    <?php foreach ($medicines as $medicine) { ?>
                        <option value="<?php echo $medicine['medicine_id']; ?>">
                            <?php echo $medicine['name']; ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" name="delete_medicine">Delete Medicine</button>
            </form>

            <!-- Display Medicines -->
            <h2>Medicines List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                </tr>
                
          
          
                <?php foreach ($medicines as $medicine) { ?>
<tr>
    <td><?php echo $medicine['medicine_id']; ?></td>
    <td><?php echo $medicine['name']; ?></td>
    <td><?php echo $medicine['price']; ?></td>
    <td><?php echo $medicine['stock']; ?></td>
    <td>
        <?php
        $imagePath = $medicine['image'] ? '../admin/uploads/' . $medicine['image'] : "images/default.jpg";
        ?>
        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($medicine['name']); ?>" class="img-fluid" style="max-height: 100px; width: 100px; object-fit: cover; border-radius: 10px;">
    </td>
</tr>
<?php } ?>

            </table>
    </body>

    </html>