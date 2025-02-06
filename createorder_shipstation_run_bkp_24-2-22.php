<?php

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
  CURLOPT_POSTFIELDS =>'{
  "orderNumber": "TEST23222",
  "orderKey": "2333",
  "orderDate": "2015-06-29T08:46:27.0000000",
  "paymentDate": "2015-06-29T08:46:27.0000000",
  "shipByDate": "2015-07-05T00:00:00.0000000",
  "orderStatus": "awaiting_shipment",
  "customerId": 1,
  "customerUsername": "test@gmail.com",
  "customerEmail": "test@gmail.com",
  "billTo": {
    "name": "The President",
    "company": null,
    "street1": null,
    "street2": null,
    "street3": null,
    "city": null,
    "state": null,
    "postalCode": null,
    "country": null,
    "phone": null,
    "residential": null
  },
  "shipTo": {
    "name": "The President",
    "company": "US Govt",
    "street1": "1600 Pennsylvania Ave",
    "street2": "Oval Office",
    "street3": null,
    "city": "Washington",
    "state": "DC",
    "postalCode": "20500",
    "country": "US",
    "phone": "555-555-5555",
    "residential": true
  },
  "items": [
    {
      "lineItemKey": "vd08-MSLbtx",
      "sku": "ABC123",
      "name": "Test item #1",
      "imageUrl": null,
      "weight": {
        "value": 24,
        "units": "ounces"
      },
      "quantity": 2,
      "unitPrice": 99.99,
      "taxAmount": 2.5,
      "shippingAmount": 5,
      "warehouseLocation": "Aisle 1, Bin 7",
      "options": [
        {
          "name": "Size",
          "value": "Large"
        }
      ],
      "productId": 123456,
      "fulfillmentSku": null,
      "adjustment": false,
      "upc": "32-65-98"
    },
    {
      "lineItemKey": null,
      "sku": "DISCOUNT CODE",
      "name": "10% OFF",
      "imageUrl": null,
      "weight": {
        "value": 0,
        "units": "ounces"
      },
      "quantity": 1,
      "unitPrice": -20.55,
      "taxAmount": null,
      "shippingAmount": null,
      "warehouseLocation": null,
      "options": [],
      "productId": 123456,
      "fulfillmentSku": "SKU-Discount",
      "adjustment": true,
      "upc": null
    }
  ],
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic N2M0NGYzY2E1OTg5NDcyYmJiM2Y4YWYwYWEyMTg5MjE6OTZhNzllZDM2ODZmNDBhMjhkM2I5YWMxMDQxZTM1M2M=',
    'Content-Type: application/json',
    'Host: ssapi.shipstation.com',
    'Accept-Charset: utf-8'
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
// echo $response;


if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
  // echo "<pre>";
  // print_r($response);
}