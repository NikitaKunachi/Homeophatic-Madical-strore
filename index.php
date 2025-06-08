<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homeopathic Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom Styles -->
    <style>
    
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            background-image: url('https://www.hri-research.org/wp-content/uploads/2014/06/Slide011.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #333333;
        }

        header {
            background-color: #0d2c54;
            padding: 15px 30px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-family: "Times New Roman", Times, serif;
            font-size: 30px;
            font-weight: 600;
            margin: 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .login-register-links {
            display: flex;
            gap: 15px;
        }

        .login-register-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            background-color: #1c3b70;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-register-links a:hover {
            background-color: #ffdd57;
            color: #0d2c54;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            min-height: 100vh;
        }

        h2 {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1c3b70;
            text-align: center;
        }

        .product-category {
            margin: 40px 0;
        }

        .category-title {
            background-color: #1c3b70;
            color: white;
            padding: 12px;
            font-size: 26px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 6px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-header {
            background-color: #1c3b70;
            color: white;
            font-size: 20px;
            font-weight: 600;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .product-info .price {
            font-size: 20px;
            font-weight: bold;
            color: #1c3b70;
        }

        .btn-category {
            background-color: #1c3b70;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            width: 100%;
        }

        .btn-category:hover {
            background-color: #142850;
        }

        header {
            background-color: #0d2c54;
            padding: 20px 40px;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
        }

        header h1 {
            font-size: 36px;
            font-weight: bold;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            width: 50px;
            height: 50px;
        }

        .login-register-links {
            display: flex;
            gap: 15px;
        }

        .login-register-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            background-color: #1c3b70;
            padding: 12px 25px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .login-register-links a:hover {
            background-color: #ffdd57;
            color: #0d2c54;
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
        }

        .header-logo {
             transition: transform 0.3s ease;
        }


        .header-logo:hover {
            transform: rotate(360deg) scale(1.2);
        }

        .login-register-links a {
            background-color: #1c3b70;
            color: white;
            transition: all 0.3s ease;
        }

        .login-register-links a:hover {
             background-color: #ffdd57;
             color: #0d2c54;
             transform: translateY(-5px);
             box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
        }

        header {
            transition: background-color 0.3s ease;
        }

        header:hover {
            background-color: #142850;
    }



        footer {
            text-align: center;
            padding: 15px;
            background-color: #091b32;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .container {
                padding: 20px;
            }

            header h1 {
                font-size: 30px;
            }

            .product-category .row {
                display: flex;
                justify-content: center;
            }

            .product-category .card {
                margin-bottom: 20px;
            }

            .card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 10px 10px 0 0;
            }
        }
    </style>
</head>

