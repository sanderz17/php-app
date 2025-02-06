<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";
$activate_link 	= ADMINURL."activate-account/".md5($row['id'])."/".$row['confirmation_string']."/";

$re = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
// $re = "margin:0 auto;background-color:#8141a1;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom:50px; border:none; text-align:center;"><img src="'.SITEURL.'mailbody/images/main-logo.png" style="width:150px;margin-top:17px;"></td>
	</tr>
	<tr>
		<td style="padding:30px; background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size:16px;" align="left">
						Your details are successfully submitted to the administrator and we will contact you soon.<br /><br />
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						The details are as follows:
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>First Name : </strong> ' .$firstname. '
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Last Name : </strong> ' .$lastname. '
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Email : </strong> ' .$email. ' 
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Contact Number : </strong> ' .$number. ' 
					</td>
				</tr>
				
				<tr>
					<td style="font-size:16px; padding-bottom:15px;" align="left">
						<strong>Message : </strong> ' . $message . '
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						'.SITETITLE.' Team.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>