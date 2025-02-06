<?php
$bg_img = SITEURL."mailbody/images/bg1.jpg";
$ta = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 10px 20px; color: #404040; font-family: lato";
$body = '
<table width="600px" border="0" style="'.$ta.'">
	<tr>
		<td style="padding-bottom: 36px;border:none; text-align: center;"><img src="'.SITEURL.'mailbody/images/logo-3.png" style="margin:7px; vertical-align:middle;"></td>
	</tr>
	<tr>
		<td style="padding:30px; background-color: #fff;border:none; border-radius: 5px;">
			<table width="100%" border="0" style="text-align: left;">
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:0px 50px 5px;">Hello ' . $name . ',</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:normal;padding:0px 50px 5px;">Hurray! Your profile get activated!</td>
				</tr>
				<tr>
					<td style="font-size: 14px; font-weight:normal;padding:0px 50px 5px;line-height: 20px;">Welcome to the ' . SITETITLE . '. You can now access your account!
					</td>
				</tr>
				<tr>
					<td style="padding:0 84px 30px;"><a href="'.SITEURL.'login/" style="padding:15px;display:block;font-size: 16px; font-weight: bold; color: #fff;background-color: #212529; text-decoration:none; text-align:center;">Login</a></td>
				</tr>
			</table>
		</td>
	</tr>
</table>';
?>