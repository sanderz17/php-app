<?php
require_once("ups.php");
$ups = new upsRate();
// $ups->setCredentials(UPS_ACCOUNT_API_KEY,ACCOUNT_NAME,ACCOUNT_PASSWORD,ACCOUNT_NUMBER);
// $result    = $ups->getRate($from_zip,$destination_zip,$services,$length,$width,$height,$weight);
$ups->setCredentials(UPS_ACCESS_KEY,ACCOUNT_NAME,ACCOUNT_PASSWORD,ACCOUNT_NUMBER);
$result    = $ups->getRate(29603,1234,$services,2,2,2,2);
echo "Price".$result;
 
?>