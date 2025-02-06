<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once('connect.php');
  include_once "include/notification.class.php";
  cb_logger("paypal_capture_order");


  if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']))
    $user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
  else {
    $user_id = 0;
  }
  $cart_det_id   = $_SESSION[SESS_PRE . '_SESS_CART_ID'];

  $cart_row = $db->getData('cart', '*', 'id=' . $cart_det_id . ' AND isDelete = 0');

  $cart_data = mysqli_fetch_assoc($cart_row);

  $qty = $db->getValue('cart_detail', 'SUM(qty)', 'id=' . $cart_det_id . ' AND isDelete = 0');
  try {
    $secretsPath = './config/secrets.json';
    $jsonString = file_get_contents($secretsPath);
    $jsonData = json_decode($jsonString, true);
    $token = $jsonData['paypal_access_token'];
  } catch (\Throwable $th) {
    cb_logger(`Error getting Token`);
    throw $th;
  }
  $jsonData = file_get_contents('php://input');
  $data = json_decode($jsonData, true);
  cb_logger('paypal_capture_request=' . $data);
  cb_logger($data['paypal_order_id']);
  $order_id = $data['paypal_order_id'];
  try {
    $curl = curl_init();
    $url = "https://api-m.paypal.com/v2/checkout/orders/$order_id/capture";
    cb_logger('url' . $url);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $token",
        'Content-Type: application/json'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $paypal_capture_response = json_decode($response, true);
    cb_logger('paypal_capture_response=' . $paypal_capture_response["status"]);
    if ($paypal_capture_response["status"] == "COMPLETED") {
      $payment_method = "PAYPAL";
      $rows = [
        'payment_method' => $payment_method,
        'order_status' => 2,
        "order_date" => date('Y-m-d H:i:s')
      ];
      $where  = "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'";
      // update payment method
      $db->update("cart", $rows, $where);
      $db->getCartDetailsFull($cart_det_id);
      $db->shipPaidCart();
	  $db->sendToQB();
      $cart_shipping_billing_details = $db->getCartShippingDetails($cart_det_id) ?? '';
      $customer_email = $cart_shipping_billing_details['shipping_email'] ?? $cart_shipping_billing_details['billing_email'];
      // send notification
      $nt = new Notification($db);
      $nt->sendMailWithTemplates($cart_det_id, $customer_email, 'New Order Confirmed', 'new_confirmation_order_template');
      // remove cart session 
      unset($_SESSION[SESS_PRE . '_SESS_CART_ID']);
    }
    echo $response;
  } catch (\Throwable $th) {
    cb_logger($th);
  }
} else {
  echo "Bad Request!";
  cb_logger('Bad Request');
}
