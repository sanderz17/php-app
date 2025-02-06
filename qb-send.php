<?php
include('./connect.php');


try {
  $cart_id = "2906";
  $db->getCartDetailsFull($cart_id);
  //$db->envDev();
  //$db->qbCreateCustomer();
  $db->sendToQB();
  //$db->qbQueryCustomerId();
  echo "success";
} catch (\Throwable $th) {
  echo $th;
}
