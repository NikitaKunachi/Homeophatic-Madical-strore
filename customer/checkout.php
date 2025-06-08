<?php
// Start the session at the top of the file
session_start();

// Include your database connection here
include('../config/db.php');

// Check if the user is logged in and the session has the customer_id
if (isset($_SESSION['user_id'])) {
    $customer_id = $_SESSION['user_id'];
} else {
    // If the customer is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}

// Fetch cart items from the database
$sql = "SELECT * FROM cart1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle the order submission if the form is submitted
if (isset($_POST['place_order'])) {
    // Extract form data
    $fname = $_POST['c_fname'];
    $lname = $_POST['c_lname'];
    $address = $_POST['c_address'];
    $city = $_POST['c_state_country'];
    $postal = $_POST['c_postal_zip'];
    $email = $_POST['c_email_address'];
    $phone = $_POST['c_phone'];

    // Default status and payment method
    $status = 'Pending';
    $payment_method = 'COD'; // Modify if you're using a different payment method

    // Calculate the total amount from cart items
    $total = 0;
    foreach ($cart_items as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    }

    // Insert into the orders table
    $sql = "INSERT INTO orders (customer_id, total_amount, status, payment_method, first_name, last_name, address, city, postal_code, email, phone)
            VALUES (:customer_id, :total_amount, :status, :payment_method, :first_name, :last_name, :address, :city, :postal_code, :email, :phone)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':total_amount', $total);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->bindParam(':first_name', $fname);
    $stmt->bindParam(':last_name', $lname);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':postal_code', $postal);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);

    try {
        $stmt->execute();
        $order_id = $conn->lastInsertId(); // Get last inserted order ID

        // Kishh
        foreach ($cart_items as $item) {
            $medicine_id = $item['medicine_id']; // Assuming you have a medicine_id field
            $price = $item['price'];
            $quantity = $item['quantity'];

            // Insert each cart item into the order_items table
            $insertOrderItems = "INSERT INTO order_items (order_id, medicine_id, price, quantity)
                                 VALUES (:order_id, :medicine_id, :price, :quantity)";
            $stmt = $conn->prepare($insertOrderItems);
            $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            $stmt->bindParam(':medicine_id', $medicine_id, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Delete all cart items for the user after placing the order
        //$deleteCartItems = "DELETE FROM cart1";
        //$stmt = $conn->prepare($deleteCartItems);
        //$stmt->execute();

        // Redirect to the homepage after order placement
        
        echo "<script>window.location.href = 'http://localhost/homeopathic_storeNEW/customer/cart1.php';</script>";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Padma Homeopathic &mdash; Store</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="site-wrap">
        <div class="site-navbar py-2">
            <div class="search-wrap">
                <div class="container">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form action="#" method="post">
                        <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
                    </form>
                </div>
            </div>

            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="index.php" class="js-logo-clone">Padma</a>
                        </div>
                    </div>
                    <div class="main-nav d-none d-lg-block">
                        <nav class="site-navigation text-right text-md-center" role="navigation">
                            <ul class="site-menu js-clone-nav d-none d-lg-block">
                                <li><a href="index.php">Home</a></li>
                                <li class="active"><a href="shop.php">Store</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="icons">
                        <a href="cart.php" class="icons-btn d-inline-block bag">
                            <span class="icon-shopping-bag"></span>
                        </a>
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                                class="icon-menu"></span></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-light py-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mb-0">
                        <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
                        <strong class="text-black">Checkout</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section">
            <form action="checkout.php" method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 mb-5 mb-md-0">
                            <h2 class="h3 mb-3 text-black">Billing Details</h2>
                            <div class="p-3 p-lg-5 border">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="c_fname" class="text-black">First Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_fname" name="c_fname" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_lname" class="text-black">Last Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_lname" name="c_lname" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="c_address" class="text-black">Address <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_address" name="c_address"
                                            placeholder="Street address" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="c_state_country" class="text-black">City / State<span
                                                class="text-danger" re>*</span></label>
                                        <input type="text" class="form-control" id="c_state_country"
                                            name="c_state_country" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_postal_zip" class="text-black">Postal code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row mb-5">
                                    <div class="col-md-6">
                                        <label for="c_email_address" class="text-black">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="c_email_address"
                                            name="c_email_address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="c_phone" class="text-black">Phone <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="c_phone" name="c_phone"
                                            placeholder="Phone Number" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <h2 class="h3 mb-3 text-black">Your Order</h2>
                                    <div class="p-3 p-lg-5 border">
                                        <?php
                                        $total = 0;
                                        if ($cart_items) {
                                            foreach ($cart_items as $item) {
                                                $subtotal = $item['price'] * $item['quantity'];
                                                $total += $subtotal;
                                                echo "
                                            <h4>" . htmlspecialchars($item['name']) . "</h4>
                                            <p>Price: &#8377;" . htmlspecialchars($item['price']) . "</p>
                                            <p>Quantity: " . htmlspecialchars($item['quantity']) . "</p>
                                            <p>Total: &#8377;" . htmlspecialchars($subtotal) . "</p> <hr>";
                                            }
                                        } else {
                                            echo "<p>Your cart is empty.</p>";
                                        }
                                        ?>

                                        <div class="text-end fw-bold">
                                            <h3>Total Amount: &#8377;<?php echo htmlspecialchars($total); ?></h3>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" name="place_order" class="btn btn-primary btn-lg btn-block">Place Order </button>
                                                
                                              
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

</body>

</html>