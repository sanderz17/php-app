<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'static_page';
	$ctable1 	= 'Static Page';
	$main_page 	= 'static_page'; //for sidebar active menu
	$page		= 'static-page';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$title = "";
	$descr = "";
	
	if(isset($_REQUEST['submit']))
	{
		//print_r($_REQUEST); exit;
		$title = $db->clean($_REQUEST['title']);
		$descr = $db->clean($_REQUEST['descr']);

		$rows 	= array(
			'title'=> $title,
			'descr'=> $descr,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$page_id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'title = "'.$title.'" AND id <> ' . $page_id . ' AND isArchived=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$page_id.'/');
				exit;
			}
			else
			{
				$db->update($ctable, $rows, 'id='.$page_id);
								
				$_SESSION['MSG'] = 'Updated';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isArchived=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$page_id = $ctable_d['id'];
		$title = stripslashes($ctable_d['title']);
		$descr = stripslashes($ctable_d['descr']);
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array('isArchived' => '1');
		
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
														<label for="title">Title <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="<?php echo $title; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label for="descr">Description <code>*</code></label>
														<textarea class="form-control" name="descr" id="descr" rows="3"><?php echo $descr; ?></textarea>
														<div class="desc_error"></div>
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
			//CKEDITOR.replace('descr');

			$(function(){
		        CKEDITOR.replace('descr');

				$("#frm").validate({
					ignore: "",
					rules: {
						name:{required:true}, 
						descr:{required : function() { CKEDITOR.instances.descr.updateElement(); } },
					},
					messages: {
						name:{required:"Please enter name."},
						descr:{required:"Please enter description."}, 
					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "descr") 
						{
							error.insertAfter(".desc_error");
						}
						else
						{
							error.insertAfter(element);
						}
					}
				});
			});
		</script>
	</body>
</html>