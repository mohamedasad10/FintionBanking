<?php
include 'db.php'; // Include database connection

// Check if account number is passed in URL
if (!isset($_GET['account_number'])) {
    die("Error: No account number found.");
}

$accountNumber = $_GET['account_number'];

// Get user details from the database
$stmt = $conn->prepare("SELECT holder_name, email, phone, balance FROM users WHERE account_number = ?");
$stmt->bind_param("i", $accountNumber);
$stmt->execute();
$stmt->bind_result($holderName, $email, $phone, $balance);
$stmt->fetch();
$stmt->close();

if (!$holderName) {
    die("Error: User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Top Banner */
        .top-banner {
            width: 100%;
            background: #667eea;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
            font-weight: bold;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        /* Bottom Banner */
        .bottom-banner {
            width: 100%;
            background: #667eea;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        /* Container */
        .container {
            width: 90%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 1s ease-in-out;
            margin-top: 60px; /* Adjust to make space for top banner */
            margin-bottom: 60px; /* Adjust to make space for bottom banner */
        }

        /* Header */
        h2 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        /* Account Info */
        .account-info {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .account-info h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.5);
        }

        .account-info p {
            font-size: 18px;
            margin: 10px 0;
            color: #ddd;
        }

        /* Quick Actions */
        .actions {
            margin-bottom: 20px;
        }

        .actions h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.5);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 5px;
            background: linear-gradient(135deg, #00ffcc, #00b3a7);
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 255, 204, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Transactions Table */
        .transactions {
            margin-bottom: 20px;
        }

        .transactions h3 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: linear-gradient(135deg, #667eea, #00b3a7);
            color: #000;
            font-weight: 600;
        }

        td {
            color: #ddd;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Settings */
        .settings {
            text-align: center;
            margin-top: 20px;
        }

        .settings .btn {
            background: linear-gradient(135deg, #ff4b5c, #d32f2f);
        }

        .settings .btn:hover {
            background: linear-gradient(135deg, #d32f2f, #ff4b5c);
        }

        /* Animations */
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
    </style>
</head>
<body>

<!-- Top Banner -->
<div class="top-banner">
    Welcome to Fintion Banking!
</div>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($holderName); ?>!</h2>

    <!-- Account Info -->
    <div class="account-info">
        <h3>Account Summary</h3>
        <p><strong>Account Number:</strong> **** <?php echo substr($accountNumber, -4); ?></p>
        <p><strong>Balance:</strong> $<?php echo number_format($balance, 2); ?></p>
    </div>

    <!-- Quick Actions -->
    <div class="actions">
        <h3>Quick Actions</h3>
        <a href="deposit.php?account_number=<?php echo $accountNumber; ?>" class="btn">Deposit Money</a>
        <a href="withdraw.html?account_number=<?php echo $accountNumber; ?>" class="btn">Withdraw Money</a>
        <a href="transfer.html?account_number=<?php echo $accountNumber; ?>" class="btn">Transfer Money</a>
        <a href="transaction_history.php?account_number=<?php echo $accountNumber; ?>" class="btn">View Transactions</a>
    </div>

    <!-- Transactions -->
    <div class="transactions">
        <h3>Recent Transactions</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>

            <?php
            // Prepare SQL statement to include sender_account and recipient_account
            $stmt = $conn->prepare("
                SELECT transaction_date, transaction_type, amount, sender_account, recipient_account
                FROM transactions
                WHERE sender_account = ? OR recipient_account = ?
                ORDER BY transaction_date DESC
                LIMIT 10
            ");
            
            // Bind the account number to both sender_account and recipient_account
            $stmt->bind_param("ii", $accountNumber, $accountNumber);
            
            // Execute query
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if transactions exist
            if ($result->num_rows > 0) {
                // Loop through each transaction
                while ($row = $result->fetch_assoc()) {
                    // Initialize the amount display
                    $amountDisplay = "";
                    $description = htmlspecialchars($row['transaction_type']);  // Default transaction type

                    // Handle deposits and withdrawals
                    if ($row['sender_account'] == $accountNumber && $row['transaction_type'] == 'withdrawal') {
                        $amountDisplay = "<span style='color:red;'>-$$" . number_format($row['amount'], 2) . "</span>";
                    }
                    elseif ($row['recipient_account'] == $accountNumber && $row['transaction_type'] == 'deposit') {
                        $amountDisplay = "<span style='color:green;'>+$$" . number_format($row['amount'], 2) . "</span>";
                    }
                    
                    // Handle transfer transactions for sender and recipient
                    if ($row['transaction_type'] == 'transfer') {
                        if ($row['sender_account'] == $accountNumber) {
                            // Sender side of transfer (red and -)
                            $amountDisplay = "<span style='color:red;'>-$$" . number_format($row['amount'], 2) . "</span>";
                        } elseif ($row['recipient_account'] == $accountNumber) {
                            // Recipient side of transfer (green and +)
                            $amountDisplay = "<span style='color:green;'>+$$" . number_format($row['amount'], 2) . "</span>";
                        }
                    }

                    // Display transaction details
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['transaction_date']) . "</td>";
                    echo "<td>" . $description . "</td>";
                    echo "<td>" . $amountDisplay . "</td>";
                    echo "</tr>";
                }
            } else {
                // Display message if no transactions
                echo "<tr><td colspan='3' style='text-align: center;'>No recent transactions found.</td></tr>";
            }

            // Close the statement
            $stmt->close();
            ?>
        </table>
    </div>

    <!-- Settings -->
    <div class="settings">
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<!-- Bottom Banner -->
<div class="bottom-banner">
    Terms & Conditions | Privacy Policy | Contact Us: 021 748 9275
</div>

</body>
</html>