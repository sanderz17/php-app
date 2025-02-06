<?php
include "connect.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | News</title>
	<?php include 'front_include/css.php'; ?>
</head>

<body>

	<?php include 'front_include/header.php'; ?>
	<!--  header section start -->
	<section class="product-header-images">

	</section>
	<!-- header section end -->


	<!-- news section stat -->
	<section class="news-section">
		<div class="container-fluid">
			<div class="section-header text-center py-4">
				<h2>Clear Ballistics Press </h2>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="news-section-box">
						<h3>In The News </h3>
						<img src="<?php echo SITEURL; ?>img/news.png" class="news-highttlight-images">
						<a href="https://www.shootingillustrated.com/content/why-you-should-test-your-ammo/">
							<div class="date-sec">
								<!-- <p>9 july 2021</p> -->
								<h5>Why You Should Test Your Ammo </h5>
							</div>
						</a>
					</div>
				</div>

				<div class="col-md-4">
					<div class="news-rightbar">
						<div class="press-contact">
							<h3>FOR PRESS RELATED INQUIRIES CONTACT</h3>
							<span><a href="mailto:media@clearballistics.com"><i class="fa fa-envelope" aria-hidden="true"></i> media@clearballistics.com</a></span>
							<p>GET INSIDER ACCESS AND PERKS WHEN YOU JOIN OUR CLEAR BALLISTICS NATION INSIDER PROGRAM.</p>
							<div class="newsletter-btn">
								<a href="<?php echo SITEURL ?>login/">SIGN UP FOR OUR NEWSLETTER</a>
							</div>
						</div>
						<div class="press-archive">
							<h3>PRESS RELEASE ARCHIVES</h3>
							<ul>
								<li>10% vs. 20% - <a href="<?php echo SITEURL; ?>10vs20-gelatin/" style="text-decoration: underline;">Read More</a></li>
								<li>Why You Should Test Your Ammo - <a href="https://www.shootingillustrated.com/content/why-you-should-test-your-ammo/" style="text-decoration: underline;">Read More</a></li>
								<li>Head to Head: .38 Super vs. 9 mm - <a href="https://www.shootingillustrated.com/content/head-to-head-38-super-vs-9-mm/" style="text-decoration: underline;">Read More</a></li>
								<li><a href="#" style="text-decoration: underline;">SEE ALL</a></li>
							</ul>
						</div>
						<div class="news-follow">
							<h3>FOLLOW US</h3>
							<ul>
								<li><a href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="https://twitter.com/ClearBallistics">
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em;height: 1em;vertical-align: -0.125em;"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
											<path fill="#1d1441" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
										</svg>
									</a>
								</li>
								<li><a href="https://www.instagram.com"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- <div class="slider-section">
				<div class="slider-section-title">
					<h3>Clearballistics Executives</h3>
				</div>
			
				<div class="container-fluid">
				<div class="row">
					<div class="col-12">
	
				<div class="news-slider">
					  <div>
						  <img src="<?php echo SITEURL; ?>img/slide1.jpg">
						  <div class="executive_name"><a href="#">Matthew J. Reintjes</a></div>
						<div class="executive_designation"><a href="#">President and Chief Executive Officer, Director</a></div>
					</div>
					<div>
						  <img src="<?php echo SITEURL; ?>img/slide2.jpg">
						  <div class="executive_name"><a href="#">Matthew J. Reintjes</a></div>
						<div class="executive_designation"><a href="#">President and Chief Executive Officer, Director</a></div>
					</div>
	
					<div>
						  <img src="<?php echo SITEURL; ?>img/slide3.jpg">
						  <div class="executive_name"><a href="#">Matthew J. Reintjes</a></div>
						<div class="executive_designation"><a href="#">President and Chief Executive Officer, Director</a></div>
					</div>
	
					<div>
						  <img src="<?php echo SITEURL; ?>img/slide1.jpg">
						  <div class="executive_name"><a href="#">Matthew J. Reintjes</a></div>
						<div class="executive_designation"><a href="#">President and Chief Executive Officer, Director</a></div>
					</div>
	
	
					<div>
						  <img src="<?php echo SITEURL; ?>img/slide1.jpg">
						  <div class="executive_name"><a href="#">Matthew J. Reintjes</a></div>
						<div class="executive_designation"><a href="#">President and Chief Executive Officer, Director</a></div>
					</div>
					 
				</div>
	
	
					</div>
					</div>
				</div>
			</div> -->
	</section>



	<!-- news section end -->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>

</body>

</html>