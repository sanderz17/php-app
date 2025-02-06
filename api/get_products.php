<?php
include_once('../connect.php');
$where = 'isDelete=0 AND isActive=1';
$product = $db->getdata('product', "*", $where);
$data = [];

if (@mysqli_num_rows($product) > 0) {
  while ($product_data = mysqli_fetch_assoc($product)) {
    $data[] = array(
      'id' => $product_data['id'],
      'name' => $product_data['name'],
      'price' => $product_data['price'],
      'image' => $product_data['image'],
      'sku' => $product_data['code']
    );
  }
}
$response = [
  'ok' => true,
  'data' => $data
];

echo json_encode($response);
