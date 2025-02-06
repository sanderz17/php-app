<?php
	include('connect.php');

	if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']))
		$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
	else{
		$user_id = 0;
}
	$cart_det_id 	= $_SESSION[SESS_PRE.'_SESS_CART_ID'];

	$cart_row = $db->getData('cart', '*', 'id=' . $cart_det_id . ' AND isDelete = 0');
	$cart_data = mysqli_fetch_assoc($cart_row); 

	$qty = $db->getValue('cart_detail', 'SUM(qty)', 'id=' . $cart_det_id . ' AND isDelete = 0');
	$adate	=  date("Y-m-d H:i:s");
	 
    $rows = array(
        "uid" 			=> $user_id,
		"cart_det_id" 	=> $cart_det_id,
	    "payment_type" 	=> 2,
		"price" 		=> $cart_data['grand_total'],
		"order_number" 	=> $cart_data['order_no'],
		"payment_status"=> 1,
		"payment_date" 	=> $adate
	);
       
	$history_id =    $db->insert('payment_history', $rows);

	$pay_form = '<script type="text/javascript">
	document.onkeydown = function (e) {
        return false;
	}

	if (document.layers) {
    	document.captureEvents(Event.MOUSEDOWN);
 		document.onmousedown = function () {
        	return false;
    	};
	}
	else {
    	document.onmouseup = function (e) {
        	if (e != null && e.type == "mouseup") {
            	if (e.which == 2 || e.which == 3) {
                	return false;
            	}
        	}
    	};
	}

  	document.oncontextmenu = function () {
    	return false;
	};

	document.onkeydown = function(e) {
		if(event.keyCode == 123) {
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == "I".charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.shiftKey && e.keyCode == "J".charCodeAt(0)){
			return false;
		}
		if(e.ctrlKey && e.keyCode == "U".charCodeAt(0)){
			return false;
		}
	}

		</script><div class="bag_loader"><img src="'.SITEURL.'images/ajax-loader.gif" style="margin-left:48%;margin-top:20%;width:120px;"><p class="text-center" style="    text-align: center;
    		font-size: 28px;
    		font-family: "Source Sans Pro", sans-serif">Please Wait redirecting to paypal</p></div>
    		<form method="post" action="'.PAYPALSB_URL.'" name="frmPayPal" id="frmPayPal">
				<input type="hidden" name="amount" id="amount" value="'.$cart_data['grand_total'].'">
				<input type="hidden" name="business" value="'.PAYPALSB_EMAIL.'">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="item_name_1" value="Product1">
				<input type="hidden" name="item_number_1" value="'.$qty.'">
				<input type="hidden" name="item_name_2" value="Product2">
				<input type="hidden" name="item_number_2" value="'.$qty.'">
				<input name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" type="hidden">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="return" value="'.SITEURL.'thankyou">
				<input type="hidden" name="cancel_return" value="'.SITEURL.'checkout/">
				<input type="hidden" name="notify_url" value="'.SITEURL.'notify.php">
				<input type="hidden" name="custom" value="'.$user_id.','.$guest_user_id.','.$cart_det_id.','.$cart_data['grand_total'].','.$history_id.'">
			</form>';

	echo json_encode($pay_form);
 	die();
?>

<!--<script type="text/javascript">document.frmPayPal.submit();</script>-->