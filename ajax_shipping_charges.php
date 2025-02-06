<?php
$page = "shipping_charge";
include("connect.php");
include("include/ups.class.php");

try {
	$zip = $db->clean($_POST['zip']);
	$country = $db->clean($_POST['c']);
	$stateCode =  $db->clean($_POST['sc']);

	$SUB_TOTAL = 0;
	$SHIPPING = "Shipping service is not available at your zip - " . $zip;
	$TOTAL = 0;
	$GTOTAL = 0;

	$discount = 0;
	$discount = $db->num($db->getValue("cart", "discount", "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'"));

	$final_total = 0;
	$shipping_price = 0;
	$Grand_total_weight = 0;
	$shipping_rates = [];
	$noOfPackages = 0;
	$ups_codes = [
		'01' => 'UPS Next Day Air',
		'02' => 'UPS 2nd Day Air',
		'03' => 'UPS Ground',
		'07' => 'UPS Worldwide Express',
		'08' => 'UPS Worldwide Expedited',
		'12' => 'UPS 3-Day Select',
		'13' => 'UPS Next Day Air Saver',
		'11' => 'UPS Standard',
		'14' => 'UPS Next Day Air Early',
		'54' => 'UPS Worldwide Express Plus',
		'59' => 'UPS 2nd Day Air AM',
		'65' => 'UPS Worldwide Saver'
	];


	if ($zip != "" && $country != "") {
		$from_zip = ORIGIN_ZIP;
		$destination_zip	= $zip;
		$services 			= $s;
		$dest_country_code  = $db->getValue("countries", "iso2", "id='" . $country . "'");
		$length = '0';
		$width 	= '0';
		$height = '0';
		$total_weight = 0;



		$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
		$where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
		$join = " LEFT JOIN product p ON p.id = cd.product_id";
		$rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.id as pro_id, p.isPrepack as isPrepack";
		$shop_cart_r = $db->getJoinData2("cart_detail cd", $join, $rows, $where);


		//$shop_cart_r = $db->getData("cart_detail", "*", "cart_id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'" . "AND isDelete=0", "");
		$noOfPackages = 0;
		if (@mysqli_num_rows($shop_cart_r) > 0) {
			$total_weight = 0;
			$cart_sub_total = 0;
			while ($shop_cart_d = @mysqli_fetch_assoc($shop_cart_r)) {
				$isPrepack = $shop_cart_d['isPrepack'];
				$qty 		= $shop_cart_d['qty'];
				$pro_weight	= $db->num($db->getValue("product", "weight", "id='" . $shop_cart_d['pro_id'] . "'"));
				$total_weight 	+= $pro_weight * $qty;
				$Grand_total_weight += $pro_weight * $qty;
				$noOfPackages += $isPrepack ? $qty : (ceil($total_weight / 49));
				$cart_sub_total += $shop_cart_d['price'] * $shop_cart_d['qty'];
			}
		}
		cb_logger("cart_sub_total=" . $cart_sub_total);
		//$noOfPackages = ceil($total_weight / 49);
		$free_gift = '';
		$image_float = '';
		$qualify = true;
		$free_gift_weight = 0;
		if ($cart_sub_total >= '300' && $cart_sub_total <= '499.99') {
			$free_gift_weight = .9;
		} else if ($cart_sub_total >= '500' && $cart_sub_total <= '999.99') {
			$free_gift_weight = 17.2;
		} else if ($cart_sub_total >= '1000') {
			$free_gift_weight = 13.1;
		} else {
			$qualify = false;
		}
		// upsRate invoke
		$ups = new upsRate();
		//$ups->setCredentials(UPS_ACCESS_KEY, UPS_USERNAME, UPS_PASSWORD, UPS_SHIPPER);
		$ups->getToken();
		$TEMPVAL = true;
		if ($TEMPVAL) {
			if ($total_weight == 0) {
				$response['message'] = 'weight is not defined';
				echo json_encode($response);
				return;
			}
			$total_weight = $total_weight + $free_gift_weight;
			$total_weight = number_format((float)$total_weight, 2, '.', '');
			$result = $ups->getRate($from_zip, $destination_zip, $dest_country_code, $services, $length, $width, $height, $total_weight, $stateCode, $noOfPackages);
			$_SESSION['SHIP_RES'] = $result['RateResponse']['Response']['ResponseStatus']["Code"];
			if ($result['RateResponse']['Response']['ResponseStatus']["Code"] == 1) {
				if (count($result['RateResponse']['RatedShipment']) > 0) {
					foreach ($result['RateResponse']['RatedShipment'] as $rs) {
						$shipping_rates[] = array(
							'service_code' => $rs['Service']['Code'],
							'desc' => $ups_codes[$rs['Service']['Code']],
							//'shipping_charge' => $rs['Service']['Code'] === '03' ? 0 : ($rs['TotalCharges']['MonetaryValue'] + ($rs['TotalCharges']['MonetaryValue'] * .10))
							'shipping_charge' => $rs['Service']['Code'] === '03' ? ($rs['TotalCharges']['MonetaryValue'] - ($rs['TotalCharges']['MonetaryValue'] * .10)) : ($rs['TotalCharges']['MonetaryValue'] + ($rs['TotalCharges']['MonetaryValue'] * .10))
						);
					}
				}
				$shipping_price += $result['RateResponse']['RatedShipment']['NegotiatedRateCharges']['TotalCharge']['MonetaryValue'];
				$order_total = 0;
				$final_total = $db->num($order_total + $shipping_price);

				$SHIPPING = CUR . $shipping_price;
				$TOTAL = CUR . $final_total;
			} elseif ($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORCODE'] == 111035) {
				$SHIPPING = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'];
			}
		}
	}


	/* 	if ($shipping_price >= 100) {
		$new_shipping_price 	= $shipping_price + ($shipping_price * 0.70) / 100;
		$SHIPPING_PRICE_CAL 	= ($new_shipping_price + $shipping_price);
		// $FINALTOTAL 		= "$".($new_shipping_price + $final_total);
	} else {
		$new_shipping_price 	= $shipping_price;
		$SHIPPING_PRICE_CAL 	= $SHIPPING;
		$SHIPPINGNOTABAI		= 0;
		// $FINALTOTAL 		= $TOTAL;
	} */

	// echo $new_shipping_price;die();

	if ($shipping_price > 0) {
		$include_shipping_charges	 	= ($new_shipping_price - 4);
		$INCLUDE_SHIPPING_PRICE_CAL	 	= $include_shipping_charges;
		$FINALTOTAL 					= ($include_shipping_charges + $order_total);
		$grand_total					= ($include_shipping_charges + $order_total);
		$TOTAL_SHIPPING_PRICE			= $include_shipping_charges;
	} else {
		$include_shipping_charges 	 	= $new_shipping_price;
		$INCLUDE_SHIPPING_PRICE_CAL  	= $SHIPPING_PRICE_CAL;
		$FINALTOTAL 					= $TOTAL;
		$grand_total					= $GTOTAL;
		$TOTAL_SHIPPING_PRICE		  	= $SHIPPING_PRICE_CAL;
	}


	$_SESSION[SESS_PRE . 'SHIPPING_CHARGES'] = $include_shipping_charges;

	$grand_total = $grand_total - $discount;

	$rows = array('grand_total' => CUR . $grand_total, 'shipping' => CUR . $TOTAL_SHIPPING_PRICE, 'shipping_method' => $services);
	$where	= "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'";
	$db->update("cart", $rows, $where);
	$INCLUDE_SHIPPING_PRICE_CAL = $INCLUDE_SHIPPING_PRICE_CAL > 0 ? number_format($INCLUDE_SHIPPING_PRICE_CAL, 2) : 0;
	function cmp($a, $b)
	{
		return strcmp($a["shipping_charge"], $b["shipping_charge"]);
	}

	usort($shipping_rates, "cmp");
	$response = array(
		'message' => 'success',
		'weight' => ' (' . $Grand_total_weight . 'lbs) ' . CUR,
		'from_zip' => $from_zip,
		'destination_zip' => $destination_zip,
		'dest_country_code' => $dest_country_code,
		'sr' => $shipping_rates
	);

	echo json_encode($response);
} catch (\Throwable $th) {
	$response = array(
		'message' => 'failed'
	);
	echo json_encode($response);
	cb_logger('throwerror' . $th);
}
