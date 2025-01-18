<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {    
    header('location:index.php');
} else {
    $msg = isset($_GET['msg']) ? $_GET['msg'] : '';

    // Delete payment
    if(isset($_GET['del'])) {
        try {
            $id = $_GET['del'];
            // Use transaction_id instead of payment_id
            $sql = "DELETE FROM payments WHERE transaction_id = :id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_STR);
            $query->execute();
            $msg = "Payment deleted successfully";
        } catch (PDOException $e) {
            $msg = "Error deleting payment: " . $e->getMessage();
        }
    }

    // Update payment details
    if(isset($_POST['update'])) {
        try {
            $id = $_POST['id'];
            $method = $_POST['method'];
            $amount = $_POST['amount'];
            $status = $_POST['status'];
            $bank = $_POST['bank'];
            $remark = $_POST['remark'];

            // Use transaction_id instead of payment_id
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
            $msg = "Error updating payment: " . $e->getMessage();
        }
    }
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Car Rental Portal | Admin Manage Payments</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
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
                        <h2 class="page-title">Manage Payments</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Payment Details</div>
                            <div class="panel-body">
                                <?php if($msg) { ?><div class="succWrap"><?php echo htmlentities($msg); ?></div><?php } ?>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Transaction ID</th>
                                            <th>Method</th>
                                            <th>Amount (NPR)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Bank</th>
                                            <th>Remark</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT * FROM payments";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if($query->rowCount() > 0) {
                                            foreach($results as $result) { ?>
                                                <tr>
                                                    <td><?php echo htmlentities($cnt); ?></td>
                                                    <td><?php echo htmlentities($result->transaction_id); ?></td>
                                                    <td><?php echo htmlentities($result->method); ?></td>
                                                    <td><?php echo htmlentities($result->amount); ?></td>
                                                    <td><?php echo htmlentities($result->date); ?></td>
                                                    <td><?php echo htmlentities($result->status); ?></td>
                                                    <td><?php echo htmlentities($result->bank); ?></td>
                                                    <td><?php echo htmlentities($result->remark); ?></td>
                                                    <td>
                                                        <!-- Updated delete link to use transaction_id instead of payment_id -->
                                                        <a href="manage-payments.php?del=<?php echo $result->transaction_id; ?>" onclick="return confirm('Do you want to delete this payment?');"><i class="fa fa-close"></i></a>
                                                        <!-- Updated edit link to use transaction_id instead of payment_id -->
                                                        <a href="edit-payments.php?id=<?php echo $result->transaction_id; ?>"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; 
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

<?php } ?>
