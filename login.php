<?php
session_start();
include('config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($password)) {
        $error = "Password is required.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("Location: admin/dashboard.php");
                } elseif ($user['role'] == 'customer') {
                    header("Location: customer/index.php");
                } else {
                    header("Location: retailers/views/index.html");
                }
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } catch (PDOException $e) {
            $error = "An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Homeopathic Store</title>
    <style>
        body {
            background: url('https://pmrxcontent.com/wp-content/uploads/herbal-remedies.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .login-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background: rgba(0, 51, 102, 0.9);
            color: white;
            border-radius: 8px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            position: relative;
            margin-bottom: 25px;
        }
        .form-label {
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            display: block;
            margin-bottom: 8px;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .form-control {
            border: 1px solid white;
            border-radius: 5px;
            background-color: #002244;
            color: white;
            height: 50px;
            font-size: 1.1rem;
            padding: 0 45px 0 10px;
            width: 100%;
        }
        .form-control:focus {
            border-color: #6fa3ef;
            box-shadow: 0px 0px 8px rgba(111, 163, 239, 0.5);
            outline: none;
        }
        .eye-icon {
            position: absolute;
            right: 10px;
            cursor: pointer;
            color: white;
            font-size: 1.3rem;
            display: none;
        }
        .btn-primary {
            background: #ff7f00;
            border: none;
            font-weight: bold;
            padding: 14px 30px;
            font-size: 1.2rem;
            width: 100%;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background: #ff9f33;
        }
        .error-message {
            color: #ff7f00;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .register-link a {
            color: #ff7f00;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .d-grid {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
    <script>
        function validateForm() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            let errorMessage = '';

            if (!email) {
                errorMessage = 'Email is required.';
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errorMessage = 'Invalid email format.';
            } else if (!password) {
                errorMessage = 'Password is required.';
            }

            if (errorMessage) {
                alert(errorMessage);
                return false;
            }
            return true;
        }

        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.textContent = "🔒";
            } else {
                passwordField.type = "password";
                eyeIcon.textContent = "👁️";
            }
        }

        function showEyeIcon() {
            document.getElementById("eye-icon").style.display = "block";
        }
    </script>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php } ?>
        <form method="POST" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required onfocus="showEyeIcon();">
                    <span id="eye-icon" class="eye-icon" onclick="togglePasswordVisibility()">👁️</span>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn-primary">Login</button>
            </div>
            <p class="register-link mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
