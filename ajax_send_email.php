<?php
include_once("connect.php");
include("include/notification_v2.class.php");
try {
	$cart_id = $_REQUEST['cart_id'] ?? "";
	$template = $_REQUEST['template'] ?? "";
	//$send_To = explode(',', $_REQUEST['sendTo']) ?? "";
	$send_To = $_REQUEST['sendTo'] ?? "";
	$subject = $_REQUEST['subject'] ?? "";
	$title = $_REQUEST['title'] ?? "";
	$nt = new Notification();
	$response = [];
	if ($nt->sendMail($cart_id, $send_To, $subject, (int)$template, $title)) {
		$order_status = $template;
		$db->update('cart', ['order_status' => $template], "id=$cart_id");
		$response = [
			'ok' => true,
			'message' => 'success',
			'request' => $_REQUEST
		];
	} else {
		$response = [
			'ok' => false,
			'message' => 'failed',
			'request' => $_REQUEST
		];
	}
	echo json_encode($response);
} catch (\Throwable $th) {
	cb_logger($th);
	die($th);
}
