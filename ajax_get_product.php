<?php
include "connect.php";

$page = "Product";
$ctable = "product";

$p_id = $db->clean($_REQUEST['p_id']);

$ctable_where = "isDelete=0 AND isActive=1";

if ($_REQUEST['height'] == "") {
	$height = 'height IS NULL';
} else {
	$height = $_REQUEST['height'];
}
if ($_REQUEST['width'] == "") {
	$width = 'width IS NULL';
} else {
	$width = $_REQUEST['width'];
}
if ($_REQUEST['length'] == "") {
	$length = 'length IS NULL';
} else {
	$length = $_REQUEST['length'];
}


$overlay_image_name = '20';

if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName'])) {
	$ctable_where .= " AND (name like '%" . $_REQUEST['searchName'] . "%')";
}
// if (isset($_REQUEST['CaliberName']) && !empty($_REQUEST['CaliberName']))
// {
//     $ctable_where .= " AND caliber_id = " . $_REQUEST['CaliberName'] . "";
// }
// if (isset($_REQUEST['length']) && !empty($_REQUEST['length']))
// {
//     $ctable_where .= " AND unit='in' AND length = " . $length . "";
// }
// if (isset($_REQUEST['height']) && !empty($_REQUEST['height']))
// {
//     $ctable_where .= " AND  height = " . $height . "";
// }
// if (isset($_REQUEST['width']) && !empty($_REQUEST['width']))
// {
//     $ctable_where .= " AND   width = " . $width . "";
// }
if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
	$ctable_where .= $_REQUEST["page"];
}
if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
	$current_page = $_REQUEST["page"];
} else {
	$current_page = 1;
}
$current_page = 1;

$num_show = 10;
if (isset($_REQUEST['main_search']) && !empty($_REQUEST['main_search'])) {

	$start_from = ($current_page - 1) * $num_show;
	$limit = " LIMIT $start_from , $num_show";

	// $ctable_r = $db->getData($ctable, "*", $ctable_where);
	// $total_records = @mysqli_num_rows($ctable_r);

	// $total_pages = ceil($total_records / $num_show);

	// if ($total_records < $start_from)
	// {
	//     $start_from = 0;
	//     $current_page = 1;
	//     $limit = " LIMIT $start_from , $num_show";
	// }

	if (isset($_REQUEST['main_search']) && !empty($_REQUEST['main_search'])) {
		$ctable_where .= " AND (name like '%" . $_REQUEST["main_search"] . "%')";
	}
	// $ctable_where .= $limit;

	$pass = 3;
	$count = 1;
	$product = $db->getdata($ctable, "*", $ctable_where);
}


// if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName']))
// {
// 	echo "3asdadas";
// 	exit();
// }
// $num_show = 9;







