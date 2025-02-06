<?php
include_once('../connect.php');
$response = [];
if (isset($_POST)) {
  $cd_table = 'cart_detail';
  $id = $_POST['id'];
  $qty = $_POST['quantity'];
  $subtotal = $_POST['total'];
  $cart_id = $_POST['cart_id'];
  $cd_table_row = array(
    'qty' => $qty,
    'sub_total' => $subtotal
  );
  if($db->update($cd_table, $cd_table_row, "id=$id")){
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
  };
  $post_data = $_POST;
  $response = [
    'ok' => true
  ];
}
echo json_encode($response);
