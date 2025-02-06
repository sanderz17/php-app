<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'review_img';
	$ctable1 	= 'Review image';
	$main_page 	= 'Review image'; //for sidebar active menu
	$page		= 'reviewImg';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$url 		= "";
	$image_path	= "";
	$isDelete	= 0;
	$description	= "";

	$IMAGEPATH_T 	= HOME_T;
	$IMAGEPATH_A 	= HOME_A;
	$IMAGEPATH 		= HOME;

	if(isset($_REQUEST['submit']))
	{
		// print_r($_REQUEST); exit;
		// $first_name = $db->clean($_REQUEST['name']);
		$name 	= $db->clean($_REQUEST['name']);
		$title 	= $db->clean($_REQUEST['title']);
		$product_id = $db->clean($_REQUEST['product_id']);
		$description	= addslashes($db->clean($_REQUEST['description']));
		// CODE FOR PRODUCT IMAGES
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
			$rsdupli = $db->getData($ctable, '*', 'email = "'.$email.'" AND isArchived=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				$rows 	= array(
					'name'			=> $name,
					'title'			=> $title,
					'product_id'	=> $product_id,
					'image_path'	=> $image_path,
					'description'	=> $description,
					'isDelete'  	=> $isDelete,
				);

				// print_r($rows); exit;

				$user_id = $db->insert($ctable, $rows,0);
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/');
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'email = "'.$email.'" AND id <> ' . $id . ' AND isArchived=0');

			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
				exit;
			}
			else
			{

				$rows 	= array(
					'name'			=> $name,
					'title'			=> $title,
					'product_id'	=> $product_id,
					'description'	=> $description,
					'image_path' => $image_path,
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

		$name               = stripslashes($ctable_d['name']);
		$title 	            = stripslashes($ctable_d['title']);
		$description 		= stripslashes($ctable_d['description']);
	    $isVerified         = stripslashes($ctable_d['isVerified']);
		$image_path 		= htmlspecialchars_decode($ctable_d['image_path']);
		$ProductId         = $ctable_d['product_id'];
		
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
	
	function category($ProductId)
	{
			// print_r($ProductId);
	    $sql = "SELECT * from product WHERE isDelete = 0";
	    $query = mysqli_query($GLOBALS['myconn'],$sql);

	    if(@mysqli_num_rows($query)>0){
	        while($row = @mysqli_fetch_array($query)){
	          //  echo '<option  value="'.$row['id'].'">'.$row['name'].'</option>';
	          //  category($row['id']);
				// print_r($row['id']. " == ".$product_id );
				// echo "<br>";
			  echo '<option  value="'.$row['id'].'" ';
			  if ($row['id'] == $ProductId)
				  echo 'selected="selected"';
			  echo '>'.$row['name'].'</option>';
	        }
	    }
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
												<div class="col-md-6">
													<div class="form-group">
														<label for="name">Name <code>*</code></label>
														<input maxlength="200" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name; ?>">
													</div>
												</div>
												<!-- <div class="col-md-6">
													<div class="form-group">
														<label>Select Product<span class="text-danger">*</span></label>
														<select class="form-control" name="product_id" id="product_id" onChange="getSubCat(this.value);">
															<option value="0">-- Select --</option>
															<?php category($ProductId); ?>
														</select>
													</div>
												</div> -->
												<div class="col-md-6">
													<div class="form-group">
														<label for="title"> Title <code>*</code></label>
														<input maxlength="200" type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?php echo $title; ?>">
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-12">
													<div class="form-group">
														<label for="description"> Description <code>*</code></label>
														<textarea id="description" name="description" placeholder="Enter description"><?php echo $description; ?></textarea>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-9">
													<label for="rand_image_path">Review Image <code>*</code>
														<br />
														<small>minimum image size 600 x 400 px</small>
													</label><br/>
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="488" data-height="551" data-ghost="false" data-cropwidth="488" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=review_img" style="width: 599;height:466;">
														<input type="file" id="image_path" name="image_path">
														<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
													</div>
												</div>
												<div class="col-md-9">
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
		<script src="<?php echo ADMINURL; ?>assets/js/ckeditor/ckeditor.js" type="text/javascript"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
		<script type="text/javascript">
			CKEDITOR.replace('description');
			var custom_img_width = '454';
		
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
						title:{required:true},
						description:{required: true},
					},
					messages: {
						name:{required:"Please enter name."},
						title:{required:"Please enter title."},
						description:{required: "Please enter description."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>