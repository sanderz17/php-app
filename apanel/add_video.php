<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'video_library';
	$ctable1 	= 'video library';
	$main_page 	= 'video library'; //for sidebar active menu
	$page		= 'video';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$question = "";
	$answer	= "";

	if(isset($_REQUEST['submit']))
	{
		$video_link = $db->clean($_REQUEST['video_link']);
		$title 		= $db->clean($_REQUEST['title']);
		
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rows 	= array(
				"video_link"=> $video_link,
				"title"		=> $title,
			);

			$user_id = $db->insert($ctable, $rows);
			
			$_SESSION['MSG'] = 'Inserted';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rows 	= array(
				"video_link" => $video_link,
				"title"		 => $title,
			);
			$db->update($ctable, $rows, 'id='.$id);
							
			$_SESSION['MSG'] = 'Updated';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$video_link = stripslashes($ctable_d['video_link']);
		$title 		= stripcslashes($ctable_d['title']);
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
												<div class="col-md-9">
													<div class="form-group">
														<label for="title">Title<code>*</code></label>
														<input type="text" class="form-control" name="title" id="title" placeholder="Video title" value="<?php echo $title ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-9">
													<div class="form-group">
														<label for="video_link">Video Link <code>*</code></label>
														<input type="text" class="form-control" name="video_link" id="video_link" placeholder="video link" value='<?php echo $video_link; ?>' >
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

			$(function(){
				CKEDITOR.replace('answer');

				$("#frm").validate({
					ignore: "",
					rules: {
						question:{required:true}, 
						answer:{required:true},
					},
					messages: {
						question:{required:"Please enter question."},
						answer:{required:"Please enter answer."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>