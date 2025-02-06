<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Privacy Policy | Clear Ballistics</title>
		<?php include 'front_include/css.php'; ?>
	</head>

	<body>
		<?php include 'front_include/header.php'; ?>
		
		<!--  header section start -->

         <section class="product-header-images">
		<!-- 		<div class="product-hero" style="background-image:url('img/product-hero.jpg')">
					<div class="overlay"></div>
					<div class="container">
					<h3>Privacy Policy </h3>
					<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
					</div>
				</div>
					<div class="pl-breadcrumb">
						<div class="container">
							<ul class="breadcrumb">
								<li><a href="#">Home /</a></li>
								<li>Privacy Policy</li>
							</ul>
						</div>
					</div> -->
		 </section>
		<!-- header section end -->


		<!-- shipping returns section stat -->

        <section class="shipping-returns-section">
			<div class="section-header text-center">
				<h2><?php echo $db->getValue("static_page", "title", "id=4 AND isArchived=0"); ?></h2>
            </div>
		 <!-- <h1 align="center" style="font-size: 60px;"></h1> -->

             <div class="container">
                 <div class="shipping-returns-section-box">
					<p><?php echo $db->getValue("static_page", "descr", "id =4 AND isArchived=0"); ?> </p>
				 </div>
			 </div>
		</section>

		<!-- shipping returns section end -->
	
		<?php include 'front_include/footer.php'; ?>
		<?php include 'front_include/js.php'; ?>
	</body>
</html>