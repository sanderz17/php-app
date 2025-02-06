<?php

    // $apiKey = "7c44f3ca5989472bbb3f8af0aa218921";
    // $apiSecret = "96a79ed3686f40a28d3b9ac1041e353c";
    // $auth = base64_encode($apiKey . ":" . $apiSecret);

    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL, "https://ssapi.shipstation.com/orders");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    // curl_setopt($ch, CURLOPT_HEADER, FALSE);
    // curl_setopt($ch, CURLOPT_USERPWD, $apiKey . ":" . $apiSecret);

    // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    // "Authorization: Basic " . $auth,
    // "Content-Type: application/json",
    // ));

    // $response = curl_exec($ch);
    // curl_close($ch);

    // // var_dump($response);

    // echo "<pre>";
    // print_r($response);

    // // echo json_decode($response);


$url = 'https://ssapi.shipstation.com/orders'; 

$curl = curl_init();
curl_setopt_array(
    $curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
      'Host: ssapi.shipstation.com',
      'Authorization: basic '.base64_encode('c0019b6535cd4551a2e7d5127d51cc6c:6a43e5b8901b49f9bb3c33760288c37c'),
    ),
  )
);
$response = curl_exec($curl);
curl_close($curl);
// print_r($response);

// print_r(json_decode($response));

  $response=json_decode($response);

if($response){ 

  include("connect.php");
  $ctable = "cart";
  // echo "data get";
  foreach($response->orders as $r){
    // print_r($r->orderKey);

    // echo $r->orderKey;
    // die;

    // $ctable_r = $db->getJoinData($ctable, 'user', 'user.id='.$ctable.'.customer_id', $ctable.'.*, user.first_name,user.last_name', "cart.isDelete=0 AND cart.id='".$r->orderKey."' AND cart.order_no='".$r->orderNumber."' ", $ctable.".id ASC ",0);
    $ctable_r = $db->getJoinData($ctable, 'user', 'user.id='.$ctable.'.customer_id', $ctable.'.*, user.first_name,user.last_name', "cart.isDelete=0 AND cart.id=18 AND cart.order_no='".$r->orderNumber."'  ", $ctable.".id ASC ",0);

    // echo $ctable_r;die;

    if(@mysqli_num_rows($ctable_r)>0){
      foreach ($ctable_r as $key => $ctable_d) {
        echo "<pre>";
        print_r($ctable_d);

        if($r->orderStatus == "cancelled") {
          $order_status_arr = array(
            "order_status" => 0,
          );
          $db->update("cart",$order_status_arr,"id='".$r->orderKey."' ",0);
        }

        if($r->orderStatus == "awaiting_shipment") {
          $order_status_arr = array(
            "order_status" => 1,
          );
          $db->update("cart",$order_status_arr,"id='".$r->orderKey."' ",0);
        }

        if($r->orderStatus == "on_hold") {
          $order_status_arr = array(
            "order_status" => 1,
          );
          $db->update("cart",$order_status_arr,"id='".$r->orderKey."' ",0);
        }

        if($r->orderStatus == "paid") {
          $order_status_arr = array(
            "order_status" => 2,
          );
          $db->update("cart",$order_status_arr,"id='".$r->orderKey."' ",0);
        }

        if($r->orderStatus == "shipped") {
          $order_status_arr = array(
            "order_status" => 3,
          );
          $db->update("cart",$order_status_arr,"id='".$r->orderKey."' ",0);
        }

        // echo "<pre>";
        // print_r($r->shipTo->postalCode);

        // $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND cart_id=18 ","id DESC");
        // print_r(mysqli_fetch_assoc($shipping_d));

        // echo $r->shipTo->name;

        $shipping_name = explode(" ", $r->shipTo->name);

        $shipping_d_arr = array(
            "shipping_first_name" => $shipping_name[0],
            "shipping_last_name" => $shipping_name[1],
            "ship_company" => $r->shipTo->company,
            "shipping_address" => $r->shipTo->street1,
            "shipping_address2" => $r->shipTo->street2,
            "shipping_address3" => $r->shipTo->street3,
            "shipping_city" => $r->shipTo->city,
            "shipping_state" => $db->getValue("states","id","states_code='".$r->shipTo->state."' "),
            "shipping_zipcode" => $r->shipTo->postalCode,
            "shipping_country" => $db->getValue("country","id","country_code='".$r->shipTo->country."' "),
            "shipping_phone" => $r->shipTo->phone,
          );

        $db->update("billing_shipping",$shipping_d_arr,"cart_id='".$r->orderKey."' ",0);


      }
    }

  }
}
else{
  echo "not recive";
}


?>

