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

		<div class="product-banner-section">
			<div class="banner-content">
				
				<div class="cnt-box">
					<h2>Custom Clear Ballistics Products </h2>
					<p>Have an idea for a custom gel block or dummy? Reach out to us and let’s see what we can do! We can do anything from custom sizes to shapes to densities. </p>
					<div class="custom-mail-btn">
						<a href="mailto:info@clearballistics.com"><button class="btn-regular">EMAIL US</button></a>
					</div>
				</div>
			</div>
		</div>
		<!-- product section end -->
		
		
		

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>



	<script type="text/javascript">
		$(".loader").hide();

		
 
	</script>

	</body>
</html>