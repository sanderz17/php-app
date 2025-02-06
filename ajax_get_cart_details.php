<?php
include "connect.php";

$cart_id = 0;

if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
	$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
	//unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);
}

// $cart_data = $db->getData("cart_detail","*",$where);


$where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
$join = " LEFT JOIN product p ON p.id = cd.product_id";
$rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.id as pro_id, p.code as product_sku";
$cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);
$cart_sub_total = 0;
if (@mysqli_num_rows($cart_data) > 0) {
	while ($cart_row = mysqli_fetch_assoc($cart_data)) {
		$cart_sub_total += $cart_row['price'] * $cart_row['qty'];
		$product_url = $db->getValue('product', 'slug', "product.id=" . $cart_row['pro_id']);

?>



		<div class="card border-0 p-3 mb-3">
			<div class="row">
				<div class="col-5 col-lg-3">
					<div class="product__thumbnail">
						<img src="<?php echo SITEURL . PRODUCT . $cart_row['image']; ?>">
					</div>
				</div>
				<div class="col-7 col-lg-9 pl-0 pl-md-1 item-details">
					<div class="row">
						<div class="col-lg-6">
							<div class="row">
								<div class="col-lg-6">
									<div class="item-header mb-1">
										<a href="/shop/<?php echo $product_url ?>" style="text-decoration: underline;" class="text-dark">
											<span style="font-size: 1rem;"><?php echo $cart_row['name']; ?></span>
										</a>
									</div>
									<p class="item-sku mb-1 font-stratum-web-med">
										<span>SKU:</span>
										<span><?php echo $cart_row['product_sku']; ?> </span>
									</p>
									<div class="item-stock-status mb-1">
										<span style="font-size: .8rem;">IN STOCK</span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="item-stock-status mb-2">
										<div class="quantity-label d-none d-sm-block">
											<p>PRICE</p>
										</div>
										<span class="text-dark font-stratum-web-black" style="font-size: 1rem;"><?php echo CURR . $cart_row['price']; ?></span>
									</div>
								</div>
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
										<input class="form-control shadow-none" style="padding: 0 0px;" type="text" placeholder="1" value="<?php echo $cart_row['qty']; ?>" onChange="qty_update(this.value,'<?php echo $cart_row['id']; ?>','<?php echo $cart_row['pro_id']; ?>')">
									</div>
								</div>
								<div class="col-6 text-right d-none">
									<div class="quantity-label d-none d-sm-block">
										<p>TOTAL PRICE</p>
									</div>
									<h6 class="pull-right font-stratum-web-black font-weight-bold"><?php echo CURR . $cart_row['sub_total']; ?></h6>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="remove text-left text-md-right mt-3 mt-md-6">
										<a href="/shop/<?php echo $product_url ?>" class="border-0 bg-none text-dark font-stratum-web-med"><span style="text-decoration: underline;cursor:pointer">VIEW FULL DETAILS</span></a>
										<span> | </span>
										<!-- <button class="border-0 bg-white"><span style="text-decoration: underline;" onlick="Remove_Coupon('<?php //echo $cart_id 
																																																														?>','<?php //echo $cart_row['sub_total']
																																																																	?>');">REMOVE</span></button> -->
										<button class="border-0 bg-none text-dark font-stratum-web-med"><span style="text-decoration: underline;" onclick="remove_cart(<?php echo $cart_row['id']; ?>);">REMOVE</span></button>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	<?php
	}
} else {
	?>
	<!-- 	<div class="container text-center">
		<h1>OPPPPS! YOUR CART IS EMPTY!</h1>
		<div class="banner-btn">
			<a href="<?php echo SITEURL; ?><?php echo $db->getValue("site_setting", "btn_link", "isDelete=0"); ?>" class="btn-regular">BUY NOW</a>
		</div>
	</div> -->
<?php
}


$free_gift = '';
$image_float = '';
$qualify = false;
if ($cart_sub_total >= '300' && $cart_sub_total <= '499.99') {
	$free_gift = "You've Earned a Free Yeti Rambler (20 oz Tumbler)";
	$image_float = SITEURL . "/img/gift_item/Yeti-Tumbler_Clear.png";
} else if ($cart_sub_total >= '500' && $cart_sub_total <= '999.99') {
	$free_gift = "You've Earned a Free 10% FBI Block";
	$image_float = "https://clearballistics.com/img/product/1712147489_8327123_prod.png";
} else if ($cart_sub_total >= '1000') {
	$free_gift = "You've Earned a Free Yeti Roadie 24 Hard Cooler ";
	$image_float = SITEURL . "/img/gift_item/Yeti-Roadie_Brighter.png";
} else {
	$qualify = false;
}
?>
<!-- FREE GIFT -->
<?php if ($qualify) { ?>
	<div class="card border-3 p-3 mb-3" style="border: solid #cf3e2e;">
		<div class="row">
			<div class="col-5 col-lg-3">
				<div class="product__thumbnail">
					<img class="ornament_overlay" src="<?php echo SITEURL; ?>/img/overlay/free_overlay.png">
					<img id='free-gift-cart-image' src="<?php echo $image_float ?>">
				</div>
			</div>
			<div class="col-7 col-lg-9 pl-0 pl-md-1 item-details">
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-lg-6">
								<div class="item-header mb-1">
									<a href="/shop/10-gel-fbi-block" style="text-decoration: none;" class="christmas_red">
										<span style="font-size: 1rem;"><?php echo $free_gift ?></span>
									</a>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="item-stock-status mb-2">
									<div class="quantity-label d-none d-sm-block christmas_red">
										<p>PRICE</p>
									</div>
									<span class="text-dark font-stratum-web-black christmas_red" style="font-size: 1rem;">$0.00</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div class=" col-6">
								<div class="quantity-label d-none d-sm-block christmas_red">
									<p>QUANTITY</p>
									<p>1</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>
<!-- FREE GIFT -->
<script type="text/javascript">
	$(document).ready(function() {
		$('.cart-down').click(function() {
			// alert("Down");
			var $input = $(this).parent().find('input');
			var count = parseInt($input.val()) - 1;
			count = count < 1 ? 1 : count;
			$input.val(count);
			$input.change();
			return false;
		});
		$('.cart-up').click(function() {
			// alert("Up");
			var $input = $(this).parent().find('input');
			$input.val(parseInt($input.val()) + 1);
			$input.change();
			return false;
		});
	});
</script>