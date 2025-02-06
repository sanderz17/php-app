<?php
include('connect.php');
include('include/notification.class.php');

try {

  //$cart_id = '4703'; 
  $cart_shipping_billing_details = $db->getCartShippingDetails($cart_id) ?? '';
  $customer_email = $cart_shipping_billing_details['shipping_email'] ?? $cart_shipping_billing_details['billing_email'];
  // send notification
  $nt = new Notification($db);
  if($nt->sendMailWithTemplates($cart_id, $customer_email, 'New Order Confirmed', 'new_confirmation_order_template')){
    echo "Email sent";
  };
} catch (\Throwable $th) {
  cb_logger($th);
}
