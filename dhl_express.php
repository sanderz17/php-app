<?php
// $page = "shipping_charge";
include("connect.php");



$zip= $db->clean($_POST['zip']);
$country = $db->clean($_POST['c']);
$city = $db->clean($_POST['city']);

// echo $city;
// echo $country;
// echo $zip;



$SHIPPING = "Shipping service is not available at your zip - ".$zip;
$TOTAL = CUR.$db->getCartSubTotalPrice();
$GTOTAL = $db->getCartSubTotalPrice();

$final_total = 0;
$shipping_price = 0;
$Grand_total_weight = 0;

if($zip!="" && $country != ""){
	$from_zip 			= ORIGIN_ZIP;
	$destination_zip	= $zip;
	$services 			= $s;
	$dest_country_code  = $db->getValue("countries","iso2","id='".$country."'");
	cb_logger('dest_country_code '. $dest_country_code);
	// $dest_country_code  = "US";
	//echo $dest_country_code;
	$length = '0';
	$width 	= '0';
	$height = '0';
	$total_weight = 0;

	
	
	$shop_cart_r = $db->getData("cart_detail","*","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'","",0);

	

	if(@mysqli_num_rows($shop_cart_r)>0)
	{			
		$total_weight = 0;
		while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
		{	
			$qty 		= $shop_cart_d['qty'];	
			// $pro_weight	= $db->num($shop_cart_d['pro_weight']);
			$pro_weight	= $db->num($db->getValue("product", "weight", "id='" . $shop_cart_d['product_id'] . "'"));
			$pro_width	= $db->num($db->getValue("product","width","id='".$shop_cart_d['product_id']."'",0));
			$pro_length	= $db->num($db->getValue("product","length","id='".$shop_cart_d['product_id']."'",0));
			$pro_height	= $db->num($db->getValue("product","height","id='".$shop_cart_d['product_id']."'",0));
			
			$total_weight 	+= $pro_width * $qty;
			$Grand_total_weight += $pro_width * $qty;

			// echo $pro_weight;
		}
	}

	//echo $total_weight;
	//echo $Grand_total_weight;	

	$accountNumber = "849767524";
	$originCountryCode = $dest_country_code;
	$originCityName = $city;
	$destinationCountryCode = $dest_country_code;
	$destinationCityName = $city;
	$weight = $total_weight;
	$length = $pro_length;
	$width = $pro_width;
	$height = $pro_height;
	$plannedShippingDate = date("Y-m-d");
	$isCustomsDeclarable = "false";
	$unitOfMeasurement = "metric";

	$curl = curl_init();

	curl_setopt_array($curl, [
		CURLOPT_URL => "https://api-mock.dhl.com/mydhlapi/rates?accountNumber=<?php echo $accountNumber; ?>&originCountryCode=<?php echo $originCountryCode; ?>&originCityName=<?php echo $originCityName; ?>&destinationCountryCode=<?php echo $destinationCountryCode; ?>&destinationCityName=<?php echo $destinationCityName; ?>&weight=<?php echo $weight; ?>&length=<?php echo $length; ?>&width=<?php echo $width; ?>&height=<?php echo $height; ?>&plannedShippingDate=<?php echo $plannedShippingDate; ?>&isCustomsDeclarable=<?php echo $isCustomsDeclarable; ?>&unitOfMeasurement=<?php echo $unitOfMeasurement; ?>",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPHEADER => [
			// "Authorization: Basic YXBSOWlMOHpCNmNKN3A6WCQ1d0okNm1LITVpTiEweA==",
			"Authorization: Basic ZGVtby1rZXk6ZGVtby1zZWNyZXQ=",
			"Message-Reference: d0e7832e-5c98-11ea-bc55-0242ac13",
			"Message-Reference-Date: Wed, 21 Oct 2015 07:28:00 GMT",
			"Plugin-Name: ",
			"Plugin-Version: ",
			"Shipping-System-Platform-Name: ",
			"Shipping-System-Platform-Version: ",
			"Webstore-Platform-Name: ",
			"Webstore-Platform-Version: "
		],
	]);

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		// echo $response;
		cb_logger('result', $response);
		$result = json_decode($response, true);
		// echo "<pre>";
		// print_r($result);

		

		// $rows = array('sub_total'=>$Grand_total_weight);
		// $where	= "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
		// $db->update("cartdetails",$rows,$where); 

		

		$response1['currencyType'] = $result['products'][0]['totalPrice'][0]['currencyType'];
		$response1['priceCurrency'] = $result['products'][0]['totalPrice'][0]['priceCurrency'];
		$response1['price'] = $result['products'][0]['totalPrice'][0]['price'];


		$order_total = $db->getCartSubTotalPrice();

		$_SESSION[SESS_PRE.'SHIPPING_CHARGES'] = $response1['price'];
		$include_shipping_charges			   =$response1['price'];
		$grand_total						   = ($include_shipping_charges + $order_total);
		$TOTAL_SHIPPING_PRICE                  = $include_shipping_charges;

		$rows = array('grand_total'=>$grand_total,'shipping'=>$TOTAL_SHIPPING_PRICE,'dhl_express'=>1);
		$where	= "id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
		$db->update("cart",$rows,$where,0);

		echo json_encode($response1);die;

	}

}
