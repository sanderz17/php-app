<?php 
	include('connect.php');
	include("include/ups.class.php");
	if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']))
		$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
	else
		$user_id = 0;

	if(isset($_SESSION[SESS_PRE.'_SESS_CART_ID']))
		$cart_det_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
	else
		$cart_det_id = 0;

	$response = array();
	$response['error'] = "";
	$response['shipping_price'] = "";
	$response['grand_total'] = "";

	$ck_val  		= $_POST['ck_val'];
	$add_id  		= $_POST['add_id'];
	$pro_id  		= $_POST['pro_id'];
	$cart_id  		= $_POST['cart_id'];
	$qty  			= $_POST['qty'];
	$delivery_option= $_POST['delivery_option'];
	$armsg 			= $_POST['msg'];
	$apply_address_id = 0;

	$msg = '';
	foreach ($armsg as $key => $value) {
		$msg .= '(' . $value . '),';
	}
	$msg = substr($msg, 0, strlen($msg)-1);

	$zipcode = $db->getValue('tbl_address', 'zipcode', 'id = ' . $add_id);

	$where = "add_id=" . $add_id . " AND user_id=" . $user_id . " AND pro_id=" . $pro_id . " AND cart_det_id=" . $cart_det_id; 
	$r = $db->dupCheck("tbl_apply_address", $where);
	if($r)
	{
		$apply_address_id = $db->getValue('tbl_apply_address', 'id', $where);

		$rows = array(
				  "user_id" 	=> $user_id
				, "cart_id" 	=> $cart_id
				, "cart_det_id" => $cart_det_id
				, "add_id" 		=> $add_id
				, "pro_id" 		=> $pro_id
				, "opt_val"		=> $qty
				, "opt_del" 	=> $delivery_option
				, "shipping_method" => $delivery_option
				, "zip"			=> $zipcode
				, "status"		=> $ck_val
				, "msg"			=> $msg
			);
		$db->update('tbl_apply_address', $rows, 'id = ' . $apply_address_id);
	}else{ 	
		$rows = array(
			  "user_id"
			, "cart_id"
			, "cart_det_id"
			, "add_id"	
			, "pro_id"
			, "opt_val"
			, "opt_del"
			, "shipping_method"
			, "zip"
			, "status"
			, "msg"
		);
		$values = array(
			  $user_id
			, $cart_id
			, $cart_det_id
			, $add_id
			, $pro_id
			, $qty
			, $delivery_option
			, $delivery_option
			, $zipcode
			, $ck_val
			, $msg
		);
		$apply_address_id = $db->insert("tbl_apply_address", $values, $rows);
	}


	/* calculate shipping charges */
	$shipping_name = '';
	$prod_r = $db->getData('product', 'length, width, height, weight', 'id = ' . $pro_id);
	$prod_d = @mysqli_fetch_array($prod_r);
	$length = $prod_d['length'];
	$width 	= $prod_d['width'];
	$height = $prod_d['height'];
	$weight = $prod_d['weight'];
	$total_weight = ($weight * $qty) / 16;  // converting Ounce (oz) to Pound (lbs)

	if( $delivery_option == 1 )
	{
		$shipping_price = (HAND_DELIVERY_CHARGE * $qty);
		$shipping_name = 'Hand Delivery';
	}
	else if( $delivery_option == 4 )
	{
		$shipping_price = 0;
		$shipping_name = 'Pick Up';
	}
	else if( $delivery_option == 5 )
	{
		$shipping_price = 0;
		$shipping_name = 'Free USPS Shipping';
	}
	else if( $delivery_option != 0 )
	{
		if( $delivery_option == '03' || $delivery_option == 3 )
			$shipping_name = 'UPS Ground';
		else if( $delivery_option == 12 )
			$shipping_name = 'UPS 3 Day Select';

		$country = $db->getValue('tbl_address', 'country', 'id = ' . $add_id);
		$from_zip 		 	= ORIGIN_ZIP;
		$destination_zip 	= $zipcode;
		$dest_country_code 	= $db->getValue("countries", "webCode", "countryID='".$country."'");

		$ups = new upsRate();
		$ups->setCredentials(UPS_ACCESS_KEY, UPS_USERNAME, UPS_PASSWORD, UPS_SHIPPER);

		//echo $from_zip . ', ' . $destination_zip . ', ' . $dest_country_code . ', ' . $delivery_option . ', ' . $length . ', ' . $width . ', ' . $height . ', ' . $total_weight;
		
	/*	$max_ship_weight = 150;
		$total_parcels 	= $total_weight / $max_ship_weight;
		$full_parcels 	= floor($total_parcels);	
		$total_remain  	= $total_weight - ( $full_parcels * $max_ship_weight);	*/
		//$result       = $ups->getRate($from_zip,$destination_zip,$dest_country_code,$delivery_option,$length,$width,$height,150);
		$result        	= $ups->getRate($from_zip, $destination_zip, $dest_country_code, $delivery_option, $length, $width, $height, $total_weight);
		
		//print_r($result);
		$_SESSION['SHIP_RES'] = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE'];
		if( $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE'] == 1 )
		{
			$shipping_price = $result['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE'];			
			$shipping_price = $db->num($shipping_price);
			//$shipping_price = $shipping_price * $total_devided;
		}
		//elseif( $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORCODE'] == 111035 )
		else
		{
			$response['error'] = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'];
			$shipping_price = 0;
		}
	}

	$rows = array(
				  'shipping_charge' => $shipping_price
				, 'option_value' => $shipping_price
				, 'shipping_name' => $shipping_name
				, 'total_weight' => $total_weight
			);
	$db->update('tbl_apply_address', $rows, 'id = ' . $apply_address_id);

	/* update cart master table for shipping charges */
    $total_shipping_charge = $db->getValue('tbl_apply_address', 'SUM(shipping_charge)', ' user_id=' . $user_id . ' AND cart_det_id=' . $cart_det_id);
    $total_shipping_charge = $db->num($total_shipping_charge);

    $cart_r = $db->getData('cart_detail', '*', ' user_id=' . $user_id . ' AND id=' . $cart_det_id);
    $cart_d = @mysqli_fetch_array($cart_r);
    $grandtotal = $cart_d['subtotal'] - $cart_d['discount_price'] + $cart_d['tax'] + $total_shipping_charge;
    $grandtotal = $db->num($grandtotal);

    $rows = array(
	    		  'shipping_charge' => $total_shipping_charge
	    		, 'grandtotal' => $grandtotal  
    		);
    $db->update('cart_detail', $rows, ' user_id=' . $user_id . ' AND id=' . $cart_det_id);

	$response['shipping_price'] = CURR.$total_shipping_charge;
	$response['grand_total'] 	= CURR.$grandtotal;
	echo json_encode($response);
	die();
?>