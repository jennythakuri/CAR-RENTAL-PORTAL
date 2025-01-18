<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

// Redirect to login page if not logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:login.php');
    exit;
}

// Initialize variables for search query and results
$search_query = '';
$user_info = null;
$payment_info = null;

// Check if a search query is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_id'])) {
    $search_query = $_POST['transaction_id'];

    // Fetch user information based on transaction_id from user_info table
    try {
        $stmt_user = $dbh->prepare("SELECT * FROM user_info WHERE transaction_id = :transaction_id");
        $stmt_user->bindValue(':transaction_id', $search_query);
        $stmt_user->execute();
        $user_info = $stmt_user->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching user info: " . $e->getMessage();
        exit;
    }

    // Fetch payment information from payments table based on transaction_id
    try {
        $stmt_payment = $dbh->prepare("SELECT * FROM payments WHERE transaction_id = :transaction_id");
        $stmt_payment->bindValue(':transaction_id', $search_query);
        $stmt_payment->execute();
        $payment_info = $stmt_payment->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching payment info: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel - Payment Search</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; color: #333; }
        .container { max-width: 1000px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); position: relative; }
        .refresh-btn { position: absolute; top: 10px; right: 10px; padding: 5px 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 12px; }
        h2 { color: #4CAF50; text-align: center; }
        .search-form { text-align: center; margin-bottom: 20px; }
        .search-form input[type="text"] { padding: 10px; width: 60%; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .search-form button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .search-form button:hover { background-color: #45a049; }
        .result-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-completed { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
        .btn-container { text-align: center; margin-top: 30px; }
        .btn-container button { padding: 10px 20px; margin: 5px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-print { background-color: #007bff; color: white; }
        .btn-dashboard { background-color: #4CAF50; color: white; }
        .btn-print:hover { background-color: #0069d9; }
        .btn-dashboard:hover { background-color: #45a049; }
    </style>
    <script>
        function printPage() {
            window.print();
        }
        function refreshPage() {
            window.location.href = window.location.pathname; // Clears query parameters and form data
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- Refresh Button -->
        <button class="refresh-btn" onclick="refreshPage()">Refresh</button>

        <h2>User Payment Details</h2>

        <!-- Search Form -->
        <div class="search-form">
            <form method="POST" action="">
                <input type="text" name="transaction_id" placeholder="Enter Transaction ID" value="<?php echo htmlspecialchars($search_query); ?>" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if ($user_info && $payment_info) : ?>
            <!-- Display User Info and Payment Info -->
            <h3>User Information</h3>
            <table class="result-table">
                <tr>
                    <th>Name</th>
                    <td><?php echo htmlspecialchars($user_info['first_name']) . ' ' . htmlspecialchars($user_info['last_name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user_info['email']); ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo htmlspecialchars($user_info['phone']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo htmlspecialchars($user_info['address']); ?></td>
                </tr>
                <tr>
                    <th>Remarks</th>
                    <td><?php echo htmlspecialchars($user_info['remarks']); ?></td>
                </tr>
            </table>

            <h3>Payment Information</h3>
            <table class="result-table">
                <tr>
                    <th>Transaction ID</th>
                    <td><?php echo htmlspecialchars($payment_info['transaction_id']); ?></td>
                </tr>
                <tr>
                    <th>Payment Method</th>
                    <td><?php echo htmlspecialchars($payment_info['method']); ?></td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td><?php echo 'NPR ' . number_format($payment_info['amount'], 2); ?></td>
                </tr>
                <tr>
                    <th>Bank</th>
                    <td><?php echo htmlspecialchars($payment_info['bank']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td class="<?php echo 'status-' . strtolower($payment_info['status']); ?>"><?php echo ucfirst($payment_info['status']); ?></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td><?php echo htmlspecialchars($payment_info['date']); ?></td>
                </tr>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
            <p>No details found for the entered transaction ID.</p>
        <?php endif; ?>

        <!-- Print and Dashboard Buttons -->
        <div class="btn-container">
            <button class="btn-print" onclick="printPage()">Print</button>
            <button class="btn-dashboard" onclick="window.location.href='index.php'">Go to Dashboard</button>
        </div>
    </div>
</body>
</html>