if (isset($_REQUEST['slug']) && !empty($_REQUEST['slug']) && empty($_REQUEST['main_search'])) {

	$total_records;

	$num_show = 10;
	if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
		$current_page = $_REQUEST["page"];
	} else {
		$current_page = 1;
	}
	$rsdupli = $db->getData('category', '*', 'slug = "' . $_REQUEST["slug"] . '" AND isDelete=0');

	$Cid;
	while ($rsdupli_data = mysqli_fetch_assoc($rsdupli)) {
		$Cid = $rsdupli_data['id'];
	}


	// $join = 'SELECT DISTINCT * FROM `prod_cate` LEFT JOIN product ON product.id = prod_cate.product_id WHERE prod_cate.cate_id  = ' . $Cid . ' AND product.isDelete=0 AND prod_cate.isDelete=0 AND (product.name LIKE "%'.$searchName .'%") ';	

	$join = " LEFT JOIN product ON product.id = prod_cate.product_id";
	$where = ' prod_cate.cate_id  = ' . $Cid . ' AND product.isDelete=0 AND product.isActive=1 AND prod_cate.isDelete=0';
	$row = " DISTINCT *";
	$order = "";

	if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName'])) {
		$where .= " AND (product.name like '%" . $_REQUEST['searchName'] . "%')";
	}
	if (isset($_REQUEST['CaliberName']) && !empty($_REQUEST['CaliberName'])) {
		$where .= " AND FIND_IN_SET(" . $_REQUEST['CaliberName'] . ", product.caliber_id)";
	}
	if (isset($_REQUEST['height']) && !empty($_REQUEST['height'])) {
		$height_size = $_REQUEST['height'];
		$height_plus = $height_size + 5;
		$height_minus = $height_size - 5;
		$where .= " AND product.height BETWEEN " . $height_minus . " AND " . $height_plus . "";
	}
	if (isset($_REQUEST['length']) && !empty($_REQUEST['length'])) {
		$length_size = $_REQUEST['length'];
		$length_plus = $length_size + 5;
		$length_minus = $length_size - 5;
		$where .= " AND product.length BETWEEN " . $length_minus . " AND " . $length_plus . "";
	}
	if (isset($_REQUEST['width']) && !empty($_REQUEST['width'])) {
		$width_size = $_REQUEST['width'];
		$width_plus = $width_size + 5;
		$width_minus = $width_size - 5;
		$where .= " AND product.width BETWEEN " . $width_minus . " AND " . $width_plus . "";
	}

	$start_from = ($current_page - 1) * $num_show;

	$limit = " LIMIT $start_from , $num_show";
	$total_records = $db->getTotalRecord_JoinData2("prod_cate", $join, $where);
	$total_pages = ceil($total_records / $num_show);
	if ($total_records < $start_from) {
		$start_from = 0;
		$current_page = 1;
		$limit = " LIMIT $start_from , $num_show";
	}
	$order .= " product.bs_rank ASC" . $limit;

	$product = $db->getJoinData2("prod_cate", $join, $row, $where, $order);

	$pass = 3;
	$count = 1;
}

