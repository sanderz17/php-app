<?php
	include("connect.php");
	if((isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) && $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']>0)){
		$db->location(ADMINURL."dashboard/");
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include('include/css.php'); ?>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="<?php echo ADMINURL; ?>assets/images/logo-3.png" height="60"><span class="text-primary" style="font-size: 25px; font-weight: bold;" title="<?php echo SITETITLE; ?>" alt="<?php echo SITETITLE; ?>"></span>
                </div>
                <h4>Reset Password</h4>
	            <form class="pt-3" name="frm" id="frm" method="post" action="<?php echo ADMINURL."process-set-new-password/"; ?>">
					<input type="hidden" name="slug" id="slug" value="<?php echo $_REQUEST['slug']; ?>" />
	  				<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>" />
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="newpass" id="newpass" placeholder="Enter New Password" maxlength="20">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="cnewpass" id="cnewpass" placeholder="Confirm New Password" maxlength="20">
                  </div>
                  <div class="mt-3">
                    <button class="btn btn-block btn-gradient-dark btn-lg font-weight-medium auth-form-btn">CHANGE PASSWORD</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light">
                  	Click here to <a href="<?php echo ADMINURL; ?>" class="auth-link">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <?php include('include/js.php'); ?>
	<script type="text/javascript">
		$(function(){
			$("#frm").validate({
				rules: {
					newpass:{required:true},
					cnewpass:{required:true, equalTo:"#newpass"},
				},
				messages: {
					newpass:{required:"Please enter new password."},
					cnewpass:{required:"Please enter confirm password.", equalTo:"Passwords do not match."},
				}
			});
		});
	</script>
 </body>
</html>