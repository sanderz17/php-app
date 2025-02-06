<?php

$data=array();
// $data['orderId']= '22022222';
$data['orderNumber']= '22022222';
$data['orderKey'] ='2222';
$data['orderDate'] ='2021-06-29T08:46:27.0000000';  
$data['paymentDate'] = '2021-06-29T08:46:27.0000000';
$data['createDate'] = '2021-06-29T08:46:27.0000000'; 
// $data['modifyDate'] = '2021-06-29T08:46:27.0000000';
$data['shipByDate'] = '2021-06-29T08:46:27.0000000';
$data['orderStatus'] = 'awaiting_shipment';
$data['customerId'] = 1;
$data['customerUsername'] = 'test22222@gmail.com';
$data['customerEmail'] = 'test22222@gmail.com';
$data['billTo']= array();
$data['billTo']['name']= 'The President';
$data['billTo']['company'] = null;
$data['billTo']['street1'] = null;
$data['billTo']['street2'] = null;
$data['billTo']['street3'] = null;
$data['billTo']['city'] = null;
$data['billTo']['state'] = null;
$data['billTo']['postalCode'] = null;
$data['billTo']['country'] = null;
$data['billTo']['phone'] = null;
$data['billTo']['residential'] = null;
// $data['billTo']['addressVerified'] ='';
$data['shipTo']= array();
$data['shipTo']['name']= 'test The President';
$data['shipTo']['company'] = 'US Govt';
$data['shipTo']['street1'] = '1600 PENNSYLVANIA AVE NW';
$data['shipTo']['street2'] = 'Oval Office';
$data['shipTo']['street3'] = null;
$data['shipTo']['city'] = 'Washington';
$data['shipTo']['state'] = 'DC';
$data['shipTo']['postalCode'] = '20500-0005';
$data['shipTo']['country'] = 'US';
$data['shipTo']['phone'] = '512-555-5555';
$data['shipTo']['residential'] = true;
// $data['shipTo']['addressVerified'] ='';
$data['items']= array();
$data['items']['lineItemKey'] = 'testaaaa1111';
$data['items']['sku'] = 'testaaaa1111';
$data['items']['name'] = 'Testitem1';
$data['items']['imageUrl'] = null;
$data['items']['weight'] = array();
$data['items']['weight']['value'] = 24;
$data['items']['weight']['units'] = 'ounces';
$data['items']['quantity'] = 3;
$data['items']['unitPrice'] = 99.99;
$data['items']['taxAmount'] = 2.5;
$data['items']['shippingAmount'] = 5;
$data['items']['warehouseLocation'] = 'Aisle 1, Bin 7';
$data['items']['options'] = array();
$data['items']['options']['name'] = 'Size';
$data['items']['options']['value'] = 'Large';
$data['items']['productId'] = 1111;
$data['items']['fulfillmentSku'] = null;
$data['items']['adjustment'] = false;
$data['items']['upc'] = '32-65-98';

// $data['items']['item']= array();
// $data['items']['item']['SKU']= '22';
// $data['items']['item']['Name']= '10% Ballistics Gelatin Joe Fit Torso & Mold';
// $data['orderTotal']='423.98';
// $data['amountPaid'] ='423.98';

// echo json_encode($data); die;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://ssapi.shipstation.com/orders/createorder',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//   "orderNumber": "TEST23222",
//   "orderKey": "2333",
//   "orderDate": "2015-06-29T08:46:27.0000000",
//   "paymentDate": "2015-06-29T08:46:27.0000000",
//   "shipByDate": "2015-07-05T00:00:00.0000000",
//   "orderStatus": "awaiting_shipment",
//   "customerId": 1,
//   "customerUsername": "test@gmail.com",
//   "customerEmail": "test@gmail.com",
//   "billTo": {
//     "name": "The President",
//     "company": null,
//     "street1": null,
//     "street2": null,
//     "street3": null,
//     "city": null,
//     "state": null,
//     "postalCode": null,
//     "country": null,
//     "phone": null,
//     "residential": null
//   },
//   "shipTo": {
//     "name": "The President",
//     "company": "US Govt",
//     "street1": "1600 Pennsylvania Ave",
//     "street2": "Oval Office",
//     "street3": null,
//     "city": "Washington",
//     "state": "DC",
//     "postalCode": "20500",
//     "country": "US",
//     "phone": "555-555-5555",
//     "residential": true
//   },
//   "items": [
//     {
//       "lineItemKey": "vd08-MSLbtx",
//       "sku": "ABC123",
//       "name": "Test item #1",
//       "imageUrl": null,
//       "weight": {
//         "value": 24,
//         "units": "ounces"
//       },
//       "quantity": 2,
//       "unitPrice": 99.99,
//       "taxAmount": 2.5,
//       "shippingAmount": 5,
//       "warehouseLocation": "Aisle 1, Bin 7",
//       "options": [
//         {
//           "name": "Size",
//           "value": "Large"
//         }
//       ],
//       "productId": 123456,
//       "fulfillmentSku": null,
//       "adjustment": false,
//       "upc": "32-65-98"
//     },
//     {
//       "lineItemKey": null,
//       "sku": "DISCOUNT CODE",
//       "name": "10% OFF",
//       "imageUrl": null,
//       "weight": {
//         "value": 0,
//         "units": "ounces"
//       },
//       "quantity": 1,
//       "unitPrice": -20.55,
//       "taxAmount": null,
//       "shippingAmount": null,
//       "warehouseLocation": null,
//       "options": [],
//       "productId": 123456,
//       "fulfillmentSku": "SKU-Discount",
//       "adjustment": true,
//       "upc": null
//     }
//   ],
// }',
  CURLOPT_POSTFIELDS, json_encode($data),
  CURLOPT_HTTPHEADER => array(
    // 'Authorization: Basic N2M0NGYzY2E1OTg5NDcyYmJiM2Y4YWYwYWEyMTg5MjE6OTZhNzllZDM2ODZmNDBhMjhkM2I5YWMxMDQxZTM1M2M=',
    'Authorization: basic '.base64_encode('c0019b6535cd4551a2e7d5127d51cc6c:6a43e5b8901b49f9bb3c33760288c37c'),
    'Content-Type: application/json',
    'Host: ssapi.shipstation.com',
    'Accept-Charset: utf-8'
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
echo $response;


if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  // echo "<pre>";
  // print_r($response);
}