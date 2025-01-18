<?php
// Start the session and include config file for DB connection
session_start();
require 'admin/includes/config.php';  // Ensure the path is correct

// Initialize variables for user and payment details
$user_details = [];
$payment_details = [];

// Check if the form has been submitted with a transaction_id
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Retrieve user details from user_info table based on transaction_id
    try {
        $stmt = $dbh->prepare("SELECT * FROM user_info WHERE transaction_id = :transaction_id");
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();
        $user_details = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data

        // Retrieve payment details from payments table based on transaction_id
        $stmt = $dbh->prepare("SELECT * FROM payments WHERE transaction_id = :transaction_id");
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();
        $payment_details = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch payment data

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transaction Details - Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 10px; text-align: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { color: #4CAF50; }
        input[type="text"] { padding: 10px; width: 80%; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .details { margin-top: 30px; text-align: left; }
        .details p { font-size: 16px; line-height: 1.6; }
        .back-button { margin-top: 20px; display: inline-block; padding: 10px 20px; background-color: #FF9800; color: white; text-decoration: none; border-radius: 5px; }
        .result { background-color: #f9f9f9; padding: 15px; margin-top: 20px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Transaction Details</h2>

        <!-- Form to input transaction_id -->
        <form method="POST" action="">
            <input type="text" name="transaction_id" placeholder="Enter Transaction ID" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user_details && $payment_details): ?>
            <!-- Show the user and payment details if available -->
            <div class="result">
                <h3>User Information</h3>
                <div class="details">
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($user_details['first_name']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user_details['last_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user_details['address']); ?></p>
                    <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user_details['dob']); ?></p>
                    <p><strong>Nationality:</strong> <?php echo htmlspecialchars($user_details['nationality']); ?></p>
                    <p><strong>Remarks:</strong> <?php echo htmlspecialchars($user_details['remarks']); ?></p>
                </div>

                <h3>Payment Information</h3>
                <div class="details">
                    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_details['method']); ?></p>
                    <p><strong>Amount:</strong> NPR <?php echo htmlspecialchars($payment_details['amount']); ?></p>
                    <p><strong>Bank:</strong> <?php echo htmlspecialchars($payment_details['bank']); ?></p>
                    <p><strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($payment_details['status'])); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($payment_details['date']); ?></p>
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <!-- If no data is found -->
            <div class="result">
                <p>No details found for the provided transaction ID.</p>
            </div>
        <?php endif; ?>

        <!-- Back Button -->
        <a href="index.php" class="back-button">Back to Admin Panel</a>
    </div>
</body>
</html>
