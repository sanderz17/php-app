<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'blog';
	$ctable1 	= 'Blog';
	$main_page 	= 'Blog'; //for sidebar active menu
	$page		= 'blog';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$title 		 = "";
	$description = "";
	$isPublished = "";
	$image_path  = "";

	$IMAGEPATH_T 	= BLOG_T;
	$IMAGEPATH_A 	= BLOG_A;
	$IMAGEPATH 		= BLOG;

	if(isset($_REQUEST['submit']))
	{
		$title 		= $db->clean($_REQUEST['title']);
		$description= $db->clean($_REQUEST['description']);
		$isPublished	= $db->clean($_REQUEST['isPublished']);

		if(isset($_REQUEST['isPublished']) && $_REQUEST['isPublished'] == "1"){
			$isPublished = $db->clean($_REQUEST['isPublished']);
		}else{
			$isPublished = 0;
		}


		
		// CODE FOR BLOG IMAGES
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
			$rsdupli = $db->getData($ctable, '*', 'title = "'.$title.'" AND isDelete=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{

				$rows 	= array(
					'title'			=> $title,
					'descr'  		=> $description,
					'image_path'	=> $image_path,
					'isPublished'	=> $isPublished,
				);

				$user_id = $db->insert($ctable, $rows,0);
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'title = "'.$title.'" AND id <> ' . $id . ' AND isDelete=0');

			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
				exit;
			}
			else
			{
				$rows 	= array(
					'title'		=> $title,
					'descr'  	=> $description,
					'image_path'=> $image_path,
					'isPublished'=> $isPublished,
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

		$title 			= stripslashes($ctable_d['title']);
		$description 	= stripslashes($ctable_d['descr']);
		$image_path 	= stripcslashes($ctable_d['image_path']);
		$isPublished	= stripslashes($ctable_d['isPublished']);
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
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
		<link href="<?php echo ADMINURL; ?>assets/js/crop/css/demo.html5imageupload.css?v1.3" rel="stylesheet">
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
														<input type="text" class="form-control" name="title" id="title" placeholder="Enter blog title" value="<?php echo $title; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group float-right">
														<div class="button-list">	
															<div class="btn-switch btn-switch-dark pull-right">
																<input type="checkbox" name="isPublished" id="isPublished" value="1" <?php if($isPublished=="1"){ echo "checked";}?>/>
																<label for="isPublished" class="btn btn-rounded btn-dark waves-effect waves-light">
																	<em class="mdi mdi-check"></em>
																	<strong> Is Published? </strong>
																</label>
															</div>
														</div>
													</div>
												</div>
												<!-- <div class="col-md-10">
													<div class="form-group">
														<label for="category">Category(s) <code>*</code></label>
															<select multiple="true" name="tag[]" id="tag" class="form-control select2">
																<?php
																//load all category for tag
																$where 		= ' isDelete=0';
																$ctable_r 	= $db->getData("blog_category","*", $where);
																$category = explode(",",$ctable_d['category']);
																while($user_d = @mysqli_fetch_assoc($ctable_r)){  ?>
																		<option <?php if(in_array($user_d['id'],$category)){ echo "selected"; } ?> value="<?php echo $user_d['id']; ?>"><?php echo $user_d['name']; ?></option>
																<?php } ?>
														</select>
													</div>
												</div> -->
												<!-- <div class="col-md-2"></div> -->
												<div class="col-md-10">
													<div class="form-group">
														<label for="description">Description <code>*</code></label>
														<textarea name="description" id="description" placeholder="Enter blog description"><?php echo $description; ?></textarea>
													</div>
												</div>
											</div>
												<div  class="row">
													<div class="col-md-6">
														<input type="hidden" name="filename" id="filename" class="form-control" />
														<div id="dropzone_img" class="dropzone" data-width="1100" data-height="700" data-ghost="false" data-cropwidth="1100" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=blogImg" style="width: 550px;height:350px;">
															<input type="file" id="image_path" name="image_path">
															<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															
															<?php
															if($image_path!="" && file_exists($IMAGEPATH_A.$image_path)){
															?>
																<img src="<?php echo SITEURL.$IMAGEPATH.$image_path; ?>" width="550"><br /><br />
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
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<script src="<?php echo ADMINURL; ?>assets/js/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
		<script type="text/javascript" src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">

			var custom_img_width = '1100';
			$('#dropzone_img').html5imageupload({
				onAfterProcessImage: function() {
					var imgName = $('#filename').val($(this.element).data('imageFileName'));
				},
				onAfterCancel: function() {
					$('#filename').val('');
				}
			});

			CKEDITOR.replace('description');
			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						title:{required:true}, 
						description:{required:true},
					},
					messages: {
						title:{required:"Please enter title name."},
						description:{required:"Please enter description."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});


			$('#tag').select2({
				placeholder: "Select Category",
	            tags: true,
	            tokenSeparators: [",", " "]
	        });
	        $("input[type='search']").on('keyup', function() {
	            $("#tag option[data-select2-tag='true']").remove();
	        });
		</script>
	</body>
</html>