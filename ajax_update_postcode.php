<?php
    include 'connect.php';
    $shipping_post = $_POST['shipping_post'];
    $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
    // print_r($_SESSION[SESS_PRE.'_SESS_USER_ID']);
    // exit;
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    if(isset($_POST['shipping_post']))
    {
        $shipp_arr = array(
			"user_id" => $user_id,
			"cart_id" => $cart_id,

			"billing_zipcode" 	=> $shipping_post,
		);

        $dupcheck = $db->dupCheck("billing_shipping","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id);
		if ($dupcheck) 
		{
			$b_id = $db->update("billing_shipping",$shipp_arr,"isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id);
            echo $shipping_post;
		}
		else
		{
			$b_id = $db->insert("billing_shipping",$shipp_arr);
            echo $shipping_post;

		}
    }