<?php
$page = "shipping_charge";
include("connect.php");
include("include/ups.class.php");
try {
	$s 	= $db->clean($_POST['s']);
	$zip = $db->clean($_POST['zip']);
	$country = $db->clean($_POST['c']);
	$sm = $db->clean($_POST['sm']) ?? "";

	$SUB_TOTAL = 0;
	$SHIPPING = "Shipping service is not available at your zip - " . $zip;
	$TOTAL = 0;
	$GTOTAL = 0;

	$discount = 0;
	$discount = $db->num($db->getValue("cart", "discount", "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'"));
	$discount_code = $db->getValue("cart", "coupon_code", "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'");
	$final_discount = 0;
	$final_total = 0;
	$discount_text = "-";
	$shipping_price = (float)$s;
	$shipping_price_compute = $shipping_price ?? 0;
	$Grand_total_weight = 0;
	$order_total = $db->getCartSubTotalPrice();
	$SUB_TOTAL = $order_total;
	if ($s != "" && $zip != "" && $country != "") {
		$from_zip 			= ORIGIN_ZIP;
		$destination_zip	= $zip;
		$services 			= $s;
		$dest_country_code  = $db->getValue("countries", "iso2", "id='" . $country . "'");
		$length = '0';
		$width 	= '0';
		$height = '0';
		$total_weight = 0;

		$shop_cart_r = $db->getData("cart_detail", "*", "cart_id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'" . "AND isDelete=0", "");

		if (@mysqli_num_rows($shop_cart_r) > 0) {
			$total_weight = 0;
			while ($shop_cart_d = @mysqli_fetch_array($shop_cart_r)) {
				$qty 		= $shop_cart_d['qty'];
				$pro_weight	= $db->num($db->getValue("product", "weight", "id='" . $shop_cart_d['product_id'] . "'"));
				$total_weight 	+= $pro_weight * $qty;
				$Grand_total_weight += $pro_weight * $qty;
			}
		}

		$TEMPVAL = true;

		if ($TEMPVAL) {
			if ($total_weight == 0) {
				$response['message'] = 'weight is not defined';
				return json_encode($response);
				die();
			}
			$total_weight = number_format((float)$total_weight, 2, '.', '');
			$final_total = $db->num($order_total + $shipping_price);
			$SHIPPING = $shipping_price;
			$TOTAL = CUR . $final_total;
			//$result    = $ups->getRate($from_zip, $destination_zip, $dest_country_code, $services, $length, $width, $height, $total_weight);
			//echo $total_weight;
			//print_r($result);
			/* 		$_SESSION['SHIP_RES'] = $result['RateResponse']['Response']['ResponseStatus']["Code"];
			if ($result['RateResponse']['Response']['ResponseStatus']["Code"] == 1) {
				$shipping_price += $result['RateResponse']['RatedShipment']['NegotiatedRateCharges']['TotalCharge']['MonetaryValue'];
				$order_total = $db->getCartSubTotalPrice();
				$final_total = $db->num($order_total + $shipping_price);
	
				$SHIPPING = CUR . $shipping_price;
				$TOTAL = CUR . $final_total;
			} elseif ($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORCODE'] == 111035) {
				$SHIPPING = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'];
			} */
		}
	}


	/* if ($shipping_price >= 100) {
		$new_shipping_price 	= $shipping_price + ($shipping_price * 0.70) / 100;
		$SHIPPING_PRICE_CAL 	= ($new_shipping_price + $shipping_price);
		// $FINALTOTAL 		= "$".($new_shipping_price + $final_total);
	} else {
		$new_shipping_price 	= $shipping_price;
		$SHIPPING_PRICE_CAL 	= $SHIPPING;
		$SHIPPINGNOTABAI		= 0;
		// $FINALTOTAL 		= $TOTAL;
	} */
	if(isset($discount_code)  && $discount_code){
		cb_logger("have discount");
		cb_logger("discount_code=$discount_code");
		if ($discount_code == '1dol') {
			$shipping_price = 0;
			$order_total = 0.01;
			$SHIPPING = 0;
			$final_discount = - ($SUB_TOTAL + $order_total + $shipping_price_compute);
			$discount_text = '<strong class="text-success"><span><bdi>' . CUR . number_format($final_discount, 2) . '</bdi></span></strong>';
		} else {
			$final_discount = - ($discount);
			$discount_text = '<strong class="text-success"><span><bdi>' . CUR . number_format($final_discount, 2) . '</bdi></span></strong>';
		}
	}

	$new_shipping_price 	= $shipping_price;
	$SHIPPING_PRICE_CAL 	= $SHIPPING;
	$SHIPPINGNOTABAI		= 0;
	if ($new_shipping_price > 0) {
		$include_shipping_charges	 	= ($new_shipping_price);
		$INCLUDE_SHIPPING_PRICE_CAL	 	= $include_shipping_charges;
		$FINALTOTAL 					= ($include_shipping_charges + $order_total);
		$grand_total					= ($include_shipping_charges + $order_total - $discount);
		$TOTAL_SHIPPING_PRICE			= $include_shipping_charges;
	} else {
		$include_shipping_charges 	 	= $new_shipping_price;
		$INCLUDE_SHIPPING_PRICE_CAL  	= $SHIPPING_PRICE_CAL;
		$FINALTOTAL 					= $TOTAL;
		$grand_total					= $order_total;
		$TOTAL_SHIPPING_PRICE		  	= $SHIPPING_PRICE_CAL;
	}

	// echo $FINALTOTAL."==".$SHIPPING_PRICE_CAL."==".$shipping_price;die();

	$_SESSION[SESS_PRE . 'SHIPPING_CHARGES'] = $include_shipping_charges;

	// $rows = array('sub_total'=>$Grand_total_weight);
	// $where	= "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
	// $db->update("cartdetails",$rows,$where); 

	//cb_logger('grandtotal' .$grand_total);



	$rows = array('grand_total' => $grand_total, 'shipping' => $shipping_price_compute, 'shipping_method' => $sm, 'discount' => $final_discount);
	$where	= "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'";
	$db->update("cart", $rows, $where);

	// $response['html'] = '<ul><li>Subtotal<span>'.$SUB_TOTAL.'</span></li><li>Shipping ('.$Grand_total_weight.'lbs)<span>'.$INCLUDE_SHIPPING_PRICE_CAL.'</span></li><li>Total<span>'.$FINALTOTAL.'</span></li></ul>';

	$response['shipping'] = '<span><b><span>' . CUR . number_format($shipping_price_compute, 2) . '</b></span></span>';

	// $response['finaltot'] = '<strong><span><bdi>'.$FINALTOTAL.'</bdi></span></strong>';
	$response['finaltot'] = '<strong><span><bdi>' . CUR . number_format($grand_total, 2) . '</bdi></span></strong>';

	$response['finaldiscount'] = $discount_text;

	$response['total_cart_price'] = number_format($grand_total, 2);

	echo json_encode($response);
} catch (\Throwable $th) {
	cb_logger($th);
}
