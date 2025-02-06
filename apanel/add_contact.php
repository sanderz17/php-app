<?php	
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");

	$ctable 	= 'contact';
	$ctable1 	= 'Contact';
	$main_page 	= 'user'; //for sidebar active menu
	$page		= 'contact';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$firstname = "";
	$lastname = "";
	$email = "";
	$number = "";
	$street_address = "";
	$city = "";
	$country = "";
	$state = "";
	$zip_code = "";
	// $query_type	= "";
	$message = "";
	$isAttended = "";

	if(isset($_REQUEST['submit']))
	{
		$firstname = $db->clean($_REQUEST['firstname']);
		$lastname = $db->clean($_REQUEST['lastname']);
		$email = $db->clean($_REQUEST['email']);
		$number = $db->clean($_REQUEST['number']);
		$street_address = $db->clean($_REQUEST['street_address']);
		$city = $db->clean($_REQUEST['city']);
		$country = $db->clean($_REQUEST['country']);
		$state = $db->clean($_REQUEST['state']);
		$zip_code = $db->clean($_REQUEST['zip_code']);
		// $query_type = $db->clean($_REQUEST['query_type']);
		$message = $db->clean($_REQUEST['message']);
		$isAttended = (int) $db->clean($_REQUEST['isAttended']);

		$rows 	= array(
			'firstname' => $firstname,
			'lastname' => $lastname,
			'email' 	=> $email,
			'number'		=> $number,
			'street_address'		=> $street_address,
			'city'		=> $city,
			'country'		=> $country,
			'state'		=> $state,
			'zip_code'		=> $zip_code,
			// 'query_type'	=> $query_type,
			'message'		=> $message,
			'isAttended'	=> $isAttended,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$uid = $db->insert($ctable, $rows);
			
			if ($uid != "") 
			{
				if(ISMAIL)
				{
					$nt = new Notification();
					$subject = SITETITLE." : New contact request received";
					include("../mailbody/contact_to_admin.php");
					// die($body);
					$nt->sendEmail($email, $subject, $body); 

					$subject = SITETITLE." : Contact request sent successfully";
					include("../mailbody/contact_to_user.php");
					// die($body);
					$nt->sendEmail(SITEMAIL, $subject, $body); 
				}
			}

			$_SESSION['MSG'] = 'Inserted';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$db->update($ctable, $rows, 'id='.$id);

			$_SESSION['MSG'] = 'Updated';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
	}
	
	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 	= 'id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r = $db->getData($ctable, '*', $where);
		$ctable_d = @mysqli_fetch_assoc($ctable_r);

		$firstname = stripslashes($ctable_d['firstname']);
		$lastname = stripslashes($ctable_d['lastname']);
		$email = stripslashes($ctable_d['email']);
		$number = htmlspecialchars_decode($ctable_d['number']);
		$street_address = htmlspecialchars_decode($ctable_d['street_address']);
		$city = htmlspecialchars_decode($ctable_d['city']);
		$country = htmlspecialchars_decode($ctable_d['country']);
		$state = htmlspecialchars_decode($ctable_d['state']);
		$zip_code = htmlspecialchars_decode($ctable_d['zip_code']);
		// $query_type = htmlspecialchars_decode($ctable_d['query_type']);
		$message = htmlspecialchars_decode($ctable_d['message']);
		$isAttended = stripslashes($ctable_d['isAttended']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array('isDelete' => '1');
		
		$db->update($ctable, $rows, 'id='.$id);
		
		$_SESSION['MSG'] = 'Deleted';
		$db->location(ADMINURL.'manage-'.$page.'/');
		exit;
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
							<span class="page-title-icon bg-gradient-info text-white mr-2">
								<i class="mdi mdi-account"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
							    	<form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
								    	<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="firstname">First Name <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter First Name" value="<?php echo $firstname; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="lastname">Last Name <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Last Name" value="<?php echo $lastname; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="email">Email <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?php echo $email; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="number">Phone <code>*</code></label>
														<input maxlength="20" type="text" class="form-control" name="number" id="number" placeholder="Enter Phone" value="<?php echo $number; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="street_address">Street Address <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="street_address" id="street_address" placeholder="Enter Street Address" value="<?php echo $street_address; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="city">City <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="city" id="city" placeholder="Enter City" value="<?php echo $city; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="country">Country <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="country" id="country" placeholder="Enter Country" value="<?php echo $country; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="state">State <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="state" id="state" placeholder="Enter State" value="<?php echo $state; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="zip_code">Zip Code <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Enter Zip Code" value="<?php echo $zip_code; ?>">
													</div>
												</div>
												<!-- <div class="col-md-6">
													<div class="form-group">
														<label for="query_type">Query Type <code>*</code></label>
														<select name="query_type" id="query_type" class="form-control">
															<option value="General" <?php if($query_type=='General') echo 'selected'; ?>>General</option>
															<option value="Billing" <?php if($query_type=='Billing') echo 'selected'; ?>>Billing</option>
															<option value="Technical" <?php if($query_type=='Technical') echo 'selected'; ?>>Technical</option>
														</select>
													</div>
												</div> -->
												<div class="col-md-6">
													<div class="form-group">
														<label for="message">Message <code>*</code></label>
														<textarea class="form-control" name="message" id="message" placeholder="Enter message" rows="4"><?php echo $message; ?></textarea>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<div class="button-list">	
															<div class="btn-switch btn-switch-info pull-right">
																<input type="checkbox" name="isAttended" id="isAttended" value="1" <?php if($isAttended=="1"){ echo "checked";}?>/>
																<label for="isAttended" class="btn btn-rounded btn-info waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> Is Attended? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
											<button type="button" title="Back" class="btn btn-gradient-danger btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<?php include("include/footer.php"); ?>
				</div>
			</div>
		</div>

		<?php include('include/js.php'); ?>
		<script type="text/javascript">
			$(function(){
				$("#frm").validate({
					ignore:"",
					rules: {
						firstname:{required:true},
						lastname:{required:true},
						email:{required:true, email:true},
						number:{ required:true},		
						// query_type:{ required:true},		
						message:{ required:true},		
					},
					messages: {
						firstname:{required:"Please enter first name."},
						lastname:{required:"Please enter last name."},
						email:{required:"Please enter email.", email:"Please enter valid email address."},
						number:{required:"Please enter phone number."},
						// query_type:{required:"Please select query type."},
						message:{required:"Please enter message."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}

				});
			});
		</script>
	</body>
</html>

