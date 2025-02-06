<?php
include("connect.php");
$ctable = "cart";
try {

	//for sidebar active menu
	$ctable_where = '';
	if (isset($_REQUEST['searchName']) && $_REQUEST['searchName'] != "") {
		$ctable_where .= " (
					name like '%" . $_REQUEST['searchName'] . "%' OR
					order_no like '%" . $_REQUEST['searchName'] . "%' OR
					order_date like '%" . $_REQUEST['searchName'] . "%' OR
					grand_total like '%" . $_REQUEST['searchName'] . "%'
		) AND ";
	}

	if (isset($_REQUEST['startdate']) && $_REQUEST['startdate'] != "" && $_REQUEST['enddate'] && $_REQUEST['enddate'] != "") {
		$ctable_where .= " ( date(c.adate) BETWEEN '" . $_REQUEST['startdate'] . "' AND '" . $_REQUEST['enddate'] . "'
		) AND ";
	}

	$ctable_where .= "c.isDelete=0 AND c.order_status=2";
	//$ctable_where .= "cart.isDelete=0 AND cart.order_status<>1";

	//get starting position to fetch the records
	$rows = "cart_detail.*,
					c.adate as cart_adate,
					c.id as cart_id,
					c.sub_total as cart_subtotal,
					c.grand_total as cart_grand_total,
					c.order_no as cart_order_no,
					c.discount as cart_discount,
					shipping_first_name,
					shipping_last_name,
					shipping_address,
					shipping_address2,
					shipping_city,
					shipping_state,
					shipping_zipcode,
					shipping_country,
					billing_shipping.adate as billing_shipping_adate
					";
	$ctable_r = $db->getJoinData(
		'cart_detail',
		'billing_shipping',
		'billing_shipping.cart_id=cart_detail.cart_id RIGHT JOIN cart c ON c.id=cart_detail.cart_id',
		$rows,
		$ctable_where,
		"c.adate DESC"
	);

	// xml report generat
	$delimiter = ",";
	$filename = "report-data_" . date('Y-m-d-His') . ".csv";

	// Create a file pointer 	
	$f = fopen('php://memory', 'w');

	// Set column headers 
	$fields = explode(' ', 'Invoice_Date Invoice_Number Invoice_Description Customer_First_Name Customer_Last_Name Company PO_Number Address City State ZIP Country Units_Sold Product_Descriptions Shipping_Discount Total_Sales_Order');

	fputcsv($f, $fields, $delimiter);

	if (@mysqli_num_rows($ctable_r) > 0) {
		$count = 0;
		while ($ctable_d = @mysqli_fetch_assoc($ctable_r)) {
			$count++;
			cb_logger("count=$count");
			if ($ctable_d['order_status'] == 0) {
				$order_status = "Cancelled";
			}
			if ($ctable_d['order_status'] == 1) {
				$order_status = "In Progress";
			}
			if ($ctable_d['order_status'] == 2) {
				$order_status = "Completed";
			}
			if ($ctable_d['order_status'] == 3) {
				$order_status = "Shipped";
			}
			if ($ctable_d['order_status'] == 4) {
				$order_status = "Delivered";
			}

			$payment_type = $db->getValue("payment_history", "payment_type", 'cart_det_id=' . $ctable_d['id']);

			if ($payment_type == 1) {
				$payment_type_name = "Card";
			}
			if ($payment_type == 2) {
				$payment_type_name = "PayPal";
			}
			// echo $order_status;
			$txn_id = 0;
			//$txn_id = $db->getValue("payment_history", "txn_id", "cart_det_id='" . $ctable_d['id'] . "' ");
			// echo $txn_id;
			// die;
			$state_name = $db->getValue("states_ex", "name", "id='" . $ctable_d['shipping_state'] . "' ");
			$country_name = $db->getValue("countries", "name", "id='" . $ctable_d['shipping_country'] . "' ");
			$product_description = $db->getValue("product", "name", "id='" . $ctable_d['product_id'] . "' ");
			$lineData = array($ctable_d['cart_adate'], $ctable_d['cart_order_no'], "", $ctable_d['shipping_first_name'], $ctable_d['shipping_last_name'], "", "", $ctable_d['shipping_address'],   $ctable_d['shipping_city'],  $state_name, $ctable_d['shipping_zipcode'], $country_name,  $ctable_d['qty'], $product_description, $ctable_d["cart_discount"], $ctable_d['cart_grand_total']);
			fputcsv($f, $lineData, $delimiter);
		}
		fseek($f, 0);

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');

		//output all remaining data on a file pointer 
		fpassthru($f);
		// exit;
	}
} catch (\Throwable $th) {
	cb_logger($th);
}
