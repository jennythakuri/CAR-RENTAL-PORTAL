<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Car Rental Portal | Revenue Generated</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f8ff;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 30px;
        }
        .panel-heading {
            background-color: #4CAF50;
            color: white;
            font-size: 20px;
            text-align: center;
            padding: 10px;
        }
        .panel-body {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
        }
        .highlight {
            color: #4CAF50;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }
        .chart-container {
            margin: 30px 0;
            padding: 20px;
            border-radius: 8px;
            background-color: #f1f1f1;
        }
        canvas {
            width: 100% !important;
            height: auto !important;
        }
        .btn-custom {
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #45a049;
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
                        <h2 class="page-title">Revenue Generated</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">Revenue Details</div>
                            <div class="panel-body">
                                <!-- Date Range Form -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="dateRange">Select Date Range:</label>
                                        <input type="date" class="form-control" id="dateRange" name="dateRange">
                                    </div>
                                    <button type="submit" class="btn-custom" name="submit">View Revenue</button>
                                </form>

                                <?php 
                                // Handle form submission to filter revenue by selected date range
                                if (isset($_POST['submit'])) {
                                    $selectedDate = $_POST['dateRange'];
                                    echo "<h4>Revenue for: " . htmlentities($selectedDate) . "</h4>";

                                    // Filter the total revenue by the selected date
                                    $sql = "SELECT SUM(amount) AS totalRevenue FROM payments WHERE status='completed' AND DATE(date) = :selectedDate";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
                                    $query->execute();
                                    $result = $query->fetch(PDO::FETCH_OBJ);
                                    $totalRevenue = $result->totalRevenue;
                                    echo "<p class='highlight'>Total Revenue: NPR " . htmlentities($totalRevenue) . "</p>";
                                } else {
                                    // Default Total Revenue without filter
                                    $sql = "SELECT SUM(amount) AS totalRevenue FROM payments WHERE status='completed'";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $result = $query->fetch(PDO::FETCH_OBJ);
                                    $totalRevenue = $result->totalRevenue;
                                    echo "<p class='highlight'>Total Revenue: NPR " . htmlentities($totalRevenue) . "</p>";
                                }

                                // Get total revenue for the day
                                $sql = "SELECT SUM(amount) AS totalDayRevenue FROM payments WHERE status='completed' AND DATE(date) = CURDATE()";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $dayRevenue = $query->fetch(PDO::FETCH_OBJ)->totalDayRevenue;
                                echo "<p class='highlight'>Today's Revenue: NPR " . htmlentities($dayRevenue) . "</p>";

                                // Get total revenue for the month
                                $sql = "SELECT SUM(amount) AS totalMonthRevenue FROM payments WHERE status='completed' AND MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE())";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $monthRevenue = $query->fetch(PDO::FETCH_OBJ)->totalMonthRevenue;
                                echo "<p class='highlight'>This Month's Revenue: NPR " . htmlentities($monthRevenue) . "</p>";

                                // Get total revenue for the year
                                $sql = "SELECT SUM(amount) AS totalYearRevenue FROM payments WHERE status='completed' AND YEAR(date) = YEAR(CURRENT_DATE())";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $yearRevenue = $query->fetch(PDO::FETCH_OBJ)->totalYearRevenue;
                                echo "<p class='highlight'>This Year's Revenue: NPR " . htmlentities($yearRevenue) . "</p>";
                                ?>

                                <!-- Revenue by Month -->
                                <h4>Revenue by Month</h4>
                                <?php
                                $sql = "SELECT MONTH(date) AS month, SUM(amount) AS revenue FROM payments WHERE status='completed' GROUP BY MONTH(date)";
                                if (isset($_POST['submit'])) {
                                    $sql .= " AND DATE(date) = :selectedDate";
                                }
                                $query = $dbh->prepare($sql);
                                if (isset($_POST['submit'])) {
                                    $query->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);
                                }
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $months = [];
                                $monthlyRevenues = [];
                                foreach($results as $row) {
                                    $months[] = date('F', mktime(0, 0, 0, $row->month, 1)); // Convert month number to name
                                    $monthlyRevenues[] = $row->revenue;
                                }
                                ?>
                                <div class="chart-container">
                                    <canvas id="monthRevenueChart"></canvas>
                                </div>

                                <!-- Revenue by Week -->
                                <h4>Revenue by Week</h4>
                                <?php
                                $sql = "SELECT WEEK(date) AS week, SUM(amount) AS revenue FROM payments WHERE status='completed' GROUP BY WEEK(date)";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $weeks = [];
                                $weeklyRevenues = [];
                                foreach($results as $row) {
                                    $weeks[] = 'Week ' . $row->week;
                                    $weeklyRevenues[] = $row->revenue;
                                }
                                ?>
                                <div class="chart-container">
                                    <canvas id="weekRevenueChart"></canvas>
                                </div>

                                <!-- Revenue by Day -->
                                <h4>Revenue by Day</h4>
                                <?php
                                $sql = "SELECT DATE(date) AS day, SUM(amount) AS revenue FROM payments WHERE status='completed' GROUP BY DATE(date)";
                                $query = $dbh->prepare($sql);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $days = [];
                                $dailyRevenues = [];
                                foreach($results as $row) {
                                    $days[] = $row->day;
                                    $dailyRevenues[] = $row->revenue;
                                }
                                ?>
                                <div class="chart-container">
                                    <canvas id="dayRevenueChart"></canvas>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Revenue by Month Chart
        const monthRevenueCtx = document.getElementById('monthRevenueChart').getContext('2d');
        new Chart(monthRevenueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Revenue (NPR)',
                    data: <?php echo json_encode($monthlyRevenues); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.3)', // Lighter background color
                    borderColor: 'rgba(75, 192, 192, 0.8)',   // Lighter border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue by Week Chart
        const weekRevenueCtx = document.getElementById('weekRevenueChart').getContext('2d');
        new Chart(weekRevenueCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($weeks); ?>,
                datasets: [{
                    label: 'Revenue (NPR)',
                    data: <?php echo json_encode($weeklyRevenues); ?>,
                    backgroundColor: 'rgba(255, 159, 64, 0.3)', // Lighter background color
                    borderColor: 'rgba(255, 159, 64, 0.8)',   // Lighter border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Revenue by Day Chart
        const dayRevenueCtx = document.getElementById('dayRevenueChart').getContext('2d');
        new Chart(dayRevenueCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($days); ?>,
                datasets: [{
                    label: 'Revenue (NPR)',
                    data: <?php echo json_encode($dailyRevenues); ?>,
                    fill: false,
                    borderColor: 'rgba(153, 102, 255, 0.8)', // Lighter border color
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
<?php } ?>
