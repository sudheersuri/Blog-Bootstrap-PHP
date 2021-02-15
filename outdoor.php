<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Andrea - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>

	<div id="colorlib-page">
		<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
		<aside id="colorlib-aside" role="complementary" class="js-fullheight">
			<nav id="colorlib-main-menu" role="navigation">
				<ul>
				<?php
					   if(isset($_SESSION["emailid"]))
						{
						if(trim($_SESSION["emailid"])=="sudhirsuri43@gmail.com")
								echo '<li ><a href="admin.php">Admin</a></li>';
						}
				?>
					<li ><a href="index.php">Hot</a></li>
					<li><a href="food.php">Food</a></li>
					<li class="colorlib-active"><a href="outdoor.php">Outdoor</a></li>
					<li ><a href="about.html">About</a></li>
					<li><a href="contact.html">Contact</a></li>
					<?php
					if(!isset($_SESSION["username"]))
						echo '<li><a href="loginmodule/html/login.html">Login</a></li>';
					else
						echo '<li><a href="loginmodule/php/logout.php">Logout</a></li>';
					?>
				</ul>
			</nav>

			<?php include 'baymemoriesfooter.php'?>
		</aside> <!-- END COLORLIB-ASIDE -->
		<div id="colorlib-main">
			<section class="ftco-section ftco-no-pt ftco-no-pb">
	    	<div class="container">
	    		<div class="row d-flex">
	    			<div class="col-xl-8 py-5 px-md-5">
	    				<div class="row pt-md-4 blogs">
							<?php
							
							$query = "select  * from blogs where category='outdoor'";
							$result = $conn->query($query);
							while($row=$result->fetch_assoc())
							{
								?>
			    			    <div class="col-md-12">
									<div class="blog-entry ftco-animate d-md-flex">
										<a href="detail.php?id=<?php echo $row["id"];?>" class="img img-2" style="background-image: url(<?php echo $row["imglocation"];?>);"></a>
										<div class="text text-2 pl-md-4">
				              <h3 class="mb-2"><a href="detail.php?id=<?php echo $row["id"];?>"><?php echo $row["title"];?></a></h3>
				              <div class="meta-wrap">
												<p class="meta">
				              		<span><i class="icon-calendar mr-2"></i><?php 
									 $date=date_create($row["dateadded"]);
									 echo date_format($date,"F m,Y"); 
									  ?></span>
				              		<span><a href="detail.php?id=<?php echo $row["id"];?>"></a></span>
				              		<span><i class="icon-eye mr-2"></i><?php echo $row["viewcounter"];?></span>
				              	</p>
			              	</div>
				              <p class="mb-4"><?php echo $row["sdesc"];?></p>
				              <p><a href="#" class="btn-custom">Read More <span class="ion-ios-arrow-forward"></span></a></p>
				           			    </div>
									</div>
								</div>
								<?php
								}
								?>
			    		</div><!-- END-->
			    		<div class="row">
			          <div class="col">
			            <div class="block-27">
			              <ul>
			                <li><a href="#">&lt;</a></li>
			                <li class="active"><span>1</span></li>
			                <li><a href="#">2</a></li>
			                <li><a href="#">3</a></li>
			                <li><a href="#">4</a></li>
			                <li><a href="#">5</a></li>
			                <li><a href="#">&gt;</a></li>
			              </ul>
			            </div>
			          </div>
			        </div>
			    	</div>
					<?php include 'sidebar.php'?>
		</div><!-- END COLORLIB-MAIN -->
	</div><!-- END COLORLIB-PAGE -->

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>

  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
  
  </body>
</html>