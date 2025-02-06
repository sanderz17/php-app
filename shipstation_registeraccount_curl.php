<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://ssapi.shipstation.com/accounts/registeraccount",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\n  \"firstName\": \"crazy\",\n  \"lastName\": \"coder09\",\n  \"email\": \"crazycoder09@gmail.com\",\n  \"password\": \"crazycoder09\",\n  \"shippingOriginCountryCode\": \"US\",\n  \"companyName\": \"Test LLC\",\n  \"addr1\": \"542 Midichlorian Rd.\",\n  \"addr2\": \"\",\n  \"city\": \"Austin\",\n  \"state\": \"TX\",\n  \"zip\": \"78703\",\n  \"countryCode\": \"US\",\n  \"phone\": \"5124111234\"\n}",
  CURLOPT_HTTPHEADER => array(
    "Host: ssapi.shipstation.com",
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
