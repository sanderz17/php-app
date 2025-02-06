<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= CTABLE_ADMIN;
	$ctable1 	= 'My Account';
	$main_page 	= 'Dashboard'; //for sidebar active menu
	$page		= 'my-account';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;


	$first_name = '';
	$last_name = '';
	$email = '';
	$phone = '';

	if(isset($_REQUEST['submit']))
	{
		$first_name = $db->clean($_REQUEST['first_name']);
		$last_name 	= $db->clean($_REQUEST['last_name']);
		$email 		= $db->clean($_REQUEST['email']);
		$phone 		= $db->clean($_REQUEST['phone']);

		$rows 	= array(
			"first_name" => $first_name,
			"last_name" => $last_name,
			"email" => $email,
			"phone" => $phone,
		);

		$check_user_r = $db->getData($ctable, "*", "id <> " . $_SESSION[SESS_PRE.'_ADMIN_SESS_ID'] . " AND email = '".$email."' AND isArchived=0");
	
		if($check_user_r->num_rows > 0)
		{
			$_SESSION['MSG'] = "Duplicate";
			$db->location(ADMINURL.$page.'/');
			exit;
		}
		else
		{
			$db->update($ctable, $rows, "id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']);

			$_SESSION['MSG'] = "Updated";
			$db->location(ADMINURL.$page.'/');
			exit;
		}
	}

	$where 		= " id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID']." AND isArchived=0";
	$ctable_r 	= $db->getData($ctable, "*", $where);
	$ctable_d 	= mysqli_fetch_assoc($ctable_r);
	// die('11');

	$first_name = stripslashes($ctable_d['first_name']);
	$last_name = stripslashes($ctable_d['last_name']);
	$email = stripslashes($ctable_d['email']);
	$phone = stripslashes($ctable_d['phone']);
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
								<i class="mdi mdi-account-edit"></i>
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
														<label for="first_name">First Name <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="<?php echo $first_name; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="last_name">Last Name <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="<?php echo $last_name; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="email">Email <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?php echo $email; ?>" readonly>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="phone">Phone <code>*</code></label>
														<input maxlength="20" type="text" class="form-control" name="phone" id="phone" placeholder="Enter Contact Number" value="<?php echo $phone; ?>">
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
						first_name:{required:true},
						last_name:{required:true},
						email:{required:true, email:true},
						phone:{required:true},
					},
					messages: {
						first_name:{required:"Please enter first name."},
						last_name:{required:"Please enter last name."},
						email:{required:"Please enter email address.", email:"Please enter valid email address."},
						phone:{required:"Please enter contact number."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>