<?php
// include('connect.php'); 
include("include/notification.class.php");
include_once 'connect.php';
//include_once "./include/notification.class.php";
$a = json_encode($_REQUEST);

$_POST = json_decode($a, true);

// summary details
try {
	$cart_number = $_REQUEST['order_number'];
	if ($cart_number) {
		$cart_details = new Cart();
		$order_summary = $cart_details->getCartDetails($cart_number)['items'];
	}
} catch (\Throwable $th) {
	cb_logger($th);
	throw $th;
}

$rs_cart = $db->getData('cart', '*', 'id=' . (int) $cart_number . ' AND isDelete=0');
$row_cart = @mysqli_fetch_assoc($rs_cart);

// shipping billing
$rs_bs 	= $db->getData('billing_shipping', "*", 'cart_id=' . (int) $cart_number . ' AND isDelete=0');
$row_bs 	= @mysqli_fetch_assoc($rs_bs);

$billing_first_name			=	stripslashes($row_bs['billing_first_name']);
$billing_last_name			=	stripslashes($row_bs['billing_last_name']);
$billing_email				=	stripslashes($row_bs['billing_email']);
$billing_phone				= 	stripslashes($row_bs['billing_phone']);
$billing_address			= 	stripslashes($row_bs['billing_address']);
$billing_address2			= 	stripslashes($row_bs['billing_address2']);
$billing_city				=	stripslashes($row_bs['billing_city']);
$billing_state_code				=	stripslashes($row_bs['billing_state']);
$billing_state = $db->getValue("states_ex", "name", " id='" . $billing_state_code . "' ");
$billing_country_code			=	stripslashes($row_bs['billing_country']);
$billing_country = $db->getValue("countries", "iso2", "id='" . $billing_country_code . "'");
$billing_zipcode			=	stripslashes($row_bs['billing_zipcode']);

$shipping_first_name		=	stripslashes($row_bs['shipping_first_name']);
$shipping_last_name			=	stripslashes($row_bs['shipping_last_name']);
$shipping_email				=	stripslashes($row_bs['shipping_email']);
$shipping_phone				= stripslashes($row_bs['shipping_phone']);
$shipping_address			= stripslashes($row_bs['shipping_address']);
$shipping_address2		= stripslashes($row_bs['shipping_address2']);
$shipping_city				=	stripslashes($row_bs['shipping_city']);
$shipping_state_code				=	stripslashes($row_bs['shipping_state']);
$shipping_state = $db->getValue("states_ex", "name", " id='" . $shipping_state_code . "' ");
$shipping_country_code			=	stripslashes($row_bs['shipping_country']);
$shipping_country = $db->getValue("countries", "iso2", "id='" . $shipping_country_code . "'");
$shipping_zipcode			=	stripslashes($row_bs['shipping_zipcode']);
$shipping_method = $row_cart['shipping_method'];
$order_date = date("Y-m-d", strtotime($row_cart['adate']));
$payment_method = $row_cart["payment_method"];


