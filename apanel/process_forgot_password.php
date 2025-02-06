<?php
	include("connect.php"); 
	include("../include/notification.class.php");

	$email 	= $db->clean($_POST['email']);

	if($email!="" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false)
	{
		$check_user_r = $db->getData(CTABLE_ADMIN, "id, CONCAT(first_name, ' ', last_name) AS name, email", "email = '".$email."' AND isArchived=0 ");
		
		if(@mysqli_num_rows($check_user_r)>0)
		{
			$check_user_d = @mysqli_fetch_assoc($check_user_r);
			$id 	=  $check_user_d['id'];
			$name 	=  $check_user_d['name'];
			$email 	=  $check_user_d['email'];
			$fps	=  $db->generateRandomString(8);

			$rows 	= array("forgot_pass_string" => $fps);
			$db->update(CTABLE_ADMIN, $rows, "id=".$id);

			if(ISMAIL)
			{
				$nt = new Notification();
				$reseturl = ADMINURL."set-new-password/".md5($id)."/".$fps."/";
				include("../mailbody/admin_forgot_pass.php");

				$subject = "Reset your password";
				//die($body);
				$nt->sendEmail($email, $subject, $body); 
			}
			
			$_SESSION['MSG'] = 'Success_Fsent';
			$db->location(ADMINURL);
		}
		else
		{
			$_SESSION['MSG'] = 'No_Data_Found';
			$db->location(ADMINURL."forgot-password/");
		}
	}
	else
	{
		$_SESSION['MSG'] = 'Something_Wrong';
		$db->location(ADMINURL."forgot-password/");
	}
?>