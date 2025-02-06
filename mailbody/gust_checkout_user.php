<?php
$bg_img = SITEURL."mailbody/images/bg1.jpg";
//$ta = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$ta = "margin:0 auto;background-color:#fff;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$body = '
<table width="600px" border="0" style="'.$ta.'">
	<tr>
		<td style="padding-bottom: 36px;border:none; text-align: center;"><img src="'.SITEURL.'mailbody/images/logo-3.png" style="width:150px;margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="background-color: #fff;border:none; border-radius: 5px;">
			<table width="100%" border="0" style="text-align: left; font-size: 14px; font-weight:normal;padding:30px;line-height: 20px;">
				<tr>
					<td>Hello '.$shipping_first_name . '' . $shipping_last_name .',</td>
				</tr>
				<tr>
					<td>Please find the details below:</td>
				</tr>
				<tr>
					<td>
						Name : <strong>'.$shipping_first_name . '' . $shipping_last_name .'</strong><br/>
						Email : <strong>'.$shipping_email.'</strong><br/>
                        Password : <strong>'.$check_out_signup_password.'</strong>
					</td>
				</tr>
				<tr>
					<td><br /><br />'.SITETITLE.' Team.</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>