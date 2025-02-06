<?php

$curl = curl_init();

curl_setopt_array($curl, [
	// CURLOPT_URL => "https://api-mock.dhl.com/mydhlapi/landed-cost",
	CURLOPT_URL => "https://express.api.dhl.com/mydhlapi/test/landed-cost",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => '{
  "customerDetails": {
    "shipperDetails": {
      "postalCode": "14800",
      "cityName": "Prague",
      "countryCode": "CZ",
      "provinceCode": "CZ",
      "addressLine1": "addres1",
      "addressLine2": "addres2",
      "addressLine3": "addres3",
      "countyName": "Central Bohemia"
    },
    "receiverDetails": {
      "postalCode": "14800",
      "cityName": "Prague",
      "countryCode": "CZ",
      "provinceCode": "CZ",
      "addressLine1": "addres1",
      "addressLine2": "addres2",
      "addressLine3": "addres3",
      "countyName": "Central Bohemia"
    }
  },
  "accounts": [
    {
      "typeCode": "shipper",
      "number": "969295000"
    }
  ],
  "productCode": "P",
  "localProductCode": "P",
  "unitOfMeasurement": "metric",
  "currencyCode": "CZK",
  "isCustomsDeclarable": true,
  "isDTPRequested": true,
  "isInsuranceRequested": false,
  "getCostBreakdown": true,
  "charges": [
    {
      "typeCode": "insurance",
      "amount": 1250,
      "currencyCode": "CZK"
    }
  ],
  "shipmentPurpose": "personal",
  "transportationMode": "air",
  "merchantSelectedCarrierName": "DHL",
  "packages": [
    {
      "typeCode": "3BX",
      "weight": 10.5,
      "dimensions": {
        "length": 25,
        "width": 35,
        "height": 15
      }
    }
  ],
  "items": [
    {
      "number": 1,
      "name": "KNITWEAR COTTON",
      "description": "KNITWEAR 100% COTTON REDUCTION PRICE FALL COLLECTION",
      "manufacturerCountry": "CN",
      "partNumber": "12345555",
      "quantity": 2,
      "quantityType": "prt",
      "unitPrice": 120,
      "unitPriceCurrencyCode": "EUR",
      "customsValue": 120,
      "customsValueCurrencyCode": "EUR",
      "commodityCode": "6110129090",
      "weight": 5,
      "weightUnitOfMeasurement": "metric",
      "category": "204",
      "brand": "SHOE 1",
      "goodsCharacteristics": [
        {
          "typeCode": "IMPORTER",
          "value": "Registered"
        }
      ],
      "additionalQuantityDefinitions": [
        {
          "typeCode": "DPR",
          "amount": 2
        }
      ],
      "estimatedTariffRateType": "default_rate"
    }
  ],
  "getTariffFormula": true,
  "getQuotationID": true
}',
	CURLOPT_HTTPHEADER => [
		"Authorization: Basic YXBSOWlMOHpCNmNKN3A6WCQ1d0okNm1LITVpTiEweA==",
		// "Authorization: Basic ZGVtby1rZXk6ZGVtby1zZWNyZXQ=",
		"Message-Reference: d0e7832e-5c98-11ea-bc55-0242ac13",
		"Message-Reference-Date: Wed, 21 Oct 2015 07:28:00 GMT",
		"Plugin-Name: ",
		"Plugin-Version: ",
		"Shipping-System-Platform-Name: ",
		"Shipping-System-Platform-Version: ",
		"Webstore-Platform-Name: ",
		"Webstore-Platform-Version: ",
		"content-type: application/json"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	// echo $response;
	echo "<pre>";
	print_r($response);
	die;
}