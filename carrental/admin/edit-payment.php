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

// Handle form submission to update payment details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $method = $_POST['method'];
    $amount = $_POST['amount'];
    $bank = $_POST['bank'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];

    try {
        $stmt = $dbh->prepare("UPDATE payments SET method = :method, amount = :amount, bank = :bank, status = :status, remark = :remark WHERE transaction_id = :transaction_id");
        $stmt->execute([
            'method' => $method,
            'amount' => $amount,
            'bank' => $bank,
            'status' => $status,
            'remark' => $remark,
            'transaction_id' => $transaction_id
        ]);

        echo "Payment updated successfully!";
        header('Location: manage-payment.php');
        exit;
    } catch (PDOException $e) {
        echo "Error updating payment: " . $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
    <!-- Add CSS styling here -->
     <style>
        /* General Styles */
/* General Styles */
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
    padding: 30px;
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

/* Form Elements */
label {
    display: block;
    font-weight: bold;
    color: #333;
    margin-top: 20px;
    font-size: 16px;
}

input,
select,
textarea {
    width: 100%;
    padding: 12px;
    margin-top: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

/* Textarea */
textarea {
    resize: vertical;
}

/* Button Styles */
button[type="submit"] {
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
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-top: 20px;
    width: auto;
}

button[type="submit"]:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

button[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
}

button[type="submit"]:active {
    background-color: #004085;
    transform: scale(0.98);
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

a[href="manage-payment.php"]:hover {
    background-color: #218838;
    transform: scale(1.05);
}

a[href="manage-payment.php"]:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(40, 167, 69, 0.5);
}

a[href="manage-payment.php"]:active {
    background-color: #1e7e34;
    transform: scale(0.98);
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

th,
td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease;
}

/* Status Styling */
.status-completed {
    color: #28a745;
    font-weight: bold;
}

.status-pending {
    color: #ffc107;
    font-weight: bold;
}

.status-failed {
    color: #dc3545;
    font-weight: bold;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }

    h2 {
        font-size: 1.6em;
    }

    input,
    select,
    textarea,
    button[type="submit"],
    a[href="manage-payment.php"] {
        font-size: 14px;
        padding: 10px 20px;
    }

    th,
    td {
        font-size: 14px;
        padding: 12px 8px;
    }

    .table-action-btn {
        font-size: 12px;
        padding: 5px 10px;
    }
}


     </style>
</head>
<body>
    <div class="container">
        <h2>Edit Payment</h2>
        <form action="edit-payment.php?id=<?php echo $payment['transaction_id']; ?>" method="POST">
            <label>Method:</label>
            <input type="text" name="method" value="<?php echo htmlspecialchars($payment['method']); ?>" required>
            <label>Amount:</label>
            <input type="number" name="amount" value="<?php echo htmlspecialchars($payment['amount']); ?>" required>
            <label>Bank:</label>
            <input type="text" name="bank" value="<?php echo htmlspecialchars($payment['bank']); ?>">
            <label>Status:</label>
            <select name="status" required>
                <option value="pending" <?php echo $payment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo $payment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="failed" <?php echo $payment['status'] == 'failed' ? 'selected' : ''; ?>>Failed</option>
            </select>
            <label>Remark:</label>
            <textarea id="remark" name="remark"><?php echo htmlspecialchars($payment['remark'] ?? ''); ?></textarea>

            <button type="submit">Update Payment</button>
        </form>
        <a href="manage-payment.php">Back to Manage Payments</a>
    </div>
</body>
</html>
