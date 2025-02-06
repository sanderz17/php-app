<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Order Status</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
	
		<!--  header section start -->
         <section class="product-header-images">
				<div class="product-hero" style="background-image:url('img/product-hero.jpg')">
					<div class="overlay"></div>
					<div class="container">
					<h3>Order Status </h3>
					<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
					<img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt="">
					
					</div>
				</div>
					<div class="pl-breadcrumb">
						<div class="container">
							<ul class="breadcrumb">
								<li><a href="#">Home /</a></li>
								<li>Order Tracking</li>
							</ul>
						</div>
					</div>
		 </section>
		<!-- header section end -->

        
		<!-- Order main section start  -->
     
	    <section class="order-section-main">
             <div class="container">
			 <div class="row">
                 <div class="offset-lg-1 col-lg-10">
					<div class="order-section-header">
							<img src="img/order-tracking.svg" alt="">
							<figcaption>
								<h4>Tracking Details</h4>
								<h6>Order Number</h6>
								<h2># A61452B</h2>
							</figcaption>
					</div>
				  </div>
             </div>
			
			<div class="hh-grayBox pt45 pb20">
				<div class="row">
				<div class="order-tracking completed">
					<span class="is-complete"></span>
					<p>Ordered<br><span>Mon, June 24</span></p>
				</div>
				<div class="order-tracking completed">
					<span class="is-complete"></span>
					<p>Order Confirmed<br><span>Tue, June 25</span></p>
				</div>
				<div class="order-tracking completed">
					<span class="is-complete"></span>
					<p>Shipped<br><span>Tue, June 28</span></p>
				</div>
				<div class="order-tracking">
					<span class="is-complete"></span>
					<p>Delivered<br><span>Fri, June 28</span></p>
				</div>
			</div>
			
		</div>
		</div>
	</div>
 </section>

 <!-- Order main section end  -->
	
	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>

</body>
</html>