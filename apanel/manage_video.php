<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= 'video_library';
	$ctable1 	= 'video library';
	$main_page 	= 'video library'; //for sidebar active menu
	$page		= 'video';
	$page_title = "Manage ".$ctable1;

	if(isset($_REQUEST['submit']))
	{
		$disp_count = $_REQUEST['disp_count'];
		
		for($i=1; $i<=$disp_count; $i++)
		{
			$row_id = $_REQUEST['row_id'.$i];
			$display_order = $_REQUEST['disp'.$i];
			
			if($row_id > 0)
			{
				$rows = array("display_order" => $display_order);
				$db->update($ctable, $rows, "id=" . $row_id);
				$_SESSION['MSG'] = 'OrderUpdated';
			}
		}
		
		$db->location(ADMINURL."manage-$page/");
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
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-contacts"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
						<div class="col-md-12">
							<div class="box border-top-info">
								<div class="card">
									<div class="card-body">
										<!-- For Table 1 -->
										<div class="box-header with-border">
											<div class="col-md-12 ">
												<form action="#" onSubmit="return searchByName();">
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<input type="text" value="" name="searchName" class="form-control" placeholder="Search Here..." id="searchName" value="">
															</div>
														</div>
														<div class="col-md-3">
															<button type="submit" class="btn btn-gradient-dark"><i class="mdi mdi-magnify"></i></button>
															<button type="submit" class="btn btn-gradient-light" title="Clear Search Result" value="clear" onClick="clearSearchByName();"><i class="mdi mdi-filter-remove"></i></button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="box-body no-padding">
											<div class="col-md-12 table-responsive">
												<div class="loading-div" style="display:none;">
													<div><img style="width:10%;margin-left:440px;" src="<?php echo ADMINURL; ?>assets/images/loader.svg"></div>
												</div>
												<div id="results"></div>
											</div>
										</div>
									</div>
								</div>
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
		/*$(document).ready(function() {
			$('.loading-div').hide();
		});*/
	/*Table 1 */
		var searchName="";
		function searchByName(){
			searchName = $("#searchName").val();
			displayRecords(10);
			return false;
		}
		function clearSearchByName(){
			searchName = "";
			$("#searchName").val("");
			displayRecords(10);
		}
		$("#searchName").keyup(function(event){
			if(event.keyCode == 13){
				$("#searchByName").click();
			}
		});
		function loadDataTable(data_url,page=""){
			setTimeout(function(){
				$("#results" ).load( data_url,{"page":page},function(){
					$('#example').DataTable({
						"bPaginate": false,
						"bFilter": false,
						"bInfo": false,
						"bAutoWidth": false, 
						"aoColumns": [
							{ "sWidth": "5%","bSortable": false }, 
							{ "sWidth": "5%" },
							{ "sWidth": "40%" },
							{ "sWidth": "5%","bSortable": false }
						]
					});
					$(".loading-div").fadeOut(500);
					$("#results").fadeIn();
				}); //load initial records
			},1500);
		}
		
		function displayRecords(numRecords) {
			var searchName 	= $("#searchName").val();
			searchName 	    = encodeURIComponent(searchName.trim());
			var data_url    = "<?php echo ADMINURL; ?>ajax_get_<?php echo $page; ?>.php?show=" + numRecords + "&searchName=" + searchName;
			$("#results").html("");
			$(".loading-div").show();
			loadDataTable(data_url);
			
			//executes code below when user click on pagination links
			$("#results").on("click",".paging_simple_numbers a", function (e){
				e.preventDefault();
				var numRecords  = $("#numRecords").val();
				$(".loading-div").show(); //show loading element
				var page = $(this).attr("data-page"); //get page number from link
				loadDataTable(data_url,page);
			});
			$("#results").on( "change", "#numRecords", function (e){
				e.preventDefault();
				var numRecords  = $("#numRecords").val();
				$(".loading-div").show(); //show loading element
				var page = $(this).attr("data-page"); //get page number from link
				loadDataTable(data_url,page);
			});
		}

		// used when user change row limit
		function changeDisplayRowCount(numRecords) {
			displayRecords(numRecords);
		}

		$(document).ready(function() {
			displayRecords(10);
		});

		function del_conf(id){
			var r = confirm("Are you sure you want to delete?");
			if(r){
				window.location.href='<?php echo ADMINURL; ?>add-<?php echo $page; ?>/delete/'+id+'/';
			}
		}
	</script>
</html>