?>
<div class="row">
	<?php
	if ($total_records > 0) {
		while ($product_data = mysqli_fetch_assoc($product)) {


			/* 			try {
				if ($product_data['slug'] == '10-gel-fbi-block') {
					$overlay_image_name = '44';
				} elseif ($product_data['slug'] == '10-gel-long-range-block') {
					$overlay_image_name = '44';
				} elseif ($product_data['slug'] == '10-gel-archery-block') {
					$overlay_image_name = '46';
				} elseif ($product_data['slug'] == 'gel-rabbit-3-d-target') {
					$overlay_image_name = '43';
				} elseif ($product_data['slug'] == 'gel-gummy-bear-3-d-target') {
					$overlay_image_name = '41';
				} elseif ($product_data['slug'] == '10-gel-starter-kit') {
					$overlay_image_name = '41';
				} else {
					$overlay_image_name = '30';
				}
			} catch (\Throwable $th) {
				//throw $th;
			} */



	?>
			<div class="col-lg-4 col-md-6 <?php echo $count; ?>">
				<div class="product-section-box">
					<div class="product-section-inner">
						<div class="product-title">
							<a href="#">
								<h5><?php echo $product_data['name']; ?></h5>
							</a>

							<div class="product-pricing">
								<span class="product-sales-price" title="product-sales-pricee"><?php echo CURR . $product_data['price']; ?><del><?php //echo $product_data['sell_price'] > 0 ? CURR . $product_data['sell_price'] : '' 
																																																																?></del></span>
							</div>
						</div>
						<?php
						if ($product_data['new'] == 1) {
						?>
							<div class="tag_new">
								New
							</div>
						<?php
						} elseif ($product_data['onSale'] == 1) {
						?>
							<div class="tag_new on_sale">
								On Sale
							</div>
						<?php
						} elseif ($product_data['out_of_stock'] == 1) {
						?>
							<div class="tag_new Outof_Stock">
								Out of Stock
							</div>
						<?php
						}
						?>
					</div>

					<div class="product-images">

						<?php
						$url = "img/product/" . $product_data['image'];
						if (file_exists($url) && $product_data['image'] != "") { ?>
							<a href="javascript:void(0);"><img src="<?php echo SITEURL . $url; ?>"></a>
							<!-- <img class="ornament_overlay" src="<?php echo SITEURL; ?>/img/overlay/save_<?php echo $overlay_image_name; ?>_overlay.png"> -->
						<?php } else { ?>
							<a href="javascript:void(0);"><img src="<?php echo SITEURL; ?>img/noavailable2.png"></a>
						<?php } ?>
						<!-- <a href="<?php echo SITEURL; ?>product-details/<?php echo $_REQUEST['slug']; ?>/<?php echo $product_data['id']; ?>/"> -->
						<a href="<?php echo SITEURL; ?>shop/<?php echo $product_data['slug']; ?>/">
							<div class="overlay"></div>
							<div class="button"> view product </div>
						</a>
					</div>

					<?php
					if ($product_data['new'] == 1) {
					?>
						<div class="product_view-btn">
							<a data-toggle="modal" id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
						</div>
					<?php
					} elseif ($product_data['onSale'] == 1) {
					?>
						<div class="product_view-btn">
							<a data-toggle="modal" id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
						</div>
					<?php
					} elseif ($product_data['out_of_stock'] == 1) {
					?>
						<div class="product_view-btn">
							<a href="javascript:void(0);" class="cart-btn">Out Of Stock</a>
						</div>
					<?php
					} elseif ($product_data['new'] == 0) {
					?>
						<div class="product_view-btn">
							<a data-toggle="modal" id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
						</div>
					<?php
					} ?>
				</div>
			</div>
			<?php
			if (!empty($product_data['random_image']) && $count == $pass) {
				$pass = $pass + 4;

				$img_status = SITEURL . 'img/product/' . $product_data['random_image'];
				// echo file_exists($img_status);
				if ($product_data['random_image'] != "" && file_exists('img/product/' . $product_data['random_image']) && $total_records > 3) {
			?>
					<div class="col-lg-4 col-md-6 <?php echo $count . ' ' . $pass; ?>">
						<div class="product-section-box">
							<img src="<?php echo SITEURL; ?>img/product/<?php echo $product_data['random_image']; ?>" class="product-hightlight">
						</div>
					</div>
		<?php
				}
			}
			$count++;
		}

		?>

</div>

<?php if ($_REQUEST['slug'] == 'top-gifts') { ?>
	<div class="row">
		<div class="col-12 d-flex justify-content-center">
			<div class="col-4">
				<a href="<?php echo SITEURL ?>product/ballistics-gel" class="btn btn-lg btn-block text-white" style="
    background-color: #63773d;
">VIEW MORE</a>
			</div>
		</div>
	</div>
<?php } ?>

<?php
		if ($total_pages > 1) {
?>
	<div class="ps-pagination">
		<ul class="pagination">
			<?php for ($i = 0; $i < $total_pages; $i++) { ?>
				<li class="<?php if ($current_page == $i + 1) {
											echo 'active';
										} ?>"><a href="javascript:void(0)" onclick="paginate(<?php echo $i + 1; ?>);"><?php echo ($i + 1) ?></a></li>
			<?php } ?>
			<!-- <li><a href="javascript:void(0)" onclick="paginate(<?php echo ($current_page + 1); ?>);">Next Page<i class="icon-chevron-right"></i></a></li> -->
		</ul>
	</div>
<?php
		}
	} else {
?>
<div class="noProduct-sec">
	<h1>No Product</h1>
</div>


<?php
	} ?>

