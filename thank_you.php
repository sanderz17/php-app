<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Thank You</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>

		<!--  header section start -->
         <section class="product-header-images">
				<div class="product-hero" style="background-image:url('img/product-hero.jpg')">
					<div class="overlay"></div>
					<div class="container">
					<h3>Thank You </h3>
					<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
					<img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt="">
					
					</div>
				</div>
					<div class="pl-breadcrumb">
						<div class="container">
							<ul class="breadcrumb">
								<li><a href="#">Home /</a></li>
								<li>Thank You</li>
							</ul>
						</div>
					</div>
		 </section>
		<!-- header section end -->


		<!-- Thank You Page Section start-->
         
		 <section class="thank-you-section">
			  <div class="container">
				    <div class="thank-you-section-box">
						<div class="thank-you-section-box-images">
							<img src="<?php echo SITEURL; ?>img/thankyou.png">
						</div>
						<div class="thank-you-section-box-content">
						    
							 <h5>Your order was completed successfully.</h5>
							 <p>For Contacting Us, We Will Get In Touch With You Soon...</p>
							 <a href="#" class="home-btn">go home</a>
						</div>
					</div>
			  </div>
		 </section>

        <!-- Thank You Page Section End-->

        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
	</body>
</html>