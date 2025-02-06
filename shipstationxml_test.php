<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://ssapi.shipstation.com/orders/createorder",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"orderNumber\": \"TEST-ORDER-API-DOCS\",\n  \"orderKey\": \"0f6bec18-3e89-4881-83aa-f392d84f4c74\",\n  \"orderDate\": \"2015-06-29T08:46:27.0000000\",\n  \"paymentDate\": \"2015-06-29T08:46:27.0000000\",\n  \"shipByDate\": \"2015-07-05T00:00:00.0000000\",\n  \"orderStatus\": \"awaiting_shipment\",\n  \"customerId\": 37701499,\n  \"customerUsername\": \"headhoncho@whitehouse.gov\",\n  \"customerEmail\": \"headhoncho@whitehouse.gov\",\n  \"billTo\": {\n    \"name\": \"The President\",\n    \"company\": null,\n    \"street1\": null,\n    \"street2\": null,\n    \"street3\": null,\n    \"city\": null,\n    \"state\": null,\n    \"postalCode\": null,\n    \"country\": null,\n    \"phone\": null,\n    \"residential\": null\n  },\n  \"shipTo\": {\n    \"name\": \"The President\",\n    \"company\": \"US Govt\",\n    \"street1\": \"1600 Pennsylvania Ave\",\n    \"street2\": \"Oval Office\",\n    \"street3\": null,\n    \"city\": \"Washington\",\n    \"state\": \"DC\",\n    \"postalCode\": \"20500\",\n    \"country\": \"US\",\n    \"phone\": \"555-555-5555\",\n    \"residential\": true\n  },\n  \"items\": [\n    {\n      \"lineItemKey\": \"vd08-MSLbtx\",\n      \"sku\": \"ABC123\",\n      \"name\": \"Test item #1\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 24,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 2,\n      \"unitPrice\": 99.99,\n      \"taxAmount\": 2.5,\n      \"shippingAmount\": 5,\n      \"warehouseLocation\": \"Aisle 1, Bin 7\",\n      \"options\": [\n        {\n          \"name\": \"Size\",\n          \"value\": \"Large\"\n        }\n      ],\n      \"productId\": 123456,\n      \"fulfillmentSku\": null,\n      \"adjustment\": false,\n      \"upc\": \"32-65-98\"\n    },\n    {\n      \"lineItemKey\": null,\n      \"sku\": \"DISCOUNT CODE\",\n      \"name\": \"10% OFF\",\n      \"imageUrl\": null,\n      \"weight\": {\n        \"value\": 0,\n        \"units\": \"ounces\"\n      },\n      \"quantity\": 1,\n      \"unitPrice\": -20.55,\n      \"taxAmount\": null,\n      \"shippingAmount\": null,\n      \"warehouseLocation\": null,\n      \"options\": [],\n      \"productId\": 123456,\n      \"fulfillmentSku\": \"SKU-Discount\",\n      \"adjustment\": true,\n      \"upc\": null\n    }\n  ],\n  \"amountPaid\": 218.73,\n  \"taxAmount\": 5,\n  \"shippingAmount\": 10,\n  \"customerNotes\": \"Please ship as soon as possible!\",\n  \"internalNotes\": \"Customer called and would like to upgrade shipping\",\n  \"gift\": true,\n  \"giftMessage\": \"Thank you!\",\n  \"paymentMethod\": \"Credit Card\",\n  \"requestedShippingService\": \"Priority Mail\",\n  \"carrierCode\": \"fedex\",\n  \"serviceCode\": \"fedex_2day\",\n  \"packageCode\": \"package\",\n  \"confirmation\": \"delivery\",\n  \"shipDate\": \"2015-07-02\",\n  \"weight\": {\n    \"value\": 25,\n    \"units\": \"ounces\"\n  },\n  \"dimensions\": {\n    \"units\": \"inches\",\n    \"length\": 7,\n    \"width\": 5,\n    \"height\": 6\n  },\n  \"insuranceOptions\": {\n    \"provider\": \"carrier\",\n    \"insureShipment\": true,\n    \"insuredValue\": 200\n  },\n  \"internationalOptions\": {\n    \"contents\": null,\n    \"customsItems\": null\n  },\n  \"advancedOptions\": {\n    \"warehouseId\": 98765,\n    \"nonMachinable\": false,\n    \"saturdayDelivery\": false,\n    \"containsAlcohol\": false,\n    \"mergedOrSplit\": false,\n    \"mergedIds\": [],\n    \"parentId\": null,\n    \"storeId\": 12345,\n    \"customField1\": \"Custom data that you can add to an order. See Custom Field #2 & #3 for more info!\",\n    \"customField2\": \"Per UI settings, this information can appear on some carrier's shipping labels. See link below\",\n    \"customField3\": \"https://help.shipstation.com/hc/en-us/articles/206639957\",\n    \"source\": \"Webstore\",\n    \"billToParty\": null,\n    \"billToAccount\": null,\n    \"billToPostalCode\": null,\n    \"billToCountryCode\": null\n  },\n  \"tagIds\": [\n    53974\n  ]\n}",
  CURLOPT_HTTPHEADER => array(
    "Host: ssapi.shipstation.com",
    "Authorization: __YOUR_AUTH_HERE__",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
