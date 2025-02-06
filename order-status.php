<?php
include "connect.php";
include("include/ups.class.php");
$dateShipped = null;
$ORDER_STATUS = [
	'ORDER_CONFIRMED' => [
		'text' => "Packaging"
	],
	'ORDER_SHIPPED' => [
		'text' => 'On the way'
	],
	'DELIVERED' => [
		'text' => 'Delivered'
	]
];
//default
$currentOrderStatus = $ORDER_STATUS['ORDER_CONFIRMED'];

$order_num = $db->clean($_REQUEST['order_no']) ?? '';
$ups = new upsRate();
$shipStations = new Cart();
$shipstation_shipment = $shipStations->getOrderShipmentFromShipStation($order_num) ?: '';
if (!empty($shipstation_shipment)) {
	$dateOrdered = date("F j, Y", strtotime($shipstation_shipment->createDate)) ?? "";
	$dateShipped = date("F j, Y", strtotime($shipstation_shipment->shipDate)) ?? "";
} else {
	$shipstation_shipment = $shipStations->getOrderFromShipStation($order_num);
	$dateOrdered = date("F j, Y", strtotime($shipstation_shipment->createDate)) ?? "";
}

$carrierCode = $shipstation_shipment->carrierCode;
$status_detail;

if (!empty($dateShipped)) {
	$currentOrderStatus = $ORDER_STATUS['ORDER_SHIPPED'];
}

if ($carrierCode == 'ups' || $carrierCode != null ) {
	$upsTrackingNumber = $shipstation_shipment->trackingNumber;
	$order_ups_current_status = $ups->getUpsShipmentStatus($upsTrackingNumber);
	$order_ups_current_status_description = $order_ups_current_status["trackResponse"]["shipment"][0]["package"][0]["currentStatus"]["description"];
	if ($order_ups_current_status["trackResponse"]["shipment"][0]["package"][0]["currentStatus"]["description"] == 'Delivered') {
		$currentOrderStatus = $ORDER_STATUS['DELIVERED'];
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | Order Status</title>
	<?php include 'front_include/css.php'; ?>
</head>

<body>
	<?php include 'front_include/header.php'; ?>



	<!--  header section start -->
	<section class="product-header-images">
		<div class="product-hero" style="background-image:url('img/product-hero.jpg')">
			<div class="overlay"></div>
			<div class="container">
				<h3>Order Status </h3>
				<p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
				<img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt="">
			</div>
		</div>
		<div class="pl-breadcrumb">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="#">Home /</a></li>
					<li>Order Tracking</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- header section end -->


	<!-- Order main section start  -->

	<section class="order-section-main">
		<div class="container">
			<div class="row">
				<div class="offset-lg-1 col-lg-10">
					<div class="order-section-header">
						<img src="<?php echo SITEURL; ?>img/order-tracking.svg" alt="">
						<figcaption>
							<h4>Tracking Details</h4>
							<h6>Order Number</h6>
							<h2>#<?php echo $order_num; ?></h2>
						</figcaption>
					</div>
				</div>
			</div>

			<div class="hh-grayBox pt45 pb20">
				<div class="row">
					<div class="order-tracking completed">
						<span class="is-complete"></span>
						<p>Order<br><span><?php echo $dateOrdered; ?></span></p>
					</div>
					<div class="order-tracking completed">
						<span class="is-complete"></span>
						<p>Order Confirmed<br><span><?php echo $dateOrdered; ?></span></p>
					</div>
					<div class="order-tracking <?php echo !empty($dateShipped) ?  "completed" : "" ?>">
						<span class="is-complete"></span>
						<p>Shipped<br><span><?php echo !empty($dateShipped) ? $dateShipped : "" ?></span></p>
					</div>
					<div class="order-tracking <?php echo $currentOrderStatus['text'] == 'Delivered' ? "completed" : "" ?>">
						<span class="is-complete"></span>
						<p>Delivered<br><span></span></p>
					</div>



				</div>
				<div class="row justify-content-center mt-3">
					<div class="col-10">
						<div class="alert alert-info" role="alert">
							<h6 class="alert-heading">Order Status:</h6>
							<hr>
							<p><?php echo $currentOrderStatus['text'] ?></p>
						</div>

					</div>
				</div>

			</div>


		</div>
		</div>
	</section>

	<!-- Order main section end  -->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>

</body>

</html>