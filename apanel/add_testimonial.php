<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'testimonial';
	$ctable1 	= 'Testimonial';
	$main_page 	= 'Testimonia'; //for sidebar active menu
	$page		= 'testimonial';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = "";
	$descr = "";
	
	if(isset($_REQUEST['submit']))
	{
		$name = $db->clean($_REQUEST['name']);
		$descr = $db->clean($_REQUEST['descr']);

		$rows 	= array(
			'name'=> $name,
			'descr'=> $descr,
			'isDelete'=> 0,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rsdupli = $db->getData($ctable, '*', 'name = "'.$name);
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				//$_SESSION['MSG'] = 'Duplicate';
				$_SESSION['MSG'] = 'Name is already exists.';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				$contact_id = $db->insert($ctable, $rows);

				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$contact_id = (int) $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'id <> '.$contact_id.' AND name = "'.$name);
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				//$_SESSION['MSG'] = 'Duplicate';
				$_SESSION['MSG'] = 'Name is already exists.';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				$db->update($ctable, $rows, 'id='.$contact_id);

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

		$name = stripslashes($ctable_d['name']);
		$descr = stripslashes($ctable_d['descr']);
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
												<div class="col-md-12">
													<div class="form-group">
														<label for="name">Name <code>*</code></label>
														<input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" value="<?php echo $name; ?>" maxlength="100">
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<label for="descr">Description<code>*</code></label>
														<textarea name="descr" id="descr" placeholder="Enter technical"><?php echo $descr; ?></textarea>
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
		<script src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script type="text/javascript">

			CKEDITOR.replace('descr');

			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						name:{required:true}, 
						name:{required:true}, 
						name:{required:true}, 
					},
					messages: {
						name:{required:"Please enter name."},
						name:{required:"Please enter name."},
						name:{required:"Please enter name."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>