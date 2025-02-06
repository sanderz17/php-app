<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'product_accessories';
	$ctable1 	= 'Product Accessories';
	$main_page 	= 'Product Accessories'; //for sidebar active menu
	$page		= 'accessories';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name 			= "";
	$slug 			= "";
	$price			= "";
	$image_path 	= "";
	$isDelete 		= "";
	$quantity		= "";

	$IMAGEPATH_T 	= PRODUCT_T;
	$IMAGEPATH_A 	= PRODUCT_A;
	$IMAGEPATH 		= PRODUCT;

	$product_id = 0;
	if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
		$product_id = $_REQUEST['id'];
	}


	if(isset($_REQUEST['submit']))
	{	
		$name 			= $db->clean($_REQUEST['name']);
		$slug		    = $db->createSlug($_REQUEST['name']);
		$price			= trim($_REQUEST['price']);
		$quantity		= trim($_REQUEST['quantity']);

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

		$rows 	= array(
			'name'			=> $name,
			'slug'			=> $slug,
			'image_path' 	=> $image_path,
			'product_id'	=> $product_id,
			'price'			=> $price,
			'quantity'		=> $quantity,
			'isDelete'  	=> 0,
		);

		// print_r($_REQUEST); exit;
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$rsdupli = $db->getData($ctable, '*', 'slug = "'.$slug.'" AND isDelete=0');
		
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/');
				exit;
			}
			else
			{
				$user_id = $db->insert($ctable, $rows);
				
				$_SESSION['MSG'] = 'Inserted';
				$db->location(ADMINURL.'manage-'.$page.'/'.$product_id);
				exit;
			}
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$rsdupli = $db->getData($ctable, '*', 'slug = "'.$slug.'" AND id <> ' . $id . ' AND isDelete=0');
			// exit;
			if(@mysqli_num_rows($rsdupli) > 0)
			{
				$_SESSION['MSG'] = 'Duplicate';
				$db->location(ADMINURL.'add-'.$page.'/'.$_REQUEST['mode'].'/'.$id.'/');
				exit;
			}
			else
			{				
				// print_r($rows); exit;
				$db->update($ctable, $rows, 'id='.$id);
								
				$_SESSION['MSG'] = 'Updated';
				$db->location(ADMINURL.'manage-'.$page.'/'.$product_id);
				exit;
			}
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$name 			= stripslashes($ctable_d['name']);
		$price 			= stripslashes($ctable_d['price']);
		$sell_price 	= stripslashes($ctable_d['sell_price']);
		$decs 			= stripslashes($ctable_d['decs']);
		$image_path 	= stripslashes($ctable_d['image']);
		$rand_image_path= stripslashes($ctable_d['random_image']);
		$description 	= stripslashes($ctable_d['description']);
		$technical 		= stripslashes($ctable_d['technical']);
		$specification 	= stripslashes($ctable_d['specification']);	
		$quantity	 	= stripslashes($ctable_d['quantity']);
		$new	 		= stripslashes($ctable_d['new']);	
		$onsale	 		= stripslashes($ctable_d['onSale']);
		$outofstock	 	= stripslashes($ctable_d['out_of_stock']);
		$isActive	 	= stripslashes($ctable_d['isActive']);
		$video 			= stripslashes($ctable_d['video']);
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
												<div class="col-md-6">
													<div class="form-group">
														<label for="name"> Name <code>*</code></label>
														<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="price"> Price <code>*</code></label>
														<input type="text" class="form-control" name="price" id="price" placeholder=" Price" value="<?php echo $price; ?>">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="image_path">Image <code>*</code>
															<br />
															<small>minimum image size 288 x 146 px</small>
														</label>
														<div class="row">
															<div class="col-md-6">
																<input type="hidden" name="filename" id="filename" class="form-control" />
																<div id="dropzone_img" class="dropzone" data-width="200" data-height="146" data-ghost="false" data-cropwidth="200" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prodimg" style="width: 200px;height:146px;">
																	<input type="file" id="image_path" name="image_path">
																	<input type="hidden" name="old_image_path" value="<?php echo $image_path; ?>" />
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
															<div class="col-md-6">
																<div class="form-group">
																	<label for="quantity"> Quantity <code>*</code></label>
																	<input type="number" class="form-control" name="quantity" id="quantity" placeholder="quantity" value="<?php echo $quantity; ?>">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
											<button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page.'/'.$product_id; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
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

			// CKEDITOR.replace('description');
			// CKEDITOR.replace('technical');
			// CKEDITOR.replace('specification');


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

			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						name:{required:true}, 
						price:{required:true},
						sell_price:{required:true},
						image_path:{ required: $("#mode").val()=="add" && $("#filename").val()=="" }, 
						description:{required:function() { CKEDITOR.instances.description.updateElement(); }}, 
						specification:{required:function() { CKEDITOR.instances.specification.updateElement(); }}, 
						technical:{required:function() { CKEDITOR.instances.technical.updateElement(); }}, 
					},
					messages: {
						name:{required:"Please enter name."},
						price:{required:"Please enter price."},
						sell_price:{required:"Please enter sell price."},
						image_path:{required:"Please upload image."},
						description:{required:"Please enter description."},
						specification:{required:"Please enter specification."},
						technical:{required:"Please enter technical."},

					},
					errorPlacement: function(error, element) {
						if (element.attr("name") == "filename") 
							error.insertAfter("#dropzone_img");
						else
							error.insertAfter(element);
					}
				});
			});
		</script>
	</body>
</html>