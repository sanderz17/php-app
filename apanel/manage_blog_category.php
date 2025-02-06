<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "blog_category";
	$ctable1 	= "Category";
	$page 		= "blog-category";
	$page_title = "Manage ".$ctable1;

	if(isset($_REQUEST['submit']))
	{
	    $id = $_REQUEST['id'];
	    $name = $_REQUEST['name'];

	    $n = count($id);
	    for( $i=0; $i<$n; $i++ )
	    {
	        $rows = array(
	            "name" => $name[$i]
	        );
			if( (int)$id[$i] > 0 )
			{
				$db->update($ctable, $rows, 'id='.$id[$i]);
			}
			else
			{
				$color_id = $db->insert($ctable, $rows);
			}
	    }

	    $_SESSION['MSG'] = "Updated";
	    $db->location(ADMINURL."manage-$page/");
	    exit;
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array("isDelete" => "1");
		
		$db->update($ctable, $rows, "id=".$id);
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
			<!-- partial:partials/_navbar.html -->
			<?php include("include/header.php"); ?>
			<!-- partial -->
			<div class="container-fluid page-body-wrapper">
				<?php include('include/left.php'); ?>
				<!-- partial -->
				<div class="main-panel">
					<div class="content-wrapper">
						<div class="page-header">
							<h3 class="page-title">
							<span class="page-title-icon bg-gradient-info text-white mr-2">
								<i class="mdi mdi-account menu-icon"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="card mb-4  border-left-info">
									<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

										<div class="card-body col-lg-12">
											<p class="btn-success p-2">NOTE: Please click on <strong>SUBMIT</strong> button to save the changes or new rows.</p>
											<div id="divcontent">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label> Name </label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label> Remove </label>
														</div>
													</div>
												</div>
												<?php
													$count = 0;
													$rs = $db->getData($ctable, '*', 'isDelete=0');
													while( $row = @mysqli_fetch_assoc($rs) )
													{
														$count++;
												?>
												<div class="row" id="row_<?php echo $count; ?>">
													<div class="col-md-6">
														<div class="form-group">
															<input type="hidden" name="id[]" id="id<?php echo $count; ?>" value="<?php echo $row['id']; ?>">
															<input type="text" class="form-control" name="name[]" id="name<?php echo $count; ?>" value="<?php echo $row['name']; ?>" maxlength="100" required>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<a href="javascript:void(0);" class="btn btn-gradient-light mb-3" onclick="remove_block(<?php echo $row['id']; ?>, <?php echo $count; ?>);" title="Remove"><i class="mdi mdi-delete"></i></a>
														</div>
													</div>
												</div>
												<?php
													}
												?>
											</div>
											<div class="row mb-2">
												<div class="col-md-6">
													<button type="button" name="btnadd" id="btnadd" class="btn btn-gradient-light mb-3" title="Add More"><i class="mdi mdi-database-plus"></i></button>
													<input type="hidden" name="hdncount" id="hdncount" value="<?php echo $count; ?>">
												</div>
											</div>
											<div class="box-footer">
												<button type="submit" name="submit" id="submit" class="btn btn-gradient-success btn-icon-text" title="Submit"><i class="mdi mdi-content-save-all"></i></button>
												<button type="button" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL.'manage-'.$page.'/'; ?>'" title="Back"><i class="mdi mdi-step-backward" aria-hidden="true"></i></button>
											</div>
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
	</body>
	<script type="text/javascript">

		$('#btnadd').click(function(){
		    val = $("#hdncount").val();
		    val++;
		    $("#hdncount").val(val);
		    $("#divcontent").append('<div class="row" id="row_'+val+'"> <div class="col-md-6"> <div class="form-group"> <input type="hidden" name="id[]" id="id'+val+'" value="0"> <input type="text" class="form-control" name="name[]" id="name'+val+'" value="" maxlength="100" required> </div> </div> <div class="col-md-6"> <div class="form-group"> <a href="javascript:void(0);" class="btn btn-danger" onclick="remove_block(0, '+val+');" title="Remove"><i class="mdi mdi-delete"></i></a> </div> </div> </div>');
	  	});

		function remove_block(id, ctrlid)
		{
			if( confirm('Are you sure you want to delete the record?') )
			{
				$.ajax({
					type: "POST",
					url: "<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/",
					data: 'mode=delete&id='+id,
					success: function(res) {
						$("#row_"+ctrlid).remove();
						$.notify({message: "Record deleted successfully."}, {type: "success"});
					}
				}); 
			}
		}
	</script>
</html>