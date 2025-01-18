<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

// Redirect to login page if not logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Check if transaction ID is provided
if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];

    // Fetch payment details by transaction_id
    $stmt = $dbh->prepare("SELECT * FROM payments WHERE transaction_id = :transaction_id");
    $stmt->execute(['transaction_id' => $transaction_id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$payment) {
        echo "Payment record not found.";
        exit;
    }
} else {
    echo "Transaction ID is missing.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payment</title>
    <!-- Add CSS styling here -->
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-size: 16px;
        }

        /* Container */
        .container {
            max-width: 700px;
            width: 90%;
            margin: 20px auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Headings */
        h2 {
            text-align: center;
            color: #007bff;
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Paragraph Styling */
        p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        p strong {
            color: #007bff;
            font-weight: bold;
        }

        /* Button Styling */
        .btn,
        .back-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
        }

        .btn:hover,
        .back-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Back Button Styling */
        .back-btn {
            background-color: #28a745;
        }

        .back-btn:hover {
            background-color: #218838;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }

            h2 {
                font-size: 1.6em;
            }

            p {
                font-size: 16px;
            }

            .btn,
            .back-btn {
                font-size: 14px;
                padding: 10px 20px;
            }
        }

        /* Back Button Styling */
        a[href="manage-payment.php"] {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 20px;
        }

        /* Hover effect */
        a[href="manage-payment.php"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Focus effect */
        a[href="manage-payment.php"]:focus {
            outline: none;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
        }

        /* Active effect */
        a[href="manage-payment.php"]:active {
            background-color: #1e7e34;
            transform: scale(0.98);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            a[href="manage-payment.php"] {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Payment</h2>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($payment['transaction_id'] ?? ''); ?></p>
<p><strong>Method:</strong> <?php echo htmlspecialchars($payment['method'] ?? ''); ?></p>
<p><strong>Amount:</strong> NPR <?php echo number_format($payment['amount'] ?? 0, 2); ?></p>
<p><strong>Bank:</strong> <?php echo htmlspecialchars($payment['bank'] ?? ''); ?></p>
<p><strong>Status:</strong> <?php echo ucfirst($payment['status'] ?? ''); ?></p>
<p><strong>Remark:</strong> <?php echo htmlspecialchars($payment['remark'] ?? ''); ?></p>
<p><strong>Date:</strong> <?php echo htmlspecialchars($payment['date'] ?? ''); ?></p>

        <a href="manage-payment.php">Back to Manage Payments</a>
    </div>
</body>
</html>
