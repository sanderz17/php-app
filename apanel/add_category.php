<?php
include("connect.php");
$db->checkAdminLogin();
include("../include/notification.class.php");

$ctable 	= 'category';
$ctable1 	= 'Category';
$main_page 	= 'manage-category'; //for sidebar active menu
$page		= 'category';
$page_title = ucwords($_REQUEST['mode']) . " " . $ctable1;

$category_name = "";
$parent_id	= "";
$description = "";
$isDelete 	= "";
$isVerified = "";

$IMAGEPATH_T 	= CATEGORY_T;
$IMAGEPATH_A 	= CATEGORY_A;
$IMAGEPATH 		= CATEGORY;
$VIDEO_SLUG 	= "_vid";

if (isset($_REQUEST['submit'])) {
	$category_name = $db->clean($_REQUEST['category_name']);
	$slug		   = $db->createSlug($_REQUEST['category_name']);
	$parent_id 	= $db->clean($_REQUEST['parent_id']);
	$description = $db->clean($_REQUEST['description']);

	// print_r($_REQUEST); exit;

	// CODE FOR CATEGORY IMAGES
	if (isset($_SESSION['image_path']) && $_SESSION['image_path'] != "") {
		copy($IMAGEPATH_T . $_SESSION['image_path'], $IMAGEPATH_A . $_SESSION['image_path']);
		$image_path = $_SESSION['image_path'];
		unlink($IMAGEPATH_T . $_SESSION['image_path']);
		unset($_SESSION['image_path']);
	}
	if ($_REQUEST['old_image_path'] != "" && $image_path != "") {
		if (file_exists($IMAGEPATH_A . $_REQUEST['old_image_path'])) {
			unlink($IMAGEPATH_A . $_REQUEST['old_image_path']);
		}
	} else {
		if ($image_path == "") {
			$image_path = $_REQUEST['old_image_path'];
		}
	}


	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "add") {

		$rsdupli = $db->getData($ctable, '*', 'slug = "' . $slug . '" AND parent_id="' . $parent_id . '"AND isDelete=0');

		if (@mysqli_num_rows($rsdupli) > 0) {
			$_SESSION['MSG'] = 'Duplicate';
			$db->location(ADMINURL . 'add-' . $page . '/' . $_REQUEST['mode'] . '/');
			exit;
		} else {
			$rows 	= array(
				'name'		=> $category_name,
				'parent_id' => $parent_id,
				'image_path' => $image_path,
				'slug'		=> $slug,
				'description' => $description,
				'isDelete'  => 0,
			);

			$user_id = $db->insert($ctable, $rows, 0);

			$_SESSION['MSG'] = 'Inserted';
			$db->location(ADMINURL . 'manage-' . $page . '/');
			exit;
		}
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "edit" && $_REQUEST['id'] != null) {
		$id = $_REQUEST['id'];
		$rsdupli = $db->getData($ctable, '*', 'slug = "' . $slug . '" AND id <> ' . $id . ' AND isDelete=0');
		if (@mysqli_num_rows($rsdupli) > 0) {
			$_SESSION['MSG'] = 'Duplicate';
			//$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
			//exit;
		} else {
			try {
				$getCategorySlug = $db->getValue('category', 'slug', 'id=' . $id);
				$slug = count($getCategorySlug) > 0 ?  $getCategorySlug : $slug;
				$rows 	= array(
					'name' => $category_name,
					'parent_id' => $parent_id,
					'slug'		=> $slug,
					'image_path' => $image_path,
					'description' => $description,
					'isDelete'	=> 0,
				);
				$db->update($ctable, $rows, 'id=' . $id);
				$_SESSION['MSG'] = 'Updated';
				//$db->location(ADMINURL.'manage-'.$page.'/');
				header('Location: ' . $_SERVER['REQUEST_URI']);
				//exit;
			} catch (\Throwable $th) {
				cb_logger($th);
				throw new Error($th);
			}
		}
	}
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == 'edit') {
	$where 		= ' id=' . $_REQUEST['id'] . ' AND isDelete=0';
	$ctable_r 	= $db->getData($ctable, '*', $where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

	$category_name = stripslashes($ctable_d['name']);
	$ParentId 	= stripslashes($ctable_d['parent_id']);
	$isDelete = stripslashes($ctable_d['isDelete']);
	$isVerified = stripslashes($ctable_d['isVerified']);
	$description = stripslashes($ctable_d['description']);
	$image_path = stripslashes($ctable_d['image_path']);
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "delete") {
	$id = $_REQUEST['id'];
	$rows = array('isDelete' => '1');

	$db->update($ctable, $rows, 'id=' . $id);

	$_SESSION['MSG'] = 'Deleted';
	$db->location(ADMINURL . 'manage-' . $page . '/');
	exit;
}

function category($parent_id = 0, $sub_mark = '')
{
	$sql = "SELECT * from category WHERE parent_id=" . $parent_id . " AND isDelete=0";
	$query = mysqli_query($GLOBALS['myconn'], $sql);
	global $ParentId;

	if (@mysqli_num_rows($query) > 0) {
		while ($row = @mysqli_fetch_array($query)) {
			echo '<option ' . (($ParentId == $row['id']) ? 'selected' : "") . ' value="' . $row['id'] . '">' . $sub_mark . $row['name'] . '</option>';
			category($row['id'], $sub_mark . '&nbsp;&nbsp;&nbsp;');
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
								<i class="mdi mdi-contacts"></i>
							</span> <?php echo $page_title; ?>
						</h3>
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
													<label for="category_name">Category Name <code>*</code></label>
													<input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" value="<?php echo $category_name; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Select Parent Category <span class="text-danger">*</span></label>
													<select class="form-control" name="parent_id" id="parent_id" onChange="getSubCat(this.value);">
														<option value="0">-- Select --</option>
														<?php category(); ?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<input type="hidden" name="filename" id="filename" class="form-control" />
												<div id="dropzone_img" class="dropzone" data-width="350" data-height="251" data-ghost="false" data-cropwidth="350" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=catimg" style="width:216;height:151px;">
													<input type="file" id="image_path" name="image_path">
													<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">

													<?php
													if ($image_path != "" && file_exists($IMAGEPATH_A . $image_path)) {
													?>
														<img src="<?php echo SITEURL . $IMAGEPATH . $image_path; ?>"><br /><br />
													<?php
													}
													?>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="description"> Description <code>*</code></label>
													<textarea id="description" name="description" placeholder="Enter description"><?php echo $description; ?></textarea>
												</div>
											</div>
											<hr>
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

		$(function() {
			$("#frm").validate({
				ignore: "",
				rules: {
					category_name: {
						required: true
					},
					// parent_id:{required:true},
				},
				messages: {
					category_name: {
						required: "Please enter category name."
					},
					// parent_id:{required:"Please select parent category."},
				},
				errorPlacement: function(error, element) {
					error.insertAfter(element);
				}
			});
		});
	</script>
</body>

</html>