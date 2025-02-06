<?php 


$page = "shipping_charge";
include("connect.php");
include("include/ups.class.php");
// include("../include/cart.class.php");


$s 	= $db->clean($_POST['s']);
$zip= $db->clean($_POST['zip']);
$country = $db->clean($_POST['c']);
$quote_id = $db->clean($_POST['quote_id']);

// $SUB_TOTAL = "$".$db->getCartSubTotalPrice($quote_id);
// echo $quote_id;
// echo "<pre>";
// print_r($SUB_TOTAL);
// die;
$SHIPPING = "Shipping service is not available at your zip - ".$zip;
// $TOTAL = CUR.$db->getCartSubTotalPrice($quote_id);
// $GTOTAL = $db->getCartSubTotalPrice($quote_id);




// echo "=====";die;
$final_total = 0;
$shipping_price = 0;
$Grand_total_weight = 0;

if($s!="" && $zip!="" && $country != ""){
	$from_zip 			= ORIGIN_ZIP;
	$destination_zip	= $zip;
	$services 			= $s;
	$dest_country_code  = $db->getValue("countries","iso2","id='".$country."'");
	// $dest_country_code  = "US";
	$length = '0';
	$width 	= '0';
	$height = '0';
	$total_weight = 0;

	
	
	$shop_cart_r = $db->getData("quote_detail","*","quote_id='".$quote_id."'","");

	

	if(@mysqli_num_rows($shop_cart_r)>0)
	{			
		$total_weight = 0;
		while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
		{	
			$qty 		= $shop_cart_d['qty'];	
			// $pro_weight	= $db->num($shop_cart_d['pro_weight']);
			$pro_weight	= $db->num($db->getValue("product","width","id='".$shop_cart_d['product_id']."'",0));
			
			$total_weight 	+= $pro_weight * $qty;
			$Grand_total_weight += $pro_weight * $qty;

			// echo $pro_weight."<br>";
		}
	}

	// echo "<pre>";
	// // print_r($shop_cart_r);
	// echo $pro_weight;
	// echo $total_weight;
	// echo $Grand_total_weight;
	// die;
	$ups = new upsRate(); 
	$ups->setCredentials('2DAE4B0A1F438212','Clearballistics1','Maxhouse#1234','61F941');
	
//	$ups->setCredentials('AD257C38A0F50AA8','prohairlabs','Phl_inc2016!','X92076');
	$TEMPVAL = true ; 

	// print_r($_REQUEST);

	// echo $from_zip;
	// echo '<br>--------<br>';
	// echo $dest_country_code;
	// echo '<br>--------<br>';

	//$result = $ups->getRate($from_zip,29306,$dest_country_code,11,5,5,5,150);
	
	//from_zip => 33541 destination_zip => 123 dest_country_code => US services => 03 length => 0 width => 0 height => 0150

	
/* 
	from_zip - 33541
	destination_zip - 123
	dest_country_code - US
	services - 03
	length - 0
	height - 0
	width - 0
	total_weight - 9.8 */

	// $result        = $ups->getRate('33541','123','US',03,0,0,0,9.8);
	
	// print '<pre>'; print_r($ups); 
	// print '<pre>'; print_r($result); exit;

	if($total_weight > 150)
	{

		$total_devided = $total_weight / 150;
		$total_devided = floor($total_devided);	

		$total_remain  = $total_weight - ( $total_devided * 150);	

		// echo "<pre>";
		// print_r($total_remain);
		// die;

		// echo "from_zip".$from_zip."<br>";
		// echo "destination_zip".$destination_zip."<br>";
		// echo "dest_country_code".$dest_country_code."<br>";
		// echo "services".$services."<br>";
		// echo "length".$length."<br>";
		// echo "width".$pro_weight."<br>";
		// echo "height".$height."<br>";
		// die;


		// $result        = $ups->getRate($from_zip,$destination_zip,$dest_country_code,$services,$length,$width,$height,150);

		
		// $result        = $ups->getRate($from_zip,29605,$dest_country_code,11,5,5,5,150);
		
		// echo "<pre>";
		// print_r($result);
		// die();

		$result        = $ups->getRate($from_zip,$destination_zip,$dest_country_code,$services,$length,$width,$height,150);
		
		if($result)
		{
			$response['is_blank_arr'] = 0;
		}
		$TEMPVAL = false ; 
		
		$_SESSION['SHIP_RES'] 		= $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE'];
		if($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE']==1){
			$shipping_price 	= $result['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE'];
			
			$shipping_price = $shipping_price * $total_devided ;

			// echo "<pre>";
			// print_r($shipping_price);
			// die();

			//$TEMPVAL = true ; 
			if($total_remain > 0)
			{
				$TEMPVAL = true ;
				$total_weight = $total_remain;
			}else
			{
				$TEMPVAL = false ; 
				// $order_total = $db->getCartSubTotalPrice($quote_id);
				$final_total = $db->num($order_total + $shipping_price);
				
				$SHIPPING = CUR.$shipping_price;
				// $TOTAL = CUR.$final_total;
				// $GTOTAL	= $final_total;
			}

			$SHIPPING = CUR.$shipping_price;
			// $TOTAL = CUR.$final_total; 
			// $GTOTAL	= $final_total;
		}
		elseif($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORCODE']==111035)
		{
			$TEMPVAL = false ; 
			$SHIPPING = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'];

		}
		
	}
	//echo $shipping_price;
	
	//exit;
			
	//**************************************************************************************************************************			
	//$total_qty 		= $db->getSumVal("cartitems","qty","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
	//$total_weight 	= $db->getSumVal("cartitems","pro_weight","cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'");
	//$total_weight 	= ceil($total_qty*$total_weight);
	//************************************************************************************************************************
	if($TEMPVAL)
	{
		$result    = $ups->getRate($from_zip,$destination_zip,$dest_country_code,$services,$length,$width,$height,$total_weight);
		//echo $total_weight;
		//print_r($result);
		$_SESSION['SHIP_RES'] = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE'];
		if($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['RESPONSESTATUSCODE']==1){
			$shipping_price += $result['RATINGSERVICESELECTIONRESPONSE']['RATEDSHIPMENT']['TOTALCHARGES']['MONETARYVALUE'];
			// $order_total = $db->getCartSubTotalPrice($quote_id);
			$final_total = $db->num($order_total + $shipping_price);
			
			$SHIPPING = CUR.$shipping_price;
			// $TOTAL = CUR.$final_total; 
		}
		elseif($result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORCODE']==111035)
		{
			$SHIPPING = $result['RATINGSERVICESELECTIONRESPONSE']['RESPONSE']['ERROR']['ERRORDESCRIPTION'];
			
		}
	}
}


if ($shipping_price >= 100) {
	$new_shipping_price 	= $shipping_price + ($shipping_price * 0.70)/100;
	$SHIPPING_PRICE_CAL 	= "$".($new_shipping_price + $shipping_price);
	// $FINALTOTAL 		= "$".($new_shipping_price + $final_total);
}else{
	$new_shipping_price 	= $shipping_price;
	$SHIPPING_PRICE_CAL 	= $SHIPPING;
	$SHIPPINGNOTABAI		= 0;
	// $FINALTOTAL 		= $TOTAL;
}

// echo $new_shipping_price;die();
	
if ($shipping_price >0) 
{
	$include_shipping_charges	 	= ($new_shipping_price + 4);
	$INCLUDE_SHIPPING_PRICE_CAL	 	= "$".$include_shipping_charges;
	$FINALTOTAL 					= "$".($include_shipping_charges + $order_total);
	$grand_total					= ($include_shipping_charges + $order_total);
	$TOTAL_SHIPPING_PRICE			= $include_shipping_charges;
}
else
{
	$include_shipping_charges 	 	= $new_shipping_price;
	$INCLUDE_SHIPPING_PRICE_CAL  	= $SHIPPING_PRICE_CAL;
	$FINALTOTAL 					= $TOTAL;
	// $grand_total					= $GTOTAL;
	$TOTAL_SHIPPING_PRICE		  	= $SHIPPING_PRICE_CAL;
}

// echo $FINALTOTAL."==".$SHIPPING_PRICE_CAL."==".$shipping_price;die();

$_SESSION[SESS_PRE.'SHIPPING_CHARGES'] = $include_shipping_charges;

// $rows = array('sub_total'=>$Grand_total_weight);
// $where	= "cart_id='".$_SESSION[SESS_PRE.'_SESS_CART_ID']."'";
// $db->update("cartdetails",$rows,$where); 

$rows = array('grand_total'=>$grand_total,'shipping'=>$TOTAL_SHIPPING_PRICE,'shipping_method'=>$services);
$where	= "id='".$quote_id."'";
$db->update("quote",$rows,$where);

// $response['html'] = '<ul><li>Subtotal<span>'.$SUB_TOTAL.'</span></li><li>Shipping ('.$Grand_total_weight.'lbs)<span>'.$INCLUDE_SHIPPING_PRICE_CAL.'</span></li><li>Total<span>'.$FINALTOTAL.'</span></li></ul>';

$response['shipping'] = '<span> ('.$Grand_total_weight.'lbs)<span>'.$INCLUDE_SHIPPING_PRICE_CAL.'</span></span>';

$response['finaltot'] = '<strong><span><bdi>'.$FINALTOTAL.'</bdi></span></strong>';

$response['SHIPPINGNOTABAI'] = $SHIPPINGNOTABAI;

echo json_encode($response);die();

?>

