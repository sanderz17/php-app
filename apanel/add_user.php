<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'user';
	$ctable1 	= 'User';
	$main_page 	= 'User'; //for sidebar active menu
	$page		= 'user';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$first_name = "";
	$last_name	= "";
	$email		= "";
	$password	= "";
	$phone		= "";
	$isVerified = "";

	if(isset($_REQUEST['submit']))
	{
		//print_r($_REQUEST); exit;
		$first_name = $db->clean($_REQUEST['first_name']);
		$last_name 	= $db->clean($_REQUEST['last_name']);
		$email 		= $db->clean($_REQUEST['email']);
		$password 	= $db->clean($_REQUEST['password']);
		$phone 		= $db->clean($_REQUEST['phone']);
		if(isset($_REQUEST['isVerified']) && $_REQUEST['isVerified'] == "1"){
			$isVerified = $db->clean($_REQUEST['isVerified']);
		}else{
			$isVerified = 0;
		}

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rsdupli = $db->getData($ctable, '*', 'email = "'.$email.'" AND isDelete=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				if( empty($password)){
					$password = $db->generateRandomString(8, false);
				}
				$forgot_string = $db->generateRandomString(10);

				$rows 	= array(
					'first_name'=> $first_name,
					'last_name' => $last_name,
					'email' 	=> $email,
					'password'	=> md5($password),
					'phone'		=> $phone,
					'forgot_string' => $forgot_string,
					'isActive'  => $isVerified
				);

				$user_id = $db->insert($ctable, $rows);

				if($user_id && ISMAIL){
					$nt = new Notification();
					include('../mailbody/set_pass.php');
					$subject	= SITETITLE.' Set Password';
					
					$toemail = $email;
					$nt->sendEmail($toemail,$subject,$body);
				}
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			

			$id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'email = "'.$email.'" AND id <> ' . $id . ' AND isDelete=0');

			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
				exit;
			}
			else
			{
				if(!empty($password))
				{
					$rows = array('password' => md5($password));
					$db->update($ctable, $rows, 'id='.$id);
				}

				

				$rows 	= array(
					'first_name'=> $first_name,
					'last_name' => $last_name,
					'email' 	=> $email,
					'phone'		=> $phone,
					'isActive'	=> $isVerified
				);

				// echo "<pre>";
				// print_r($rows);
				// die;

				$db->update($ctable, $rows, 'id='.$id);
								
				$_SESSION['MSG'] = 'Updated';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$first_name = stripslashes($ctable_d['first_name']);
		$last_name 	= stripslashes($ctable_d['last_name']);
		$email 		= stripslashes($ctable_d['email']);
		$isVerified = stripslashes($ctable_d['isActive']);
		$phone 		= htmlspecialchars_decode($ctable_d['phone']);
		// $phone 		= $db->getValue("billing_shipping","billing_phone","isDelete=0 AND user_id=".$_REQUEST['id']." ","id DESC");
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
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-contacts"></i>
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
														<input maxlength="100" type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?php echo $email; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="password">Password</label><code>*</code><small>(keep blank if no change)</small>
														<input maxlength="20" type="password" class="form-control" name="password" id="password" value="" minlength="8">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="phone">Phone</label>
														<input maxlength="14" type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone" value="<?php echo $phone; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<div class="button-list">	
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="isVerified" id="isVerified" value="1" <?php if($isVerified=="1"){ echo "checked";}?>/>
																<label for="isVerified" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> Is Account Verified? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
											<button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
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
						email:{required: true, email:true},
						password:{minlength: 8},
					},
					messages: {
						first_name:{required:"Please enter first name."},
						last_name:{required:"Please enter last name."},
						email:{required: "Please enter email.", email:"Please enter valid email address."},
						password: {minlength: "Please enter atleast 8 characters."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});

			// phone number formate start
            let telEl = document.querySelector('#phone');
            telEl.addEventListener('keyup', (e) => {
              let val = e.target.value;
              e.target.value = val
                .replace(/\D/g, '')
                .replace(/(\d{1,3})(\d{1,3})?(\d{1,4})?/g, function(txt, f, s, t) {
                  if (t) {
                    return `(${f}) ${s}-${t}`
                  } else if (s) {
                    return `(${f}) ${s}`
                  } else if (f) {
                    return `(${f})`
                  }
                });
            });
		</script>
	</body>
</html>