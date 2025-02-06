

<?php 
	include('connect.php'); 
	include("include/notification.class.php");
	$a = json_encode($_REQUEST);
	//@mail("crazycoder08@gmail.com", "Paypal Response ", $a);

	$_POST = json_decode($a,true);
	
	if(isset($_POST)){
		if($_POST['payment_status'] == 'Completed'){

			$paypal_response = json_encode($_POST);
			$custom_arr = explode(",", $_POST['custom']);
           
			$user_id 			= $custom_arr[0];
			$guest_user_id 	    = $custom_arr[1];
			$cart_det_id 		= $custom_arr[2];
			$grandtotal 		= $custom_arr[3];
			$history_id 		= $custom_arr[4];

		
			if(isset($cart_det_id) && $cart_det_id > 0 ){
				
				$adate				= date('Y-m-d H:i:s');;
				$total_amount 		= $_POST['mc_gross'];
				$transaction_id 	= $_POST['txn_id'];
					
				$rows = array(
						  "payment_status" 	=> 2
						, "payment_date" 	=> $adate
						, "txn_id" 			=> $transaction_id
						, "err_msg" 		=> 'success'
					);
				$db->update("payment_history", $rows, 'id = ' . $history_id);

				// $rows = array("status" => "DONE");
				// $db->rpupdate("coupon_apply", $rows, "uid=" . $user_id . " AND status='PENDING'");

				$rows = array(
							//   "order_complete"	=> 1
							 "order_status"	=> 2
							, "order_date"		=> date('Y-m-d H:i:s')
						);
				//$db->rpupdate("cart_detail", $rows, "user_id=" . $user_id . " AND id = " . $_SESSION[SESS_PRE.'_SESS_CART_ID']);
				$db->update("cart", $rows, "customer_id=" . $user_id . " AND id = " . $cart_det_id);



				unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);
				unset($_SESSION[SESS_PRE.'_SESS_GUEST_ID']);

				//$_SESSION['MSG'] = "Send Mail Successfully";
				$db->location(SITEURL."thankyou/");

		        // /* EMail Send Code Start */
		        // $nt = new Notification();
		        // //$email = $db->rpgetValue('candleroses', 'email', 'isDelete=0');
		        // $email = SITEMAIL;
		        // //$email = 'freeeup.kkalyani@gmail.com';		// for testing

				// $logo = $db->rpgetValue('storeinfo', 'site_logo', 'id=1');
				// $site_logo = '';
				// if( !empty($logo) && !is_null($logo) && @getimagesize(SITEURL.LOGO.$logo) )
				// {
				// 	$site_logo = SITEURL.LOGO.$logo;
				// }else{
				//     $site_logo = SITEURL . 'images/Euphoric-logo-ORANGE-flower.png';
				// }

		        // include("mailbody/order_placed.php");
		        // $toemail  = $email; 
		        // $subject  = 'New Order Received';
		        // $body     = $body;

		        // $nt->rpsendEmail($toemail, $subject, $body);
		     	/* EMail Send Code End */

			}
		}
	}
	
?>
