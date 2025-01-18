<?php
session_start();
include('includes/config.php');

// Check for login (optional, depending on your application structure)
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    // Fetch payment records
    $sql = "SELECT * FROM payments ORDER BY date DESC";
    $query = $dbh->prepare($sql);
    $query->execute();
    $payments = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Bank</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['transaction_id']); ?></td>
                        <td><?php echo htmlspecialchars($payment['method']); ?></td>
                        <td>NPR <?php echo htmlspecialchars($payment['amount']); ?></td>
                        <td><?php echo htmlspecialchars($payment['bank']); ?></td>
                        <td><?php echo htmlspecialchars($payment['status']); ?></td>
                        <td><?php echo htmlspecialchars($payment['date']); ?></td>
                        <td><?php echo htmlspecialchars($payment['remark']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
