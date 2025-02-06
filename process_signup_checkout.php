<?php
	include("connect.php");
	include("include/notification.class.php");

	// print_r($_REQUEST); exit;

	$first_name			= 	$db->clean($_REQUEST['first_name']);
	$last_name 			= 	$db->clean($_REQUEST['last_name']);
	$email 				= 	$db->clean($_REQUEST['email']);
	$password 			= 	$db->clean($_REQUEST['password']);
	$confirmation_string = $db->generateRandomString(8);

	if($email!="" && $password!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
	{
		$r = $db->dupCheck("user", "email = '".$email."' AND isDelete=0");

		if($r)
		{
			$_SESSION['MSG'] = "Already_registred_email";
			$db->location(SITEURL."checkout-login/");
			exit;
		}
		else
		{
			$rows 	= array(
				"first_name"	=> $first_name,
				"last_name"		=> $last_name,
				"email"			=> $email,
				"password"		=> md5($password),
				"confirmation_string" => $confirmation_string,
			);
			cb_logger("new user process_signup_checkout=$first_name");
			$uid = $db->insert('user', $rows);

			if($uid!='')
			{
				if( ISMAIL )
				{
					$subject = "Activate your account";
					$nt = new Notification();
					include("mailbody/signup_str.php");
					// die($body);
					$toemail = $email;
					$nt->sendEmail($toemail, $subject, $body);
				}

				$_SESSION['MSG'] = "Success_Signup";
				$db->location(SITEURL."checkout-login/");
			}
		}
	}
	else
	{
		$_SESSION['MSG'] = 'FILL_ALL_DATA';
		$db->location(SITEURL."checkout-login/");
	}
?>