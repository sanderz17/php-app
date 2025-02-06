<?php
	include "connect.php";
	$ctable = "product";

	$cate_detail = $db->getData("category","*","slug='".$_REQUEST['slug']."'");
	$cate_data = mysqli_fetch_assoc($cate_detail);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Product</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
		<!--  product header section start -->
		<div class="loader"></div>

         	<section class="product-header-images">

		 	</section> 
			<!-- product header section end -->


			<!-- product section start -->
		 	<section class="main-product-section accessories-product">
               	<div class="container-fluid">

				<div id="" class="row">
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 1</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 2</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 3</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 4</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 5</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 6</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 7</div>
					</div>
					<div class="col-lg-3 col-md-5">
						<div class="product-section-box">
							<a href="#"><img src="<?php echo SITEURL; ?>img/noavailable2.png" class="product-hightlight"></a>
						</div>
						<div class="prod-category">category 8</div>
					</div>
				</div>

				<!-- Product Description start -->

				<div class="Product-Description">
	              	<h2>What is Lorem Ipsum?</h1>
				  	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				  	<h2>Where does it come from?</h1>
				  	<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
				</div>


		<!-- Product Description end -->
		</section>
		<!-- product section end -->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>



	<script type="text/javascript">
		$(".loader").hide();

		
 
	</script>

	</body>
</html>