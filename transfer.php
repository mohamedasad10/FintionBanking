<?php
include 'db.php'; // Connect to the database
session_start(); // Start the session to access user data

// <--------------------- TRANSFERRING MONEY FROM ONE ACCOUNT TO THE OTHER----------------------------->

// Check if the user is logged in (you should have a session variable for this)
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to make a transfer.";
    exit;
}

// Get the sender's account number from the session
$sender = $_SESSION['user_id']; // Assuming 'user_id' is the logged-in user's account number

// Get recipient and amount from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient = $_POST['recipient'];
    $amount = $_POST['amount'];

    // Ensure the amount is a valid positive number
    if ($amount <= 0) {
        echo "Invalid amount. Please enter a positive value.";
        exit;
    }

    // Retrieve the sender's current balance
    $stmt = $conn->prepare("SELECT balance FROM users WHERE account_number = ?");
    $stmt->bind_param("s", $sender); // Bind sender account number to the query
    $stmt->execute();
    $stmt->bind_result($senderBalance); // Store the retrieved balance
    $stmt->fetch();
    $stmt->close(); // Close statement after fetching balance

    // Check if the sender has enough money to transfer
    if ($senderBalance < $amount) {
        echo "Insufficient funds."; // Stop execution if there isn't enough balance
        exit;
    }

    // Deduct the amount from the sender's balance
    $stmt = $conn->prepare("UPDATE users SET balance = balance - ? WHERE account_number = ?");
    $stmt->bind_param("ds", $amount, $sender); // Bind amount and sender account
    $stmt->execute();
    $stmt->close(); // Close statement

    // Add the amount to the recipient's balance
    $stmt = $conn->prepare("UPDATE users SET balance = balance + ? WHERE account_number = ?");
    $stmt->bind_param("ds", $amount, $recipient); // Bind amount and recipient account
    $stmt->execute();
    $stmt->close(); // Close statement

    // <--------------------- RECORD TRANSACTION IN DATABASE ----------------------------->
    $stmt = $conn->prepare("INSERT INTO transactions (sender_account, recipient_account, amount, transaction_type) VALUES (?, ?, ?, 'transfer')");
    $stmt->bind_param("ssd", $sender, $recipient, $amount);
    $stmt->execute();
    $stmt->close();

    echo "Transfer successful!";
}
?>
