<?php
include('../config/db.php');
session_start();

// Get Medicine ID from URL
if (isset($_GET['id'])) {
    $medicine_id = $_GET['id'];

    $sql = "SELECT medicine_id, name, price, stock, dosage, description, image FROM medicines WHERE medicine_id = :medicine_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':medicine_id', $medicine_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "<p>Medicine not found.</p>";
        exit;
    }
} else {
    echo "<p>No medicine ID provided.</p>";
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $medicine_id = $_POST['medicine_id'];
    $quantity = 1;

    // Check if item exists in cart
    $check_sql = "SELECT * FROM cart1 WHERE medicine_id = :medicine_id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':medicine_id', $medicine_id);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        $update_sql = "UPDATE cart1 SET quantity = quantity + :quantity WHERE medicine_id = :medicine_id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':quantity', $quantity);
        $update_stmt->bindParam(':medicine_id', $medicine_id);
        $update_stmt->execute();
    } else {
        $cart_sql = "INSERT INTO cart1 (medicine_id, name, price, quantity) VALUES (:medicine_id, :name, :price, :quantity)";
        $cart_stmt = $conn->prepare($cart_sql);
        $cart_stmt->bindParam(':medicine_id', $medicine_id);
        $cart_stmt->bindParam(':name', $product['name']);
        $cart_stmt->bindParam(':price', $product['price']);
        $cart_stmt->bindParam(':quantity', $quantity);
        $cart_stmt->execute();
    }

    header("Location: cart.php");
    exit;
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
  <style>
    #foot{
      text-align: center;   
    }
  </style>

</head>

<body style="background-color: rgb(238, 238, 247);">

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
              <a href="index.php" class="js-logo-clone">Padma Homeopathic Store</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="shop.php">Store</a></li>
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
            <!--<a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>-->
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
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <a
              href="shop.php">Store</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo $product['name']; ?></strong></div>
        </div>
      </div>
    </div>
    <?php
          $imagePath = "images/default.jpg"; // Default image if no image is found
          if (!empty($product['image'])) {
              $imagePath = '../admin/uploads/' . $product['image']; // Fetch the exact image from the medicine table
          }
          ?>
          <!--<div class="border text-center">
              <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid" style="max-height: 300px; width:300px; object-fit: cover;">
          </div>-->
          
    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-5 mr-auto">
            <div class="border text-center">
            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="img-fluid" style="max-height: 300px; width:350px; object-fit: cover;">
            </div><br><br>
            <div>
                <h3 style="color: rgb(82, 81, 81);">Disclaimer: </h3>
                <h4>The information provided herein on request, is not to be taken as a replacement for medical advice or diagnosis or treatment of any medical condition. DO NOT SELF MEDICATE. PLEASE CONSULT YOUR PHYSICIAN FOR PROPER DIAGNOSIS AND PRESCRIPTION.</h4>

            </div>
          </div>
          <div class="col-md-6">
            <h2 class="text-black"><?php echo $product['name']; ?></h2>
            <p>Stock : In stock <?php echo $product['stock']; ?></p>
             <p>Categories : Capsules</p>
              <p>Brands: Bakson</p>
              <p>Pack Size : 30 Capsule</p>
            

            <p><del>&#8377;<?php echo $product['price'] + 50; ?></del>  <strong class="text-primary h4">&#8377;<?php echo $product['price']; ?></strong></p>

            
            
            <div class="mb-5">
              <div class="input-group mb-3" style="max-width: 220px;"> 
              </div>
            </div>
            
            <form method="POST">
              <input type="hidden" name="medicine_id" value="<?php echo $product['medicine_id']; ?>">
              <button type="submit" name="add_to_cart" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">Add To Cart</button>
            </form>

            <div class="mt-5">
              <ul class="nav nav-pills mb-3 custom-pill" id="pills-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                    aria-controls="pills-home" aria-selected="true">Information</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                    aria-controls="pills-profile" aria-selected="false">Specifications</a>
                </li>
            
              </ul>
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                  <table class="table custom-table">
                    
                    <tbody>
                      <tr>
                        <th scope="row"><b>Description:</b> </th>
                        <td><?php echo $product['description']; ?></td>
                        
                      </tr>
                      <tr>
                        <th scope="row"><b>Dosage: </b></th>
                        <td><?php echo $product['dosage']; ?></td>
                        
                      </tr>
                      
                     
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            
                  <table class="table custom-table">
            
                    <tbody>
                      <tr>
                        <th>ID: </th>
                        <td class="bg-light"><?php echo $product['medicine_id']; ?></td>
                      </tr>
                      <tr>
                        <th>HEALTHCARE PROVIDERS ONLY</th>
                        <td class="bg-light">No</td>
                      </tr>
                      <tr>
                        <td scope="row" >Side effects:</th>
                        <td>No known side effects</td>                 
                      </tr>
                      
                    </tbody>
                  </table>
            
                </div>
            
              </div>
            </div>

    
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-secondary bg-image" style="background-image: url('images/bg_2.jpg');">
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_1.jpg');">
              <div class="banner-1-inner align-self-center">
                <h2>Pharma Products</h2>
                <p ><h4 style="color: aliceblue;">Want to Choose the product you Desire !
                  Padma Homeopathic Store.</h4>
                </p>
              </div>
            </a>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_2.jpg');">
              <div class="banner-1-inner ml-auto  align-self-center">
                <h2>Rated by Experts</h2>
                <h4 style="color: rgb(90, 83, 83);">Prioritized by Best Homeopathic doctors and Many Happy Customers. 
                </h4>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <footer id="foot">
      
        <P>Copyright &copy;
        <script>document.write(new Date().getFullYear());</script> All rights reserved 
        <!--<i class="icon-heart" aria-hidden="true"></i>--> by <a href="" target="_blank"
          class="text-primary">Padma Homeopathic Store</a></P>
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