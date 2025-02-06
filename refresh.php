<?php
include('./connect.php');
function generatePaypalToken()
{
  try {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api-m.paypal.com/v1/oauth2/token',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Basic QVRxMFBqOVVOUHBWYkQ4ZjY3VWptRFpuZm8zS3FXUDVZdWNiTFBIMk9ZZDNmWGJ0b09hMjI4UjlGbWE5bEFpV3RrcExTdmhJSU10NlFRaWE6RUdtdUpKZWdyNXZLSnFFUm9IRHU3RGNRUUI1THd4alZsWDY4dnljazZRMVdQTDlaOE8yZC1kN2p3UmphUEVPbVY0c0xzNi13cHV6TFAyVW4=',
        'Cookie: cookie_check=yes; d_id=23aaded5a33245ea9888d8d9e72cd8441696254566974; enforce_policy=global; l7_az=ccg01.phx; ts=vreXpYrS%3D1790956619%26vteXpYrS%3D1696264019%26vr%3Df0a6a05018a0a6022349a922f12bc855%26vt%3Df11b662e18a0a6022c4707dff1129c39%26vtyp%3Dreturn; ts_c=vr%3Df0a6a05018a0a6022349a922f12bc855%26vt%3Df11b662e18a0a6022c4707dff1129c39; tsrce=unifiedloginnodeweb; x-pp-s=eyJ0IjoiMTY5NjI2MjIxOTg5MyIsImwiOiIwIiwibSI6IjAifQ'
      ),
    ));

    $response = curl_exec($curl);
    $error = curl_error($curl);

    curl_close($curl);
    $response;
    if ($error) {
      echo "cURL Error #:" . $error;
    } else {
      $res = json_decode($response, true);
      cb_logger('paypal');
      cb_logger($res);
      if ($res['token_type'] == 'Bearer') {
        return $res['access_token'];
      } else {
        cb_logger('generatePaypalToken');
        cb_logger($response);
        return false;
      }
    }
  } catch (\Throwable $th) {
    cb_logger($th);
  }
};
try {
  $secretsPath = './config/secrets.json';
  $jsonString = file_get_contents($secretsPath);
  $jsonData = json_decode($jsonString, true);
  $refresh_token = $jsonData['refresh_token'];


  $curl = curl_init();

  $payload = "grant_type=refresh_token&refresh_token={$refresh_token}";

  curl_setopt_array($curl, [
    CURLOPT_HTTPHEADER => [
      "Content-Type: application/x-www-form-urlencoded",
      "Authorization: Basic " . base64_encode("cd8MMRsMRJsHuJvIDgIhuiajOUvS9gaQ7nuE3QOZ588ccJWZ:BYwZqkqJmDFLHgYf1rrIJOrnfsAtJL6cPySqNtypFBGLiGJphMeGrcjnM8AcBD4L")
    ],
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_URL => "https://wwwcie.ups.com/security/v1/oauth/refresh",
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "POST",
  ]);

  $response = curl_exec($curl);
  $error = curl_error($curl);

  curl_close($curl);

  if ($error) {
    echo "cURL Error #:" . $error;
  } else {
    $res = json_decode($response, true);
    if ($res['status'] == 'approved') {
      $paypalToken = generatePaypalToken();
      $res['paypal_access_token'] = $paypalToken;
      cb_logger('refresh at ' . date('Y-m-d H:i:s'));
      $fp = fopen($secretsPath, 'w');
      fwrite($fp, json_encode($res));
      fclose($fp);
      echo json_encode(array('access_token' => $res['access_token'], 'ppt' => $res['paypal_access_token']));
    } else {
      cb_logger('refresh');
      cb_logger($response);
    }
  }
} catch (\Throwable $th) {
  cb_logger($th);
}
