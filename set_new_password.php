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
				<h1 class="dashboard-title">RESET PASSWORD</h1>
				<form action="<?php echo SITEURL ?>process-reset-password/" method="post" id="forgot_frm" name="forgot_frm">
					<input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>" />
				    <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" />
	    			<div class="field-wrapper">
	    				<div class="form-group">
							<input type="password" class="form-control" placeholder="New password" id="password" name="password">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" placeholder="Confirm password" id="cpassword" name="cpassword">
						</div>
					    <button class="form-control forgot-btn" type="submit" value="Send" name="dwfrm_requestpassword_send">SEND</button>
					</div>
				</form>
			</div>

        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>

        <script type="text/javascript">
        	
        	$('.loader').hide();

	        	$("#forgot_frm").validate({
		            rules: {
		                password:{required : true, minlength:6},
		                cpassword:{required:true,equalTo:"#password"},
		            },
		            messages: {
		                password:{required:"Please enter password.",minlength:"Please enter atleast 5 character."},
		                cpassword:{required: "Please enter confirm password",equalTo:"password not match."}
		            }, 
			        errolacement: function(error, element) {
					}
		        });

        </script>

	</body>
</html>