<?php
include 'db.php'; // Include database connection

$response = []; // Initialize the response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT account_number FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists, send an error message
        $response['status'] = 'error';
        $response['message'] = 'Error: Email already registered!';
    } else {
        // Insert the new user into the database (account_number is auto-generated)
        $stmt = $conn->prepare("INSERT INTO users (holder_name, email, phone, password, balance) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("ssss", $fullName, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            // Send a success response
            $response['status'] = 'success';
            $response['message'] = 'Signup successful! Please login.';
        } else {
            // Send an error response
            $response['status'] = 'error';
            $response['message'] = 'Error: Could not register user.';
        }

        $stmt->close();
    }
}

// Return the response as JSON
echo json_encode($response);
?>
