<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Login</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
		<div class="loader"></div>
         <section class="product-header-images">
		 </section>
			<div class="set-new-password-page">
				<h1 class="dashboard-title">REQUEST TO RESET YOUR PASSWORD RECEIVED</h1>
				<form id="forgot_frm" name="forgot_frm">
	    			<div class="field-wrapper">
						<p>THANKS FOR SUBMITTING YOUR EMAIL ADDRESS. WE'VE SENT YOU AN EMAIL WITH THE INFORMATION NEEDED TO RESET YOUR PASSWORD. THE EMAIL MIGHT TAKE A COUPLE OF MINUTES TO REACH YOUR ACCOUNT. PLEASE CHECK YOUR JUNK MAIL TO ENSURE YOU RECEIVE IT..</p>
					    <button class="form-control button-primary forgot-btn" type="button"><a href="<?php echo SITEURL ?>login/"> Go to the Home page</a></button>
					</div>
				</form>
			</div>

        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
	</body>
</html>