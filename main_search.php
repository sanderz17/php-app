<?php
include "connect.php";
$ctable = "product";

// echo "<pre>";
// print_r($_REQUEST);
// die;

$cate_detail = $db->getData("category", "*", "slug='" . $_REQUEST['slug'] . "'");
$cate_data = mysqli_fetch_assoc($cate_detail);

$ctable_where = "isDelete=0 AND isActive=1";

$result_for = "";

if (isset($_REQUEST['main_search']) && !empty($_REQUEST['main_search'])) {
	$ctable_where .= " AND (name like '%" . $_REQUEST["main_search"] . "%')";
	$result_for .= $_REQUEST['main_search'];
}

if (isset($_REQUEST['search_mobile']) && !empty($_REQUEST['search_mobile'])) {
	$ctable_where .= " AND (name like '%" . $_REQUEST["search_mobile"] . "%')";
	$result_for .= $_REQUEST['search_mobile'];
}


// $product = $db->getdata($ctable, "*", $ctable_where);


?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | Product</title>
	<?php include 'front_include/css.php'; ?>
	<style type="text/css">
		.reset-btn {
			float: right;
			font-size: 13px;
			cursor: pointer;
		}

		.reset-icon {
			font-family: LTCSquareFaceW00-SC;
		}
	</style>
</head>

