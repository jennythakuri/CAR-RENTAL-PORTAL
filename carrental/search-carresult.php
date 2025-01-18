<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Car Rental Portal | Car Listing</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Car Listing</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Home</a></li>
        <li>Car Listing</li>
      </ul>
    </div>
  </div>
</section>
<!-- /Page Header--> 

<!--Listing-->
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
<?php 
// Fetch filter values from the POST request
$brand = $_POST['brand'];
$fueltype = $_POST['fueltype'];
$minprice = $_POST['minprice'];
$maxprice = $_POST['maxprice'];

// Build dynamic SQL query with optional price filtering
$sql = "SELECT id FROM tblvehicles WHERE tblvehicles.VehiclesBrand = :brand AND tblvehicles.FuelType = :fueltype";
if (!empty($minprice)) {
    $sql .= " AND tblvehicles.PricePerDay >= :minprice";
}
if (!empty($maxprice)) {
    $sql .= " AND tblvehicles.PricePerDay <= :maxprice";
}
$query = $dbh->prepare($sql);
$query->bindParam(':brand', $brand, PDO::PARAM_STR);
$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
if (!empty($minprice)) {
    $query->bindParam(':minprice', $minprice, PDO::PARAM_INT);
}
if (!empty($maxprice)) {
    $query->bindParam(':maxprice', $maxprice, PDO::PARAM_INT);
}
$query->execute();
$cnt = $query->rowCount();
?>
<p><span><?php echo htmlentities($cnt); ?> Listings</span></p>
</div>
</div>

<?php 
// Fetch filtered car data
$sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles 
        JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand 
        WHERE tblvehicles.VehiclesBrand = :brand AND tblvehicles.FuelType = :fueltype";
if (!empty($minprice)) {
    $sql .= " AND tblvehicles.PricePerDay >= :minprice";
}
if (!empty($maxprice)) {
    $sql .= " AND tblvehicles.PricePerDay <= :maxprice";
}
$query = $dbh->prepare($sql);
$query->bindParam(':brand', $brand, PDO::PARAM_STR);
$query->bindParam(':fueltype', $fueltype, PDO::PARAM_STR);
if (!empty($minprice)) {
    $query->bindParam(':minprice', $minprice, PDO::PARAM_INT);
}
if (!empty($maxprice)) {
    $query->bindParam(':maxprice', $maxprice, PDO::PARAM_INT);
}
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
?>
        <div class="product-listing-m gray-bg">
          <div class="product-listing-img">
            <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" class="img-responsive" alt="Image" />
          </div>
          <div class="product-listing-content">
            <h5>
              <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>">
                <?php echo htmlentities($result->BrandName); ?>, <?php echo htmlentities($result->VehiclesTitle); ?>
              </a>
            </h5>
            <p class="list-price">NPR <?php echo htmlentities($result->PricePerDay); ?> Per Day</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity); ?> seats</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear); ?> model</li>
              <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType); ?></li>
            </ul>
            <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn">View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
          </div>
        </div>
<?php 
    }
} else {
    echo "<h5>No cars found matching your criteria.</h5>";
}
?>
      </div>

      <!--Side-Bar-->
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car</h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option value="">Select Brand</option>
                  <?php 
                  $sql = "SELECT * FROM tblbrands";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $brands = $query->fetchAll(PDO::FETCH_OBJ);
                  foreach ($brands as $brand) {
                      echo "<option value='{$brand->id}'>{$brand->BrandName}</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option value="">Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                </select>
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="minprice" placeholder="Min Price">
              </div>
              <div class="form-group">
                <input type="number" class="form-control" name="maxprice" placeholder="Max Price">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block"><i class="fa fa-search" aria-hidden="true"></i> Search Car</button>
              </div>
            </form>
          </div>
        </div>
      </aside>
      <!--/Side-Bar-->
    </div>
  </div>
</section>
<!-- /Listing--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
</body>
</html>
