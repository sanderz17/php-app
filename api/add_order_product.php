<?php
include_once('../connect.php');
$response = [];
if (isset($_POST)) {
  $cd_table = 'cart_detail';
  $post_data = json_decode(file_get_contents('php://input'), true);
  $cart_id = $post_data['cart_id'];
  $product_id = $post_data['product_id'];
  $price = (float)$db->num($post_data['price']);
  $qty = (float)$db->num($post_data['qty']);
  $subtotal = $qty * $price;
  $rows = array(
    'cart_id' => $cart_id,
    'product_id' => $product_id,
    'price' => $price,
    'qty' => $qty,
    'sub_total' => $subtotal
  );
  $order_products_one_where = "cart_id=$cart_id AND product_id=$product_id AND isDelete=0";
  $order_products_query = $db->getData($cd_table, '*', $order_products_one_where);
  $cart_sub_total = 0;
  if (!empty($order_products_query)) {
    while ($cart_detail_result = mysqli_fetch_assoc($order_products_query)) {
      $cd_table_row = array(
        'cart_id' => $cart_detail_result['cart_id'],
        'product_id' => $cart_detail_result['product_id'],
        'price' => $cart_detail_result['price'],
        'qty' => $cart_detail_result['qty'] + $qty,
        'sub_total' => $cart_detail_result['sub_total'] + $subtotal
      );
      $cart_detail_id =$cart_detail_result['id'];
      $db->update($cd_table, $cd_table_row, "id=$cart_detail_id");
    }
  } else {
    // insert payment method
    $db->insert($cd_table, $rows, 0);
  }


  $order_products_all_where = "cart_id=$cart_id AND isDelete=0";
  $order_products_all = $db->getData($cd_table, '*', $order_products_all_where);
  $cart_sub_total = 0;
  if (!empty($order_products_all)) {
    while ($cart_detail_result = mysqli_fetch_assoc($order_products_all)) {
      $cart_sub_total += $cart_detail_result['sub_total'];
    }
  }

  $db->update('cart', ['sub_total' => $cart_sub_total], "id=$cart_id");
  /*   $where = 'isDelete=0 AND isActive=1';
  $product = $db->getdata('product', "*", $where);

  if (@mysqli_num_rows($product) > 0) {
    while ($product_data = mysqli_fetch_assoc($product)) {
      $data[] = array(
        'id' => $product_data['id'],
        'name' => $product_data['name'],
        'price' => $product_data['price'],
        'image' => $product_data['image'],
      );
    }
  } */
  $response = [
    'ok' => true
  ];
}
echo json_encode($response);
