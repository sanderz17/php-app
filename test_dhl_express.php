<?php

$accountNumber = "849767524";
$originCountryCode = "US";
$originCityName = "green ville";
$destinationCountryCode = "US";
$destinationCityName = "green ville";
$weight = 5;
$length = 15;
$width = 10;
$height = 10;
$plannedShippingDate = date('Y-m-d');
$isCustomsDeclarable = false;
$unitOfMeasurement = "metric";

$curl = curl_init();
set_time_limit(0);
/* curl_setopt_array($curl, [
	CURLOPT_URL => "https://express.api.dhl.com/mydhlapi/test/rates?accountNumber=$accountNumber&originCountryCode=$originCountryCode&originCityName=$originCityName&destinationCountryCode=$destinationCountryCode&destinationCityName=$destinationCityName&weight=$weight&length=$length&width=$width&height=$height&plannedShippingDate=$plannedShippingDate&isCustomsDeclarable=$isCustomsDeclarable&unitOfMeasurement=$unitOfMeasurement",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		// "Authorization: Basic YXBSOWlMOHpCNmNKN3A6WCQ1d0okNm1LITVpTiEweA==",
		"Authorization: Basic Q2xlYXJnZWw6TWF4aG91c2UxMg==",
		// "Authorization: Basic ZGVtby1rZXk6ZGVtby1zZWNyZXQ=",
		"Message-Reference: d0e7832e-5c98-11ea-bc55-0242ac13",
		"Message-Reference-Date: Wed, 21 Oct 2015 07:28:00 GMT",
		"Plugin-Name: ",
		"Plugin-Version: ",
		"Shipping-System-Platform-Name: ",
		"Shipping-System-Platform-Version: ",
		"Webstore-Platform-Name: ",
		"Webstore-Platform-Version: "
	],
	CURLOPT_SSL_VERIFYPEER => false
]); */

curl_setopt_array($curl, [
	CURLOPT_URL => "https://express.api.dhl.com/mydhlapi/test/rates?accountNumber=$accountNumber&originCountryCode=CZ&originPostalCode=14800&originCityName=123213&destinationCountryCode=CZ&destinationPostalCode=14800&destinationCityName=Prague&weight=5&length=15&width=10&height=5&plannedShippingDate=$plannedShippingDate&isCustomsDeclarable=false&unitOfMeasurement=metric",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"Authorization: Basic YXBSOWlMOHpCNmNKN3A6WCQ1d0okNm1LITVpTiEweA==",
		//"Authorization: Basic Q2xlYXJnZWw6TWF4aG91c2UxMg==",
		// "Authorization: Basic ZGVtby1rZXk6ZGVtby1zZWNyZXQ=",
		//"Authorization: Basic ZGVtby1rZXk6ZGVtby1zZWNyZXQ=",
		"Message-Reference: d0e7832e-5c98-11ea-bc55-0242ac13",
		"Message-Reference-Date: Wed, 21 Oct 2015 07:28:00 GMT",
		"Plugin-Name: ",
		"Plugin-Version: ",
		"Shipping-System-Platform-Name: ",
		"Shipping-System-Platform-Version: ",
		"Webstore-Platform-Name: ",
		"Webstore-Platform-Version: "
	],
	CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
	//$result = json_decode($response, true);
	//echo "<pre>";
	//print_r($result);
	//die;
}
