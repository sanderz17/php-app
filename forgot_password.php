<?php
	include "connect.php";
	if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] != "") {
		$db->location(SITEURL);
	}
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
		<!--  header section start -->
         <section class="product-header-images">
         
		 </section>
		<!-- header section end -->
			<div class="set-new-password-page">
				<h1 class="dashboard-title">Request to Reset Your Password</h1>
				<p class='text-center'>PROVIDE YOUR ACCOUNT EMAIL ADDRESS TO RECEIVE AN EMAIL TO RESET YOUR PASSWORD.</p>
				<form action="<?php echo SITEURL ?>process-forgot-password/" method="post" id="forgot_frm" name="forgot_frm">
	    			<div class="field-wrapper">
	        			<input class="form-control" required="" type="text" id="forgot_input" name="forgot_input"/>
					    <button class="form-control forgot-btn rounded-0" type="submit" value="Send" name="dwfrm_requestpassword_send">SEND</button>
					</div>
				</form>
			</div>

        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>

        <script type="text/javascript">
        	
        	$('.loader').hide();

	        	$("#forgot_frm").validate({
		            rules: {
		                forgot_input:{required : true,email: true},
		            },
		            messages: {
		                forgot_input:{required:"Please enter email address.", email:"Please enter valid email."},
		            }, 
			        errolacement: function(error, element) {
					}
		        });

        </script>

	</body>
</html>