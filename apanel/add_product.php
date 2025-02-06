<?php
include("connect.php");
$db->checkAdminLogin();
include("../include/notification.class.php");

$ctable 	= 'product';
$ctable1 	= 'Product';
$main_page 	= 'manage-product'; //for sidebar active menu
$page		= 'product';
$page_title = ucwords($_REQUEST['mode']) . " " . $ctable1;

$name 			= "";
$price			= "";
$sell_price		= "";
$caliber_id     = "";
$height         = "";
$width          = "";
$length         = "";
$weight         = "";
$unit           = "";
$description	= "";
$specification 	= "";
$technical 		= "";
$image_path 	= "";
$rand_image_path = "";
$isDelete 		= "";
$new 			= "";
$onsale			= "";
$outofstock		= "";
$quantity		= 0;
$isActive		= "";
$isRemelt		= "";
$isPrepack		= "";
$video_path 	= "";
$dimen_descr 	= "";
$bs_rank = "";

$IMAGEPATH_T 	= PRODUCT_T;
$IMAGEPATH_A 	= PRODUCT_A;
$IMAGEPATH 		= PRODUCT;
$VIDEO_SLUG 	= "_vid";

$video_array = array("WEBM", "MPG", "MP2", "MPEG", "MPE", "MPV", "OGG", "MP4", "M4P", "M4V", "AVI", "WMV", "MOV", "QT", "FLV", "SWF", "AVCHD");

