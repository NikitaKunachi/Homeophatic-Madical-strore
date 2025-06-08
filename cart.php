<?php
include('../config/db.php');
session_start();

if (isset($_GET['remove'])) {
    $medicine_id = $_GET['remove'];

    $delete_sql = "DELETE FROM cart1 WHERE medicine_id = :medicine_id";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bindParam(':medicine_id', $medicine_id);
    $delete_stmt->execute();

    header("Location: cart.php");
    exit;
}

if (isset($_GET['increase'])) {
    $medicine_id = $_GET['increase'];

    $increase_sql = "UPDATE cart1 SET quantity = quantity + 1 WHERE medicine_id = :medicine_id";
    $increase_stmt = $conn->prepare($increase_sql);
    $increase_stmt->bindParam(':medicine_id', $medicine_id);
    $increase_stmt->execute();

    header("Location: cart.php");
    exit;
}

if (isset($_GET['decrease'])) {
    $medicine_id = $_GET['decrease'];

    $decrease_sql = "UPDATE cart1 SET quantity = quantity - 1 WHERE medicine_id = :medicine_id AND quantity > 1";
    $decrease_stmt = $conn->prepare($decrease_sql);
    $decrease_stmt->bindParam(':medicine_id', $medicine_id);
    $decrease_stmt->execute();

    header("Location: cart.php");
    exit;
}

$sql = "SELECT * FROM cart1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
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

  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f7f7f7;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 1200px;
  margin: 40px auto;
  background: #ffffff;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

h2 {
  text-align: center;
  margin-bottom: 30px;
  color: #333333;
}

.card {
  border: none;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  transition: transform 0.3s ease-in-out;
}

.card:hover {
  transform: scale(1.05);
}

.card-body {
  text-align: center;
  padding: 20px;
}

.card-title {
  font-size: 20px;
  font-weight: bold;
  color: #333333;
}

.card-text {
  margin: 10px 0;
  color: #555555;
}

.btn-warning, .btn-success {
  margin: 0 10px;
  padding: 5px 10px;
  font-size: 14px;
  border-radius: 5px;
}

.btn-danger {
  background-color: #ff4d4d;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  margin-top: 10px;
  transition: background 0.3s;
}

.btn-danger:hover {
  background-color: #ff1a1a;
}

h3 {
  text-align: center;
  color: #333333;
  margin-top: 30px;
}

.btn-secondary {
  display: block;
  width: 200px;
  margin: 20px auto;
  background-color: #17a2b8;
  color: #ffffff;
  text-align: center;
  padding: 10px;
  border-radius: 5px;
  text-decoration: none;
  transition: background 0.3s;
}

.btn-secondary:hover {
  background-color: #138496;
}

  </style>

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
            <li class="has-children">
              <a href="#">Categories</a>
              <ul class="dropdown">
                <li><a href="#">Medicine</a></li>
                <li class="has-children">
                  <a href="#">Personal care &amp; cosmetics </a>
                  <ul class="dropdown">
                    <li><a href="#">Soap</a></li>
                    <li><a href="#">Shampoo</a></li>
                    <li><a href="#">Hair Oil</a></li>
                    <li><a href="#">Skin care</a></li>
                  </ul>
                </li>
                <li><a href="#">Diet &amp; Nutrition</a></li>
                <li><a href="#">Skin Cure </a></li>

              </ul>
            </li>
            <!--<li><a href="about.html">About</a></li>-->
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </nav>
      </div>
      <div class="icons">
        <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
        <a href="cart.php" class="icons-btn d-inline-block bag">
          <span class="icon-shopping-bag"></span>
          <span class="number">2</span>
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
            <strong class="text-black">Cart</strong>
          </div>
        </div>
      </div>
    </div>


<div class="container">
  <h2>Your Cart</h2>
  <div class="row">
    <?php
    $total = 0;
    foreach ($cart_items as $item) {
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
        echo "
        <div class='col-md-4'>
          <div class='card mb-4'>
            <div class='card-body'>
              <h5 class='card-title'>" . htmlspecialchars($item['name']) . "</h5>
              <p class='card-text'>Price: &#8377;" . htmlspecialchars($item['price']) . "</p>
              <p class='card-text'>Quantity: 
                <a href='cart.php?decrease=" . htmlspecialchars($item['medicine_id']) . "' class='btn btn-sm btn-warning'>-</a>
                " . htmlspecialchars($item['quantity']) . "
                <a href='cart.php?increase=" . htmlspecialchars($item['medicine_id']) . "' class='btn btn-sm btn-success'>+</a>
              </p>
              <p class='card-text'>Total: &#8377;" . htmlspecialchars($subtotal) . "</p>
              <a href='cart.php?remove=" . htmlspecialchars($item['medicine_id']) . "' class='btn btn-danger'>Remove</a>
            </div>
          </div>
        </div>";
    }
    ?>
  </div>
  <h3>Total Amount: &#8377;<?php echo $total; ?></h3>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-secondary btn-lg w-50" onclick="window.location='checkout.php'">Proceed To Checkout</button>
        </div>
    </div> <br>
  <a href="shop.php" class="btn btn-secondary">Continue Shopping</a>
</div>
<div class="site-section bg-secondary bg-image" style="background-image: url('images/bg_2.jpg');"></div>

<footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">

            <div class="block-7">
              <h3 class="footer-heading mb-4">Our Brands</h3>
              <a class="br" href="#">Bakson’s</a><br>
              <a class="br" href="#">Dr. Reckeweg</a><br>
              <a class="br" href="#">Hahnemann Laboratories</a><br>
              <a class="br" href="#">Hamdard</a><br>
              <a class="br" href="#">Wilmar Schwabe India</a>
            </div>

          </div>
          <div class="col-lg-3 mx-auto mb-5 mb-lg-0">
            <h3 class="footer-heading mb-4">Quick Links</h3>
            <ul class="list-unstyled">
              <li><a href="#">FACEBOOK</a></li>
              <li><a href="#">INSTAGRAM</a></li>
              <li><a href="index.html">HOME</a></li>
              <!--<li><a href="#"> </a></li>-->
            </ul>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Contact Info</h3>
              <ul class="list-unstyled">
                <li class="address">G-10 B, 1808, Krishna Vihar, Kirloskar Rd, near navagrah mandir, Kelkar Bagh, Raviwar Peth, Belagavi, Karnataka 590001</li>
                <li class="phone"><a href="tel://23923929210">+91 9480454399</a></li>
                <li class="email">Padmastores@gmail.com</li>
              </ul>
            </div>


          </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
          <div class="col-md-12">
            <p id="foot">
      
              <P>Copyright &copy;
              <script>document.write(new Date().getFullYear());</script> All rights reserved 
              <!--<i class="icon-heart" aria-hidden="true"></i>--> by <a href="" target="_blank"
                class="text-primary">Padma Homeopathic Store</a></P>
              </p>
          </div>

        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

</body>
</html>
