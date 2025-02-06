<?php
$curl = curl_init();

$secretsPath = './config/secrets_qb.json';
$jsonString = file_get_contents($secretsPath);
$jsonData = json_decode($jsonString, true);
$refresh_token = $jsonData['refresh_token'];
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_SSL_VERIFYHOST => false,
  CURLOPT_SSL_VERIFYPEER => false,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => "refresh_token=$refresh_token&grant_type=refresh_token",
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic QUJrSEFOTHRzQU1wQjZPMkVlWVo1QVZXVzFwalJvZlE0bUVKR1hPV3BMNmdDcnh4dVU6UXU1cVZqTEpjZFZXaUZaWGJQbzdEdmpFbW9QOER6N2xrU2RPMmdSMw==',
    'Content-Type: application/x-www-form-urlencoded',
    'Accept: application/json'
  ),
));

$response = curl_exec($curl);

/* $responseData = json_decode($jsonString, true);

$responseData["refreshToken"] = $responseData["refresh_token"];

$response = json_encode($responseData); */

$fp = fopen($secretsPath, 'w');
fwrite($fp, $response);
fclose($fp);


curl_close($curl);
//cb_logger("qb-response".$response);
echo $response;


