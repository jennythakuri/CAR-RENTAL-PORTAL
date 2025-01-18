<?php
session_start();
error_reporting(E_ALL);
include('includes/config.php');

// Redirect to login page if not logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit;
}

// Initialize the payments array
$payments = [];

// Check if a search query is submitted
$search_query = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['transaction_id'])) {
    $search_query = $_POST['transaction_id'];
    
    // Fetch payment records based on transaction_id search query
    try {
        $stmt = $dbh->prepare("SELECT * FROM payments WHERE transaction_id LIKE :transaction_id ORDER BY date DESC");
        $stmt->bindValue(':transaction_id', '%' . $search_query . '%');
        $stmt->execute();
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching payments: " . $e->getMessage();
        exit;
    }
} else {
    // Fetch all payment records if no search query
    try {
        $stmt = $dbh->query("SELECT * FROM payments ORDER BY date DESC");
        $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching payments: " . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments - Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; color: #333; }
        .container { max-width: 1000px; margin: 50px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { color: #4CAF50; text-align: center; }
        .action-buttons { text-align: right; margin-bottom: 20px; }
        .action-buttons a { text-decoration: none; padding: 10px 20px; background-color: #4CAF50; color: white; border-radius: 5px; transition: background-color 0.3s; }
        .action-buttons a:hover { background-color: #45a049; }
        .search-form { text-align: center; margin-bottom: 20px; }
        .search-form input[type="text"] { padding: 10px; width: 60%; margin-right: 10px; border-radius: 5px; border: 1px solid #ccc; }
        .search-form button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .search-form button:hover { background-color: #45a049; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-completed { color: #28a745; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
        .btn { text-decoration: none; padding: 5px 10px; color: white; border-radius: 5px; }
        .btn-edit { background-color: #2196F3; }
        .btn-view { background-color: #4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Payments</h2>

        <!-- Search Form -->
        <div class="search-form">
            <form method="POST" action="">
                <input type="text" name="transaction_id" placeholder="Search by Transaction ID" value="<?php echo htmlspecialchars($search_query); ?>" required>
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="action-buttons">
            <a href="index.php">Back to Dashboard</a>
        </div>
        
        <?php if ($payments && count($payments) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Bank</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($payment['method']); ?></td>
                            <td><?php echo 'NPR ' . number_format($payment['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($payment['bank']); ?></td>
                            <td class="<?php echo 'status-' . strtolower($payment['status']); ?>"><?php echo ucfirst($payment['status']); ?></td>
                            <td><?php echo htmlspecialchars($payment['date']); ?></td>
                            <td>
                                <a href="edit-payment.php?id=<?php echo $payment['transaction_id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="view-payment.php?id=<?php echo $payment['transaction_id']; ?>" class="btn btn-view">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No payment records found for the search query.</p>
        <?php endif; ?>
    </div>
</body>
</html>
