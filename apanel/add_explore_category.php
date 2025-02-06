<?php	
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= 'explore_category';
	$ctable1 	= 'Explore Category';
	$main_page 	= 'explore category'; //for sidebar active menu
	$page		= 'explore-category';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = "";
	$email = "";

	$IMAGEPATH_T 	= CATEGORY_T;
	$IMAGEPATH_A 	= CATEGORY_A;
	$IMAGEPATH 		= CATEGORY;

	if(isset($_REQUEST['submit']))
	{
		$name = $db->clean($_REQUEST['name']);
		$email = $db->clean($_REQUEST['category_id']);

		// CATEGORY IMAGE UPLOAD CODE
		if(isset($_SESSION['cate_image_path']) && $_SESSION['cate_image_path']!="")
		{
			copy($IMAGEPATH_T.$_SESSION['cate_image_path'], $IMAGEPATH_A.$_SESSION['cate_image_path']);
			$image_path = $_SESSION['cate_image_path'];
			unlink($IMAGEPATH_T.$_SESSION['cate_image_path']);
			unset($_SESSION['cate_image_path']);
		}
		if($_REQUEST['old_cate_image_path']!="" && $old_cate_image_path!=""){
			if(file_exists($IMAGEPATH_A.$_REQUEST['old_cate_image_path'])){
				unlink($IMAGEPATH_A.$_REQUEST['old_cate_image_path']);
			}
		}else{
			if($cate_image_path==""){
				$cate_image_path = $_REQUEST['old_cate_image_path'];
			}
		}
		// CATEGORY IMAGEUPLOAD CODE OVER

		$rows 	= array(
			'name' 			=> $name,
			'category_slug' => $email,
			"image_path"	=> $image_path,
		);

		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$uid = $db->insert($ctable, $rows);

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

		$name = stripslashes($ctable_d['name']);
		$slug = stripslashes($ctable_d['category_slug']);
		$cate_image_path = htmlspecialchars_decode($ctable_d['image_path']);
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

	function category($parent_id = 0, $sub_mark = '')
	{
		global $slug;
	    $sql = "SELECT * from category WHERE parent_id=".$parent_id." AND isDelete=0";
	    $query = mysqli_query($GLOBALS['myconn'],$sql);

	    if(@mysqli_num_rows($query)>0){
	        while($row = @mysqli_fetch_array($query)){
	           

	            echo '<option value="'.$row['slug'].'" ';
				if ($row['slug'] == $slug)
					echo 'selected="selected"';
				echo '>'.$sub_mark.$row['name'].'</option>';
				
				category($row['id'], $sub_mark.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
	        }
	    }
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
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
														<label for="name">Name <code>*</code></label>
														<input maxlength="50" type="text" class="form-control" name="name" id="name" placeholder="Enter First Name" value="<?php echo $name; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="email">Select Category <code>*</code></label>
														<select name="category_id" id="category_id" class="form-control">  
															<option value="">-- Select --</option>
															<?php category(); ?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="300" data-height="200" data-ghost="false" data-cropwidth="300" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=exCategory" style="width: 300px;height:200px;">
														<input type="file" id="cate_image_path" name="cate_image_path">
														<input type="hidden" name="old_cate_image_path" value="<?php echo $old_cate_image_path; ?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														
														<?php
														if($cate_image_path!="" && file_exists($IMAGEPATH_A.$cate_image_path)){
														?>
															<img src="<?php echo SITEURL.$IMAGEPATH.$cate_image_path; ?>" ><br /><br />
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
					<?php include("include/footer.php"); ?>
				</div>
			</div>
		</div>

		<?php include('include/js.php'); ?>
		<script src="<?php echo ADMINURL; ?>assets/js/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
		<script type="text/javascript">

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
					ignore:"",
					rules: {
						name:{required:true},
						category_id:{required:true},		
						cate_image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }, 		
					},
					messages: {
						name:{required:"Please enter category name."},
						category_id:{required:"Please select category."},
						cate_image_path:{required:"Please upload image"},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>