<!-- mini-cart-mobile modal start  -->
<div class="modal fade d-lg-none d-md-none d-none" id="mini-cart-mobile">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="last-item-name">
					<h3><i class="fa fa-check-circle" aria-hidden="true"></i> Added to your cart</h3>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!--  -->
				<div class="row d-none">
					<div class="col-9 col-md-12 col-lg-8">
						<div class="card border-0 p-3 mb-3">
							<div class="row">
								<div class="col-5 col-lg-3">
									<div class="product__thumbnail">
										<img src="http://localhost/img/product/1635405950_1767918_prod.png" alt="">
										<!-- <img src="https://yeti-web.imgix.net/63e5d85820ab3211/W-220111_2H23_Color_Launch_site_studio_drinkware_Rambler_8oz_Tumbler_Stainless_Front_1794_Primary_B_2400x2400.png?bg=0fff&auto=format&w=400&h=400" alt=""> -->
									</div>
								</div>
								<div class="col-7 col-lg-9 pl-0 pl-md-1 item-details">
									<div class="row">
										<div class="col-lg-6">
											<div class="row">
												<div class="col-lg-6">
													<div class="item-header mb-1">
														<a href="" style="text-decoration: underline;" class="text-dark">
															<span style="font-size: 1rem;">20% BALLISTICS GELATIN SLIM JOE TORSO</span>
														</a>
													</div>
													<p class="item-sku mb-1">
														<span>SKU:</span>
														<span>852844007000</span>
													</p>
													<div class="item-stock-status mb-1">
														<span style="font-size: .8rem;">IN STOCK</span>
													</div>
												</div>
												<!-- 												<div class="col-lg-6">
													<div class="item-stock-status mb-2">
														<div class="quantity-label d-none d-sm-block">
															<p>PRICE</p>
														</div>
														<span class="text-muted" style="font-size: 1rem;">$79.98</span>
													</div>
												</div> -->
											</div>
										</div>
										<div class="col-lg-6">
											<div class="row">
												<div class=" col-6">
													<div class="quantity-label d-none d-sm-block">
														<p>QUANTITY</p>
													</div>
													<div class="form-group--number mb-2">
														<button class="up cart-up">+</button>
														<button class="down cart-down">-</button>
														<input class="form-control" style="padding: 0 0px;" type="text" placeholder="1" value="<?php echo $cart_row['qty']; ?>" onChange="qty_update(this.value,'<?php echo $cart_row['id']; ?>','<?php echo $cart_row['pro_id']; ?>')">
													</div>
												</div>
												<div class="col-6 text-right">
													<div class="quantity-label d-none d-sm-block">
														<p>TOTAL PRICE</p>
													</div>
													<h6 class="pull-right">$79.98</h6>
												</div>
											</div>
											<div class="row">

											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="col-3">
						<button class="border-0 bg-white p-3 mb-3"><span style="text-decoration: underline;">REMOVE</span></button>
					</div>
				</div>
				<div class="row">
					<div id="cart_detail_result"></div>
				</div>
				<!--  -->
				<div class="mini-cart-cta">
					<a href="<?php echo SITEURL ?>product/ballistics-gel" class="mini-cart-keep-shopping button-outline">KEEP SHOPPING</a>
					<a href="<?php echo SITEURL ?>cart/" class="mini-cart-mobile-checkout button-dark">VIEW CART</a>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$("#total").html('<?php echo $total_records; ?>' + ' results');

	// function mini_header_modal(product_id)
	// {
	// 	$.ajax({
	// 		type: "POST",
	// 		url: SITEURL+'product_db.php',
	// 		data: {
	// 			product_id:product_id,
	// 			mode:'Product_name_data',
	// 		},
	// 		beforeSend: function(){
	//             $(".loader").show(); 
	//         },
	// 		success: function(data)
	// 		{
	// 			$(".loader").hide(); 
	// 			$("#product_name_data").text(data);
	// 			$("#mini-cart-mobile").modal('show');
	// 		},
	// 	});	
	// }

	function add_to_cart(product_id, price) {
		$.ajax({
			url: '<?php echo SITEURL; ?>product_db.php',
			method: 'post',
			data: 'mode=add_general&product_id=' + product_id + '&price=' + price,
			beforeSend: function() {
				$(".loader").show();
			},
			success: function(res) {
				/* 				var dd = JSON.parse(res);
								console.log(dd['zero']);
								// alert(data);
								if(dd['zero'] == "0")
								{
								alert("Value must be less than or equal to "+dd['pro_qty']);
								}
								if (dd['zero'] == "2") {
				                    alert("Out of Stock ");
				                } */
				$(".loader").hide();
				header_cart_count();

				mini_header_modal(product_id);
				header_cart();
				cart_drawer_details();
				slideOutPanel.open();
				/* 				$('.mini-cart-content-wrap').css({
									'opacity': '1',
									'visibility': 'visible',
								}); */
			}
		});
	}
</script>