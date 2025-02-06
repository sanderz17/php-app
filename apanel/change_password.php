<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= CTABLE_ADMIN;
	$ctable1 	= 'Change Password';
	$main_page 	= 'Dashboard'; //for sidebar active menu
	$page		= 'change-password';
	$page_title = $ctable1;

	if(isset($_REQUEST['submit']))
	{
		$where = " id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']." AND isArchived=0";
		$admin_r = $db->getData(CTABLE_ADMIN, "*", $where);
		$admin_d = @mysqli_fetch_assoc($admin_r);

		$old_password	= $admin_d['password'];
		$opassword		= md5(trim($_REQUEST['opassword']));
		$password		= md5(trim($_REQUEST['password']));

		if($old_password != $opassword)
		{
			$_SESSION['MSG'] = 'PASS_NOT_MATCH';
			$db->location(ADMINURL."change-password/");
			exit;
		}
		elseif($opassword == $password)
		{
			$_SESSION['MSG'] = 'CURRENT_PASS_MATCH';
			$db->location(ADMINURL."change-password/");
			exit;
		}
		else
		{
			$rows 	= array("password" => $password);
			$where	= "id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] ." AND isArchived=0";
			$db->update(CTABLE_ADMIN, $rows, $where);

			$_SESSION['MSG'] = 'PASS_CHANGED';
			$db->location(ADMINURL."change-password/");
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
		<?php include('include/css.php'); ?>
	</head>

	<body>
		<div class="container-scroller">
			<?php include("include/header.php"); ?>
			<div class="container-fluid page-body-wrapper">
				<?php include("include/left.php"); ?>
				<div class="main-panel">
					<div class="content-wrapper">
						<div class="page-header">
							<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-textbox-password"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
									<form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="opassword">Current Password <code>*</code></label>
														<input maxlength="20" type="password" class="form-control" name="opassword" id="opassword" placeholder="Enter Current Password" value="" autocomplete="off">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="password">New Password <code>*</code></label>
														<input maxlength="20" type="password" class="form-control" name="password" id="password" placeholder="Enter New Password" value="" autocomplete="off">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="cpassword">Confirm Password <code>*</code></label>
														<input maxlength="20" type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Enter New Password" value="" autocomplete="off">
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Save Changes" class="btn btn-gradient-dark btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- content-wrapper ends -->
					<?php include("include/footer.php"); ?>
				</div>
				<!-- main-panel ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<?php include('include/js.php'); ?>
		<script type="text/javascript">
			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						opassword:{required:true},
						password:{required:true},
						cpassword:{required:true, equalTo:"#password"},
					},
					messages: {
						opassword:{required:"Please enter current password."},
						password:{required:"Please enter new password."},
						cpassword:{required:"Please re-enter new password.", equalTo:"New and Confirm passwords do not match."},
					}, 
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>