<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= 'site_setting';
	$ctable1 	= 'Site Setting';
	$main_page 	= 'Dashboard'; //for sidebar active menu
	$page		= 'setting';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$address 		= '';
	$mnumber 		= '';
	$facebook_link 	= '';
	$twitter_link 	= '';
	$email			= '';
	$banner_title	= '';
	$btn_link		= '';

	if(isset($_REQUEST['submit']))
	{
		$address 		= $db->clean($_REQUEST['address']);
		$email			= $db->clean($_REQUEST['email']);
		$mnumber 		= $db->clean($_REQUEST['mnumber']);
		$facebook_link 	= $db->clean($_REQUEST['facebook_link']);
		$twitter_link 	= $db->clean($_REQUEST['twitter_link']);
		$instagram_link = $db->clean($_REQUEST['instagram_link']);
		$youtube_link 	= $db->clean($_REQUEST['youtube_link']);
		$banner_title 	= $db->clean($_REQUEST['banner_title']);
		$btn_link 		= $db->clean($_REQUEST['btn_link']);

		$rows 	= array(
			"address" 			=> $address,
			"mnumber" 			=> $mnumber,
			"facebook_link"		=> $facebook_link,
			"twitter_link" 		=> $twitter_link,
			"instagram_link"	=> $instagram_link,
			"youtube_link"		=> $youtube_link,
			"email"				=> $email,
			"banner_title"		=> $banner_title,
			"btn_link"			=> $btn_link,
		);

		$rsdupli = $db->getData($ctable, "*", "id <> " . $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']);
	
		if(@mysqli_num_rows($rsdupli) > 0)
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

	$where 		= " id=".$_SESSION[SESS_PRE.'_ADMIN_SESS_ID'];
	$ctable_r 	= $db->getData($ctable, "*", $where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

	$address 	= stripslashes($ctable_d['address']);
	$mnumber 	= stripslashes($ctable_d['mnumber']);
	$facebook_link 	= stripslashes($ctable_d['facebook_link']);
	$twitter_link 	= stripslashes($ctable_d['twitter_link']);
	$instagram_link = stripslashes($ctable_d['instagram_link']);
	$youtube_link 	= stripslashes($ctable_d['youtube_link']);
	$email		 	= stripslashes($ctable_d['email']);
	$banner_title	= stripslashes($ctable_d['banner_title']);
	$btn_link		= stripslashes($ctable_d['btn_link']);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
		<?php include('include/css.php'); ?>
		<link href="<?php echo ADMINURL; ?>assets/js/crop/css/demo.html5imageupload.css?v1.3" rel="stylesheet">
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
								<i class="mdi mdi-settings"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
									<form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<div class="card-body">
											<fieldset>
												<legend>Information</legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="address">Address<code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="address" id="address" placeholder="Enter address" value="<?php echo $address; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="twitter_link">Mobile <code>*</code></label>
															<input maxlength="20" type="text" class="form-control" name="mnumber" id="mnumber" placeholder="Enter mobile number" value="<?php echo $mnumber; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="email">email <code>*</code></label>
															<input maxlength="100" type="email" class="form-control" name="email" id="email" placeholder="Enter email address" value="<?php echo $email; ?>">
														</div>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<legend>Social Media Links</legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="facebook_link">Facebook Link <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="facebook_link" id="facebook_link" placeholder="Enter Facebook Link" value="<?php echo $facebook_link; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="twitter_link">Twitter Link <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="twitter_link" id="twitter_link" placeholder="Enter Twitter Link" value="<?php echo $twitter_link; ?>">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="instagram_link">Instagram Link <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="instagram_link" id="instagram_link" placeholder="Enter instagram Link" value="<?php echo $instagram_link; ?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="youtube_link">Youtube Link <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="youtube_link" id="youtube_link" placeholder="Enter youtube Link" value="<?php echo $youtube_link; ?>">
														</div>
													</div>
												</div>
											</fieldset>
											<fieldset>
												<legend>Home Page Banner </legend>
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="banner_title">Banner Title <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="banner_title" id="banner_title" placeholder="Enter Banner Title" value="<?php echo $banner_title; ?>"  >
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label for="btn_link">Button Link <code>*</code></label>
															<input maxlength="400" type="text" class="form-control" name="btn_link" id="btn_link" placeholder="Enter Button Link" value="<?php echo $btn_link; ?>" >
														</div>
													</div>
												</div>
											</fieldset>
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
		<script src="<?php echo ADMINURL; ?>assets/js/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
		<script type="text/javascript">
			var custom_img_width = 150;
		
			$('#dropzone').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});

			// $(document).ready(function(){
			$(function(){
				$("#frm").validate({
					// ignore: "",
					rules: {
						address1:{required:true},
						address2:{required:true},
						mnumber:{required:true, number:true},
						facebook_link:{required:true, url:true},
						twitter_link:{required:true, url:true},
						banner_title:{required:true},
						btn_link:{required:true},
					},
					messages: {
						address1:{required:"Please enter address."},
						address2:{required:"Please enter address."},
						mnumber:{required:"Please enter mobile number.", number:"Please enter numbers."},
						facebook_link:{required:"Please enter Facebook link.", url:"Please enter valid url."},
						twitter_link:{required:"Please enter Twitter link.", url:"Please enter valid url."},
						banner_title:{required:"Please enter banner title."},
						btn_link:{required:"Please enter button link."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>