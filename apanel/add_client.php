<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'clients';
	$ctable1 	= 'Client';
	$main_page 	= 'clients'; //for sidebar active menu
	$page		= 'client';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name 		= "";
	$image_path	= "";
	$logo_type 	= "";

	$IMAGEPATH_T 	= CLIENT_T;
	$IMAGEPATH_A 	= CLIENT_A;
	$IMAGEPATH 		= CLIENT;

	if(isset($_REQUEST['submit']))
	{
		$name 		= $db->clean($_REQUEST['name']);
		$logo_type 	= $db->clean($_REQUEST['logo_type']);
		$link  		= $db->clean($_REQUEST['links']);

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!="")
		{
			copy($IMAGEPATH_T.$_SESSION['image_path'], $IMAGEPATH_A.$_SESSION['image_path']);
			$image_path = $_SESSION['image_path'];
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
			unset($_SESSION['image_path']);
		}
		if($_REQUEST['old_image_path']!="" && $image_path!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_image_path'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_image_path']);
			}
		}else{
			if($image_path==""){
				$image_path = $_REQUEST['old_image_path'];
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rsdupli = $db->getData($ctable, '*', 'name = "'.$name.' AND link="'.$link.' AND isDelete=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{

				$rows 	= array(
					'name'		=> $name,
					'logo' 		=> $image_path,
					'type'		=> $logo_type,
					"link"		=> $link,
					'isDelete'  => 0,
				);

				$user_id = $db->insert($ctable, $rows);
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'name = "'.$name.'" AND id <> ' . $id . ' AND link="'.$link.' AND isDelete=0');

			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
				exit;
			}
			else
			{
				$rows 	= array(
					'name'=> $name,
					'logo' => $image_path,
					'type'		=> $logo_type,
					"link"		=> $link,
					'isDelete'	=> 0,
				);
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

		$name 		= stripslashes($ctable_d['name']);
		$image_path	= stripslashes($ctable_d['logo']);
		$logo_type	= stripslashes($ctable_d['type']);
		$links	= stripslashes($ctable_d['link']);
		$isDelete 	= stripslashes($ctable_d['isDelete']);
		$isVerified = stripslashes($ctable_d['isVerified']);
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
												<div class="col-md-4">
													<div class="form-group">
														<label for="name">Name <code>*</code></label>
														<input type="text" class="form-control" name="name" id="name" placeholder="Enter client name." value="<?php echo $name; ?>">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="logo_type">Select Type: <code>*</code></label>
														<select name="logo_type" id="logo_type" class="form-control">
															<option value="">-- Select --</option>
															<option <?php if ($logo_type == '0') { echo 'Selected'; } ?> value="0">Partners</option>
															<option <?php if ($logo_type == '1') { echo 'Selected'; } ?> value="1">Retailers</option>
														</select>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="links">Links <code>*</code></label>
														<input type="text" class="form-control" name="links" id="links" placeholder="Enter link." value="<?php echo $links; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
													<label>Image <code>*</code>
													<br /><small>minimum image size 200 X 150 px</small>
													</label>
													<br />
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="278" data-height="121" data-ghost="false" data-cropwidth="278" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=clientimg" style="width:278px;height:121px;">
														<input type="file" id="image_path" name="image_path">
														<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
													</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														
														<?php
														if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" ><br /><br />
														<?php
														}
														?>
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
		<script src="<?php echo ADMINURL; ?>assets/js/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
		<script type="text/javascript">

			var custom_img_width = '130';
		
			$('#dropzone_img').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});

			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						name:{required:true}, 
						logo_type:{required:true},
						image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }, 
					},
					messages: {
						name:{required:"Please enter name."},
						logo_type:{required:"Please Select Type."},
						image_path:{required:"Please enter a images."}
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>