if (isset($_POST)) {
	if ($_POST['payment_status'] == 'Completed') {

		$paypal_response = json_encode($_POST);
		$custom_arr = explode(",", $_POST['custom']);

		$user_id 			= $custom_arr[0];
		$guest_user_id 	    = $custom_arr[1];
		$cart_det_id 		= $custom_arr[2];
		$grandtotal 		= $custom_arr[3];
		$history_id 		= $custom_arr[4];


		if (isset($cart_det_id) && $cart_det_id > 0) {

			$adate				= date('Y-m-d H:i:s');
			$total_amount 		= $_POST['mc_gross'];
			$transaction_id 	= $_POST['txn_id'];

			$rows = array(
				"payment_status" => 2,
				"payment_date" 	=> $adate,
				"txn_id" 		=> $transaction_id,
				"err_msg" 		=> 'success'
			);
			$db->update("payment_history", $rows, 'id = ' . $history_id);

			$rows = array(
				"order_status"	=> 2,
				"order_date"		=> date('Y-m-d H:i:s')
			);
			$db->update("cart", $rows, "customer_id=" . $user_id . " AND id = " . $cart_det_id);

			if (ISMAIL) {
				$order_d = $db->getData("payment_history", "*", "isDelete=0 AND id=" . $history_id);
				$order_r = mysqli_fetch_assoc($order_d);
				$user_name = $_SESSION[SESS_PRE . '_SESS_USER_NAME'];
				$order_number = $order_r['order_number'];
				$ammount_price = $order_r['price'];
				$paid_date = $order_r['payment_date'];

				// $nt = new Notification();
				// include('mailbody/New_order_place.php');
				// $subject = SITETITLE.' Order Confirmed!';
				// // die($body);
				// $toemail = $_SESSION[SESS_PRE.'_SESS_USER_EMAIL'];
				// // $toemail = "derij14640@ketchet.com";
				// // $toemail = "crazycoder09@gmail.com";
				// $nt->sendEmail($toemail,$subject,$body);

				//$nt = new Notification();
				//include('mailbody/New_order_place.php');
				//$subject = SITETITLE . ' Order Confirmed!';
				//$toemail = "crazycoder09@gmail.com";
				//$email = "derij14640@ketchet.com";
				//$toemail = $_SESSION[SESS_PRE . '_SESS_USER_EMAIL'];
				//$email = "sales@cbgel.com";
				// die($body);
				// $nt->sendEmail($toemail,$subject,$body);
				//$nt->sendEmail2($toemail, $email, $subject, $body);
			}
			$db->location(SITEURL . "thankyou/");
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | Thank You</title>
	<?php include 'front_include/css.php'; ?>
</head>

<body>
	<?php include 'front_include/header.php'; ?>

	<!--  header section start -->
	<section class="product-header-images">
		<div class="product-hero" style="background-image:url('<?php echo SITEURL; ?>img/product-hero.jpg');display:none;">
			<div class="overlay"></div>
			<div class="container">
				<h3>Thank You </h3>
				<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
				<!-- <img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt=""> -->
			</div>
		</div>
		<div class="pl-breadcrumb">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="#">Home /</a></li>
					<li>Thank You</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- header section end -->


	<!-- Thank You Page Section start-->

	<section class="thank-you-section">
		<div class="container">
			<div class="thank-you-section-box">
				<div class="thank-you-section-box-images">
					<img src="<?php echo SITEURL; ?>img/thankyou.png">
				</div>
				<div class="thank-you-section-box-content">

					<h5>Your order was completed successfully.</h5>
					<!-- <p>For Contacting Us, We Will Get In Touch With You Soon...</p> -->
					<!-- <p>For Contacting Us, We Will Get In Touch With You Soon…</p> -->
					<p>Thank You For Your Business!</p>
					<a href="<?php echo SITEURL; ?>" class="home-btn">go home</a>
				</div>
			</div>
		</div>
		<div class="container">

			<div class="primary-content mb-4 mt-4">
				<div class="dashboard-title-status show-for-large mt-4 text-center">ORDER SUMMARY</div>
				<!-- Billing / Shipping -->
				<div class="row col-md-12 mt-5">
					<div class="col-md-3">
						<p>
						<h6>
							Billing Address:
						</h6>
						<br>
						<span>
							<?php echo "$billing_first_name $billing_last_name" ?>
						</span><br>
						</a>
						<span>
							<?php echo "$billing_address $billing_address2"; ?>
						</span><br>
						<span>
							<?php echo "$billing_city"; ?>
						</span><br>
						<span>
							<?php echo "$shipping_state, $shipping_zipcode"; ?>
						</span><br>
						<span>
							<?php echo "$billing_country"; ?>
						</span><br>
						</p>
					</div>
					<div class="col-md-3">
						<p>
						<h6>
							Shipping Address:
						</h6>
						<br>
						<span>
							<?php echo "$shipping_first_name $shipping_last_name" ?>
						</span><br>
						</a>
						<span>
							<?php echo "$shipping_address $shipping_address2"; ?>
						</span><br>
						<span>
							<?php echo "$shipping_city"; ?>
						</span><br>
						<?php echo "$shipping_state, $shipping_zipcode"; ?>
						</span><br>
						<span>
							<?php echo "$shipping_country"; ?>
						</span><br>
						</p>
					</div>
					<div class="col-md-6">
						<table class="table table-bordered">
							<tr>
								<td>
									Order Number
								</td>
								<td class="text-right">
									<?php echo $row_cart['order_no']; ?>
								</td>
							</tr>
							<tr>
								<td>
									Order Date
								</td>
								<td class="text-right">
									<?php echo $order_date; ?>
								</td>
							</tr>
							<tr>
								<td>
									Payment Method
								</td>
								<td class="text-right">
									<?php echo $payment_method; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Billing / Shipping End -->

				<!-- Order Table -->
				<div class="row col-md-12 mt-4">
					<div class="col-md-12">
						<table class="table table-space-admin table-bordered">
							<thead>
								<tr>
									<th class="text-center">Quantity</th>
									<th>Product Name</th>

									<!-- <th class="text-center">Tax</th> -->
									<th class="text-center">Subtotal</th>
									<th class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$counter = 0;
								$cart_sub_total = 0;
								$strquery = 'SELECT ct.*, p.name AS product_name, p.image 
												                 FROM cart_detail ct 
												                 LEFT JOIN product p ON p.id = ct.product_id 
												                 WHERE ct.cart_id = ' . (int) $cart_number . ' AND ct.isDelete=0 AND p.isDelete=0';
								// print $strquery;
								$rs_detail = @mysqli_query($myconn, $strquery);
								while ($row_detail = @mysqli_fetch_assoc($rs_detail)) {
									$counter++;

									$tt = $db->num($row_detail['sub_total']);
									$tax = $db->num(($tt * TAX_RATE) / (100 + TAX_RATE));
									$tt = $db->num($tt - $tax);
									$cart_sub_total += $db->num($row_detail['qty'] * $row_detail['price']);
								?>
									<tr>
										<td class="text-center"><?php echo $row_detail['qty']; ?></td>
										<td><?php echo $row_detail['product_name']; ?>
										</td>
										<td class="text-center"><?php echo CUR . $db->num($tt); ?></td>
										<td class="text-center"><?php echo CUR . $db->num($row_detail['sub_total']); ?></td>
									</tr>
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
								<?php if ($qualify) { ?>
									<tr>
										<td class="text-center">1</td>
										<td><?php echo $free_gift; ?>
										</td>
										<td class="text-center"><?php echo CUR . "0.00"; ?></td>
										<td class="text-center"><?php echo CUR . "0.00"; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>

				<!-- Order Table End -->

				<!-- Sub Total -->
				<div class="row col-md-12 mt-2">
					<div class="col-md-6">
					</div>
					<div class="col-md-6">
						<table class="table table-bordered">
							<tr>
								<td class="font-weight-bold text-left" style="background-color: #f1f2f2;">
									Sub Total:
								</td>
								<td class="text-right">
									<?php echo CUR . $db->num($row_cart['sub_total']); ?>
								</td>
							</tr>
							<tr>
								<td class="font-weight-bold text-left" style="background-color: #f1f2f2;">
									Discount:
								</td>
								<td class="text-right">
									<?php echo CUR . $db->num($row_cart['discount']); ?>
								</td>
							</tr>
							<tr>
								<td class="font-weight-bold text-left" style="background-color: #f1f2f2;">
									Shipping:
								</td>
								<td class="text-right">
									<?php echo CUR . $db->num($row_cart['shipping']) . " via $shipping_method"; ?>
								</td>
							</tr>
							<tr>
								<td class="font-weight-bold text-left" style="background-color: #f1f2f2;">
									Total:
								</td>
								<td class="text-right">
									<?php echo CUR . $db->num($row_cart['grand_total']); ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<!-- Sub Total End -->
				<?php //foreach ($order_summary as $summary) { 
				?>
				<!-- 					<hr>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="data-table-status">
								<p><?php echo $summary['name']; ?>
									<span></span>
								</p>
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="row">
								<div class="offset-lg-4 col-lg-4 col-sm-6">
									<div class="data-table-status float-right">
										<h6>QUANTITY</h6>
									</div>
								</div>
								<div class="col-lg-4 col-sm-6">
									<div class="data-table-status float-right">
										<p><?php echo $summary['quantity']; ?></p>
									</div>
								</div>
							</div>
						</div>
						<br />

					</div> -->
				<?php //} 
				?>
			</div>
		</div>
	</section>

	<!-- Thank You Page Section End-->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>
</body>

</html>