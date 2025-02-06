<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Partners</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
		
		<!--  header section start -->
         <section class="product-header-images">
<!-- 				<div class="product-hero" style="background-image:url('img/product-hero.jpg')">
					<div class="overlay"></div>
					<div class="container">
					<h3>OUR PARTNERS </h3>
					<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
					<img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt="">
					
					</div>
				</div>
					<div class="pl-breadcrumb">
						<div class="container">
							<ul class="breadcrumb">
								<li><a href="#">Home /</a></li>
								<li>Our Partners</li>
								
							</ul>
						</div>
					</div> -->
		 </section>
		<!-- header section end -->

		<!-- Our Partners main section start  -->

		<section class="our-partners-section">
			<div class="section-header text-center">
				<h2 class="py-3">OUR RETAILERS </h2>
				<h4>Clear Ballistics is proud to partner with organizations that celebrate a life outdoors.</h4>
			</div>
			<div class="container-fluid">
                  <div class="row">
					<?php 
						$clients = $db->getData("clients","*","isDelete=0");
						while($client_data = mysqli_fetch_assoc($clients))
						{
					?>
					<div class="col-lg-3 col-md-4 col-6">
						<div class="our-partners-section-box">
							 <div class="img-box">
								 <img src="<?php echo SITEURL; ?>img/client/<?php echo $client_data['logo']; ?>">
							 </div>  
							 <div class="comapany-deatils">
								 <h3><?php echo $client_data['name']; ?></h3>
							 </div>
						</div>
					</div>
					<?php } ?>
				  </div>
			</div>
		</section>
		<!-- Our Partners main section end  -->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>
	</body>
</html>