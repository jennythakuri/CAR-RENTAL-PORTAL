<?php
session_start();
include('includes/config.php'); // Include database configuration

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Process the payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve payment details from the form
    $paymentMethod = $_POST['method'];
    $amount = $_POST['amount'];
    $bankName = $_POST['bank'];

    // Prepare and execute the SQL query to insert payment details
    try {
        $stmt = $dbh->prepare("INSERT INTO payments (method, amount, bank, status) VALUES (:method, :amount, :bank, 'completed')");
        $stmt->bindParam(':method', $paymentMethod);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':bank', $bankName);
        $stmt->execute();

        // Redirect to the manage payments page after inserting the payment
        header('Location: admin/manage-payments.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // Handle error (for debugging, not for production)
    }
}
