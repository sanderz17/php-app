<?php
include("connect.php");
$db->checkAdminLogin();
include("../include/notification.class.php");

$ctable 	= "product_alt_image";
$ctable1 	= "Product Alternate Images";
$page 		= "alt-image";
$page_title = $ctable1;

$IMAGEPATH_T = PRODUCT_T;
$IMAGEPATH_A = PRODUCT_A;
$IMAGEPATH = PRODUCT;

$image_path = '';

$product_id = 0;
if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != "") {
	$product_id = $_REQUEST['product_id'];
}

if (isset($_REQUEST['submit'])) {
	$image_path = $db->clean($_REQUEST['image_path']);

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

	$rows 	= array(
		"product_id" => $product_id,
		"image_path" => $image_path,
	);

	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "add") {
		try {
			$image_id = $db->insert($ctable, $rows);

			$_SESSION['MSG'] = "Inserted";
			$db->location(ADMINURL . 'manage-' . $page . '/' . $product_id . '/');
			exit;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "edit") {
		$image_id = $_REQUEST['id'];
		$db->update($ctable, $rows, "id=" . $image_id);

		$_SESSION['MSG'] = "Updated";
		$db->location(ADMINURL . 'manage-' . $page . '/' . $product_id . '/');
		exit;
	}
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "edit") {
	$where 		= " id=" . $_REQUEST['id'] . " AND isDelete=0";
	$ctable_r 	= $db->getData($ctable, "*", $where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

	$product_id = stripslashes($ctable_d['product_id']);
	$image_path	= stripslashes($ctable_d['image_path']);
}
if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] > 0 && $_REQUEST['mode'] == "delete") {
	$id 	= $_REQUEST['id'];
	$rows 	= array("isDelete" => "1");

	$db->update($ctable, $rows, "id=" . $id);

	$_SESSION['MSG'] = "Deleted";
	$db->location(ADMINURL . 'manage-' . $page . '/' . $product_id . '/');
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
													<label for="image_path">Image <code>*</code>
														<br />
														<small>minimum image size 500 x 325 px</small>
													</label>

													<input type="hidden" name="filename" id="filename" class="form-control" />
													<div id="dropzone_img" class="dropzone" data-width="500" data-height="325" data-ghost="false" data-cropwidth="454" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prod_alt_img" style="width: 500px;height:325px;">
														<input type="file" id="image_path" name="image_path">
														<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<br /><br />
													<?php
													if ($image_path != "" && file_exists($IMAGEPATH_A . $image_path)) {
													?>
														<img src="<?php echo SITEURL . $IMAGEPATH . $image_path; ?>" width="454"><br /><br />
													<?php
													}
													?>
												</div>
											</div>
										</div>
									</div>
									<div class="card-footer">
										<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
										<button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/<?php echo $product_id; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
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
					title: {
						required: true
					},
					description: {
						required: true
					},
				},
				messages: {
					title: {
						required: "Please enter title name."
					},
					description: {
						required: "Please enter description."
					},
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