<body>
	<?php include 'front_include/header.php'; ?>
	<!--  product header section start -->
	<div class="loader"></div>

	<section>
		<!-- categories  -->
		<div class="quick-nav-buttons-m d-lg-none">
			<ul class="quick-nav-buttons-list mx-2  px-0 py-3 mb-0">
				<li><a class="btn btn-cb" href="/product/10-ballistics-gel">10% Gelatin</a></li>
				<li><a class="btn btn-cb" href="/product/20-ballistics-gel">20% Gelatin</a></li>
				<li><a class="btn btn-cb" href="/product/ballistic-animals">Ballistic Animals</a></li>
				<li><a class="btn btn-cb" href="/product/testing-kits">Testing Kits</a></li>
				<li><a class="btn btn-cb" href="/product/dummies">Dummies</a></li>
				<li><a class="btn btn-cb" href="/shop/zombie-zed/">Zombie</a></li>
			</ul>
		</div>
	</section>

	<section class="product-header-images">
		<div class="product-hero" style="background-image:url('../img/product-hero.jpg')">
			<div class="overlay"></div>
			<div class="container">
				<div class="row">
					<div class="offset-lg-12 col-lg-12">
						<h3><?php echo $db->getTotalRecord($ctable, $ctable_where); ?> RESULTS FOUND FOR </br> ‘<?php echo $result_for; ?>’</h3>
						<p><?php //echo $cate_data['description']; 
								?></p>
					</div>
				</div>
				<?php //echo $db->getTotalRecord($ctable,$ctable_where); 
				?>

				<!-- <img class="product-Image" src="<?php echo SITEURL ?>img/category/<?php echo $cate_data['image_path']; ?>" alt=""> -->
				<!-- <img class="product-Image" src="<?php echo SITEURL ?>img/category/1637749284_6982320_cat.png" alt=""> -->
			</div>
		</div>

	</section>
	<!-- product header section end -->

	<!-- category start section  start -->
	<?php
	if ($_REQUEST['slug'] == "ballistics-gel") {
	?>
		<section class="category-section">
			<div class="container-fluid">
				<div class="section-header">
					<h3>EXPLORE BY CATEGORY</h3>
				</div>
				<div class="category-slider">
					<?php
					$exCate_d = $db->getData("explore_category", "*", "isDelete=0");
					while ($exCate_r = mysqli_fetch_assoc($exCate_d)) {
					?>
						<div class="slick-slide">
							<a href="<?php echo SITEURL ?>product/<?php echo $exCate_r['category_slug']; ?>"><img src="<?php echo SITEURL ?>img/category/<?php echo $exCate_r['image_path']; ?>"></a>
							<h3><?php echo $exCate_r['name']; ?></h3>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>
	<?php } ?>

	<!-- category start section end -->

	<!-- product section start -->

	<section class="main-product-section">

		<div class="container-fluid">

			<?php
			$display_search = "";
			if ($_REQUEST['slug'] == "cookers") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "molds") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "display-case") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "display-case") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "remelting-kits") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "supplies") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "dummies") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "accessories") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "apparel") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "ballistics-gel") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "testing-kits") {
				$display = "no";
			} elseif ($_REQUEST['slug'] == "") {
				$display = "no";
			}


			if ($display != "no") {
			?>
				<div class="row">
					<div class="col-xl-3 col-md-12">
						<div class="category-header-filters">
							<h2 class="filter-title">PICK YOUR PRODUCT</h2>
							<p>Block or Dummy</p>
							<ul class="product-icon">
								<li onclick="PickProduct('block')"><img src="<?php echo SITEURL; ?>img/799804943698-1.jpg"></li>
								<li><a href="#">OR</a></li>
								<li onclick="PickProduct('torso')"><img src="<?php echo SITEURL; ?>img/799Aasasas804943698-1.png"></li>
							</ul>
						</div>
					</div>

					<div class="col-xl-6 col-md-12">
						<div class="category-header-filters">
							<h2 class="filter-title">What Size Caliber?</h2>
							<!-- <ul class="size-caliber-control" id='myid'>
								<li id="1"><a href="#"> <div class="tooltipli" >.380</div></a></li>
								<li id="2"><a href="#"> <div class="tooltipli">.22LR</div></a></li>
								<li id="3"><a href="#"> <div class="tooltipli">.40s&w</div></a></li>
								<li id="4"><a href="#"> <div class="tooltipli">9mm</div></a></li>
								<li id="5"><a href="#"> <div class="tooltipli">.45ACP</div></a></li>
								<li id="6"><a href="#"> <div class="tooltipli">.300 Blackout</div></a></li>
								<li id="7"><a href="#"> <div class="tooltipli">7.62 x 39mm</div></a></li>
								<li id="12"><a href="#"> <div class="tooltipli">5.56 x 45mm</div></a></li>
								<li id="11"><a href="#"> <div class="tooltipli">.223</div></a></li>
								<li id="10"><a href="#"> <div class="tooltipli">.308</div></a></li>
								<li id="9"><a href="#"> <div class="tooltipli">.30-06</div></a></li>
								<li id="8"><a href="#"> <div class="tooltipli">.50 BMG</div></a></li>
							</ul> -->

							<ul class="bullets-filter-list list-inline" id="myid">
								<li class="list-inline-item" id="1"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/.380.png"></span></a>.380</li>
								<li class="list-inline-item" id="2"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/22lr.png"></span></a>.22LR</li>
								<li class="list-inline-item" id="3"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/40-s&w.png"></span></a>.40 S&W</li>
								<li class="list-inline-item" id="4"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/9-mm.png"></span></a>.9MM</li>
								<li class="list-inline-item" id="5"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/.45.jpg"></span></a>.45 ACP</li>
								<li class="list-inline-item" id="6"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/300 blackout.png"></span></a>.300 Blackout</li>
								<li class="list-inline-item" id="6"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/7.62x54mm.png"></span></a>7.62x54mmR</li>
								<li class="list-inline-item"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/5.56  45 mm.png"></span></a>5.56 * 45 mm</li>
								<li class="list-inline-item" id="8"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/223.png"></span></a>.223</li>
								<li class="list-inline-item" id="10"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/308.png"></span></a>.308</li>
								<li class="list-inline-item" id="11"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/.30x6.png"></span>.30-06</li>
								<li class="list-inline-item" id="12"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullets/50 bmg.png"></span></a>50 BMG</li>
								<!-- <li class="list-inline-item"><a href="#"><span class="bullets-image"><img src="<?php echo SITEURL; ?>img/bullet/57x28mm.jpg"></span>57x28mm</li> -->
							</ul>

						</div>
					</div>

					<div class="col-xl-3 col-md-12">
						<div class="category-header-filters">
							<h2 class="filter-title">NEED A SPECIFIC SIZE?</h2>
							<p>Put in your max outside dimensions (in inches)</p>
							<form>
								<div class="filter-control">
									<ul class="size-control">
										<li><input type="number" name="length" id="length" min="0" placeholder="L" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></li>
										<li><input type="number" name="height" id="height" min="0" placeholder="H" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></li>
										<li><input type="number" name="width" id="width" min="0" placeholder="W" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"></li>
									</ul>
									<div class="btn-go">
										<a class="btn" type="submit" id="btnLWH" href="#">Go</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php
			}
			// echo $_REQUEST['slug']."======";die;

			if ($_REQUEST['slug'] == "molds") {
				$display_search = "no";
			} elseif ($_REQUEST['slug'] == "remelting-kits") {
				$display_search = "no";
			} elseif ($_REQUEST['slug'] == "accessories") {
				$display_search = "no";
			} elseif ($_REQUEST['slug'] == "dummies") {
				$display_search = "no";
			} elseif ($_REQUEST['slug'] == "") {
				$display_search = "no";
			}

			if ($display_search != "no") {
			?>
				<div class="reset-btn" onclick="ResetFilter();">
					<div class="reset-icon"><i class="fa fa-undo"></i> RESET ALL FILTERS</div>
				</div>
				<div class="ps-shopping__header">
					<div class="ps-shopping__actions">
						<h6 id="total"></h6>
					</div>
					<div class="search-product"><input class="form-control" type="text" id="prod_search" name="prod_search" placeholder="Search" onkeyup="prod_search(this.value);"></div>
				</div>
			<?php } else { ?>
				<input type="hidden" name="prod_search" id="prod_search" value="">
			<?php } ?>
			<div id="results"></div>


			<!-- Product Description start -->

			<div class="Product-Description">
				<h2>What Is Clear Ballistic Gel?</h1>
					<p>Clear Ballistics created synthetic gelatin to replace any application where standard gelatin is used, excluding food applications where gelatin is consumed. Our synthetic gelatin is completely transparent, shelf stable from -10F / -23.3C thru 95 F / 35C, completely odorless & colorless, it is colorable from transparent to solid color, contains no organic materials, and can be exported to any country. Our synthetic gelatin originally intent was for terminal ballistic applications however, we found it has numerous other applications.</p>
			</div>


			<!-- Product Description end -->
	</section>
	<!-- product section end -->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>



	<script type="text/javascript">
		$(".loader").hide();
		$(document).ready(function() {
			// dis_category_img("all");
			main_search('<?php echo $_REQUEST['main_search']; ?>');
			main_search('<?php echo $_REQUEST['search_mobile']; ?>');
		});

		function loadDataTable(data_url) {
			console.log(data_url);
			setTimeout(function() {
				$("#results").load(data_url, function() {
					$(".loader").fadeOut();
					$("#results").fadeIn();
				}); //load initial records		
			}, 700);
		}

		function dis_category_img(cid) {
			if (cid != '') {
				var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php";
				$("#results").html("");
				$(".loader").show();

				loadDataTable(data_url);
			}
		}

		// function prod_search(sval) 
		// {      
		//     var searchName  = sval;
		//     searchName      = encodeURIComponent(searchName.trim());
		//     var slug 		= '<?php print_r($_REQUEST['slug']); ?>';
		// 	slug      		= encodeURIComponent(slug.trim());

		//         var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?searchName="+searchName+"&slug="+slug;
		//         $("#results" ).html("");
		//         $(".loader").show();

		//         loadDataTable(data_url);

		//  	if (sval == "") {
		//  		loadDataTable();
		//  	}
		// }

		$(document).ready(function() {
			var slug = '<?php print_r($_REQUEST['slug']); ?>';
			var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?slug=" + slug;
			$("#results").html("");
			$(".loader").show();
			loadDataTable(data_url);
		});

		function prod_search_by_cate(slug) {
			var searchName = slug;
			searchName = encodeURIComponent(searchName.trim());

			var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?searchName=" + searchName;
			$("#results").html("");
			$(".loader").show();

			loadDataTable(data_url);
		}

		function paginate(p_id) {
			var searchName = $("#prod_search").val();
			searchName = encodeURIComponent(searchName.trim());
			var slug = '<?php print_r($_REQUEST['slug']); ?>';
			slug = encodeURIComponent(slug.trim());
			if (p_id != '') {
				var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?page=" + p_id + "&searchName=" + searchName + "&slug=" + slug;
				$("#results").html("");
				$(".loader").show();
				$("#pagi" + p_id).addClass('active');

				loadDataTable(data_url);
			}
		}

		$('#myid li').click(function(ev) {
			ev.preventDefault();
			var CaliberName = this.id;
			var slug = '<?php print_r($_REQUEST['slug']); ?>';
			slug = encodeURIComponent(slug.trim());
			var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?CaliberName=" + CaliberName + "&slug=" + slug;
			$("#results").html("");
			$(".loader").show();

			loadDataTable(data_url);
		});

		$('#btnLWH').click(function(ev) {
			ev.preventDefault();
			var slug = '<?php print_r($_REQUEST['slug']); ?>';
			slug = encodeURIComponent(slug.trim());

			var length = $('#length').val();
			var height = $('#height').val();
			var width = $('#width').val();
			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php",
				data: {
					length: length,
					height: height,
					width: width,
					slug: slug
				},
				success: function(data) {
					var swami = $("#results").html(data);
					loadDataTable(swami);
				}
			});
		});

		function PickProduct(pick_value) {
			var searchName = pick_value;
			searchName = encodeURIComponent(searchName.trim());
			var slug = '<?php print_r($_REQUEST['slug']); ?>';
			slug = encodeURIComponent(slug.trim());

			var data_url = "<?php echo SITEURL ?>ajax_get_<?php echo $ctable; ?>.php?searchName=" + searchName + "&slug=" + slug;
			$("#results").html("");
			$(".loader").show();

			loadDataTable(data_url);

			if (sval == "") {
				loadDataTable();
			}
		}

		function main_search(mval) {
			if (mval != "") {
				var searchName = mval;
				searchName = encodeURIComponent(searchName.trim());

				var data_url = "<?php echo SITEURL ?>ajax_get_main_search_<?php echo $ctable; ?>.php?main_search=" + searchName;
				$("#results").html("");
				$(".loader").show();

				setTimeout(function() {
					loadDataTable(data_url);
				}, 1000);

				if (mval == "") {
					loadDataTable();
				}
			}
		}

		function ResetFilter() {
			window.location.href = "<?php echo SITEURL ?>product/<?php echo $_REQUEST['slug']; ?>";
		}
	</script>

</body>

</html>