<?php
$bg_img 	= SITEURL."mailbody/images/bg1.jpg";
$reseturl 	= ADMINURL."set-new-password/".md5($id)."/".$fps."/";

//$re = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
$re = "margin:0 auto;background-color:#fff;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom:50px; border:none; text-align:center;"><img src="'.ADMINURL.'assets/images/logo-3.png" style="width:100px;margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="padding:30px; background-color:#fff; border:none; border-radius:5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size:16px;" align="left">
						Hello '.$name.', <br /><br />
					</td>
				</tr> 
				<tr>
					<td style="font-size:16px; padding-bottom:30px;" align="left">
						We have received a request to reset your password. You can reset by clicking the button below. 
					</td>
				</tr> 
				<tr>
					<td style="font-size:16px; padding:10px;">
						<a href="'.$reseturl.'" style="padding: 15px; display: inline-block !important; color: #ffffff; line-height: 32px; text-align: center; border-radius: 8px; background: #5a0a2d; min-width: 162px; display: flex; justify-content: center; align-items: center; font-family: \'Mier A\'; font-weight: 700; font-size: 24px; text-decoration: none; margin: 4px 2px; cursor: pointer;">Reset Your Password</a>
					</td>
				</tr>
				<tr>
					<td style="font-size:16px; padding-top:30px;" align="left">
						'.SITETITLE.' Team.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>