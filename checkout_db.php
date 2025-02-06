<?php
	include 'connect.php';

	$cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];

	$shipping_first_name = "";
	$shipping_last_name = "";
	$shipping_street_addr = "";
	$shipping_addr2 = "";
	$shipping_country = "";
	$shipping_state = "";
	$shipping_city = "";
	$shipping_post = "";
	$shipping_phone = "";

	$billing_first_name = "";
	$billing_last_name = "";
	$billing_street_addr1 = "";
	$billing_addr2 = "";

	$billing_city = "";
	$billing_zip_code = "";
	$billing_country = "";
	$billing_phone = "";

	$save_addr_from = "";
	$use_billing_save = "";
	$mode = "";

	$shipping_method_select = "";

	$shipping_email = "";
	$check_out_signup_password = "";


	$user_id = 0;
	if (!empty($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] ) 
		$user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];


	$shipping_first_name 	= $db->clean($_REQUEST['shipping_first_name']);
	$shipping_last_name 	= $db->clean($_REQUEST['shipping_last_name']);
	$shipping_street_addr 	= $db->clean($_REQUEST['shipping_street_addr']);
	$shipping_addr2 		= $db->clean($_REQUEST['shipping_addr2']);
	$shipping_country 		= $db->clean($_REQUEST['shipping_country']);
	$shipping_state 		= $db->clean($_REQUEST['shipping_state']);
	$shipping_city 			= $db->clean($_REQUEST['shipping_city']);
	$shipping_post 			= $db->clean($_REQUEST['shipping_post']);
	$shipping_phone 		= $db->clean($_REQUEST['shipping_phone']);
	// $shipping_infor 		= $db->clean($_REQUEST['shipping_infor']);

	$billing_first_name 	= $db->clean($_REQUEST['billing_first_name']);
	$billing_last_name 		= $db->clean($_REQUEST['billing_last_name']);
	$billing_street_addr1 	= $db->clean($_REQUEST['billing_street_addr']);
	$billing_addr2 			= $db->clean($_REQUEST['billing_addr2']);
	// $billing_compny = $_REQUEST['billing_compny'];
	$billing_city 			= $db->clean($_REQUEST['billing_city']);
	$billing_zip_code 		= $db->clean($_REQUEST['billing_post']);
	$billing_country 		= $db->clean($_REQUEST['billing_country']);
	$billing_phone 			= $db->clean($_REQUEST['billing_phone']);
	$billing_state 			= $db->clean($_REQUEST['billing_state']);

	// $shipping_same = $db->clean($_REQUEST['payment_method']);
	$save_addr_from = $db->clean($_REQUEST['save_addr_from']);
	$use_billing_save = $db->clean($_REQUEST['use_billing_save']);
	$mode = $db->clean($_REQUEST['mode']);

	$shipping_method_select = $db->clean($_REQUEST['shipping_method_select']);

	$shipping_email = $_REQUEST['shipping_email'];
	$check_out_signup_password = $_REQUEST['check_out_signup_password'];

	$gust_user_generated_padss = 0;
	if($check_out_signup_password =="" && empty($check_out_signup_password))
	{
		$gust_user_generated_padss = 1;
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$check_out_signup_password = implode($pass); //turn the array into a string
	}
	

	if ($mode == "shipping_step") 
	{

		if ($shipping_email != "" && $check_out_signup_password !="" && !empty($check_out_signup_password) ) 
		{
			$add_u_arr = array(
				"first_name"	=> $shipping_first_name,
				"last_name" 	=> $shipping_last_name,
				"email"			=> $shipping_email,
				"password" 		=> md5($check_out_signup_password),
				"isActive"	=> 1,
			);

			// echo $add_u_arr;
			// echo "<pre>";
			// print_r($add_u_arr);
			// exit;

			$dupcheck_user = $db->dupCheck("user","isDelete=0 AND email='".$shipping_email."' ");

			if ($dupcheck_user!="") {
				$db->update("user",$add_u_arr,"isDelete=0 AND id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' ",0);
			}
			else{
				$user_id = $db->insert("user",$add_u_arr);
			}

			$_SESSION[SESS_PRE.'_SESS_USER_ID']  = $user_id;

			if($user_id!='' && $gust_user_generated_padss==1)
			{
				// $gust_user_d = $db->getValue("user","*","id=".$user_id);
				include("include/notification.class.php");

				if( ISMAIL )
				{
/* 					$subject = "Your account password generated ";
					$nt = new Notification();
					include("mailbody/gust_checkout_user.php");
					// die($body);
					$toemail = $shipping_email;
					$nt->sendEmail($toemail, $subject, $body); */
				}
			}
		}

		$shipp_arr = array(
			"user_id" => !empty($_SESSION[SESS_PRE.'_SESS_USER_ID']) ? $_SESSION[SESS_PRE.'_SESS_USER_ID'] : 0,
			"cart_id" => $cart_id,

			"shipping_first_name" 	=> $shipping_first_name,
			"shipping_last_name" 	=> $shipping_last_name,
			"shipping_address" 		=> $shipping_street_addr,
			"shipping_address2" 	=> $shipping_addr2,
			"shipping_country"	 	=> $shipping_country,
			"shipping_zipcode" 		=> $shipping_post,
			"shipping_state" 		=> $shipping_state,
			"shipping_phone" 		=> $shipping_phone,
			"shipping_city" 		=> $shipping_city,
			"shipping_email"    => $shipping_email

			// "billing_first_name" 	=> $billing_first_name,
			// "billing_last_name" 	=> $billing_last_name,
			// "billing_address" 		=> $billing_street_addr1,
			// "billing_address2" 		=> $billing_addr2,
			// "billing_country" 		=> $billing_country,
			// "billing_city" 			=> $billing_city,
			// "billing_zipcode" 		=> $billing_zip_code,
			// "billing_state" 		=> $billing_state,
			// "billing_phone" 		=> $billing_phone,	
		);


		$dupcheck = $db->dupCheck("billing_shipping","isDelete=0 AND user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND cart_id='".$cart_id."' ");
		if ($dupcheck) 
		{
			$b_id = $db->update("billing_shipping",$shipp_arr,"isDelete=0 AND user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND cart_id='".$cart_id."' ",0);
			// echo $mode;
			// echo "<pre>";
			// print_r($b_id);
			// die;
		}
		else
		{
			$b_id = $db->insert("billing_shipping",$shipp_arr);

		}

		if ($use_billing_save == "on") 
		{
			$billing_arr = array(

				"billing_first_name" 	=> $shipping_first_name,
				"billing_last_name" 	=> $shipping_last_name,
			"billing_address" 		=> $shipping_street_addr,
				"billing_address2" 		=> $shipping_addr2,
				"billing_country" 		=> $shipping_country,
				"billing_city" 			=> $shipping_city,
				"billing_zipcode" 		=> $shipping_post,
				"billing_state" 		=> $shipping_state,
				"billing_phone" 		=> $shipping_phone,
				"billing_email" 		=> $shipping_email,
			);	
			// $db->update("billing_shipping",$billing_arr,"id='".$b_id."' ");
			$db->update("billing_shipping",$billing_arr,"user_id='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' AND cart_id='".$cart_id."' ");
		}

		if($save_addr_from == "on")
		{
			$save_user_addr= array(
				"phone" 	=> $shipping_phone,
				"address1" 	=> $shipping_street_addr,
				"address2" 	=> $shipping_addr2,
				"country" 	=> $shipping_country,
				"city" 		=> $shipping_city,
			);	
			$db->update("user",$save_user_addr,"id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
		}

		if (!empty($shipping_method_select) && $shipping_method_select != "") 
		{
			$ship_method_arr = array("shipping_method_name" => $shipping_method_select);
			$db->update("cart", $ship_method_arr, "id=".$cart_id);
		}

	}

	
	elseif ($mode == 'billing_step') 
	{
		

		if ($_REQUEST['copy_shipping_save']=="on")
		{
			$billing_arr = array(
				"billing_first_name" 	=> $shipping_first_name,
				"billing_last_name" 	=> $shipping_last_name,
				"billing_address" 		=> $shipping_street_addr,
				"billing_address2" 		=> $shipping_addr2,
				"billing_country" 		=> $shipping_country,
				"billing_city" 			=> $shipping_city,
				"billing_zipcode" 		=> $shipping_post,
				"billing_state" 		=> $shipping_state,
				"billing_phone" 		=> $shipping_phone,
				"billing_email" 		=> $shipping_email,
			);
		}
		else
		{
			$billing_arr = array(
				"billing_first_name" 	=> $billing_first_name,
				"billing_last_name" 	=> $billing_last_name,
				"billing_address" 		=> $billing_street_addr1,
				"billing_address2" 		=> $billing_addr2,
				"billing_country" 		=> $billing_country,
				"billing_city" 			=> $billing_city,
				"billing_zipcode" 		=> $billing_zip_code,
				"billing_state" 		=> $billing_state,
				"billing_phone" 		=> $billing_phone,
				"billing_phone" 		=> $shipping_email,
			);
		}

		// echo $_REQUEST['copy_shipping_save'];
		// echo $mode;
		// echo "<pre>";
		// print_r($billing_arr);
		// die;

		$db->update("billing_shipping",$billing_arr,"user_id=".$user_id." AND cart_id=".$cart_id);
	}

	elseif ($mode == "coupon_apply") 
	{
		$coupon_code = $db->clean($_REQUEST['coupon_code']);
		if (!empty($coupon_code)) 
		{
			$coupon_d = $db->getData("coupon","*","expiration_date > NOW() AND isDelete=0 AND code='".$coupon_code."'","",0);
			if (mysqli_num_rows($coupon_d)>0) 
			{
				$coupon_r = mysqli_fetch_assoc($coupon_d);
				$cart_total_val = $db->getValue("cart","grand_total","id=".$cart_id);
				if($coupon_r['min_spend_amount'] > $cart_total_val)
				{
					echo 'Not_Acceptable';
						exit;
				}

				$check_dup = $db->getData("cart","*","id=".$cart_id." AND coupon_id=".$coupon_r['id']);
				if (mysqli_num_rows($check_dup)>0) 
				{
					echo "Already_Apply";
					exit;	
				}
				else
				{
					$cart_total_val = $db->getValue("cart","grand_total","id=".$cart_id);

					if ($coupon_r['type'] == "percent") 
					{	
						$discount = ($cart_total_val * $coupon_r['amount']) / 100;
						$grand_total = $cart_total_val - $discount;
					}
					elseif ($coupon_r['type'] == "flat") 
					{
						$discount = $coupon_r['amount'];
						$grand_total = $cart_total_val - $coupon_r['amount'];
					}
					elseif ($coupon_r['type'] == "full") 
					{
						$discount = $cart_total_val - .01;
						$grand_total = $cart_total_val - $discount;
					}


					if ($cart_total_val > $discount) 
					{
						$coupon_arr = array(
							"discount_type" => $coupon_r['type'],
							// "discount"		=> number_format($discount ,2),
							"discount"		=> $discount,
							"coupon_id"		=> $coupon_r['id'],
							"coupon_code"	=> $coupon_r['code'],
							//"grand_total"	=> number_format($grand_total,2),
							"grand_total"	=> $grand_total,
						);
						$db->update("cart",$coupon_arr,"id=".$cart_id);
					}
					else
					{
						echo 'Not_Acceptable';
						exit;
					}
				}  
			}
			else
			{
				echo 'Invalid_Coupon';
				exit;
			}
		} else {
			echo "No coupon!";
			exit;
		}
	}

	elseif ($mode == "coupon_remove")
	{
		$cart_id = $_REQUEST['cart_id'];
		$sub_val = $_REQUEST['sub_val'];

		$cr_arr = array(
			"discount_type" => "",
			"discount"		=> 0,
			"coupon_id"		=> 0,
			"coupon_code"	=> "",
			"grand_total"	=> $sub_val,
		);

		$db->update("cart",$cr_arr,"isDelete=0 AND id=".$cart_id);
	}
