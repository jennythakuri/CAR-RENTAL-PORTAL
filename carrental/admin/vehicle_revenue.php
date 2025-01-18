<?php
session_start();
error_reporting(0);

// Check if the session is set
if (isset($_SESSION['highestRevenue']) && isset($_SESSION['lowestRevenue'])) {
    $highestRevenue = $_SESSION['highestRevenue'];
    $lowestRevenue = $_SESSION['lowestRevenue'];
} else {
    $highestRevenue = $lowestRevenue = 0;
}

// Clear session variables after use
unset($_SESSION['highestRevenue']);
unset($_SESSION['lowestRevenue']);
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Vehicle Revenue | Car Rental Portal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Add your styles here */
        .highlight {
            font-weight: bold;
            color: #FF5722;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Vehicle Revenue & Demand</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Vehicle Revenue Details</div>
                            <div class="panel-body">
                                <h4>Highest Revenue Month</h4>
                                <p class="highlight">Highest Revenue: NPR <?php echo $highestRevenue; ?></p>

                                <h4>Lowest Revenue Month</h4>
                                <p class="highlight">Lowest Revenue: NPR <?php echo $lowestRevenue; ?></p>

                                <!-- Continue with your existing content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