if (isset($_REQUEST['submit'])) {
	// print_r($_REQUEST);
	// exit;
	$name 			= $db->clean($_REQUEST['name']);
	$slug		    = $db->createSlug($_REQUEST['name']);
	$price			= trim($_REQUEST['price']) ?: 0;
	$sell_price		= trim($_REQUEST['sell_price']);
	$description	= $db->clean($_REQUEST['description']);
	$specification	= $db->clean($_REQUEST['specification']);
	$technical		= $db->clean($_REQUEST['technical']);
	$quantity		= trim($_REQUEST['quantity']) ?: 0;
	$category_id    = $_REQUEST['category_id'];
	$dimen_descr    = $db->clean($_REQUEST['dimen_descr']);
	$short_descr    = $db->clean($_REQUEST['short_descr']);
	$code    = $db->clean($_REQUEST['code']);


	$length 		= $db->clean($_REQUEST['length']);

	if (isset($_REQUEST['unit'])) {
		$unit = $db->clean($_REQUEST['unit']);
	} else {
		$unit = "";
	}
	if (isset($_REQUEST['width'])) {
		$width 	= $db->clean($_REQUEST['width']);
	} else {
		$width = "";
	}
	if (isset($_REQUEST['height'])) {
		$height = $db->clean($_REQUEST['height']);
	} else {
		$height = "";
	}
	if (isset($_REQUEST['weight'])) {
		$weight = $db->clean($_REQUEST['weight']);
	} else {
		$weight = "";
	}
	if (isset($_REQUEST['bs_rank'])) {
		$bs_rank = $db->clean($_REQUEST['bs_rank']);
	} else {
		$bs_rank = "";
	}
	if (isset($_REQUEST['caliber_id'])) {
		$caliber_id  = implode(",", $_REQUEST['caliber_id']);
	} else {
		$caliber_id = "";
	}

	$extension = pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION);
	if (in_array(strtoupper($extension), $video_array)) {
		$extension	= strtolower(end(explode('.', $_FILES['video']['name'])));
		$tmpFile 	= $_FILES['video']['tmp_name'];
		$filename 	= time() . "_" . rand(1, 9999999) . $VIDEO_SLUG . "." . $extension;

		move_uploaded_file($_FILES['video']['tmp_name'], $IMAGEPATH_T . $filename);
		if (copy($IMAGEPATH_T . $filename, $IMAGEPATH_A . $filename)) {
			$video_path = $filename;
		}
	}
	// VIDEO COED OVER

	$isActive = 0;
	if (isset($_REQUEST['isActive']) && $_REQUEST['isActive'] == "1")
		$isActive = $db->clean($_REQUEST['isActive']);


	$isRemelt = 0;
	if (isset($_REQUEST['isRemelt']) && $_REQUEST['isRemelt'] == "1")
		$isRemelt = $db->clean($_REQUEST['isRemelt']);

	$isPrepack = 0;
	if (isset($_REQUEST['isPrepack']) && $_REQUEST['isPrepack'] == "1")
		$isPrepack = $db->clean($_REQUEST['isPrepack']);

	$new = 0;
	if (isset($_REQUEST['new']) && $_REQUEST['new'] == "1")
		$new = $db->clean($_REQUEST['new']);

	$onsale = 0;
	if (isset($_REQUEST['onsale']) && $_REQUEST['onsale'] == "1")
		$onsale = $db->clean($_REQUEST['onsale']);

	$outofstock = 0;
	if (isset($_REQUEST['outofstock']) && $_REQUEST['outofstock'] == "1")
		$outofstock = $db->clean($_REQUEST['outofstock']);


	// CODE FOR PRODUCT IMAGES
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

	// CODE FOR RANDOME IMAGES 
	if (isset($_SESSION['rand_image_path']) && $_SESSION['rand_image_path'] != "") {
		copy($IMAGEPATH_T . $_SESSION['rand_image_path'], $IMAGEPATH_A . $_SESSION['rand_image_path']);
		$rand_image_path = $_SESSION['rand_image_path'];
		unlink($IMAGEPATH_T . $_SESSION['rand_image_path']);
		unset($_SESSION['rand_image_path']);
	}
	if ($_REQUEST['rand_old_image_path'] != "" && $rand_image_path != "") {
		if (file_exists($IMAGEPATH_A . $_REQUEST['rand_old_image_path'])) {
			unlink($IMAGEPATH_A . $_REQUEST['rand_old_image_path']);
		}
	} else {
		if ($rand_image_path == "") {
			$rand_image_path = $_REQUEST['rand_old_image_path'];
		}
	}

	// CODE FOR RANDOME IMAGES 
	if (isset($_SESSION['dimen_image_path']) && $_SESSION['dimen_image_path'] != "") {
		copy($IMAGEPATH_T . $_SESSION['dimen_image_path'], $IMAGEPATH_A . $_SESSION['dimen_image_path']);
		$dimen_image_path = $_SESSION['dimen_image_path'];
		unlink($IMAGEPATH_T . $_SESSION['dimen_image_path']);
		unset($_SESSION['dimen_image_path']);
	}
	if ($_REQUEST['dimen_old_image_path'] != "" && $dimen_image_path != "") {
		if (file_exists($IMAGEPATH_A . $_REQUEST['dimen_old_image_path'])) {
			unlink($IMAGEPATH_A . $_REQUEST['dimen_old_image_path']);
		}
	} else {
		if ($dimen_image_path == "") {
			$dimen_image_path = $_REQUEST['dimen_old_image_path'];
		}
	}

	// echo "<pre>";
	// print_r($_REQUEST);
	// exit;

	$rows = array(
		'name'			=> $name,
		'slug'			=> $slug,
		'image' 		=> $image_path,
		'random_image'	=> $rand_image_path,
		'dimen_image'	=> $dimen_image_path,
		'price'			=> $price,
		'sell_price'	=> $sell_price,
		'description'	=> $description,
		'specification' => $specification,
		'technical' 	=> $technical,
		'quantity'		=> $quantity,
		'video'			=> $video_path,
		'new'			=> $new,
		'onSale'		=> $onsale,
		'out_of_stock'	=> $outofstock,
		'isActive'		=> $isActive,
		'isRemelt'		=> $isRemelt,
		'isPrepack'		=> $isPrepack,
		'height'		=> $height,
		'width'		    => $width,
		'length'		=> $length,
		'weight'		=> $weight,
		'unit'	        => $unit,
		'caliber_id'	=> $caliber_id,
		'dimen_descr'	=> $dimen_descr,
		'short_description' => $short_descr,
		'code' => $code,
		'isDelete'  	=> 0,
		'bs_rank' => $bs_rank
	);

	// print_r($_REQUEST); exit;
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "add") {
		$rsdupli = $db->getData($ctable, '*', 'slug = "' . $slug . '" AND isDelete=0');

		if (@mysqli_num_rows($rsdupli) > 0) {
			$_SESSION['MSG'] = 'Duplicate';
			$db->location(ADMINURL . 'add-' . $page . '/' . $_REQUEST['mode'] . '/');
			exit;
		} else {
			$prod_id = $db->insert($ctable, $rows);
			if (empty($prod_id)) {
				//die();
			}
			//die($category_id);
			if (isset($category_id)) {
				//die();
				foreach ($category_id as $category_id1) {
					$rows1 	= array(
						'product_id'    => $prod_id,
						'cate_id'		=> $category_id1,
						'isDelete'  	=> 0,
					);
					$user_id1 = $db->insert('prod_cate', $rows1);
				}
			}
			$_SESSION['MSG'] = 'Inserted';
			//$db->location(ADMINURL.'manage-'.$page.'/');
			//exit;
		}
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "edit" && $_REQUEST['id'] != null) {
		$id = $_REQUEST['id'];
		$rsdupli = $db->getData($ctable, '*', 'slug = "' . $slug . '" AND id <> ' . $id . ' AND isDelete=0');
		// exit;
		if (@mysqli_num_rows($rsdupli) > 0) {
			$_SESSION['MSG'] = 'Duplicate';
			$db->location(ADMINURL . 'add-' . $page . '/' . $_REQUEST['mode'] . '/' . $id . '/');
			exit;
		} else {
			$getProductSlug = $db->getValue('product', 'slug', 'id=' . $id);
			$rows['slug'] = count($getProductSlug) > 0 ?  $getProductSlug : $slug;
			// print_r($caliber_id); exit;
			$db->update($ctable, $rows, 'id=' . $id);
			$rows12 	= array("isDelete" => "1");
			$db->update('prod_cate', $rows12, 'product_id=' . $id);
			if (isset($category_id)) {

				foreach ($category_id as $category_id1) {

					$rows1 	= array(
						'product_id'    => $_REQUEST['id'],
						'cate_id'		=> $category_id1,
						'isDelete'  	=> 0,
					);
					$db->insert('prod_cate', $rows1);
					//die('1');
				}
			}

			$_SESSION['MSG'] = 'Updated';
			$db->location(ADMINURL . 'manage-' . $page . '/');
			exit;
		}
	}
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == 'edit') {

	$where 		= ' id=' . $_REQUEST['id'] . ' AND isDelete=0';
	$ctable_r 	= $db->getData($ctable, '*', $where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

	$name 				= stripslashes($ctable_d['name']);
	$price 				= stripslashes($ctable_d['price']);
	$sell_price 		= stripslashes($ctable_d['sell_price']);
	$decs 				= stripslashes($ctable_d['decs']);
	$image_path 		= stripslashes($ctable_d['image']);
	$rand_image_path 	= stripslashes($ctable_d['random_image']);
	$description 		= stripslashes($ctable_d['description']);
	$technical 			= stripslashes($ctable_d['technical']);
	$specification 		= stripslashes($ctable_d['specification']);
	$quantity	 		= stripslashes($ctable_d['quantity']) ?: 0;
	$new	 			= stripslashes($ctable_d['new']);
	$onsale	 			= stripslashes($ctable_d['onSale']);
	$outofstock	 		= stripslashes($ctable_d['out_of_stock']);
	$isActive	 		= stripslashes($ctable_d['isActive']);
	$isRemelt	 		= stripslashes($ctable_d['isRemelt']);
	$isPrepack	 		= stripslashes($ctable_d['isPrepack']);
	$video 				= stripslashes($ctable_d['video']);
	$height	 			= stripslashes($ctable_d['height']);
	$width	 			= stripslashes($ctable_d['width']);
	$weight	 			= stripslashes($ctable_d['weight']);
	$length	 			= stripslashes($ctable_d['length']);
	$unit	 			= stripslashes($ctable_d['unit']);
	$dimen_image_path 	= stripslashes($ctable_d['dimen_image']);
	$dimen_descr	 	= stripslashes($ctable_d['dimen_descr']);
	$short_descr		= stripslashes($ctable_d['short_description']);
	$code		= stripslashes($ctable_d['code']);
	$bs_rank = stripslashes($ctable_d['bs_rank']);
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "delete") {
	$id = $_REQUEST['id'];
	$rows = array('isDelete' => '1');

	$db->update($ctable, $rows, 'id=' . $id);

	$_SESSION['MSG'] = 'Deleted';
	$db->location(ADMINURL . 'manage-' . $page . '/');
	exit;
}

$sel_cate = "SELECT * from prod_cate WHERE product_id=" . $_REQUEST['id'] . " AND isDelete=0";

$query_sel_cate = mysqli_query($GLOBALS['myconn'], $sel_cate);
$List = array();
if (@mysqli_num_rows($query_sel_cate) > 0) {
	while ($row_sel_cate = @mysqli_fetch_array($query_sel_cate)) {
		array_push($List, $row_sel_cate['cate_id']);
	}
}
function category($parent_id = 0, $sub_mark = '')
{
	global $List;
	$sql = "SELECT * from category WHERE parent_id=" . $parent_id . " AND isDelete=0";
	$query = mysqli_query($GLOBALS['myconn'], $sql);

	if (@mysqli_num_rows($query) > 0) {
		while ($row = @mysqli_fetch_array($query)) {


			echo '<option value="' . $row['id'] . '" ';
			if (in_array($row['id'], $List))
				echo 'selected="selected"';
			echo '>' . $sub_mark . $row['name'] . '</option>';

			category($row['id'], $sub_mark . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		}
	}
}

$sel_caliber = "SELECT * from product WHERE id =" . $_REQUEST['id'] . " AND isDelete=0";
$query_sel_caliber = mysqli_query($GLOBALS['myconn'], $sel_caliber);
$ListCaliber;
if (@mysqli_num_rows($query_sel_caliber) > 0) {
	while ($row_selCaliber = @mysqli_fetch_array($query_sel_caliber)) {
		$ListCaliber =  $row_selCaliber['caliber_id'];
	}
}
function caliber()
{
	global $ListCaliber;
	$sql = "SELECT * from caliber WHERE isDelete=0";
	$query = mysqli_query($GLOBALS['myconn'], $sql);

	if (@mysqli_num_rows($query) > 0) {
		while ($row = @mysqli_fetch_array($query)) {

			echo '<option value="' . $row['id'] . '" ';
			if (in_array($row['id'], explode(",", $ListCaliber)))
				echo 'selected="selected"';
			echo '>' . $row['name'] . '</option>';
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
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
													<label for="name"> Name <code>*</code></label>
													<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="price">Sale Price <code>*</code></label>
													<input type="text" class="form-control" name="price" id="price" placeholder=" Price" value="<?php echo $price; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Old Price </label>
													<input type="text" class="form-control" name="sell_price" id="sell_price" placeholder=" Sell Price" value="<?php echo $sell_price; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="video"> Upload Video <code>*</code></label>
													<input type="file" class="form-control" name="video" id="video" placeholder="Video upload" value="<?php echo $video; ?>" accept="video/mp4,video/x-m4v,video/*">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Select caliber <span class="text-danger"></span></label>
													<select class="form-control" name="caliber_id[]" id="caliber_id" multiple="" onChange="getSubCat(this.value);">
														<option value="0">-- Select --</option>
														<?php caliber(); ?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Height <code>*</code></label>
													<input type="text" class="form-control" name="height" id="height" placeholder="Enter height" value="<?php echo $height; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> width <code>*</code></label>
													<input type="text" class="form-control" name="width" id="width" placeholder="Enter width" value="<?php echo $width; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> weight <code>*</code></label>
													<input type="text" class="form-control" name="weight" id="weight" placeholder="Enter weight" value="<?php echo $weight; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> length <code>*</code></label>
													<input type="text" class="form-control" name="length" id="length" placeholder="Enter length" value="<?php echo $length; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Select unit <span class="text-danger"></span></label>
													<select class="form-control" name="unit" id="unit" onChange="getSubCat(this.value);">
														<option value="">-- select --</option>
														<option value="cm" <?php if ($unit == 'cm') echo "selected"; ?>>Centimeters</option>
														<option value="kg" <?php if ($unit == 'kg') echo "selected"; ?>>kilograms</option>
														<option value="ft" <?php if ($unit == 'ft') echo "selected"; ?>>feet</option>
														<option value="in" <?php if ($unit == 'in') echo "selected"; ?>>Inches</option>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Select Category <span class="text-danger">*</span></label>
													<select class="form-control select2" name="category_id[]" multiple="true" id="category_id">
														<option value="0">-- Select --</option>
														<?php category(); ?>
													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Code <code>*</code></label>
													<input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" value="<?php echo $code; ?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name"> Best seller rank <code>*</code></label>
													<input type="text" class="form-control" name="bs_rank" id="bs_rank" placeholder="Enter Name" value="<?php echo $bs_rank; ?>">
												</div>
											</div>
											<div class="clearfix">.</div>
											<div class="col-md-6">
												<div class="form-group mb-2">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="onsale" id="onsale" value="1" <?php if ($onsale == "1") {
																																														echo "checked";
																																													} ?> />
															<label for="onsale" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> On Sale? </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group mb-2">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="new" id="new" value="1" <?php if ($new == "1") {
																																											echo "checked";
																																										} ?> />
															<label for="new" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> Is New? </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="outofstock" id="outofstock" value="1" <?php if ($outofstock == "1") {
																																																		echo "checked";
																																																	} ?> />
															<label for="outofstock" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> Out Of Stock? </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="isActive" id="isActive" value="1" <?php if ($isActive == "1") {
																																																echo "checked";
																																															} ?> />
															<label for="isActive" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> isActive? </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="isRemelt" id="isRemelt" value="1" <?php if ($isRemelt == "1") {
																																																echo "checked";
																																															} ?> />
															<label for="isRemelt" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> isRemelt? </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<div class="button-list">
														<div class="btn-switch btn-switch-dark pull-right">
															<input type="checkbox" name="isPrepack" id="isPrepack" value="1" <?php if ($isPrepack == "1") {
																																																	echo "checked";
																																																} ?> />
															<label for="isPrepack" class="btn btn-rounded btn-dark waves-effect waves-light">
																<em class="mdi mdi-check"></em>
																<strong> Prepacked </strong>
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="description"> Description <code>*</code></label>
													<textarea id="description" name="description" placeholder="Enter description"><?php echo $description; ?></textarea>
												</div>
											</div>
											<!-- 											<div class="col-md-6">
												<div class="form-group">
													<label for="specification"> Specification <code>*</code></label>
													<textarea id="specification" name="specification" placeholder="Enter specification"><?php echo $specification; ?></textarea>
												</div>
											</div> -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="technical"> Technical <code>*</code></label>
													<textarea id="technical" name="technical" placeholder="Enter technical"><?php echo $technical; ?></textarea>
												</div>
											</div>

											<!-- THIS IS FOR THE DIMENSION SECTION SET -->
											<!-- 											<div class="col-md-6">
												<div class="form-group">
													<label for="dimen_descr">Dimension's Description <code>*</code></label>
													<textarea id="dimen_descr" name="dimen_descr" placeholder="Enter description"><?php echo $dimen_descr; ?></textarea>
												</div>
											</div> -->
											<div class="col-md-6">
												<div class="form-group">
													<label for="short_descr">Short Description <code>*</code></label>
													<textarea id="short_descr" name="short_descr" placeholder="Enter short description"><?php echo $short_descr; ?></textarea>
												</div>

											</div>



											<div class="col-md-12">
												<div class="form-group">
													<label for="image_path">Image <code>*</code>
														<br />
														<small>minimum image size 400 x 292 px</small>
													</label>
													<div class="row">
														<div class="col-md-6">
															<input type="hidden" name="filename" id="filename" class="form-control" />
															<div id="dropzone_img" class="dropzone" data-width="399" data-height="291" data-ghost="false" data-cropwidth="400" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prodimg" style="width: 400px;height:292px;">
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
														<!-- 															<div class="col-md-6">
																<div class="form-group">
																	<label for="quantity"> Quantity <code>*</code></label>
																	<input type="number" min="0" class="form-control quantity-btn" name="quantity" id="quantity" placeholder="quantity" value="<?php echo $quantity; ?>" onchange="myQuantity(this.value)" >
																</div>
															</div> -->

													</div>
												</div>
											</div>
											<div class="col-md-6">
												<label for="rand_image_path">Dimension Image
													<br />
													<small>minimum image size 301 x 288 px</small>
												</label><br />
												<input type="hidden" name="dimen_filename" id="dimen_filename" class="form-control" />
												<div id="dimen_dropzone_img" class="dropzone" data-width="500" data-height="350" data-ghost="false" data-cropwidth="500" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=dimension" style="width: 500px;height:350px;">
													<input type="file" id="dimen_image_path" name="dimen_image_path">
													<input type="hidden" name="dimen_old_image_path" value="<?php echo $dimen_image_path; ?>" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<?php
													if ($dimen_image_path != "" && file_exists($IMAGEPATH_A . $dimen_image_path)) {
													?>
														<img src="<?php echo SITEURL . $IMAGEPATH . $dimen_image_path; ?>" width="400"><br /><br />
													<?php
													}
													?>
												</div>
											</div>
											<!-- DIMENSION OVER -->


											<!-- RANDOM IMAGE -->
											<div class="col-md-6" hidden>
												<label for="rand_image_path">Random Image <code>*</code>
													<br />
													<small>minimum image size 550 x 700 px</small>
												</label><br />
												<input type="hidden" name="rand_filename" id="rand_filename" class="form-control" />
												<div id="rand_dropzone_img" class="dropzone" data-width="550" data-height="700" data-ghost="false" data-cropwidth="550" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=rand_prodimg" style="width: 550px;height:700px;">
													<input type="file" id="rand_image_path" name="rand_image_path">
													<input type="hidden" name="rand_old_image_path" value="<?php echo $rand_image_path; ?>" />
												</div>
											</div>
											<div class="col-md-6" hidden>
												<div class="form-group">
													<?php
													if ($rand_image_path != "" && file_exists($IMAGEPATH_A . $rand_image_path)) {
													?>
														<img src="<?php echo SITEURL . $IMAGEPATH . $rand_image_path; ?>" width="400"><br /><br />
													<?php
													}
													?>
												</div>
											</div>

											<!-- RANDOM IMAGE -->
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
		$('#category_id').select2({
			placeholder: "select categories",
			tags: true,
			tokenSeparators: [",", " "]
		});

		$('#caliber_id').select2({
			placeholder: "select calibers",
			tags: true,
			tokenSeparators: [",", " "]
		});

		$("input[type='search']").on('keyup', function() {
			$("#category_id option[data-select2-category_id='true']").remove();
			$("#category option[data-select2-category_id='true']").remove();
		});

		CKEDITOR.replace('description');
		CKEDITOR.replace('technical');
		CKEDITOR.replace('specification');
		CKEDITOR.replace('short_descr');
		CKEDITOR.replace('dimen_descr', {
			allowedContent: {
				'b i ul ol big small': true,
				'h1 h2 h3 p blockquote li': {
					styles: 'text-align'
				},
				a: {
					attributes: '!href,target'
				},
				img: {
					attributes: '!src,alt',
					styles: 'width,height',
					classes: 'left,right'
				}
			}
		});


		var custom_img_width = '454';

		$('#dropzone_img').html5imageupload({
			onAfterProcessImage: function() {
				var imgName = $('#filename').val($(this.element).data('imageFileName'));
			},
			onAfterCancel: function() {
				$('#filename').val('');
			}
		});

		$('#rand_dropzone_img').html5imageupload({
			onAfterProcessImage: function() {
				var imgName = $('#rand_filename').val($(this.element).data('imageFileName'));
			},
			onAfterCancel: function() {
				$('#rand_filename').val('');
			}
		});

		$('#dimen_dropzone_img').html5imageupload({
			onAfterProcessImage: function() {
				var imgName = $('#dimen_filename').val($(this.element).data('imageFileName'));
			},
			onAfterCancel: function() {
				$('#dimen_filename').val('');
			}
		});

		$(function() {
			$("#frm").validate({
				ignore: "",
				rules: {
					name: {
						required: true
					},
					price: {
						required: true
					},
					image_path: {
						required: $("#mode").val() == "add" && $("#filename").val() == ""
					},
					description: {
						required: function() {
							CKEDITOR.instances.description.updateElement();
						}
					},
					specification: {
						required: function() {
							CKEDITOR.instances.specification.updateElement();
						}
					},
					technical: {
						required: function() {
							CKEDITOR.instances.technical.updateElement();
						}
					},
				},
				messages: {
					name: {
						required: "Please enter name."
					},
					PeriodicWave: {
						required: "Please enter sale price."
					},
					image_path: {
						required: "Please upload image."
					},
					description: {
						required: "Please enter description."
					},
					specification: {
						required: "Please enter specification."
					},
					technical: {
						required: "Please enter technical."
					},

				},
				errorPlacement: function(error, element) {
					if (element.attr("name") == "filename")
						error.insertAfter("#dropzone_img");
					else
						error.insertAfter(element);
				}
			});
		});

		// $('#caliber_id').select2({
		// 	placeholder: "Select Caliber",
		// 	tags: true,
		// 	tokenSeparators: [",", " "]
		// });

		$(".cbox").change(function() {
			$(".cbox").prop('checked', false);
			$(this).prop('checked', true);
		});

		function myQuantity() {
			var x = document.getElementById("quantity").value;
			// alert(x);

			if (x == 0) {
				document.getElementById("outofstock").checked = true;
				document.getElementById("onsale").checked = false;
				document.getElementById("new").checked = false;
			} else {
				document.getElementById("onsale").checked = true;
				document.getElementById("outofstock").checked = false;
			}
		}
	</script>
</body>

</html>