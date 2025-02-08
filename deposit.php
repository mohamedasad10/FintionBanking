<?php
include 'db.php'; // Include database connection

// Check if the account_number is passed in the URL
if (!isset($_GET['account_number'])) {
    die("Error: No account number found.");
}

$accountNumber = $_GET['account_number'];

// Get user details to show current balance
$stmt = $conn->prepare("SELECT holder_name, balance FROM users WHERE account_number = ?");
$stmt->bind_param("i", $accountNumber);
$stmt->execute();
$stmt->bind_result($holderName, $balance);
$stmt->fetch();
$stmt->close();

if (!$holderName) {
    die("Error: User not found.");
}

// Handle form submission for deposit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $depositAmount = $_POST['deposit_amount'];

    // Check if deposit amount is valid
    if ($depositAmount > 0) {
        // Update balance in the database
        $newBalance = $balance + $depositAmount;
        $stmt = $conn->prepare("UPDATE users SET balance = ? WHERE account_number = ?");
        $stmt->bind_param("di", $newBalance, $accountNumber);
        $stmt->execute();
        $stmt->close();

        // Insert the transaction into the transactions table
        $transactionType = 'Deposit'; // For deposits
        $stmt = $conn->prepare("INSERT INTO transactions (sender_account, recipient_account, amount, transaction_type, transaction_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiis", $accountNumber, $accountNumber, $depositAmount, $transactionType);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Deposit successful!'); window.location.href = 'dashboard.php?account_number=$accountNumber';</script>";
    } else {
        echo "<script>alert('Please enter a valid deposit amount.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit Money</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Add your deposit page styles here */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 400px;
        }



        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #ffc107;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Deposit Money</h2>

    <form method="POST" action="deposit.php?account_number=<?php echo $accountNumber; ?>">
        <div class="form-group">
            <label for="deposit_amount">Amount to Deposit</label>
            <input type="number" id="deposit_amount" name="deposit_amount" required step="0.01" min="0">
        </div>
        <div class="form-group">
            <button type="submit">Deposit</button>
        </div>
    </form>

    <div class="form-group">
        <a href="dashboard.php?account_number=<?php echo $accountNumber; ?>" class="btn">Back to Dashboard</a>
    </div>
</div>

</body>
</html>
