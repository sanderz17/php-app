<style>
	.quotations-pdf .card .card-body {
		padding: 1.5rem 1.5rem;
	}
</style>

<?php
include("connect.php");
$rows = [
	'is_quote' => 1
];
$where	= "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'";
$db->update("cart", $rows, $where);

// $cart_id = $_REQUEST['id'];

$ctable = "cart";
$user = "guest";
//@$user = $_REQUEST['user'];
/* if (empty($user) && $user == "" && $user != "guest") 
{
    $db->CheckoutLogin();
} */

$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];

$rs_cart = $db->getData($ctable, '*', 'id=' . (int) $cart_id . ' AND isDelete=0');
$row_cart = @mysqli_fetch_assoc($rs_cart);

$customer_id 			= $row_cart['customer_id'];
$order_no 				= $row_cart['order_no'];
$shipping_tracking_id 	= $row_cart['shipping_tracking_id'];
$shipping_method = $row_cart['shipping_method'];
$date_now = date("Y-m-d");
$quote_date = date("F j, Y");
$quote_valid_until = date("F j, Y", strtotime("+1 month", strtotime($date_now)));

// echo "<pre>";
// print_r($row_cart);
// die;

$rs_bs 	= $db->getData('billing_shipping', "*", 'cart_id=' . (int) $cart_id . ' AND isDelete=0');
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

$rs_user = $db->getData('user', 'CONCAT(first_name, last_name) as name, email', 'id=' . (int) $row_cart['customer_id']);
$row_user = @mysqli_fetch_assoc($rs_user);

try {
	if (ISMAIL) {
		include("./include/notification.class.php");
		$subject = "Get Quotation";
		$nt = new Notification($db);
		$nt->sendMailWithTemplates($cart_id, $shipping_email, $subject, 'quotation_order_template');
	}
} catch (\Throwable $th) {
	cb_logger($th);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title . ' | ' . SITETITLE; ?></title>
	<?php include('apanel/include/css.php'); ?>
</head>

<body>
	<div class="container-scroller">
		<?php //include("include/header.php"); 
		?>
		<div class="container-fluid page-body-wrapper">
			<?php //include("include/left.php"); 
			?>
			<div class="main-panel" style="width: 100%;">
				<div class="container-fluid">
					<div class="page-header mb-3 mt-2 justify-content-center">
						<h3 class="page-title">
							<a class="btn btn-gradient-success btn-icon-text" href="javascript:void(0);" onclick="createPDF();"> Get Quotations</a>
						</h3>
					</div>
					<div class="row quotations-pdf" id="pdf_section">
						<div class="card-body">

							<div class="row col-md-12">
								<!-- image  -->
								<img class="col-md-3 rounded float-left" src="/img/home/CLEAR_new_logo_color_lg.png" alt="">
								<!-- quote -->
								<div class="col-md-9 text-right">
									<h2>Quote</h2>
								</div>
							</div>


							<!-- body -->

							<!-- From -->
							<div class="row col-md-12 mt-2">
								<div class="col-md-6">
									<p>
										<strong>
											From:
										</strong>
										<br>
										<a href="" style="text-decoration : none"> <span>
												Clear Ballistics
											</span><br>
										</a>
										<span>
											110 Augusta Arbor Way
										</span><br>
										<span>
											Greenville, SC 29605
										</span><br>
										<span>
											<a href="mailto:sales@cbgel.com" style="text-decoration : none">Sales@cbgel.com</a>
										</span><br>
									</p>
								</div>
								<div class="col-md-6">
									<table class="table table-bordered">
										<tr>
											<td>
												Quote Number
											</td>
											<td class="text-right">
												QUO-10101919
											</td>
										</tr>
										<tr>
											<td>
												Quote Date
											</td>
											<td class="text-right">
												<?php echo $quote_date; ?>
											</td>
										</tr>
										<tr>
											<td>
												Valid Until
											</td>
											<td class="text-right">
												<?php echo $quote_valid_until; ?>
											</td>
										</tr>
										<tr class="font-weight-bold">
											<td style="background-color: #f1f2f2;">
												Total
											</td>
											<td style="background-color: #f1f2f2;" class="text-right">
												<?php echo CUR . $row_cart["sub_total"]; ?>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<!-- From End-->

							<!-- Billing / Shipping -->
							<div class="row col-md-12 mt-2">
								<div class="col-md-3">
									<p>
										<strong>
											Billing Address:
										</strong>
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
										<strong>
											Shipping Address:
										</strong>
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
							</div>
							<!-- Billing / Shipping End -->
						</div>

						<!-- Order Table -->
						<div class="row col-md-12">
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
										$strquery = 'SELECT ct.*, p.name AS product_name, p.image, p.code AS product_sku 
												                 FROM cart_detail ct 
												                 LEFT JOIN product p ON p.id = ct.product_id 
												                 WHERE ct.cart_id = ' . (int) $cart_id . ' AND ct.isDelete=0 AND p.isDelete=0';
										// print $strquery;
										$rs_detail = @mysqli_query($myconn, $strquery);
										while ($row_detail = @mysqli_fetch_assoc($rs_detail)) {
											$counter++;

											$tt = $db->num($row_detail['sub_total']);
											$tax = $db->num(($tt * TAX_RATE) / (100 + TAX_RATE));
											$tt = $db->num($tt - $tax);
										?>
											<tr>
												<td class="text-center"><?php echo $row_detail['qty']; ?></td>
												<td><?php echo $row_detail['product_name']; ?>
													<p class="small"><?php echo "SKU:" . $row_detail['product_sku']; ?></p>
												</td>
												<td class="text-center"><?php echo CUR . $db->num($tt); ?></td>
												<td class="text-center"><?php echo CUR . $db->num($row_detail['sub_total']); ?></td>
											</tr>
										<?php
										}
										?>
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
						<!-- hr -->
						<div class="col-md-12">
							<hr class="hr" />
							<p class="text-center">
								This is a fixed price quote.
							</p>
							<hr class="hr" />
						</div>
						<!-- hr End-->

						<!-- footer -->
						<div class="col-md-12">
							<footer class="text-center">
								<div class="row sliced-footer">
									<div class="col-sm-12">
										<div class="footer-text">Thanks for choosing <a href="https://www.clearballistics.com/">Clear Ballistics</a> | <a href="mailto:sales@cbgel.com">Sales@cbgel.com</a></div>
									</div>
								</div>
							</footer>
						</div>
						<!-- footer End-->
					</div>



					<div class="page-header mb-3 mt-2 justify-content-center">
						<h3 class="page-title">
							<a class="btn btn-gradient-success btn-icon-text" href="javascript:void(0);" onclick="createPDF();"> Get Quotations</a>
						</h3>
					</div>

				</div>
				<!-- content-wrapper ends -->
				<?php //include("include/footer.php"); 
				?>
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<?php //include('include/js.php'); 
	?>
	<script src="https://cdn.bootcss.com/html2pdf.js/0.9.1/html2pdf.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
	<script type="text/javascript">
		function createPDF() {
			let timestamp = Date.now();
			let fileName = `qoute-${timestamp}`
			var element = document.getElementById('pdf_section');
			html2pdf(element, {
				margin: 0,
				padding: 0,
				filename: `${fileName}.pdf`,
				image: {
					type: 'jpeg',
					quality: 1
				},
				html2canvas: {
					scale: 2,
					logging: true
				},
				jsPDF: {
					unit: 'in',
					format: 'A4',
					orientation: 'P'
				},
				class: createPDF
			});
		};
	</script>
</body>

</html>