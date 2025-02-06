<?php
include("connect.php");
include("../include/notification.class.php");

$db->checkAdminLogin();

$ctable 	= 'coupon';
$ctable1 	= 'Coupon';
$main_page 	= 'Coupon'; //for sidebar active menu
$page		= 'coupon';
$page_title = ucwords($_REQUEST['mode']) . " " . $ctable1;

$name 				= "";
$code 				= "";
$type				= "";
$amount				= "";
$min_spend_amount	= 0;
$start_date			= "";
$expiration_date	= "";

if (isset($_REQUEST['submit'])) {
	//print_r($_REQUEST);die();

	$name				= $db->clean($_REQUEST['name']);
	$code				= $db->clean($_REQUEST['code']);
	$type				= $db->clean($_REQUEST['type']);
	$amount				= $db->clean($_REQUEST['amount']);
	$min_spend_amount	= $db->clean($_REQUEST['min_spend_amount']);
	$start_date			= $db->clean($_REQUEST['start_date']);
	$expiration_date	= $db->clean($_REQUEST['expiration_date']);

	$arstart = explode('/', $start_date);
	$arexpire = explode('/', $expiration_date);

	$start_date = $arstart[2] . '-' . $arstart[0] . '-' . $arstart[1];
	$expiration_date = $arexpire[2] . '-' . $arexpire[0] . '-' . $arexpire[1];

	$rows 	= array(
		"name" 	=> $name,
		"code" 	=> $code,
		"type" 	=> $type,
		"amount" => $amount,
		"min_spend_amount" => $min_spend_amount,
		"start_date" => $start_date,
		"expiration_date" => $expiration_date,
	);

	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "add") {

		$contact_id = $db->insert($ctable, $rows);

		$_SESSION['MSG'] = "Inserted";
		$db->location(ADMINURL . 'manage-' . $page . '/');
		// exit;
	}
	if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == "edit" && $_REQUEST['id'] != null) {
		$db->update($ctable, $rows, "id=" . $_REQUEST['id']);

		$_SESSION['MSG'] = "Updated";
		$db->location(ADMINURL . 'manage-' . $page . '/');
		exit;
	}
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "edit") {
	$where 		= " id=" . $_REQUEST['id'] . " AND isDelete=0";
	$ctable_r 	= $db->getData($ctable, "*", $where);
	$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

	$name 	= $ctable_d['name'];
	$code 	= $ctable_d['code'];
	$type	= $ctable_d['type'];
	$amount	= $ctable_d['amount'];
	$min_spend_amount = $ctable_d['min_spend_amount'];
	$start_date = $ctable_d['start_date'];
	$expiration_date = $ctable_d['expiration_date'];
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0 && $_REQUEST['mode'] == "delete") {
	$id = $_REQUEST['id'];
	$rows = array("isDelete" => "1");

	$db->update($ctable, $rows, "id=" . $id);

	$_SESSION['MSG'] = "Deleted";
	$db->location(ADMINURL . 'manage-' . $page . '/');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
	<?php include('include/css.php'); ?>
	<link href="<?php echo ADMINURL; ?>assets/css/bootstrap-datepicker.css" rel="stylesheet">
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
								<i class="mdi mdi-percent"></i>
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
													<label for="code">Coupon Code <code>*</code></label>
													<input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" value="<?php echo $code; ?>" maxlength="50">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="name">Coupon Name <code>*</code></label>
													<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name; ?>" maxlength="100">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="type">Type <code>*</code></label>
													<select class="form-control" name="type" id="type">
														<option value="">Select Type</option>
														<option <?php if ($type == 'percent') {
																			echo "selected";
																		} ?> value="percent">Percentage</option>
														<option <?php if ($type == 'flat') {
																			echo "selected";
																		} ?> value="flat">Flat amount</option>

													</select>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name">Discount Amount <code>*</code></label>
													<input type="number" class="form-control" value="<?php echo $amount; ?>" min="1" id="amount" name="amount" maxlength="10">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="name">Minimum Spend Amount <code>*</code></label>
													<input type="number" class="form-control" value="<?php echo $min_spend_amount; ?>" min="0" id="min_spend_amount" name="min_spend_amount" maxlength="10">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="start_date">Start Date <code>*</code></label>
													<div class="input-group date" id="start_date_div" data-date-format="mm-dd-yyyy">
														<input type="text" autocomplete="off" name="start_date" id="start_date" data-date-format="mm/dd/yyyy" class="form-control datepicker" value="<?php if (!empty($start_date) && !is_null($start_date)) echo date('m/d/Y', strtotime($start_date)); ?>" maxlength="10">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="expiration_date">Expiration Date <code>*</code></label>
													<div class="input-group date" id="expiration_date_div" data-date-format="mm-dd-yyyy">
														<input type="text" autocomplete="off" name="expiration_date" id="expiration_date" data-date-format="mm/dd/yyyy" class="form-control datepicker" value="<?php if (!empty($expiration_date) && !is_null($expiration_date)) echo date('m/d/Y', strtotime($expiration_date)); ?>" maxlength="10">
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
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
	<script src="<?php echo ADMINURL; ?>assets/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript">
		$(function() {
			$('.datepicker').datepicker({
				startDate: 'today',
				todayHighlight: true,
				autoClose: true,
				orientation: "bottom left",
				templates: {
					leftArrow: '<i class="mdi mdi-arrow-left-drop-circle"></i>',
					rightArrow: '<i class="mdi mdi-arrow-right-drop-circle"></i>'
				},
			});

			$("#frm").validate({
				ignore: "",
				rules: {
					name: {
						required: true
					},
					code: {
						required: true
					},
					type: {
						required: true
					},
					amount: {
						required: true
					},
					min_spend_amount: {
						required: true
					},
					start_date: {
						required: true
					},
					expiration_date: {
						required: true
					},
				},
				expiration_dates: {
					name: {
						required: "Please enter name."
					},
					code: {
						required: "Please enter code."
					},
					type: {
						required: "Please select type."
					},
					amount: {
						required: "Please enter amount."
					},
					min_spend_amount: {
						required: "Please enter minimum spend amount."
					},
					start_date: {
						required: "Please enter start date."
					},
					expiration_date: {
						required: "Please enter expiration date."
					},
				},
				errorPlacement: function(error, element) {
					error.insertAfter(element);
				}
			});
		});
	</script>
</body>

</html>