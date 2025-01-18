<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>

<title>Car Rental Portal</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<style>
  body {
    font-family: 'Lato', sans-serif;
    margin: 0;
    padding: 0;
  }
  /* Header */
  .navbar {
    background-color: #007bff;
  }
  .navbar-nav .nav-link {
    color: #fff !important;
    font-weight: 600;
  }
  .navbar-nav .nav-link:hover {
    color: #ffc107 !important;
  }
  .banner-section {
    background-image: url("assets/images/banner-image.jpg");no-repeat center center/cover;
    color: #fff;
    height: 400px;
    text-align: center;
    padding: 100px 20px;
  }
  .banner-section h1 {
    
    color: blue;
    font-size: 48px;
    font-weight: 700;
  }
  .banner-section p {
    font-size: 18px;
    margin: 20px 0;
  }
  .btn-banner {
    background-color: blue;
    color: #fff;
    font-weight: 700;
    padding: 12px 30px;
    text-transform: uppercase;
    border-radius: 5px;
    text-decoration: none;
    position: absolute;
    bottom: 20px;
    right: 20px;
  }

  .btn-banner:hover {
    background-color: #e0a800;
    color: #fff;
  }
  .section-title {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
  }
  .section-title span {
    color: #007bff;
  }
  .card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }
  .card img {
    border-radius: 5px;
    height: 200px;
    object-fit: cover;
  }
  .card-title {
    font-size: 20px;
    font-weight: 700;
    margin-top: 10px;
  }
  .card-text {
    font-size: 14px;
    margin-bottom: 15px;
    color: #555;
  }
  .fun-facts-section {
    background: #007bff;
    color: #fff;
    padding: 50px 0;
  }
  .fun-facts-section h2 {
    font-size: 36px;
    font-weight: 700;
  }
  .testimonial-section {
    background: #f8f9fa;
    padding: 50px 0;
  }
  .testimonial-m {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  .testimonial-m h5 {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 10px;
  }
  .testimonial-m p {
    font-size: 14px;
    color: #555;
  }
  footer {
    background: #343a40;
    color: #fff;
    padding: 20px 0;
    text-align: center;
  }
</style>
</head>
<body>

<!-- Header -->
<?php include('includes/header.php'); ?>
<!-- /Header -->

<!-- Banner Section -->
<section class="banner-section">
  <a href="car-listing.php" class="btn-banner">Explore Cars</a>
</section>
<!-- /Banner Section -->

<!-- Recent Cars -->
<section class="section-padding">
  <div class="container">
    <h2 class="section-title">Find the Best <span>Car For You</span></h2>
    <div class="row">
      <?php 
      $sql = "SELECT tblvehicles.VehiclesTitle, tblbrands.BrandName, tblvehicles.PricePerDay, tblvehicles.FuelType, tblvehicles.ModelYear, tblvehicles.id, tblvehicles.SeatingCapacity, tblvehicles.VehiclesOverview, tblvehicles.Vimage1 FROM tblvehicles JOIN tblbrands ON tblbrands.id=tblvehicles.VehiclesBrand LIMIT 6";
      $query = $dbh->prepare($sql);
      $query->execute();
      $results = $query->fetchAll(PDO::FETCH_OBJ);
      if ($query->rowCount() > 0) {
        foreach ($results as $result) { ?>
        <div class="col-md-4">
          <div class="card">
            <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="Car Image">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlentities($result->VehiclesTitle); ?></h5>
              <p class="card-text">
                Fuel: <?php echo htmlentities($result->FuelType); ?> | Year: <?php echo htmlentities($result->ModelYear); ?> | Seats: <?php echo htmlentities($result->SeatingCapacity); ?><br>
                Price: NPR <?php echo htmlentities($result->PricePerDay); ?> /Day
              </p>
              <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id); ?>" class="btn btn-primary">View Details</a>
            </div>
          </div>
        </div>
      <?php }} ?>
    </div>
  </div>
</section>
<!-- /Recent Cars -->

<!-- Fun Facts -->
<section class="fun-facts-section">
  <div class="container text-center">
    <div class="row">
      <div class="col-md-3">
        <h2>40+</h2>
        <p>Years In Business</p>
      </div>
      <div class="col-md-3">
        <h2>1200+</h2>
        <p>New Cars For Sale</p>
      </div>
      <div class="col-md-3">
        <h2>1000+</h2>
        <p>Used Cars For Sale</p>
      </div>
      <div class="col-md-3">
        <h2>600+</h2>
        <p>Satisfied Customers</p>
      </div>
    </div>
  </div>
</section>
<!-- /Fun Facts -->

<!--Testimonial -->
<section class="section-padding testimonial-section parallex-bg">
  <div class="container div_zindex">
    <div class="section-header white-text text-center">
      <h2>Our Satisfied <span>Customers</span></h2>
    </div>
    <div class="row">
      <div id="testimonial-slider">
<?php 
$tid=1;
$sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName from tbltestimonial join tblusers on tbltestimonial.UserEmail=tblusers.EmailId where tbltestimonial.status=:tid limit 4";
$query = $dbh -> prepare($sql);
$query->bindParam(':tid',$tid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


        <div class="testimonial-m">
 
          <div class="testimonial-content">
            <div class="testimonial-heading">
              <h5><?php echo htmlentities($result->FullName);?></h5>
            <p><?php echo htmlentities($result->Testimonial);?></p>
          </div>
        </div>
        </div>
        <?php }} ?>
        
       
  
      </div>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Testimonial--> 
<iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d112658.57415182929!2d81.62944789999999!3d28.0678325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3998675a30f8e175%3A0x93c04013828c9891!2sNepalgunj!5e0!3m2!1sen!2snp!4v1725256113155!5m2!1sen!2snp" 
    width="1400" 
    height="350" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>  

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>
<!--/Forgot-password-Form --> 

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>

<!-- Mirrored from themes.webmasterdriver.net/carforyou/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Jun 2017 07:22:11 GMT -->
</html>