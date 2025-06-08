

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padma Homeopathic Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            background: url('images/hero-1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
        }

        /* Header Styling */
        header {
            background-color: rgba(25, 50, 100, 0.9);
            padding: 20px;
            text-align: center;
            color: white;
            border-bottom: 3px solid #1c3b70;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 30px;
        }

        .header-logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
        }

        header h1 {
            font-size: 32px;
            font-weight: bold;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
        }

        .login-register-links a {
            color: white;
            margin: 0 10px;
            font-size: 18px;
            text-decoration: none;
            padding: 10px 20px;
            border: 2px solid #add8e6;
            border-radius: 5px;
            background: none;
            font-weight: bold;
            display: inline-block;
            transition: all 0.3s ease-in-out;
        }

        .login-register-links a:hover {
            background-color: #add8e6;
            color: #1c3b70;
        }

        /* Main Content Styling */
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            margin: 80px auto;
            max-width: 700px;
            text-align: center;
            color: #1c3b70;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .container h2 {
            font-size: 34px;
            margin-bottom: 20px;
            color: #1e3c74;
            font-weight: bold;
        }

        .container p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Footer Styling */
        footer {
            text-align: center;
            padding: 15px;
            background-color: rgba(25, 50, 100, 0.9);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 28px;
            }

            .container {
                padding: 20px;
                margin: 40px auto;
            }

            .container h2 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
<header>
    <h1>
        <img src="https://t4.ftcdn.net/jpg/01/29/07/99/360_F_129079911_rgjzs0I5F2nBSrmm10UT5AGYCCWSXKNE.jpg" alt="Store Logo" class="header-logo">
        Padma Homeopathic Store
    </h1>
    <div class="login-register-links">
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </div>
</header>

<div class="container">
    <h2>Welcome to Padma Homeopathic Medical Store</h2>
    <p>Your one-stop shop for quality homeopathic medicines and holistic health solutions. Explore our wide range of products and find the perfect remedy for your needs.</p>
    <button class="category-btn" onclick="window.location.href='index.php';">Browse Categories</button>
</div>

<footer>
    <p>&copy; 2025 Padma Homeopathic Medical Store. All rights reserved.</p>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
