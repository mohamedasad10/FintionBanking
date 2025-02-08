<?php
session_start();
include 'db.php'; // Connect to the database

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to withdraw money.");
}

$user_id = $_SESSION['user_id']; // Get the user's account number from the session
$amount = $_POST['amount']; // Get the amount to withdraw from the POST request

// Check if the amount is valid
if ($amount <= 0) {
    die("Invalid amount. Please enter a positive value.");
}

// Retrieve the user's current balance
$stmt = $conn->prepare("SELECT balance FROM users WHERE account_number = ?");
$stmt->bind_param("s", $user_id); // Bind the user account number
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

// Check if the user has sufficient funds
if ($balance < $amount) {
    die("Insufficient funds.");
}

// Deduct the withdrawal amount from the user's balance
$stmt = $conn->prepare("UPDATE users SET balance = balance - ? WHERE account_number = ?");
$stmt->bind_param("ds", $amount, $user_id); // Bind the amount and user account number
$stmt->execute();
$stmt->close();

// Insert the withdrawal into the transactions table
$transaction_type = 'withdrawal'; // Withdrawal transaction type
$stmt = $conn->prepare("INSERT INTO transactions (transaction_date, transaction_type, amount, sender_account) VALUES (NOW(), ?, ?, ?)");
$stmt->bind_param("sdi", $transaction_type, $amount, $user_id); // Bind the data
$stmt->execute();
$stmt->close();

// Confirm the successful withdrawal
echo "Withdrawal successful! Your new balance is $" . number_format($balance - $amount, 2);
?>
