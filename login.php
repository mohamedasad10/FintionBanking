<?php
session_start(); // Start the session

include 'db.php'; // Include your database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT account_number, holder_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // If the user exists, verify the password
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($account_number, $holder_name, $hashedPassword);
        $stmt->fetch();

        // Verify the password using password_verify
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $account_number;
            $_SESSION['user_name'] = $holder_name;
            
            // Redirect to the dashboard with the account number
            header("Location: dashboard.php?account_number=" . $account_number);
            exit();
        } else {
            // Incorrect password
            $error = "Incorrect password.";
        }
    } else {
        // No user found
        $error = "No account found with that email address.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fintion Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .form-container img {
            width: 100px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        .form-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #fff;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        form label {
            font-size: 14px;
            color: #ddd;
            text-align: left;
        }
        form input {
            padding: 12px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        form input::placeholder {
            color: #ccc;
        }
        form input:focus {
            border-color: #ffc107;
            outline: none;
        }
        form button {
            padding: 12px;
            background: #ffc107;
            border: none;
            border-radius: 8px;
            color: #333;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }
        form button:hover {
            background: #e0a800;
            transform: translateY(-3px);
        }
        .form-container p {
            margin-top: 20px;
            font-size: 14px;
            color: #ddd;
        }
        .form-container p a {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .form-container p a:hover {
            color: #e0a800;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <img src="Images/FintionLogo.png" alt="Fintion Bank Logo" width="500" height="100">
        <h2>Fintion Bank</h2>
        <?php if (isset($error)): ?>
            <div class="error-message" style="color: red; font-size: 14px; margin-bottom: 15px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
    </div>
</body>
</html>
