<?php
include("connect.php");
$email 		= $db->clean($_REQUEST['email']);
$password 	= $db->clean($_REQUEST['password']);

if($email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
{
	$check_user_r = $db->getData("user", "*", "email = '".$email."' AND  password = '".md5($password)."' AND isDelete=0");
	
	if($check_user_r)
	{
		$check_user_d = @mysqli_fetch_assoc($check_user_r);

		if($check_user_d['isActive']==1)
		{
			$id 	=  $check_user_d['id'];
			$name 	=  $check_user_d['first_name'].' '.$check_user_d['last_name'];
			$email 	=  $check_user_d['email'];
			

			$_SESSION[SESS_PRE.'_SESS_USER_ID'] 	= 	$id;
			// print_r($_SESSION[SESS_PRE.'_SESS_USER_ID']);
			// exit;
			$_SESSION[SESS_PRE.'_SESS_USER_NAME'] 	= 	$name;
			$_SESSION[SESS_PRE.'_SESS_USER_EMAIL'] 	= 	$email;
			
			 $cart_id = (int) $db->getValue('cart', 'id', 'order_status=1 AND customer_id=' . (int)$_SESSION[SESS_PRE.'_SESS_USER_ID'] . ' AND isDelete=0');
				if( $cart_id > 0 ){
			// 	if(isset($_SESSION['token'])){
			// 		$row = array(
			// 			"customer_id" 	=> $cart_id,
			// 		);
			// 		$token = "order_no = '".$_SESSION['token']."'";
			// 		$db->update("cart",$row,$token);
			// 	}

			// 	$_SESSION[SESS_PRE.'_SESS_CART_ID'] = $cart_id;
			// 	$_SESSION['MSG'] = 'Success_Login';
			// 	$db->location(SITEURL);
			
		
				if(isset($_SESSION['token'])){
					$row = array(
						"customer_id" 	=> $_SESSION[SESS_PRE.'_SESS_USER_ID'], 
					);
					$token = "order_no = '".$_SESSION['token']."'";
					$db->update("cart",$row,$token);
				}
			 }
				$_SESSION[SESS_PRE.'_SESS_CART_ID'] = $cart_id;
				$_SESSION['MSG'] = 'Success_Login';
				$db->location(SITEURL."profile/");
				//  print_r($_SESSION['token'] );
				// exit;
		}
		else
		{
			$_SESSION['MSG'] = 'Acc_Not_Verified';
			$db->location(SITEURL."login/");
		}
	}
	else
	{
		$_SESSION['MSG'] = 'Invalid_Email_Password';
		$db->location(SITEURL."login/");
	}
}
else
{
	$_SESSION['MSG'] = 'Something_Wrong';
	$db->location(SITEURL."login/");
}
?>