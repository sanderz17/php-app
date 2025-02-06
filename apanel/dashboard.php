<?php
include("connect.php");
$db->checkAdminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('include/css.php'); ?>
</head>

<body>
	<div class="loader" style="display: none;">
		<div><img src="<?php echo ADMINURL; ?>assets/images/loader.svg"></div>
	</div>
	<div class="container-scroller">
		<?php include('include/header.php'); ?>
		<div class="container-fluid page-body-wrapper">
			<?php include('include/left.php'); ?>
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="page-header">
						<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-home"></i>
							</span> Dashboard
						</h3>
					</div>

					<div class="row">
						<?php
						include('include/dashboard_var.php');
						foreach ($dashboard_main_array as $arboard) {
						?>
							<div class="col-md-4 stretch-card grid-margin">
								<div class="card bg-gradient-<?php echo $arboard[0]; ?> card-img-holder text-white">
									<?php
									if ($arboard[2] == "User(s)") {
										$dash_url = "manage-user/";
									} elseif ($arboard[2] == "Product(s)") {
										$dash_url = "manage-product/";
									} else {
										$dash_url = "manage-order/";
									}
									?>
									<a href="<?php echo ADMINURL ?><?= $dash_url; ?>" style="text-decoration: none;color: white;">
										<div class="card-body">
											<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
											<h4 class="font-weight-normal mb-3"><?php echo $arboard[2]; ?> <i class="mdi <?php echo $arboard[4]; ?> mdi-24px float-right"></i>
											</h4>
											<h2 class="mb-5"><?php echo $arboard[1]; ?></h2>
										</div>
									</a>
									<?php
									?>
								</div>
							</div>
						<?php
						}
						?>
					</div>

					<div class="page-header">
						<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi mdi-cart menu-icon"></i>
							</span> Order Reports
						</h3>
					</div>

					<div class="row">
						<!-- today -->
						<div class="col-md-4 stretch-card grid-margin">
							<div class="card bg-gradient-dark card-img-holder text-white">
								<?php
								?>
								<a href="<?php echo ADMINURL ?>manage-order-report" style="text-decoration: none;color: white;">
									<div class="card-body">
										<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
										<h4 class="font-weight-normal mb-3">Today <i class="mdi mdi-24px float-right"></i>
										</h4>
										<h2 class="mb-5">$
											<?php
											$today_tot = $db->getValue("cart", "SUM(sub_total)", " updateDate > DATE_SUB(NOW(), INTERVAL 1 DAY) AND isDelete=0 AND order_status=2 AND payment_method IS NOT NULL", 0);
											if ($today_tot > 0 && $today_tot != "") {
												echo number_format($today_tot, 2);
											} else {
												echo "0";
											}
											?>
										</h2>
									</div>
								</a>
								<?php
								?>
							</div>
						</div>
						<!-- this week -->
						<div class="col-md-4 stretch-card grid-margin">
							<div class="card bg-gradient-dark card-img-holder text-white">
								<?php
								?>
								<a href="<?php echo ADMINURL ?>manage-order-report" style="text-decoration: none;color: white;">
									<div class="card-body">
										<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
										<h4 class="font-weight-normal mb-3">This week <i class="mdi mdi-24px float-right"></i>
										</h4>
										<h2 class="mb-5">$
											<?php
											$week_tot = $db->getValue("cart", "SUM(sub_total)", " YEARWEEK(updateDate)=YEARWEEK(NOW()) AND isDelete=0 AND order_status=2 AND payment_method IS NOT NULL", 0);
											if ($week_tot > 0 && $week_tot != "") {
												echo number_format($week_tot, 2);
											} else {
												echo "0";
											}
											?>
										</h2>
									</div>
								</a>
								<?php
								?>
							</div>
						</div>
						<!-- this month -->
						<div class="col-md-4 stretch-card grid-margin">
							<div class="card bg-gradient-dark card-img-holder text-white">
								<?php
								?>
								<a href="<?php echo ADMINURL ?>manage-order-report" style="text-decoration: none;color: white;">
									<div class="card-body">
										<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
										<h4 class="font-weight-normal mb-3">This month <i class="mdi mdi-24px float-right"></i>
										</h4>
										<h2 class="mb-5">$
											<?php
											$month_tot = $db->getValue("cart", "SUM(sub_total)", " MONTH(updateDate) = MONTH(CURRENT_DATE()) AND YEAR(updateDate) = YEAR(CURRENT_DATE()) AND isDelete=0 AND order_status=2 AND payment_method IS NOT NULL", 0);
											if ($month_tot > 0 && $month_tot != "") {
												echo number_format($month_tot, 2);
											} else {
												echo "0";
											}
											?>
										</h2>
									</div>
								</a>
								<?php
								?>
							</div>
						</div>
						<!-- this quarterly -->
						<div class="col-md-4 stretch-card grid-margin">
							<div class="card bg-gradient-dark card-img-holder text-white">
								<?php
								?>
								<a href="<?php echo ADMINURL ?>manage-order-report" style="text-decoration: none;color: white;">
									<div class="card-body">
										<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
										<h4 class="font-weight-normal mb-3">This quarter <i class="mdi mdi-24px float-right"></i>
										</h4>
										<h2 class="mb-5">$
											<?php
											$quarter_tot = $db->getValue("cart", "SUM(sub_total)", " adate > DATE_SUB(NOW(), INTERVAL 3 MONTH) AND isDelete=0 AND order_status=2 AND payment_method IS NOT NULL", 0);
											if ($quarter_tot > 0 && $quarter_tot != "") {
												echo number_format($quarter_tot, 2);
											} else {
												echo "0";
											}
											?>
										</h2>
									</div>
								</a>
								<?php
								?>
							</div>
						</div>
						<!-- this year -->
						<div class="col-md-4 stretch-card grid-margin">
							<div class="card bg-gradient-dark card-img-holder text-white">
								<?php
								?>
								<a href="<?php echo ADMINURL ?>manage-order-report" style="text-decoration: none;color: white;">
									<div class="card-body">
										<img src="<?php echo ADMINURL; ?>assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
										<h4 class="font-weight-normal mb-3">This year <i class="mdi mdi-24px float-right"></i>
										</h4>
										<h2 class="mb-5">$
											<?php
											$year_tot = $db->getValue("cart", "SUM(sub_total)", " YEAR(updateDate) = YEAR(CURRENT_DATE()) AND isDelete=0 AND order_status=2 AND payment_method IS NOT NULL", 0);
											if ($year_tot > 0 && $year_tot != "") {
												echo number_format($year_tot, 2);
											} else {
												echo "0";
											}
											?>
										</h2>
									</div>
								</a>
								<?php
								?>
							</div>
						</div>
					</div>

				</div>
				<!-- content-wrapper ends -->
				<?php include('include/footer.php'); ?>
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
	<?php include('include/js.php'); ?>
</body>

</html>