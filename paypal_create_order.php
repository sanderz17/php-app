<?php
include('connect.php');

if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']))
  $user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
else {
  $user_id = 0;
}
$cart_det_id   = $_SESSION[SESS_PRE . '_SESS_CART_ID'];

$cart_row = $db->getData('cart', '*', 'id=' . $cart_det_id . ' AND isDelete = 0');
$cart_data = mysqli_fetch_assoc($cart_row);

$qty = $db->getValue('cart_detail', 'SUM(qty)', 'id=' . $cart_det_id . ' AND isDelete = 0');
$cart_details = $db->getCartDetails($cart_det_id);
cb_logger('cart_details=' . json_encode($cart_details));
$discount = 0;
$shipping_discount = 0;
$shippingFee = 0;
$discount_charge = 0;
$grandTotal = $cart_data['grand_total'];
$subTotal = $cart_data['sub_total'];

// discount
if ($cart_data["coupon_code"]) {
  if ($cart_data['discount_type'] == 'full') {
    $discount_charge = 0.01;
  }
  $discount = $db->num(floatval($subTotal) - $discount_charge);
  $shipping_discount = number_format($cart_data['shipping'], 2);
}


$shippingFee = number_format($cart_data['shipping'], 2);
try {
  $secretsPath = './config/secrets.json';
  $jsonString = file_get_contents($secretsPath);
  $jsonData = json_decode($jsonString, true);
  $token = $jsonData['paypal_access_token'];
} catch (\Throwable $th) {
  cb_logger(`Error getting Token`);
  throw $th;
}

$item_total = $subTotal;
try {
  foreach ($cart_details["items"] as $item) {
    $items[] = array(
      "name" => $item["name"],
      "quantity" => $item["quantity"],
      "unit_amount" => [
        "currency_code" => "USD",
        "value" =>  $item["unitPrice"]
      ]
    );
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curl = curl_init();
    $postData = [
      "intent" => "CAPTURE",
      "purchase_units" => [
        [
          "amount" =>
          [
            "currency_code" => "USD",
            "value" => $grandTotal,
            "breakdown" => [
              "item_total" => [
                "currency_code" => "USD",
                "value" => $item_total
              ],
              "discount" => [
                "currency_code" => "USD",
                "value" => $discount
              ],
              "shipping" => [
                "currency_code" => "USD",
                "value" => $shippingFee
              ],
              "shipping_discount" => [
                "currency_code" => "USD",
                "value" => $shipping_discount
              ]
            ]
          ],
          "items" => $items,
          "invoice_id" => $cart_details["orderNumber"]
        ]
      ]
    ];
    $postData = json_encode($postData);
    cb_logger('paypal_create_order_request=' . $postData);
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api-m.paypal.com/v2/checkout/orders',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POSTFIELDS => $postData,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer $token",
        'Content-Type: application/json'
      ),
    ));


    $response = curl_exec($curl);

    curl_close($curl);
    cb_logger('paypal_create_order_response=' . $response);
    echo $response;
  } else {
    echo "Bad request!";
  }
} catch (\Throwable $th) {
  cb_logger($th);
}
