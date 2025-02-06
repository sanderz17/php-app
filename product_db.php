<?php
include('connect.php');

$mode = $_REQUEST['mode'];

if ($mode == 'add_general') {
	$product_id = $_REQUEST['product_id'];
	$price = $_REQUEST['price'];
	$qty = 1;

	if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']))
		$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
	else
		$user_id = 0;

	$get_tot_qty_count = $db->getValue("product", "quantity", "isDelete=0 AND id='" . $product_id . "' ");
	$get_stock_qty_count = $db->getValue("product", "cal_qty", "isDelete=0 AND id='" . $product_id . "' ");

	/* 	if ($get_stock_qty_count == $get_tot_qty_count) {
		$data = array(
			"zero"     => 2
		);
		echo json_encode($data);
	} elseif ($get_tot_qty_count >= $qty) {
		$db->add_to_cart($user_id, $product_id, $price, $qty);

		$tot_stock_qty = $get_stock_qty_count + $qty;

		$qty_arr = array("cal_qty" => $tot_stock_qty);

		$db->update("product", $qty_arr, "id='" . $product_id . "' ");
		// echo "1";
		$data = array(
			"zero"     => 1
		);
		echo json_encode($data);
	} else {

		$data = array(
			"zero"     => 0,
			"pro_qty"  => $get_tot_qty_count
		);
		echo json_encode($data);
	} */
	$db->add_to_cart($user_id, $product_id, $price, $qty);
}

if ($mode == 'add_to_cart') {
	$product_id = $_REQUEST['product_id'];
	$qty = $_REQUEST['qty'];
	$price = $_REQUEST['price'];
	$color = $_REQUEST['color'] ?? "";

	if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']))
		$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
	else
		$user_id = 0;
	$db->add_to_cart($user_id, $product_id, $price, $qty, $color);
	/* 	try {
		cb_logger('add_to_cart');
		$product_id = $_REQUEST['product_id'];
		$qty = $_REQUEST['qty'];
		$price = $_REQUEST['price'];

		if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']))
			$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
		else
			$user_id = 0;

		$get_tot_qty_count = $db->getValue("product", "quantity", "isDelete=0 AND id='" . $product_id . "' ");
		$get_stock_qty_count = $db->getValue("product", "cal_qty", "isDelete=0 AND id='" . $product_id . "' ");

		if ($get_stock_qty_count == $get_tot_qty_count) {
			$data = array(
				"zero"     => 2
			);
			echo json_encode($data);
		} elseif ($get_tot_qty_count >= $qty) {
			cb_logger('have stocks');
			cb_logger('user_id=' . $user_id . ' product_id=' . $product_id . ' price=' . $price . ' qty=' . $qty);
			$db->add_to_cart($user_id, $product_id, $price, $qty);
			$tot_stock_qty = $get_stock_qty_count + $qty;

			$qty_arr = array("cal_qty" => $tot_stock_qty);

			$db->update("product", $qty_arr, "id='" . $product_id . "' ");
			// echo "1";
			$data = array(
				"zero"     => 1
			);
			echo json_encode($data);
		} else {

			$data = array(
				"zero"     => 0,
				"pro_qty"  => $get_tot_qty_count
			);
			echo json_encode($data);
		}
	} catch (\Throwable $th) {
		cb_logger($th);
	} */
}

if ($mode == "Product_name_data") {
	$product_id = $_REQUEST['product_id'];
	$product_name = $db->getValue("product", "name", "isDelete=0 AND id=" . $product_id);
	echo $product_name;
}
