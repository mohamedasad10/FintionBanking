<?php
session_start();
include 'db.php'; // Connect to the database

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your transaction history.";
    exit;
}

$user_id = $_SESSION['user_id']; // Get logged-in user's account number

// Retrieve the user's transactions
$stmt = $conn->prepare("
    SELECT sender_account, recipient_account, amount, transaction_type, transaction_date 
    FROM transactions 
    WHERE sender_account = ? OR recipient_account = ?
    ORDER BY transaction_date DESC
");
$stmt->bind_param("ss", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .btn {
            background: #ffc107;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
            margin-bottom: 15px;
        }

        .btn:hover {
            background: #e0a800;
            transform: translateY(-3px);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
        }

        td {
            color: #ddd;
        }

        #transactionMessage {
            margin-top: 15px;
            font-size: 14px;
            color: #ffc107;
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
    </style>
</head>
<body>

<div class="container">
    <button onclick="window.history.back()" class="btn">Go Back</button>

    <h2>Transaction History</h2>
    <table>
        <tr>
            <th>Sender</th>
            <th>Recipient</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Date</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['sender_account']) ?></td>
                <td><?= htmlspecialchars($row['recipient_account']) ?></td>
                <td>$<?= number_format($row['amount'], 2) ?></td>
                <td><?= ucfirst($row['transaction_type']) ?></td>
                <td><?= $row['transaction_date'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
