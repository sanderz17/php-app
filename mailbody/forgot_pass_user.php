<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";
$reseturl 	= SITEURL."set-new-password/".md5($id)."/".$fps."/";

$ta = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
// $ta = "margin:0 auto;background-color:#fff;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$body = '
<table width="600px" border="0" style="'.$ta.'">
	<tr>
		<td style="padding-bottom: 36px;border:none; text-align: center;"><img src="'.SITEURL.'mailbody/images/logo-3.png" style="width:150px;margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="padding:30px 0px 0px 0px; background-color: #fff;border:none; border-radius: 5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 5px;">Hi ' . $fname . '!</td>
				</tr>
				<tr>
					<td style="font-size: 14px; font-weight:normal;padding:0 30px 30px;line-height: 20px;">
					We have received a request to reset your '.SITETITLE.' account password. If you did not request a password reset, please ignore this email or reply to let us know. You can reset by clicking the button below.
					</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 5px;">
						<a href="'.$reseturl.'" style="padding: 15px; display: inline-block !important; color: #ffffff; line-height: 32px; text-align: center; border-radius: 8px; background: #5a0a2d; min-width: 162px; display: flex; justify-content: center; align-items: center; font-family: \'Mier A\'; font-weight: 700; font-size: 24px; text-decoration: none; margin: 4px 2px; cursor: pointer;">Reset Your Password</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>


