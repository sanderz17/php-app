<?php
try {
	include_once("./connect.php");
	$db->checkAdminLogin();
	$ctable = "cart";
	$ctable1 = "Order";
	$page = "order";
	$page_title = ucwords($_REQUEST['mode']) . " " . $ctable1;
	$refund = false;

	$cart_id = $_REQUEST['id'];

	if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "delete") {
		$id 	= $_REQUEST['id'];
		$rows 	= array("isDelete" => "1");

		$db->update($ctable, $rows, "id=" . $id);

		$_SESSION['MSG'] = "Deleted";
		$db->location(ADMINURL . 'manage-' . $page . '/');
		exit;
	}

	if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "update") {
		//die(print_r($_REQUEST));
		// order 
		$id = $_REQUEST['id'];
		$tracking_id = $_REQUEST['tracking_id'] ?? '';
		$order_status = $_REQUEST['order_status'] ?? '';
		$shipping = $_REQUEST['shipping'] ?? '';
		$shipping_method = $_REQUEST['shipping_method'] ?? '';
		$payment_method = $_REQUEST['payment_method'] ?? '';
		$rows_order 	= array("order_status" => $order_status, "shipping_tracking_id" => $tracking_id, 'shipping' => $shipping, 'shipping_method' => $shipping_method, 'payment_method' => $payment_method);
		$db->update($ctable, $rows_order, "id=" . $id);

		// billing/shipping

		$rows_billing_shipping = array(
			'billing_first_name' => $_REQUEST['billing_first_name'] ?? '',
			'shipping_first_name' => $_REQUEST['shipping_first_name'] ?? '',
			'billing_last_name' => $_REQUEST['billing_last_name'] ?? '',
			'shipping_last_name' => $_REQUEST['shipping_last_name'] ?? '',
			'billing_email' => $_REQUEST['billing_email'] ?? '',
			'shipping_email' => $_REQUEST['shipping_email'] ?? '',
			'billing_phone' => $_REQUEST['billing_phone'] ?? '',
			'shipping_phone' => $_REQUEST['shipping_phone'] ?? '',
			'billing_address' => $_REQUEST['billing_address'] ?? '',
			'shipping_address' => $_REQUEST['shipping_address'] ?? '',
			'billing_address2' => $_REQUEST['billing_address2'] ?? '',
			'shipping_address2' => $_REQUEST['shipping_address2'] ?? '',
			'billing_city' => $_REQUEST['billing_city'] ?? '',
			'shipping_city' => $_REQUEST['shipping_city'] ?? '',
			'billing_country' => $_REQUEST['billing_country'] ?? '',
			'shipping_country' => $_REQUEST['shipping_country'] ?? '',
			'billing_zipcode' => $_REQUEST['billing_zipcode'] ?? '',
			'shipping_zipcode' => $_REQUEST['shipping_zipcode'] ?? '',
			'billing_state' => $_REQUEST['billing_state'] ?? '',
			'shipping_state' => $_REQUEST['shipping_state'] ?? ''
		);
		$db->update('billing_shipping', $rows_billing_shipping, "cart_id=" . $id);

		$_SESSION['MSG'] = "Updated";
		//die(json_encode($_REQUEST));
		//$db->location(ADMINURL.'manage-'.$page.'/');
		//exit;
	}

	$rs_cart = $db->getData($ctable, '*', 'id=' . (int) $cart_id . ' AND isDelete=0');
	$row_cart = @mysqli_fetch_assoc($rs_cart);

	$customer_id 			= $row_cart['customer_id'];
	$order_no 				= $row_cart['order_no'];
	$shipping_tracking_id 	= $row_cart['shipping_tracking_id'];

	try {
		$shipStations = new Cart();
		$shipstation_status = $shipStations->getOrderStatusFromShipStation($order_no) ?: $row_cart['order_status'];
		switch ($shipstation_status) {
			case 'awaiting_payment':
				$row_cart['order_status'] = '5';
				break;
			case 'awaiting_shipment':
				$row_cart['order_status'] = '2';
				break;
			case 'shipped':
				$row_cart['order_status'] = '3';
				break;
			case 'cancelled':
				$row_cart['order_status'] = '0';
				break;
			default:
				$row_cart['order_status'] = '1';
				break;
		}
	} catch (\Throwable $th) {
		cb_logger($th);
	}
	$row_cart['order_status'] = intval($row_cart['order_status']);

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
	$billing_state				=	stripslashes($row_bs['billing_state']);
	$billing_country			=	stripslashes($row_bs['billing_country']);
	$billing_zipcode			=	stripslashes($row_bs['billing_zipcode']);

	$shipping_first_name		=	stripslashes($row_bs['shipping_first_name']);
	$shipping_last_name			=	stripslashes($row_bs['shipping_last_name']);
	$shipping_email				=	stripslashes($row_bs['shipping_email']);
	$shipping_phone				= 	stripslashes($row_bs['shipping_phone']);
	$shipping_address			= 	stripslashes($row_bs['shipping_address']);
	$shipping_address2			= 	stripslashes($row_bs['shipping_address2']);
	$shipping_city				=	stripslashes($row_bs['shipping_city']);
	$shipping_state				=	stripslashes($row_bs['shipping_state']);
	$shipping_country			=	stripslashes($row_bs['shipping_country']);
	$shipping_zipcode			=	stripslashes($row_bs['shipping_zipcode']);

	$rs_user = $db->getData('user', 'CONCAT(first_name, last_name) as name, email', 'id=' . (int) $row_cart['customer_id']);
	$row_user = @mysqli_fetch_assoc($rs_user);


	// refund process start

	if (isset($_REQUEST['refund_manually'])) {
		$refunded_customer_id    		= $_REQUEST['refunded_customer_id'];
		$refunded_order_no    			= $_REQUEST['refunded_order_no'];
		$refunded_shipping_tracking_id  = $_REQUEST['refunded_shipping_tracking_id'];
		$already_refunded    			= $_REQUEST['already_refunded'];
		$total_available_refund    		= $_REQUEST['total_available_refund'];
		$refund_amount    				= $_REQUEST['refund_amount'];
		$reson_refund    				= $_REQUEST['reson_refund'];
		$restock_refund_item			= $_REQUEST['restock_refund_item'];

		$restock_all_item = $total_available_refund - $refund_amount;

		if ($restock_refund_item != 0) {
			$restock_refund_item = 1;
		} else {
			$restock_refund_item = 0;
		}

		if ($restock_all_item == 0) {
			$restock_refund_item = 1;
		}

		$rows = array(
			'customer_id'			=> $refunded_customer_id,
			'order_no'				=> $refunded_order_no,
			'shipping_tracking_id' 	=> $refunded_shipping_tracking_id,
			'old_price'				=> $total_available_refund,
			'new_price'				=> $refund_amount,
			'reson_note'			=> $reson_refund,
			'cart_id'				=> $cart_id,
			'available_to_refund'	=> $total_available_refund - $refund_amount,
			'isRefund'				=> $restock_refund_item,
		);

		// echo "<pre>";
		// print_r($_REQUEST);
		// echo "<pre>";
		// print_r($rows);
		// die;

		$db->insert("refund_order_price", $rows, 0);

		$_SESSION['MSG'] = "Refund_order";
		$db->location(ADMINURL . 'view-' . $page . '/' . $_REQUEST['id'] . '/');
		exit;
	}

	$refund_order_r = $db->getData('refund_order_price', "*", 'cart_id=' . (int) $cart_id . ' AND isDelete=0');
	if (@count($refund_order_r) > 0) {
		$count = 0;
		$already_price_refund = 0;
		foreach ($refund_order_r as $refund_order_d) {
			$count++;
			$already_price_refund = $already_price_refund + $refund_order_d['new_price'];
			$restock_refund_item = $refund_order_d['isRefund'];
		}
	}

	$total_available_to_refund = $row_cart['sub_total'] - $already_price_refund;

	// echo $already_price_refund;
	// die;
	// $row_bs 	= @mysqli_fetch_assoc($refund_order_r);

	// refund process end
} catch (\Throwable $th) {
	cb_logger($th);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
	<?php include('include/css.php'); ?>
</head>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

<body>
	<div class="container-scroller">
		<?php include("include/header.php"); ?>
		<div class="container-fluid page-body-wrapper">
			<?php include("include/left.php"); ?>
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="page-header">
						<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-contacts"></i>
							</span> <?php echo $page_title; ?>
						</h3>
						<?php
						if (!empty($row_cart['shipping_tracking_id']) && !is_null($row_cart['shipping_tracking_id'])) {
						?>
							<div style="float: right;"><a href="<?php echo ADMINURL; ?>track-order/<?php echo $row_cart['id']; ?>/" target="_blank">Track Order</a></div>
						<?php
						}
						?>
					</div>
					<div class="row">
						<!-- <pre><?php echo json_encode($row_cart); ?></pre> -->
						<div class="col-lg-12">
							<div class="card mb-4  border-left-info">
								<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
									<input type="hidden" name="mode" id="mode" value="update">
									<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

									<div class="card-body col-lg-12">
										<div class="row mb-3">
											<!-- <div class="col-md-1"></div> -->
											<!-- 											<div class="col-md-3" style="text-align: right;"><label for="tracking_id">Shipment Tracking ID: </label></div>
											<div class="col-md-3">
												<input type="text" name="tracking_id" id="tracking_id" value="<?php echo $row_cart['shipping_tracking_id']; ?>" placeholder="Tracking ID" class="form-control" readonly>
											</div> -->
											<!-- 											<div class="col-md-2" style="text-align: right;"><label for="order_status">Order Status: </label></div>
											<div class="col-md-3">
												<?php //echo $row_user['order_status']; 
												?>
											</div> -->
											<div class="col-md-1">
												<button type="submit" name="btnsubmit" class="btn btn-gradient-success waves-effect w-md waves-light" title="Update"><i class="mdi mdi-content-save-all" aria-hidden="true"></i></button>
											</div>
										</div>
										<table class="table table-space-admin table-bordered table-striped">
											<tbody>
												<tr>
													<td><strong>Order Number</strong></td>
													<td><?php echo $row_cart['order_no']; ?></td>
													<td><strong>Sub Total</strong></td>
													<td><?php echo CUR . $db->num($row_cart['sub_total']); ?></td>
												</tr>
												<tr>
													<td><strong>Order Date</strong></td>
													<td><?php echo (!is_null($row_cart['order_date'])) ? $db->date($row_cart['order_date'], 'm/d/Y') : $db->date($row_cart['adate'], 'm/d/Y'); ?></td>
													<td><strong>Tax</strong></td>
													<td><?php echo CUR . $db->num($row_cart['tax']); ?></td>
												</tr>
												<tr>
													<td><strong>Order Status</strong></td>
													<td><?php
															/* 						switch ($row_cart['order_status']) {
																			case 0:
																				echo 'Cancelled';
																				break;
																			case 2:
																				echo 'Completed';
																				break;
																			case 3:
																				echo 'Shipped';
																				break;
																			case 4:
																				echo 'Delivered';
																				break;
																			default:
																				echo 'In Progress';
																				break; 
																		} */
															?>
														<select name="order_status" id="order_status" class="form-control inline" onchange="changeStatus(this)">
															<option value="0" <?php if ($row_cart['order_status'] == 0) echo ' selected'; ?>>Cancelled</option>
															<option value="1" <?php if ($row_cart['order_status'] == 1) echo ' selected'; ?>>In Progress</option>
															<option value="2" <?php if ($row_cart['order_status'] == 2) echo ' selected'; ?>>Awaiting Shipment</option>
															<option value="3" <?php if ($row_cart['order_status'] == 3) echo ' selected'; ?>>Shipped</option>
															<option value="4" <?php if ($row_cart['order_status'] == 4) echo ' selected'; ?>>Delivered</option>
															<option value="5" <?php if ($row_cart['order_status'] == 5) echo ' selected'; ?>>Pending Payment</option>
														</select>
													</td>
													<td><strong>Shipping</strong></td>
													<td><input type="text" class="form-control" name="shipping" id="shipping" placeholder="" value="<?php echo $row_cart['shipping']; ?>"></td>
												</tr>
												<tr>
													<td><strong>Shipping Method</strong></td>
													<td><input type="text" class="form-control" name="shipping_method" id="shipping_method" placeholder="" value="<?php echo $row_cart['shipping_method']; ?>"></td>
													<td><strong>Order Amount</strong></td>
													<td><?php echo CUR . $db->num($row_cart['grand_total']); ?></td>
												</tr>
												<tr>
													<td><strong>Payment Method</strong></td>
													<td> <select name="payment_method" id="payment_method" class="form-control inline">
															<option value="PURCHASE ORDER" <?php if ($row_cart['payment_method'] === 'PURCHASE ORDER') echo ' selected'; ?>>PURCHASE ORDER</option>
															<option value="PAYPAL" <?php if ($row_cart['payment_method'] === 'PAYPAL') echo ' selected'; ?>>PAYPAL</option>
															<option value="CARD" <?php if ($row_cart['payment_method'] === 'CARD') echo ' selected'; ?>>CARD</option>
														</select>
													</td>
													<td><strong>Transaction ID</strong></td>
													<td><input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="" value="<?php echo $row_cart['transaction_id']; ?>" <?php echo $row_cart['payment_method'] == 'PURCHASE ORDER' ?  "" : "readonly" ?>></td>
												</tr>
											</tbody>
										</table>

										<table id="user" class="table table-space-admin table-bordered table-striped">
											<tbody>
												<tr>
													<th>Details</th>
													<th>Billing Details</th>
													<th>Shipping Details</th>
												</tr>

												<tr>
													<td>First Name:</td>
													<td><input type="text" class="form-control" name="billing_first_name" id="billing_first_name" placeholder="" value="<?php echo $billing_first_name; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" placeholder="" value="<?php echo $shipping_first_name; ?>"></span></td>
												</tr>
												<tr>
													<td>Last Name:</td>
													<td><input type="text" class="form-control" name="billing_last_name" id="billing_last_name" placeholder="" value="<?php echo $billing_last_name; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name" placeholder="" value="<?php echo $shipping_last_name; ?>"></span></td>
												</tr>
												<tr>
													<td>E-Mail</td>
													<td><input type="text" class="form-control" name="billing_email" id="billing_email" placeholder="" value="<?php echo $billing_email; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_email" id="shipping_email" placeholder="" value="<?php echo $shipping_email; ?>"></span></td>
												</tr>
												<tr>
													<td>Phone</td>
													<td><input type="text" class="form-control" name="billing_phone" id="billing_phone" placeholder="" value="<?php echo $billing_phone; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_phone" id="shipping_phone" placeholder="" value="<?php echo $shipping_phone; ?>"></span></td>
												</tr>
												<tr>
													<td>Address1</td>
													<td><input type="text" class="form-control" name="billing_address" id="billing_address" placeholder="" value="<?php echo $billing_address; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_address" id="shipping_address" placeholder="" value="<?php echo $shipping_address; ?>"></span></td>
												</tr>
												<tr>
													<td>Address2</td>
													<td><input type="text" class="form-control" name="billing_address2" id="billing_address2" placeholder="" value="<?php echo $billing_address2; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_address2" id="shipping_address2" placeholder="" value="<?php echo $shipping_address2; ?>"></span></td>
												</tr>
												<tr>
													<td>City</td>
													<td><input type="text" class="form-control" name="billing_city" id="billing_city" placeholder="" value="<?php echo $billing_city; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_city" id="shipping_city" placeholder="" value="<?php echo $shipping_city; ?>"></span></td>
													<!-- 													<td><span class="text-muted"> <?php echo $billing_city; ?></span></td>
													<td><span class="text-muted"> <?php echo $shipping_city; ?></span></td> -->
												</tr>
												<tr>
													<td>Country</td>
													<td>
														<select class="form-control" aria-required="true" onchange="getState(this.value, 'billing');" name="billing_country" id="billing_country">
															<option value="">Country / Region</option>
															<?php
															$country_d = $db->getData("countries", "*");
															foreach ($country_d as $key => $country_r) {
															?>
																<option value="<?php echo $country_r['id'] ?>" <?php if ($country_r['id'] == $billing_country) {
																																									echo "selected";
																																								} ?>><?php echo $country_r['name']; ?></option>
															<?php
															}
															?>
														</select>
													</td>
													<td>
														<select class="form-control" aria-required="true" onchange="getState(this.value, 'shipping');" name="shipping_country" id="shipping_country">
															<option value="">Country / Region</option>
															<?php
															$country_d = $db->getData("countries", "*");
															foreach ($country_d as $key => $country_r) {
															?>
																<option value="<?php echo $country_r['id'] ?>" <?php if ($country_r['id'] == $shipping_country) {
																																									echo "selected";
																																								} ?>><?php echo $country_r['name']; ?></option>
															<?php
															}
															?>
														</select>
													</td>
													<!-- 												<td><span class="text-muted"> <?php echo $db->getValue('countries', 'name', 'id=' . $billing_country); ?></span></td>
													<td><span class="text-muted"> <?php echo $db->getValue('countries', 'name', 'id=' . $shipping_country); ?></span></td> -->
												</tr>
												<tr>
													<td>Zipcode</td>
													<td><input type="text" class="form-control" name="billing_zipcode" id="billing_zipcode" placeholder="" value="<?php echo $billing_zipcode; ?>"></span></td>
													<td><input type="text" class="form-control" name="shipping_zipcode" id="shipping_zipcode" placeholder="" value="<?php echo $shipping_zipcode; ?>"></span></td>
												</tr>
												<tr>
													<td>State</td>
													<td> <select name="billing_state" id="billing_state" class="form-control">
															<option value="">State</option>
														</select>
													</td>
													<td>
														<select name="shipping_state" id="shipping_state" class="form-control">
															<option value="">State</option>
														</select>
													</td>
												</tr>
											</tbody>
										</table>
										<!-- Products -->
										<div class="table-wrapper">
											<div class="table-title">
												<div class="row">
													<div class="col-6">
														<h2><b>Products</b></h2>
													</div>
													<div class="col-6">
														<a href="" class="btn btn-success" data-toggle="modal" onclick="addProduct();"><i class="mdi mdi-plus"></i> <span>Add Order Product</span></a>
														<!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="mdi mdi-delete"></i> <span>Delete</span></a> -->
													</div>
												</div>
											</div>
											<table class=" table table-space-admin table-bordered">
												<thead>
													<tr>
														<th class="text-center">#</th>
														<th class="text-center">Image</th>
														<th>Product Name</th>
														<th class="text-center">Quantity</th>
														<!-- <th class="text-center">Tax</th> -->
														<th class="text-center">Price Per Unit</th>
														<th class="text-center">Total</th>
														<th class="text-center"></th>
													</tr>
												</thead>
												<tbody>
													<?php
													$counter = 0;
													$strquery = 'SELECT ct.*, p.name AS product_name, p.image , p.code AS product_sku
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
															<td class="text-center"><?php echo $counter; ?></td>
															<td class="text-center"><img src="<?php echo SITEURL . PRODUCT . $row_detail['image']; ?>" class="img-fluid" width="70"></td>
															<td><?php echo $row_detail['product_name']; ?>
																	<p class="small">SKU: <?php echo $row_detail['product_sku']; ?></p>
															</td>
															<td class="text-center"><?php echo $row_detail['qty']; ?></td>
															<!-- <td class="text-center"><?php echo CUR . $db->num($tax); ?></td> -->
															<td class="text-center"><?php echo CUR . $row_detail['price']; ?></td>
															<td class="text-center"><?php echo CUR . $db->num($row_detail['sub_total']); ?></td>
															<td class="text-center">
																<!-- 									<a href="<?php echo ADMINURL; ?>view-<?php echo $page; ?>/<?php echo $ctable_d['id']; ?>/" title="View"><i class="mdi mdi-pencil text-warning"></i></a> -->
																<a href="javascript:void(0)" onclick="editOrderProduct(<?php echo $row_detail['id']; ?>, <?php echo $db->num($row_detail['sub_total']); ?>, <?php echo $row_detail['qty']; ?>, <?php echo $row_detail['price']; ?>)" title="Edit"><i class="mdi mdi-pencil text-warning"></i></a>
																<a href="javascript:void(0)" onclick="removeItem(<?php echo $row_detail['id']; ?>)" title="DELETE"><i class="mdi mdi-delete text-danger"></i></a>
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
										<!-- Products End -->


										<!-- Notes -->
										<?php
										$notes = $db->getData("notes", "*", "cart_id=$cart_id");
										?>
										<div id="notes" style="background: #edf1f5;">
											<div class="page-content container note-has-grid pt-5">
												<ul class="nav nav-pills p-3 bg-white mb-3 rounded-pill align-items-center">
													<li class="nav-item">
														<a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2 active" id="all-category">
															<i class="icon-layers mr-1"></i><span class="d-none d-md-block">All Notes</span>
														</a>
													</li>
													<!-- 													<li class="nav-item">
														<a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-business"> <i class="icon-briefcase mr-1"></i><span class="d-none d-md-block">Business</span></a>
													</li>
													<li class="nav-item">
														<a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-social"> <i class="icon-share-alt mr-1"></i><span class="d-none d-md-block">Social</span></a>
													</li>
													<li class="nav-item">
														<a href="javascript:void(0)" class="nav-link rounded-pill note-link d-flex align-items-center px-2 px-md-3 mr-0 mr-md-2" id="note-important"> <i class="icon-tag mr-1"></i><span class="d-none d-md-block">Important</span></a>
													</li> -->
													<li class="nav-item ml-auto">
														<a href="javascript:void(0)" class="nav-link btn-primary rounded-pill d-flex align-items-center px-3" id="add-notes" onclick="openAddNotesModal();"> <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Add
																Notes</span></a>
													</li>
												</ul>
												<div class="tab-content bg-transparent">
													<div id="note-full-container" class="note-has-grid row">
														<!-- Loop Starts Here for notes -->
														<?php
														foreach ($notes as $key => $note) {
														?>
															<div class="col-md-4 single-note-item all-category note-business">
																<div class="card card-body">
																	<span class="side-stick"></span>
																	<h5 class="note-title text-truncate w-75 mb-0" data-noteheading="<?php echo $note['title'] ?>"> <?php echo $note['title'] ?> <i class="point fa fa-circle ml-1 font-10"></i></h5>
																	<p class="note-date font-12 text-muted"></p>
																	<div class="note-content">
																		<p class="note-inner-content text-muted" data-notecontent=" <?php echo $note['description'] ?>">
																			<?php echo $note['description'] ?></p>
																	</div>
																	<div class="d-flex align-items-center">
																		<span class="mr-1"><i class="fa fa-star favourite-note text-warning"></i></span>
																		<span class="mr-1"><i class="fa fa-trash remove-note text-danger" title="DELETE" onclick="deleteNote(<?php echo $note['id'] ?>)"></i></span>
																		<!-- 																		<div class="ml-auto">
																			<div class="category-selector btn-group">
																				<a class="nav-link dropdown-toggle category-dropdown label-group p-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="true">
																					<div class="category">
																						<div class="category-business"></div>
																						<div class="category-social"></div>
																						<div class="category-important"></div>
																						<span class="more-options text-dark"><i class="icon-options-vertical"></i></span>
																					</div>
																				</a>
																				<div class="dropdown-menu dropdown-menu-right category-menu">
																					<a class="note-business badge-group-item badge-business dropdown-item position-relative category-business text-success" href="javascript:void(0);">
																						<i class="mdi mdi-checkbox-blank-circle-outline mr-1"></i>Business
																					</a>
																					<a class="note-social badge-group-item badge-social dropdown-item position-relative category-social text-info" href="javascript:void(0);">
																						<i class="mdi mdi-checkbox-blank-circle-outline mr-1"></i> Social
																					</a>
																					<a class="note-important badge-group-item badge-important dropdown-item position-relative category-important text-danger" href="javascript:void(0);">
																						<i class="mdi mdi-checkbox-blank-circle-outline mr-1"></i> Important
																					</a>
																				</div>
																			</div>
																		</div> -->
																	</div>
																</div>
															</div>
														<?php
														}
														?>
														<!-- Loop Ends Here for notes -->
													</div>
												</div>
											</div>
										</div>
										<!-- Notes ENd -->
										<div class="box-footer pt-5">
											<button type="button" class="btn btn-gradient-light waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL . 'manage-' . $page . '/';
																																																																				?>'" title="Back"><i class="mdi mdi-step-backward" aria-hidden="true"></i></button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php if ($refund) { ?>
						<div class="page-header">
							<h3 class="page-title">
								<!-- <span class="page-title-icon bg-gradient-dark text-white mr-2">
									<i class="mdi mdi-contacts"></i>
								</span>  -->
								Refund
							</h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
									<form class="forms-sample" role="form" id="frm_refund" name="frm_refund" action="." method="post" enctype="multipart/form-data">

										<input type="hidden" class="form-control" name="refunded_customer_id" id="refunded_customer_id" placeholder="customer_id" value="<?php echo $customer_id; ?>" readonly>
										<input type="hidden" class="form-control" name="refunded_order_no" id="refunded_order_no" placeholder="order_no" value="<?php echo $order_no; ?>" readonly>
										<input type="hidden" class="form-control" name="refunded_shipping_tracking_id" id="refunded_shipping_tracking_id" placeholder="shipping_tracking_id" value="<?php echo $shipping_tracking_id; ?>" readonly>

										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group mb-2">
														<div class="button-list">
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="restock_refund_item" id="restock_refund_item" value="1" <?php if ($restock_refund_item == "1") {
																																																												echo "checked";
																																																											} ?> />
																<label for="restock_refund_item" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> Restock refunded items ? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="already_refunded"> Amount already refunded </label>
														<input type="text" class="form-control" name="already_refunded" id="already_refunded" placeholder=" -$0.00 " value="<?php echo $already_price_refund; ?>" readonly>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="total_available_refund"> Total available to refund </label>
														<input type="text" class="form-control" name="total_available_refund" id="total_available_refund" placeholder="" value="<?php echo $total_available_to_refund; ?>" readonly>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="refund_amount"> Refund amount <code>*</code></label>
														<input type="text" class="form-control" name="refund_amount" id="refund_amount" placeholder="" value="">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="reson_refund"> Reason for refund (optional) </label>
														<input type="text" class="form-control" name="reson_refund" id="reson_refund" placeholder="" value="<?php echo $reson_refund; ?>">
													</div>
												</div>
												<div class="col-md-6"></div>
												<div class="col-md-3">
													<div class="form-group">
														<button type="submit" name="refund_manually" id="refund_manually" title="Submit" class="btn btn-gradient-success btn-icon-text"> Refund </button>
													</div>
												</div>
												<!-- <div class="col-md-3">
													<div class="form-group">
														<button type="submit" name="refiund_via_auth" id="refiund_via_auth" title="Submit" class="btn btn-gradient-success btn-icon-text" style="pointer-events: none;"> Refund $0.00 via Authorize.Net </button>
													</div>
												</div> -->

											</div>
											<div class="box-footer">
												<button type="button" class="btn btn-gradient-light waves-effect w-md waves-light" onClick="window.location.href='<?php echo ADMINURL . 'manage-' . $page . '/'; ?>'" title="Back"><i class="mdi mdi-step-backward" aria-hidden="true"></i></button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					<?php }; ?>
				</div>
				<!-- content-wrapper ends -->
				<?php include("include/footer.php"); ?>
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
		<!-- modal loading start -->
		<div id="loader" class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" style="width: 48px">
					<div class="spinner-border text-primary" role="status">
						<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>
		<!-- modal loading ends -->

		<!-- Add Modal HTML -->
		<div id="addProductModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<form>
						<div class="modal-header">
							<h4 class="modal-title">Add Product</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						</div>
						<div class="modal-body" style="height: 500px;overflow-y: auto;">
							<table class="table table-image">
								<thead>
									<tr>
										<!-- 	<th scope="col"></th> -->
										<th scope="col">Product</th>
										<th scope="col">Price</th>
										<!-- 										<th scope="col">Qty</th> -->
										<!-- 										<th scope="col">Total</th> -->
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!-- 										<td class="w-25">
											<img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/vans.png" class="img-fluid img-thumbnail" alt="Sheep">
										</td> -->
										<td>Vans Sk8-Hi MTE Shoes</td>
										<td>89$</td>
										<!-- 										<td class="qty"><input type="text" class="form-control" id="input1" value="2"></td> -->
										<!-- <td>178$</td> -->
										<td>
											<a href="#" class="btn btn-info btn-sm">
												<span>SELECT</span>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<!-- 							<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
							<input type="submit" class="btn btn-success" value="Add"> -->
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Add Modal HTML -->

		<!-- Edit Modal Start -->

		<div id="editProductModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Edit Product</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body" style="overflow-y: auto;">
						<table class="table table-image">
							<thead>
								<tr>
									<!-- 	<th scope="col"></th> -->
									<th scope="col">Product</th>
									<th scope="col">Price</th>
									<!-- 										<th scope="col">Qty</th> -->
									<!-- 										<th scope="col">Total</th> -->
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<!-- 										<td class="w-25">
											<img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/vans.png" class="img-fluid img-thumbnail" alt="Sheep">
										</td> -->
									<td>Vans Sk8-Hi MTE Shoes</td>
									<td>89$</td>
									<!-- 										<td class="qty"><input type="text" class="form-control" id="input1" value="2"></td> -->
									<!-- <td>178$</td> -->
									<td>
										<a href="#" class="btn btn-info btn-sm">
											<span>SELECT</span>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Edit Modal End -->

		<!-- Delete Modal -->
		<div class="modal fade" id="deleteModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">DELETE</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
		<!-- Delete Modal -->

		<!-- Modal Add notes -->
		<div class="modal fade" id="addnotesmodal" tabindex="-1" role="dialog" aria-labelledby="addnotesmodalTitle" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content border-0">
					<div class="modal-header bg-info text-white">
						<h5 class="modal-title text-white">Add Notes</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">X</span>
						</button>
					</div>
					<form id="addNoteForm">
						<div class="modal-body">
							<div class="notes-box">
								<div class="notes-content">
									<form action="javascript:void(0);" id="addnotesmodalTitle">
										<div class="row">
											<div class="col-md-12 mb-3">
												<div class="note-title">
													<label>Note Title</label>
													<input type="hidden" name="cart_id" value="<?= $cart_id; ?>">
													<input type="text" name="note_title" class="form-control" minlength="25" placeholder="Title" />
												</div>
											</div>

											<div class="col-md-12">
												<div class="note-description">
													<label>Note Description</label>
													<textarea name="note_description" class="form-control" minlength="100" placeholder="Description" rows="3"></textarea>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</form>
					<div class="modal-footer">
						<button id="btn-n-save" class="float-left btn btn-success" style="display: none;">Save</button>
						<button class="btn btn-danger" data-dismiss="modal">Discard</button>
						<button id="btn-n-add" class="btn btn-info" onclick="saveNote()">Add</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Modal Add notes -->

	</div>
	<?php include('include/js.php'); ?>
	<script src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js" type="text/javascript"></script>
	<style>
		.bd-example-modal-lg .modal-dialog {
			display: table;
			position: relative;
			margin: 0 auto;
			top: calc(50% - 24px);
		}

		.bd-example-modal-lg .modal-dialog .modal-content {
			background-color: transparent;
			border: none;
		}

		.table-title {
			padding-bottom: 15px;
			background: #435d7d;
			color: #fff;
			padding: 16px 30px;
			margin: -20px -25px 10px;
			border-radius: 3px 3px 0 0;
		}

		.table-title h2 {
			margin: 5px 0 0;
			font-size: 24px;
		}

		.table-title .btn-group {
			float: right;
		}

		.table-title .btn {
			color: #fff;
			float: right;
			font-size: 13px;
			border: none;
			min-width: 50px;
			border-radius: 2px;
			border: none;
			outline: none !important;
			margin-left: 10px;
		}

		.table-title .btn i {
			float: left;
			font-size: 21px;
			margin-right: 5px;
		}

		.table-title .btn span {
			float: left;
			margin-top: 2px;
		}

		.table-wrapper {
			min-width: 1000px;
			background: #fff;
			padding: 20px 25px;
			border-radius: 3px;
			box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
		}

		body {
			background: #edf1f5;
			margin-top: 20px;
		}

		.card {
			position: relative;
			display: flex;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 0 solid transparent;
			border-radius: 0;
		}

		.card {
			margin-bottom: 30px;
		}

		.card-body {
			flex: 1 1 auto;
			padding: 1.57rem;
		}

		.note-has-grid .nav-link {
			padding: .5rem
		}

		.note-has-grid .single-note-item .card {
			border-radius: 10px
		}

		.note-has-grid .single-note-item .favourite-note {
			cursor: pointer
		}

		.note-has-grid .single-note-item .side-stick {
			position: absolute;
			width: 3px;
			height: 35px;
			left: 0;
			background-color: rgba(82, 95, 127, .5)
		}

		.note-has-grid .single-note-item .category-dropdown.dropdown-toggle:after {
			display: none
		}

		.note-has-grid .single-note-item .category [class*=category-] {
			height: 15px;
			width: 15px;
			display: none
		}

		.note-has-grid .single-note-item .category [class*=category-]::after {
			content: "\f0d7";
			font: normal normal normal 14px/1 FontAwesome;
			font-size: 12px;
			color: #fff;
			position: absolute
		}

		.note-has-grid .single-note-item .category .category-business {
			background-color: rgba(44, 208, 126, .5);
			border: 2px solid #2cd07e
		}

		.note-has-grid .single-note-item .category .category-social {
			background-color: rgba(44, 171, 227, .5);
			border: 2px solid #2cabe3
		}

		.note-has-grid .single-note-item .category .category-important {
			background-color: rgba(255, 80, 80, .5);
			border: 2px solid #ff5050
		}

		.note-has-grid .single-note-item.all-category .point {
			color: rgba(82, 95, 127, .5)
		}

		.note-has-grid .single-note-item.note-business .point {
			color: rgba(44, 208, 126, .5)
		}

		.note-has-grid .single-note-item.note-business .side-stick {
			background-color: rgba(44, 208, 126, .5)
		}

		.note-has-grid .single-note-item.note-business .category .category-business {
			display: inline-block
		}

		.note-has-grid .single-note-item.note-favourite .favourite-note {
			color: #ffc107
		}

		.note-has-grid .single-note-item.note-social .point {
			color: rgba(44, 171, 227, .5)
		}

		.note-has-grid .single-note-item.note-social .side-stick {
			background-color: rgba(44, 171, 227, .5)
		}

		.note-has-grid .single-note-item.note-social .category .category-social {
			display: inline-block
		}

		.note-has-grid .single-note-item.note-important .point {
			color: rgba(255, 80, 80, .5)
		}

		.note-has-grid .single-note-item.note-important .side-stick {
			background-color: rgba(255, 80, 80, .5)
		}

		.note-has-grid .single-note-item.note-important .category .category-important {
			display: inline-block
		}

		.note-has-grid .single-note-item.all-category .more-options,
		.note-has-grid .single-note-item.all-category.note-favourite .more-options {
			display: block
		}

		.note-has-grid .single-note-item.all-category.note-business .more-options,
		.note-has-grid .single-note-item.all-category.note-favourite.note-business .more-options,
		.note-has-grid .single-note-item.all-category.note-favourite.note-important .more-options,
		.note-has-grid .single-note-item.all-category.note-favourite.note-social .more-options,
		.note-has-grid .single-note-item.all-category.note-important .more-options,
		.note-has-grid .single-note-item.all-category.note-social .more-options {
			display: none
		}

		@media (max-width:767.98px) {
			.note-has-grid .single-note-item {
				max-width: 100%
			}
		}

		@media (max-width:991.98px) {
			.note-has-grid .single-note-item {
				max-width: 216px
			}
		}
	</style>
	<script>
		// load jquery
		$(document).ready(function() {
			try {
				let shipping_country = <?= $billing_country ?: "" ?>,
					billing_country = <?= $billing_country ?: "" ?>

				getState(shipping_country, 'shipping');
				getState(billing_country, 'billing');
			} catch (error) {
				console.log(error)
			}

			$("#payment_method").on('change', function() {
				let payment_value = $(this).val();
				if (payment_value == 'PURCHASE ORDER') {
					$('#transaction_id').prop("readonly", false)
				}
			});

		});
		$(function() {

		});

		function modal() {
			$('#modal').modal('show');
			setTimeout(function() {
				$('.modal').modal('hide');
			}, 3000);
		}
		$.validator.addMethod('le', function(value, element, param) {
			return this.optional(element) || parseFloat(value) <= parseFloat($(param).val());
		}, 'Invalid value');

		$("#frm_refund").validate({
			// ignore: "",
			rules: {
				refund_amount: {
					required: true,
					number: true,
					le: '#total_available_refund'
				},
			},
			messages: {
				refund_amount: {
					required: "Please enter refund amount.",
					number: "Please enter amount as a numerical value",
					le: 'Must be less than refund price.'
				},

			},
			errorPlacement: function(error, element) {
				if (element.attr("name") == "filename")
					error.insertAfter("#dropzone_img");
				else
					error.insertAfter(element);
			}
		});

		$('[name="refund_amount"]').on('change blur keyup', function() {
			$('[name="total_available_refund"]').valid();
		});

		function getUsZipCode(zipCode) {
			let stateCode = '';
			zipCode = parseFloat(zipCode);
			if (zipCode >= 35000 && zipCode <= 36999) {
				$('#shipping_state').val('1456')
				stateCode = 'AL';
			} else if (zipCode >= 99500 && zipCode <= 99999) {
				$('#shipping_state').val('1400')
				stateCode = 'AK';
			} else if (zipCode >= 85000 && zipCode <= 86999) {
				$('#shipping_state').val('1434')
				stateCode = 'AZ';
			} else if (zipCode >= 71600 && zipCode <= 72999) {
				$('#shipping_state').val('1444')
				stateCode = 'AR';
			} else if (zipCode >= 90000 && zipCode <= 96699) {
				$('#shipping_state').val('1416')
				stateCode = 'CA';
			} else if (zipCode >= 80000 && zipCode <= 81999) {
				$('#shipping_state').val('1450')
				stateCode = 'CO';
			} else if ((zipCode >= 6000 && zipCode <= 6389) || (zipCode >= 6391 && zipCode <= 6999)) {
				$('#shipping_state').val('1435')
				stateCode = 'CT';
			} else if (zipCode >= 19700 && zipCode <= 19999) {
				$('#shipping_state').val('1399')
				stateCode = 'DE';
			} else if (zipCode >= 32000 && zipCode <= 34999) {
				$('#shipping_state').val('1436')
				stateCode = 'FL';
			} else if ((zipCode >= 30000 && zipCode <= 31999) || (zipCode >= 39800 && zipCode <= 39999)) {
				$('#shipping_state').val('1455')
				stateCode = 'GA';
			} else if (zipCode >= 96700 && zipCode <= 96999) {
				$('#shipping_state').val('1411')
				stateCode = 'HI';
			} else if (zipCode >= 83200 && zipCode <= 83999) {
				$('#shipping_state').val('1460')
				stateCode = 'ID';
			} else if (zipCode >= 60000 && zipCode <= 62999) {
				$('#shipping_state').val('1425')
				stateCode = 'IL';
			} else if (zipCode >= 46000 && zipCode <= 47999) {
				$('#shipping_state').val('1440')
				stateCode = 'IN';
			} else if (zipCode >= 50000 && zipCode <= 52999) {
				$('#shipping_state').val('1459')
				stateCode = 'IA';
			} else if (zipCode >= 66000 && zipCode <= 67999) {
				$('#shipping_state').val('1406')
				stateCode = 'KS';
			} else if (zipCode >= 40000 && zipCode <= 42999) {
				$('#shipping_state').val('1419')
				stateCode = 'KY';
			} else if (zipCode >= 70000 && zipCode <= 71599) {
				$('#shipping_state').val('1457')
				stateCode = 'LA';
			} else if (zipCode >= 3900 && zipCode <= 4999) {
				$('#shipping_state').val('1453')
				stateCode = 'ME';
			} else if (zipCode >= 20600 && zipCode <= 21999) {
				$('#shipping_state').val('1401')
				stateCode = 'MD';
			} else if ((zipCode >= 1000 && zipCode <= 2799) || (zipCode >= 5501 && zipCode <= 5544)) {
				$('#shipping_state').val('1433')
				stateCode = 'MA';
			} else if (zipCode >= 48000 && zipCode <= 49999) {
				$('#shipping_state').val('1426')
				stateCode = 'MI';
			} else if (zipCode >= 55000 && zipCode <= 56899) {
				$('#shipping_state').val('1420')
				stateCode = 'MN';
			} else if (zipCode >= 38600 && zipCode <= 39999) {
				$('#shipping_state').val('1430')
				stateCode = 'MS';
			} else if (zipCode >= 63000 && zipCode <= 65999) {
				$('#shipping_state').val('1451')
				stateCode = 'MO';
			} else if (zipCode >= 59000 && zipCode <= 59999) {
				$('#shipping_state').val('1446')
				stateCode = 'MT';
			} else if (zipCode >= 27000 && zipCode <= 28999) {
				$('#shipping_state').val('1447')
				stateCode = 'NC';
			} else if (zipCode >= 58000 && zipCode <= 58999) {
				$('#shipping_state').val('1418')
				stateCode = 'ND';
			} else if (zipCode >= 68000 && zipCode <= 69999) {
				$('#shipping_state').val('1408')
				stateCode = 'NE';
			} else if (zipCode >= 88900 && zipCode <= 89999) {
				$('#shipping_state').val('1458')
				stateCode = 'NV';
			} else if (zipCode >= 3000 && zipCode <= 3899) {
				$('#shipping_state').val('1404')
				stateCode = 'NH';
			} else if (zipCode >= 7000 && zipCode <= 8999) {
				$('#shipping_state').val('1417')
				stateCode = 'NJ';
			} else if (zipCode >= 87000 && zipCode <= 88499) {
				$('#shipping_state').val('1423')
				stateCode = 'NM';
			} else if ((zipCode >= 10000 && zipCode <= 14999) || zipCode == 6390 || zipCode <= 501 || zipCode <= 544) {
				$('#shipping_state').val('1452')
				stateCode = 'NY';
			} else if (zipCode >= 43000 && zipCode <= 45999) {
				$('#shipping_state').val('4851')
				stateCode = 'OH';
			} else if ((zipCode >= 73000 && zipCode <= 73199) || (zipCode >= 73400 && zipCode <= 74999)) {
				$('#shipping_state').val('1421')
				stateCode = 'OK';
			} else if (zipCode >= 97000 && zipCode <= 97999) {
				$('#shipping_state').val('1415')
				stateCode = 'OR';
			} else if (zipCode >= 15000 && zipCode <= 19699) {
				$('#shipping_state').val('1422')
				stateCode = 'PA';
			} else if (zipCode >= 300 && zipCode <= 999) {
				$('#shipping_state').val('0')
			} else if (zipCode >= 2800 && zipCode <= 2999) {
				$('#shipping_state').val('1461')
				stateCode = 'RI';
			} else if (zipCode >= 29000 && zipCode <= 29999) {
				$('#shipping_state').val('1443')
				stateCode = 'SC';
			} else if (zipCode >= 57000 && zipCode <= 57999) {
				$('#shipping_state').val('1445')
				stateCode = 'SD';
			} else if (zipCode >= 37000 && zipCode <= 38599) {
				$('#shipping_state').val('1454')
				stateCode = 'TN';
			} else if ((zipCode >= 75000 && zipCode <= 79999) || (zipCode >= 73301 && zipCode <= 73399) || (zipCode >= 88500 && zipCode <= 88599)) {
				$('#shipping_state').val('1407')
				stateCode = 'TX';
			} else if (zipCode >= 84000 && zipCode <= 84999) {
				$('#shipping_state').val('1414')
				stateCode = 'UT';
			} else if (zipCode >= 5000 && zipCode <= 5999) {
				$('#shipping_state').val('1409')
				stateCode = 'VT';
			} else if ((zipCode >= 20100 && zipCode <= 20199) || (zipCode >= 22000 && zipCode <= 24699) || zipCode == 20598) {
				$('#shipping_state').val('1427')
				stateCode = 'VA';
			} else if ((zipCode >= 20000 && zipCode <= 20099) || (zipCode >= 20200 && zipCode <= 20599) || zipCode == 56900 || zipCode == 56999) {
				$('#shipping_state').val('0')
			} else if (zipCode >= 98000 && zipCode <= 99499) {
				$('#shipping_state').val('1462')
				stateCode = 'WA';
			} else if (zipCode >= 24700 && zipCode <= 26999) {
				$('#shipping_state').val('1429')
				stateCode = 'WV';
			} else if (zipCode >= 53000 && zipCode <= 54999) {
				$('#shipping_state').val('1441')
				stateCode = 'WI';
			} else if (zipCode >= 82000 && zipCode <= 83199) {
				$('#shipping_state').val('1442')
				stateCode = 'WY';
			}
			return stateCode;
		}

		function getState(country_id, shipping_billing) {

			if (country_id == 0 || country_id == '') {
				$('#shipping_country').css('color', 'grey');
			}
			let state = '';
			switch (shipping_billing) {
				case 'shipping':
					state = <?= json_encode($shipping_state) ?>;
					break;
				case 'billing':
					state = <?= json_encode($billing_state) ?>;
				default:
					break;
			}

			$.ajax({
				type: "POST",
				url: "<?php echo SITEURL; ?>ajax_state.php",
				data: {
					country_id: country_id,
					shipping_state: state
				},
				success: function(options) {
					$(`#${shipping_billing}_state`).html(options === "" ? "<option value=''>State</option>" : options);
				}
			});
		}

		function changeStatus(el) {
			try {
				let cart_id = <?= $cart_id; ?>;
				let status = el.value;
				let sendTo = "<?= $billing_email ?: $shipping_email; ?>";
				if (!sendTo) {
					$.notify({
						message: 'billing/shipping email is not defined.'
					}, {
						type: 'danger'
					});
				}
				$('#loader').modal('show');
				$.ajax({
					type: "GET",
					dataType: "json",
					url: `<?php echo SITEURL ?>ajax_send_email.php?cart_id=${cart_id}&template=${status}&sendTo=${sendTo}`,
					success: function(data) {
						setTimeout(function() {
							$('#loader').modal('hide');
						}, 3000);
						if (data.ok) {
							$.notify({
								message: 'Updated successfully!'
							}, {
								type: 'success'
							});
						} else {
							$.notify({
								message: 'sending failed'
							}, {
								type: 'danger'
							});
						}
					}
				});
			} catch (error) {
				console.log(error)
			}
		}

		function addProduct() {
			try {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: `<?php echo SITEURL ?>api/get_products.php`,
					success: function(res) {
						if (res.ok) {
							let index = 0
							let table_data = `
									<div class='table-responsive'>
										<table class='table table-image'> <thead>
										<tr>
											<th scope = "col">Image</th>
											<th scope = "col">Name</th>
											<th scope = "col">Qty</th> 
											<th scope = "col">Price</th> 
											<th scope = "col">Actions</th> 
										</tr> 
										</thead><tbody>`;

							res.data.forEach(element => {
								let name = element.name.substring(0, 30)
								let qty = 1
								table_data += `
							<tr>
							<td class="text-center"><img src="<?php echo SITEURL . PRODUCT; ?>${element.image}" class="img-fluid" width="50"></td>
								<td style="font-size: 8px;">${name} <p style="font-size: 8px;">${element.sku}</p></td>
								<td><input style="width:30px;" value="${qty}" id="qtyInput-${index}"></td>
								<td style="font-size: 8px;">$${element.price}</td> 
								<td>
									<a href ="javascript:void(0)" class ='btn btn-info btn-xs' onclick="selectOrderProduct(${element.id}, ${element.price}, ${index})"><span> SELECT </span> </a> 
								</td> 
							</tr>`
								index++;
							});

							table_data += `
							</tbody> 
							</table></div>`;

							$('#addProductModal .modal-body').html(table_data);
							$('#addProductModal').modal('show');
						} else {

						}
					}
				});
			} catch (error) {
				console.log(error)
			}

		}

		function selectOrderProduct(product_id, price, index) {
			let qty = $(`#qtyInput-${index}`).val()
			let sendInfo = {
				product_id: product_id,
				price: price.toFixed(2),
				qty: qty,
				cart_id: <?php echo $cart_id; ?>
			}

			$.ajax({
				type: 'post',
				url: `<?php echo SITEURL ?>api/add_order_product.php`,
				data: JSON.stringify(sendInfo),
				contentType: "application/json; charset=utf-8",
				traditional: true,
				success: function(data) {
					$('#addProductModal').modal('hide');
					location.reload()
				}
			});
		}

		function editOrderProduct(id, total, qty, ppm) {
			let cart_id = <?= $cart_id; ?>;
			let table_data = `
				<form id="editOrderProductForm">
					<div class="card">
						<div class="card-body">
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Quantity</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="hidden" name="cart_id" value="${cart_id}">
									<input type="hidden" name="id" value="${id}">
									<input type="text" id="inputQty" class="form-control" name="quantity" value="${qty}" onchange="multiply(this.value, ${ppm})" >
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<h6 class="mb-0">Total</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" id="inputTotal" class="form-control" name="total" value="${total}">
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="updateOrderProduct()">Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			`
			$('#editProductModal .modal-body').html(table_data);
			$('#editProductModal').modal('show');
		}

		const updateOrderProduct = () => {
			try {
				$.ajax({
					url: "<?php echo SITEURL; ?>/api/update_order_product.php",
					type: "post",
					dataType: 'json',
					data: $('#editOrderProductForm').serialize(),
					success: function(response) {
						if (response.ok) {
							$('#editProductModal').modal('hide');
							location.reload()
						} else {
							$('#editProductModal').modal('hide');
						}
					}
				});

			} catch (error) {
				console.log(`updateOrderProduct : ${error}`)
			}
		}

		function multiply(inputQty, ppm) {
			document.getElementById('inputTotal').value = (inputQty * ppm).toFixed(2);
			console.log(inputTotal)
		}

		function deleteProduct(id, cart_id) {
			try {
				$.ajax({
					url: "<?php echo SITEURL; ?>/api/delete_order_product.php",
					type: "post",
					dataType: 'json',
					data: `cart_detail_id=${id}&cart_id=${cart_id}`,
					success: function(response) {
						if (response.ok) {
							$('#deleteModal').modal('hide');
							location.reload()
						} else {
							$('#deleteModal').modal('hide');
							$.notify({
								message: 'failed'
							}, {
								type: 'danger'
							});

						}
					}
				});

			} catch (error) {
				console.log(`updateOrderProduct : ${error}`)
			}
		}

		const removeItem = (id) => {
			let cart_id = <?= $cart_id; ?>;
			let table_data = `
				<p>Are you sure you want to delete?</p>
				<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
						<button type="button" class="btn btn-danger" onclick="deleteProduct(${id}, ${cart_id})">Yes</button>
				</div>
			`
			$('#deleteModal .modal-body').html(table_data);
			$('#deleteModal').modal('show');
		}
		const openAddNotesModal = () => {
			$('#addnotesmodal').modal('show')
		}

		const saveNote = () => {
			try {
				$.ajax({
					url: "<?php echo SITEURL; ?>/api/add_note.php",
					type: "post",
					dataType: 'json',
					data: $('#addNoteForm').serialize(),
					success: function(response) {
						if (response.ok) {
							$('#addnotesmodal').modal('hide');
							$.notify({
								message: 'Updated successfully!'
							}, {
								type: 'success'
							});
							location.reload()
						} else {
							$('#addnotesmodal').modal('hide');
						}
					}
				});

			} catch (error) {
				console.log(`saveNote : ${error}`)
			}
		}

		const deleteNote = (id) => {
			try {
				$.ajax({
					url: "<?php echo SITEURL; ?>/api/delete_note.php",
					type: "post",
					dataType: 'json',
					data: `id=${id}`,
					success: function(response) {
						if (response.ok) {
							location.reload()
						} else {
							$.notify({
								message: 'failed'
							}, {
								type: 'danger'
							});

						}
					}
				});

			} catch (error) {
				console.log(`deleteNote : ${error}`)
			}
		}
	</script>
</body>

</html>