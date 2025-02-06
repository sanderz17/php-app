<?php
include('connect.php');
include('include/notification.class.php');

try {

  $cart_id = '531';
  $db->getCartDetails($cart_id);
  $db->shipPaidCart();
} catch (\Throwable $th) {
  cb_logger($th);
}
