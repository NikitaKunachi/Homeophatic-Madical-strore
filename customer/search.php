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

        .br {
            display: block;
        }

        .icon-shopping-bag {
            font-size: 1.5rem; /* Increase the size of shopping bag icon */
        }
    </style>

</head>

<body>

    <div class="site-wrap">

        <div class="site-navbar py-2">

            <div class="search-wrap">
                <div class="container">
                    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
                    <form action="search.php" method="GET">
                        <input type="text" name="query" class="form-control" placeholder="Search keyword and hit enter...">
                    </form>
                </div>
            </div>

            <div class="container">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="logo">
                        <div class="site-logo">
                            <a href="index.html" class="js-logo-clone">Padma</a>
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
                                
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="icons">
                        <a href="cart.php" class="icons-btn d-inline-block bag">
                            <span class="icon-shopping-bag"></span>
                        </a>
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
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
                    <div class="col-sm-9">
                    <?php
                        if (isset($_POST['keyword'])) {
                            $keyword = htmlspecialchars($_POST['keyword'], ENT_QUOTES, 'UTF-8');

                            $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM medicines WHERE name LIKE :keyword");
                            $stmt->execute(['keyword' => '%' . $keyword . '%']);
                            $row = $stmt->fetch();

                            if ($row['numrows'] < 1) {
                                echo '<h1 class="page-header">No results found for <i>' . $keyword . '</i></h1>';
                            } else {
                                echo '<h1 class="page-header">Search results for <i>' . $keyword . '</i></h1>';

                                try {
                                    $stmt = $conn->prepare("SELECT * FROM medicines WHERE name LIKE :keyword ORDER BY medicine_id DESC");
                                    $stmt->execute(['keyword' => '%' . $keyword . '%']);

                                    foreach ($stmt as $row) {
                                        $highlighted = preg_filter('/' . preg_quote($keyword, '/') . '/i', '<b>$0</b>', $row['name']);
                                        $image = (!empty($row['image'])) ? '../admin/uploads/' . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8') : 'images/noimage.jpg';

                                        echo "<div class='col-sm-4 mb-4'>
                                            <div class='custom-box'>
                                                <div class='custom-body'>
                                                    <img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
                                                    <h5><a href='product.php?product=" . $row['medicine_id'] . "'>" . $highlighted . "</a></h5>
                                                    <p><b>&#8377; " . number_format($row['price'], 2) . "</b></p>
                                                </div>
                                                <div class='custom-footer text-center'>
                                                    <a href='medicine_details.php?id=" . htmlspecialchars($row['medicine_id'], ENT_QUOTES, 'UTF-8') . "' class='btn btn-primary'>View</a>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                } catch (PDOException $e) {
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }
                            }
                        } else {
                            echo '<h1 class="page-header">Please enter a search keyword.</h1>';
                        }
                        $conn = null;
                    ?>
                    </div>
                    <div class="col-sm-3">
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
