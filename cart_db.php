<?php
include "connect.php";
$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];

$mode = $_REQUEST['mode'];

if ($mode == "update_qty") {

	$id = $_REQUEST['id'];
	$qty = $_REQUEST['qty'];
	$pid = $_REQUEST['pid'];

	// $db->update_quantity($cart_id, $id, $qty);

	$get_tot_qty_count = $db->getValue("product", "quantity", "isDelete=0 AND id='" . $pid . "' ");
	$get_stock_qty_count = $db->getValue("product", "cal_qty", "isDelete=0 AND id='" . $pid . "' ");

	// $db->add_to_cart($user_id, $product_id, $price, $qty);
	$db->update_quantity($cart_id, $id, $qty);
	// echo "1";

	$tot_stock_qty = $qty;
	$qty_arr = array("cal_qty" => $tot_stock_qty);
	$db->update("product", $qty_arr, "id='" . $pid . "' ");

	$data = array(
		"zero"     => 1
	);
	echo json_encode($data);
}

if ($mode == "remove_cart") {

	// echo "<pre>";
	// print_r($_REQUEST);
	// die;
	$id = $_REQUEST['id'];

	$cart_detail_qty = $db->getValue("cart_detail", "qty", "isDelete=0 AND id='" . $id . "' AND cart_id='" . $cart_id . "' ");
	$cart_detail_pid = $db->getValue("cart_detail", "product_id", "isDelete=0 AND id='" . $id . "' AND cart_id='" . $cart_id . "' ");
	$get_stock_qty_count = $db->getValue("product", "cal_qty", "isDelete=0 AND id='" . $cart_detail_pid . "' ");

	$qty_arr = array("cal_qty" => $get_stock_qty_count - $cart_detail_qty);
	$db->update("product", $qty_arr, "id='" . $cart_detail_pid . "' ");


	$db->remove_from_cart($cart_id, $id);
}
