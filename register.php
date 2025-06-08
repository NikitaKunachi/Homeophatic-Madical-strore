<?php
session_start();

// Include database connection
include(__DIR__ . '/config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Sanitize inputs
    $first_name = filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
    $last_name = filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['password']);
    $role = $_POST['role'];
    $country_code = $_POST['country_code'];
    $phone_number = filter_var(trim($_POST['phone_number']), FILTER_SANITIZE_STRING);
    $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($first_name) || !preg_match("/^[a-zA-Z]+$/", $first_name)) $errors[] = "Valid first name is required.";
    if (empty($last_name) || !preg_match("/^[a-zA-Z]+$/", $last_name)) $errors[] = "Valid last name is required.";
    if (!$email) $errors[] = "Valid email is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";
    if (empty($role)) $errors[] = "Role is required.";
    if (empty($country_code)) $errors[] = "Country code is required.";
    if (empty($phone_number) || !preg_match("/^[0-9]+$/", $phone_number)) $errors[] = "Valid phone number is required.";
    if (empty($address)) $errors[] = "Address is required.";

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email is already registered.";
        } else {
            // Insert user into the database
            $stmt = $conn->prepare("INSERT INTO users 
                (first_name, last_name, email, password, role, country_code, phone_number, address) 
                VALUES (:first_name, :last_name, :email, :password, :role, :country_code, :phone_number, :address)");

            // Bind parameters
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':country_code', $country_code);
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':address', $address);

            // Execute and redirect
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Error in registration.";
            }
        }
    } else {
        $_SESSION['error'] = implode('<br>', $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXD8w_gA17RcxfUcUdVE_NLHR2R-JYdDgyR1PFeg1cgIZP44TL0jZcyc8_aqq_lwOxQUY&usqp=CAU') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        .register-box {
            background-color: rgba(255, 255, 255, 0.8);
            color: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 70px;
            border: 2px solid #007BFF;
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #FF7F00;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #e67e22;
        }

        .message {
            text-align: center;
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 14px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-box">
            <h2>Register</h2>
            <form method="POST" onsubmit="return validateForm()">
                <input type="text" id="first_name" name="first_name" placeholder="First Name">
                <div class="error" id="first_name_error">First name is required (letters only).</div>

                <input type="text" id="last_name" name="last_name" placeholder="Last Name">
                <div class="error" id="last_name_error">Last name is required (letters only).</div>

                <input type="email" id="email" name="email" placeholder="Email">
                <div class="error" id="email_error">Enter a valid email.</div>

                <input type="password" id="password" name="password" placeholder="Password">
                <div class="error" id="password_error">Password must be at least 6 characters.</div>

                <select name="country_code">
                    <option value="">Select Country Code</option>
                    <option value="+1">+1 (USA)</option>
                    <option value="+91">+91 (India)</option>
                </select>

                <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number">
                <div class="error" id="phone_error">Enter a valid phone number.</div>

                <textarea name="address" placeholder="Address" rows="3"></textarea>

                <select name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="user">User</option>
                </select>

                <button type="submit">Register</button>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="message"> <?= $_SESSION['error'] ?> </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            alert("Validating form..."); // You can implement JavaScript validation here
            return true; 
        }
    </script>
</body>
</html>
