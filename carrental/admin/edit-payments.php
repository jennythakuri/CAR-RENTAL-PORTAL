<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Redirect if not logged in
if(strlen($_SESSION['alogin']) == 0) {	
    header('location:index.php');
} else {
    $msg = '';
    $error = '';

    // Get the payment transaction ID from the URL
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the payment record for editing
        try {
            $sql = "SELECT * FROM payments WHERE transaction_id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $payment = $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error fetching payment: " . $e->getMessage();
        }
    }

    // Update payment details if form is submitted
    if(isset($_POST['update'])) {
        try {
            $method = $_POST['method'];
            $amount = $_POST['amount'];
            $status = $_POST['status'];
            $bank = $_POST['bank'];
            $remark = $_POST['remark'];

            // Update the payment record
            $sql = "UPDATE payments SET method = :method, amount = :amount, status = :status, bank = :bank, remark = :remark WHERE transaction_id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':method', $method, PDO::PARAM_STR);
            $query->bindParam(':amount', $amount, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':bank', $bank, PDO::PARAM_STR);
            $query->bindParam(':remark', $remark, PDO::PARAM_STR);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();

            $msg = "Payment updated successfully";
        } catch (PDOException $e) {
            $error = "Error updating payment: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment - Car Rental Portal</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Payment Details</h2>
                        
                        <!-- Success/Error Message -->
                        <?php if($msg){?><div class="succWrap"><?php echo htmlentities($msg); ?></div><?php }
                        if($error){?><div class="errorWrap"><?php echo htmlentities($error); ?></div><?php }?>

                        <form method="post" class="form-horizontal">
                            <input type="hidden" name="id" value="<?php echo $payment['transaction_id']; ?>">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Payment Method</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="method" value="<?php echo htmlentities($payment['method']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Amount (NPR)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="amount" value="<?php echo htmlentities($payment['amount']); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Payment Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status" required>
                                        <option value="pending" <?php if($payment['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="completed" <?php if($payment['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                        <option value="failed" <?php if($payment['status'] == 'failed') echo 'selected'; ?>>Failed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Bank</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="bank" value="<?php echo htmlentities($payment['bank']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Remark</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="remark" rows="3" required><?php echo htmlentities($payment['remark']); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" name="update" class="btn btn-primary">Update Payment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
