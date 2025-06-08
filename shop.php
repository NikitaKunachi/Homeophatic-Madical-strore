<?php
include('../config/db.php');
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
    #foot {
      text-align: center;
    }

    .product-item {
      margin-bottom: 30px;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 10px;
      transition: transform 0.3s ease;
      text-align: center;
    }

    .product-item:hover {
      transform: scale(1.05);
    }

    .product-item img {
      max-width: 100%;
      height: auto;
      margin-bottom: 15px;
    }

    .price {
      font-size: 1.5rem;
      color: #333;
      margin-bottom: 10px;
    }

    .tag {
      background: red;
      color: white;
      font-size: 1rem;
      padding: 5px;
      position: absolute;
      top: 10px;
      left: 10px;
      border-radius: 5px;
    }
  </style>

</head>

<body>

  <div class="site-wrap">

    <div class="site-navbar py-2">
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
                <!--<li><a href="about.html">About</a></li>-->
                <li><a href="contact.html">Contact</a></li>
              </ul>
            </nav>
          </div>
          <form method="POST" class="navbar-form navbar-left" action="search.php">
            <div class="input-group">
              <input type="text" class="form-control" id="navbar-search-input" name="keyword" placeholder="Search for Product" required>
              <span class="input-group-btn" id="searchBtn" style="display:none;">
                <button type="submit" class="btn btn-default btn-flat"><i class="fa fa-search"></i> </button>
              </span>
            </div>
          </form>
          <div class="icons">
            <!--<a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>-->
            <a href="cart.php" class="icons-btn d-inline-block bag">
              <span class="icon-shopping-bag"></span>
              <!--<span class="number">2</span>-->
            </a>

            
            <a href="../login.php" class="btn btn-danger btn-sm ml-3">Logout</a>


            <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
                class="icon-menu"></span></a>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Store</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <?php
          try {
            $sql = "SELECT medicine_id, name, price, stock, dosage, description, image FROM medicines";
            $result = $conn->query($sql);

            if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $imagePath = $row['image'] ? '../admin/uploads/' . $row['image'] : "images/default.jpg";
          ?>
          <div class="col-sm-6 col-lg-4 card text-center mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>

            <div class="image-wrapper">
              <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="img-fluid" style="max-height: 200px; object-fit: cover;">
            </div>

            <div class="card-body">
              <h3 class="card-title text-dark"><?php echo htmlspecialchars($row['name']); ?></h3>
              <p class="price text-primary fw-bold">&#8377;<?php echo htmlspecialchars($row['price']); ?></p>
              <p class="text-muted mb-1">Stock: <?php echo htmlspecialchars($row['stock']); ?></p>
              <!--<p class="text-muted mb-1">Dosage: <?php echo htmlspecialchars($row['dosage']); ?></p>-->
              <!--<p class="text-muted">Description: <?php echo htmlspecialchars($row['description']); ?></p>-->

              <a href="medicine_details.php?id=<?php echo htmlspecialchars($row['medicine_id']); ?>" class="btn btn-primary">View</a>
            </div>
          </div>

          <?php
              }
            } else {
              echo "<p>No medicines found.</p>";
            }
          } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
          }

          $conn = null;
          ?>

        </div>
      </div>
    </div>

    <div class="site-section bg-secondary bg-image" style="background-image: url('images/bg_2.jpg');">
      <div class="container">
        <div class="row align-items-stretch">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_1.jpg');">
              <div class="banner-1-inner align-self-center">
                <h2>Our Products</h2>
                <p>Arnica Montana <br>
                  Calendula <br>
                  Oscillococcinum <br>
                  Aller Aid <br>
                  Nux Vomica <br>
                  Rhus Toxicodendron <br>
                  Belladonna <br>
                  Hypericum 
              </div>
            </a>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0">
            <a href="#" class="banner-1 h-100 d-flex" style="background-image: url('images/bg_2.jpg');">
              <div class="banner-1-inner ml-auto  align-self-center">
                <h2>Rated by Experts</h2>
                <p>These Medicines are often regarded as effective by practitioners when used appropriately for the right symptoms. Always consult a healthcare provider for personalized advice.
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>


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
              <li><a href="index.php">HOME</a></li>
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
              <script>
                document.write(new Date().getFullYear());
              </script> All rights reserved
              <!--<i class="icon-heart" aria-hidden="true"></i>--> by <a href="" target="_blank"
                class="text-primary">Padma Homeopathic Store</a>
            </P>
            </p>
          </div>

        </div>
      </div>
    </footer>
  </div>
</body>

</html>