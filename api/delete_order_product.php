<?php
include_once('../connect.php');
$response = [];
if (isset($_POST)) {
  $cd_table = 'cart_detail';
  $id = $_POST['cart_detail_id'];
  $cart_id = $_POST['cart_id'];
  if ($db->delete($cd_table, "id=$id")) {
    $order_products_all_where = "cart_id=$cart_id AND isDelete=0";
    $order_products_all = $db->getData($cd_table, '*', $order_products_all_where);
    $cart_sub_total = 0;
    if (!empty($order_products_all)) {
      while ($cart_detail_result = mysqli_fetch_assoc($order_products_all)) {
        $cart_sub_total += $cart_detail_result['sub_total'];
      }
      if ($cart_id) {
        $db->update('cart', ['sub_total' => $cart_sub_total], "id=$cart_id");
      }
    } else {
      $db->update('cart', ['sub_total' => $cart_sub_total], "id=$cart_id");
    }
    $response = [
      'ok' => true,
      'post' => $_POST
    ];
  } else {
    $response = [
      'ok' => false,
    ];
  };
}
echo json_encode($response);
