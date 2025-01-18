<?php
require './admin/includes/config.php';  // Database connection

// Get payment ID from the URL
$paymentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($paymentId <= 0) {
    echo "Invalid payment ID.";
    exit;
}

// Fetch the current payment data
$stmt = $dbh->prepare("SELECT * FROM payments WHERE payment_id = :id");
$stmt->execute([':id' => $paymentId]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$payment) {
    // Display a message and exit if the payment record is not found
    echo "Payment not found or invalid ID.";
    exit;
}

// If POST request is detected, handle the form submission for updating
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['method'];
    $amount = $_POST['amount'];
    $bank = $_POST['bank'];
    $status = $_POST['status'];

    // Update the payment record in the database
    $updateStmt = $dbh->prepare("UPDATE payments SET method = :method, amount = :amount, bank = :bank, status = :status WHERE payment_id = :id");
    $updateStmt->execute([
        ':method' => $method,
        ':amount' => $amount,
        ':bank' => $bank,
        ':status' => $status,
        ':id' => $paymentId
    ]);

    // Redirect back to manage-payment.php
    header("Location: manage-payment.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
    <style>
        /* Styling the body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container for the form */
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        /* Form header */
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        /* Form elements */
        form label {
            display: block;
            font-weight: bold;
            margin-top: 15px;
            text-align: left;
        }

        form input[type="text"],
        form select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Submit button */
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Payment</h2>
        <form method="POST">
            <label for="method">Payment Method:</label>
            <input type="text" id="method" name="method" value="<?php echo htmlspecialchars($payment['method']); ?>" required>

            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($payment['amount']); ?>" required>

            <label for="bank">Bank:</label>
            <input type="text" id="bank" name="bank" value="<?php echo htmlspecialchars($payment['bank']); ?>">

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="completed" <?php echo $payment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="pending" <?php echo $payment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="failed" <?php echo $payment['status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
            </select>

            <button type="submit">Update Payment</button>
        </form>
    </div>
</body>
</html>
