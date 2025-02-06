<?php
	include "connect.php";
	$product_id = $_REQUEST['id'];

	$product_details = $db->getData("product","*","id=".$product_id." AND isDelete=0");
	$prod_row = mysqli_fetch_assoc($product_details);
// print_r($product_id);
// exit;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Product Details</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>

		<!--  product header section start -->
       	<section class="product-header-images">
			<div class="pl-breadcrumb">
				<div class="container">
					<ul class="breadcrumb">
						<li><a href="#">Home /</a></li>
						<li><a href="#">Store /</a></li>
						<li><a href="#">Ballistic Gelatin /</a></li>
						<li> <a href="#">10% SYNTHETIC /</a></li>
						<li>10% Ballistic Gelatin Sample</li>
					</ul>
				</div>
			</div>
		 </section>
		<!-- product header section end -->


		<!-- product section start -->
		
        	<section class="product-detail-section">
            	<div class="container-fluid">
			     <div class="product-ds-box">
					<div class="row">
						<div class="col-lg-8 col-md-12">
							<section class="module-gallery module-12345">
								<div class="maxWidth900 padLR15">
									<div class="padTB20">
										<div class="slider-wrapper">
											<ul class="slider-thumb noPad noMar">
												<li class="type-image"><img src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>" alt=""></li>
												<?php
													$alt_img = $db->getData("product_alt_image","*","isDelete=0 AND product_id=".$product_id);
													while($alt_row = mysqli_fetch_assoc($alt_img)){
												?>
													<li class="type-image"><img src="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path']; ?>" alt=""></li>
												<?php } ?>
											</ul>
							
											<ul class="slider-preview slide-main-show noPad noMar">
												<li class="type-image">
													<div class="ver-img-thub">
														<a href="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>" data-fancybox="gallery" title=""> 
															<img class="img-full" src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>" alt="">
														</a>
													</div>
												</li>
												<?php
													$alt_img = $db->getData("product_alt_image","*","isDelete=0 AND product_id=".$product_id);
													while($alt_row = mysqli_fetch_assoc($alt_img)){
												?>
												<li class="type-image">
													<div class="ver-img-thub">
														<a href="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path']; ?>" data-fancybox="gallery" title=""> 
															<img class="img-full" src="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path']; ?>" alt="">
														</a>
													</div>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</section>
						</div>

						<div class="col-lg-4 col-md-12">
							<div class="product-detail-right">
								<div class="product-detail-right-content">
									<h2><?php echo $prod_row['name']; ?></h2>
									
									<p><?php echo $prod_row['description']; ?></p>
									
									<div class="product-price-row">
										<input type="hidden" name="price" id="price" value="<?php echo $prod_row['price']; ?>">
										<h3><?php echo $prod_row['price']; ?> <del><?php echo $prod_row['sell_price']; ?></del> <span><?php echo 'On Sale'; ?></span></h3>
									</div>

									<div class="add-to-cart">
										<div class="number">
											<span class="minus">-</span>
											<input type="text" value="1" id="quantity_value" name="quantity_value" />
											<span class="plus">+</span>
										</div>
										
										<div class="cb-cart-btn">
											<a href="javascript:void(0);" class="btn" onclick="add_to_cart();">Add To Cart</a>
										</div>
									</div>

									<div class="product-location">
										<span class="lcly-location-prompt-label">Want it today in <span class="lcly-city-name">US, Newyork</span>?</span>
										<a id="lcly-location-prompt-link-0" class="lcly-location-prompt-link" href="javascript:;">Change</a>
										<a id="lcly-link-0" href="#" class="lcly-anchor lcly-toggleable-0">Find Rambler Bottle Sling Small - Charcoal. Locally.</a>
									</div>

									<div class="share-icon">
										<ul class="list-inline">
											<li><a href="#"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>	
											<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>


				<!-- Compatible product start  -->
				<section class="compatible-section">
					<div class="container-fluid">
					   	<div class="section-header text-center">
						   	<h3>Compatible Accessories</h3>
					   	</div>
<?php
		$join = 'SELECT * FROM `product_accessories` LEFT JOIN product ON product.id = product_accessories.related_pid  WHERE product_accessories.product_id  = '.$product_id;

		$product = mysqli_query($GLOBALS['myconn'],$join);
		//print_r($product['num_rows']);
		//exit;
?>
	<div class="compatible-slider">
		<?php
while ($product_data = mysqli_fetch_assoc($product)) {

	?>
	<div class="slick-slide">
		<a href="#"><img src="<?php echo SITEURL; ?>img/product/<?php echo $product_data['image']; ?>"></a>
		<h3><?php echo $product_data['name']; ?></h3>

		<div class="product-pricing text-center">
			<span class="product-sales-price" title="product-sales-pricee">$<?php echo $product_data['price']; ?> </span>
		</div>
		<div class="product-actions">
			<a class="btn add-to-cart-btn"  href="j:void(0);" onclick="add_to_cart_accessories(<?php echo $product_data['related_pid']; ?>,<?php echo $product_data['price']; ?>);">Add To Cart</a>
		</div>
	</div>    

<?php } ?>
					   	</div>
					</div>
				</section>
				<!-- Compatible product end -->


	     		<!-- product description start  -->
			
					<div class="product-description">
						<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
							<li class="nav-item">
							  <a class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
								aria-selected="true">DESCRIPTION</a>
							</li>
							<li class="nav-item">
							  <a class="nav-link" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
								aria-selected="false">TECHNICAL</a>
							</li>
							<li class="nav-item">
							  <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
								aria-selected="false">Video</a>
							</li>
						</ul>
					  	<div class="tab-content card pt-3 py-4 px-4" id="myTabContentMD">
							<div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
								<div class="py-3">
									<h4 class="mb-2">DESCRIPTION</h4>
									<p><?php echo $prod_row['description']; ?></p>
								</div>
							</div>
							

							<div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
								
								<div class="py-3">
									<h4 class="mb-2">TECHNICAL SPECIFICATIONS</h4>
									<?php echo $prod_row['technical']; ?>
								</div>
							</div>

							<div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
								<div class="cb-video-section" id="corporatevideo">
									<video playsinline="playsinline" autoplay="" muted="muted" controls="" loop="">
										<source src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['video']; ?>" type="video/mp4">
									</video>
								</div>
							</div>
						
					  	</div>
					</div>
			
				<!-- product description end  -->

			</div>
		</section>

		<!-- product section end -->


        	<!-- Alternate usage images slider start -->

		<section class="Alternate-images-section">
            	<div class="container-fluid">
                  	<div class="alternate-images-slider">
                        	<div class="slick-slide">
                              <img src="<?php echo SITEURL; ?>img/hero-banner.jpg">
					</div>
					<div class="slick-slide">
						<img src="<?php echo SITEURL; ?>img/hero-banner.jpg">
					</div>
					<div class="slick-slide">
						<img src="<?php echo SITEURL; ?>img/hero-banner.jpg">
				  	</div>
				</div>
			</div>
		</section>


		<!-- Alternate usage images slider end -->

	<?php include 'front_include/footer.php'; ?>	
	<?php include 'front_include/js.php'; ?>

	<script type="text/javascript">

		function add_to_cart()
		{
			var qty = $('#quantity_value').val();
			var price = $('#price').val();

			$.ajax({
				url: '<?php echo SITEURL; ?>product_db.php', 
				method: 'post', 
				data: 'mode=add_to_cart&product_id=<?php echo $product_id; ?>&qty='+qty+'&price='+price, 
	            beforeSend: function(){
	                $(".loader").show(); 
	            },
				success: function(res) {
	                $(".loader").hide();
					window.location = '<?php echo SITEURL; ?>cart/';
				}
			});
		}

		function add_to_cart_accessories(id,price)
		{
		//	alert(id);
			var qty = 1
			// var price = $('#price').val();

			$.ajax({
				url: '<?php echo SITEURL; ?>product_db.php', 
				method: 'post', 
				data: 'mode=add_to_cart&product_id='+id+'&qty='+qty+'&price='+price, 
	            beforeSend: function(){
	                $(".loader").show(); 
	            },
				success: function(res) {
	                $(".loader").hide();
					window.location = '<?php echo SITEURL; ?>cart/';
				}
			});
		}

	</script>

	</body>
</html>