<body>
<header>
        <div class="header-content">
            <h1>
                <img src="https://t4.ftcdn.net/jpg/01/29/07/99/360_F_129079911_rgjzs0I5F2nBSrmm10UT5AGYCCWSXKNE.jpg" alt="Store Logo" class="header-logo">
                Padma Homeopathic Store
            </h1>
            <div class="login-register-links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- <h2>Our Products</h2> -->

        <!-- Medicines Category -->
        <div class="product-category">
            <div class="category-title">Medicines</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Bakunil</div>
                        <img src="https://multimedicos.in/media/catalog/product/cache/67b225953a43d703d27714231d68a9fa/b/a/bakson_s_bakunil_syrup_200_ml.png" alt="Natural Cold Relief">
                        <div class="card-body">
                            <p><b>Description:</b> A natural remedy to ease the symptoms of a cold and congestion.</p>
                            <div class="product-info">
                                <div class="price">₹300.00</div>
                                <a href="https://www.amazon.in/dp/B084R2GZ98" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Ferrum Plus</div>
                        <img src="https://onemg.gumlet.io/l_watermark_346,w_480,h_480/a_ignore,w_480,h_480,c_fit,q_auto,f_auto/10776e00fb0e40f2a0119c147f2980fd.jpg?format=auto" alt="Homeopathic Sleep Aid">
                        <div class="card-body">
                            <p><b>Description:</b> A remedy designed to help you get better sleep without any side effects.</p>
                            <div class="product-info">
                                <div class="price">₹500.00</div>
                                <a href="https://www.amazon.in/dp/B0836FBK5X" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Stress Relief Solution</div>
                        <img src="https://images-eu.ssl-images-amazon.com/images/I/51hGsdFAqBL._AC_UL600_SR600,600_.jpg" alt="Stress Relief Solution">
                        <div class="card-body">
                            <p><b>Description:</b> A mild solution to help with stress relief and anxiety management.</p>
                            <div class="product-info">
                                <div class="price">₹350.00</div>
                                <a href="https://www.amazon.in/dp/B085V87MGR" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skincare Category -->
        <div class="product-category">
            <div class="category-title">Skincare</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Sunny Glamour Cream</div>
                        <img src="https://5.imimg.com/data5/SELLER/Default/2024/8/442291466/DG/TO/GK/142909792/sunny-herbals-glamour-women-face-cream-500x500.jpeg" alt="Herbal Skin Lotion">
                        <div class="card-body">
                            <p><b>Description:</b> A soothing lotion made with natural ingredients to hydrate your skin.</p>
                            <div class="product-info">
                                <div class="price">₹450.00</div>
                                <a href="https://www.flipkart.com/sunny-herbals-glamour-women-face-cream/p/itmecdd3bba5b497" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Akne Aid</div>
                        <img src="https://naattumarundhukadai.com/cdn/shop/products/bakson-akne-aid-soap.jpg?v=1506523802" alt="Aloe Vera Gel">
                        <div class="card-body">
                            <p><b>Description:</b> Pure aloe vera gel to moisturize and soothe irritated skin.</p>
                            <div class="product-info">
                                <div class="price">₹350.00</div>
                                <a href="https://www.amazon.in/dp/B084BXM7J9" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Sunny face Pack</div>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGLIZHy_C3c8QU1ZO9-eLABbjFIttzA3nr5g&s" alt="Anti-Aging Serum">
                        <div class="card-body">
                            <p><b>Description:</b> A rejuvenating serum designed to reduce the appearance of wrinkles.</p>
                            <div class="product-info">
                                <div class="price">₹600.00</div>
                                <a href="https://www.flipkart.com/sunny-face-pack/p/itm0a85d325f415e" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Healthy Drinks Category -->
        <div class="product-category">
            <div class="category-title">Healthy Drinks</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Alfavena</div>
                        <img src="https://homeomart.com/cdn/shop/products/Baksons-Alfavena-Homoeo-Drink--BAKAHD750_85168b86-6ef7-4933-b26c-969c20a5ea53.jpg?v=1571713310&width=500" alt="Herbal Green Tea">
                        <div class="card-body">
                            <p><b>Description:</b> A refreshing green tea to boost metabolism and health.</p>
                            <div class="product-info">
                                <div class="price">₹250.00</div>
                                <a href="https://www.amazon.in/dp/B0842GV8BQ" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Sabal Drink</div>
                        <img src="https://tiimg.tistatic.com/fp/2/002/282/sabal-drink-405.jpg" alt="Detox Drink">
                        <div class="card-body">
                            <p><b>Description:</b> A detox drink to cleanse and revitalize your body.</p>
                            <div class="product-info">
                                <div class="price">₹180.00</div>
                                <a href="https://www.amazon.in/dp/B085V87MGR" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Alfavena Malt</div>
                        <img src="https://www.homeoondoor.com/image/cache/catalog/Bakson/bakson%20alfavena%20malt-320x320.png" alt="Herbal Coffee">
                        <div class="card-body">
                            <p><b>Description:</b> A caffeine-free alternative to coffee, made with herbal ingredients.</p>
                            <div class="product-info">
                                <div class="price">₹350.00</div>
                                <a href="https://www.amazon.in/dp/B084R2GZ98" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hair Care Products Category -->
        <div class="product-category">
            <div class="category-title">Hair Care Products</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Sunny Hair Color</div>
                        <img src="https://onemg.gumlet.io/a_ignore,w_380,h_380,c_fit,q_auto,f_auto/b756098cfd954dc3a1f5cc46f02802d4.jpg" alt="Baby Healing Cream">
                        <div class="card-body">
                            <p><b>Description:</b> A hair color formula designed to cover grays naturally.</p>
                            <div class="product-info">
                                <div class="price">₹40.00</div>
                                <a href="https://www.amazon.in/dp/B086Y85HL2" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Camy Black k2</div>
                        <img src="https://onemg.gumlet.io/l_watermark_346,w_480,h_480/a_ignore,w_480,h_480,c_fit,q_auto,f_auto/cf4f77d42f1b48478dec5be131251785.jpg" alt="Hair Vitality Oil">
                        <div class="card-body">
                            <p><b>Description:</b> A nourishing hair oil to improve hair growth and reduce hair fall.</p>
                            <div class="product-info">
                                <div class="price">₹192.00</div>
                                <a href="https://www.amazon.in/dp/B084GGVQ75" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Arnica Shampoo</div>
                        <img src="https://m.media-amazon.com/images/I/51vZMJalWWL.jpg" alt="Natural Shampoo">
                        <div class="card-body">
                            <p><b>Description:</b> A mild shampoo formulated with herbs for clean and healthy hair.</p>
                            <div class="product-info">
                                <div class="price">₹122.00</div>
                                <a href="https://www.amazon.in/dp/B086Y85HL2" class="btn-category">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div style="padding: 20px; text-align: center;">
        <!-- <h2>Welcome to Padma Homeopathic Store</h2> -->
        <p>Discover our range of quality homeopathic products designed to promote wellness and balance.</p>
    </div>

    <!-- Add jQuery Script -->
    <script>
        $(document).ready(function () {
            // Smooth hover color change for header
            $("header").hover(
                function () {
                    $(this).css("background-color", "#142850");
                },
                function () {
                    $(this).css("background-color", "#0d2c54");
                }
            );

            // Header logo hover effect with jQuery
            $(".header-logo").hover(
                function () {
                    $(this).css({
                        transform: "rotate(360deg) scale(1.2)",
                        transition: "transform 0.5s ease"
                    });
                },
                function () {
                    $(this).css({
                        transform: "rotate(0deg) scale(1)",
                        transition: "transform 0.5s ease"
                    });
                }
            );

            // Button hover text animation
            $(".login-register-links a").hover(function () {
                $(this).animate({ padding: "15px 30px" }, 200);
            }, function () {
                $(this).animate({ padding: "12px 25px" }, 200);
            });
        });
    </script>

    <footer>
        <p>&copy; 2025 Homeopathic Store. All Rights Reserved.</p>
    </footer>

</body>

</html>
