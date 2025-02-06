<?php
class upsRate
{
	private $AccessLicenseNumber;
	private $UserId;
	private $Password;
	private $shipperNumber;
	private $credentials;
	private $token;
	function __construct()
	{
		$this->getToken();
	}
	function getToken()
	{
		try {
			$secretsPath = './config/secrets.json';
			$jsonString = file_get_contents($secretsPath);
			$jsonData = json_decode($jsonString, true);
			$this->token = $jsonData['access_token'];
		} catch (\Throwable $th) {
			cb_logger(`Error getting Token`);
			throw $th;
		}
	}
	function setCredentials($access, $user, $pass, $shipper)
	{
		$this->AccessLicenseNumber = $access;
		$this->UserId = $user;
		$this->Password = $pass;
		$this->shipperNumber = $shipper;
		$this->credentials = 1;
	}
	// Define the function getRate() - no parameters
	function getRate($PostalCode, $dest_zip, $dest_country_code, $service, $length, $width, $height, $weight, $stateCode = "", $noOfPackages = 0)
	{
		$curl = curl_init();

		$payload = array(
			"RateRequest" => array(
				"Request" => array(
					"TransactionReference" => array(
						"CustomerContext" => "Verify Success response",
						"TransactionIdentifier" => "?"
					),
					"RequestOption" => "Shop"
				),
				"Shipment" => array(
					"Shipper" => array(
						"Name" => "Shipper_Name",
						"ShipperNumber" => "1F8A60",
						"Address" => array(
							"AddressLine" => array(
								"Morris Road",
								"Morris Road",
								"Morris Road"
							),
							"City" => "Alpharetta",
							"StateProvinceCode" => "SC",
							"PostalCode" => $PostalCode,
							"CountryCode" => "US"
						)
					),
					"ShipTo" => array(
						"Name" => "France Company",
						"Address" => array(
							"AddressLine" => array(
								"103 avenue des Champs-Elysees",
								"103 avenue des Champs-Elysees",
								"103 avenue des Champs-Elysees"
							),
							"City" => "STARZACH",
							"StateProvinceCode" => $stateCode,
							"PostalCode" => $dest_zip,
							"CountryCode" => $dest_country_code,
							"ResidentialAddressIndicator" => "Y"
						)
					),
					"ShipFrom" => array(
						"Name" => "ShipFromName",
						"Address" => array(
							"AddressLine" => array(
								"ShipFromAddressLine",
								"ShipFromAddressLine",
								"ShipFromAddressLine"
							),
							"City" => "Alpharetta",
							"StateProvinceCode" => "SC",
							"PostalCode" => $PostalCode,
							"CountryCode" => "US"
						)
					),
					"NumOfPieces" => "1",
					"ShipmentRatingOptions" => array(
						"TPFCNegotiatedRatesIndicator" => "Y",
						"NegotiatedRatesIndicator" => "Y"
					),
				)
			)
		);
		$total_weight = $weight;
		$weight = (round($weight / $noOfPackages));
		//$weight = 49;
		cb_logger("weight = $weight and noOfPackages=$noOfPackages and totalWeight $total_weight");
		for ($i = 0; $i < $noOfPackages; $i++) {
			$payload['RateRequest']['Shipment']['Package'][] = array(
				"PackagingType" => array(
					"Code" => "02",
					"Description" => "Packaging"
				),
				"Dimensions" => array(
					"UnitOfMeasurement" => array(
						"Code" => "IN",
						"Description" => "Inches"
					),
					"Length" => '0',
					"Width" => '0',
					"Height" => '0'
				),
				"PackageWeight" => array(
					"UnitOfMeasurement" => array(
						"Code" => "LBS",
						"Description" => "Pounds"
					),
					"Weight" => "$weight"
				)
			);
		}
		cb_logger($payload['RateRequest']['Shipment']['Package']);
		$token = $this->token;
		curl_setopt_array($curl, [
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			],
			CURLOPT_POSTFIELDS => json_encode($payload),
			CURLOPT_URL => "https://onlinetools.ups.com/api/rating/v1/Shop",
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "POST",
		]);
		cb_logger('PayLoad' . json_encode($payload));
		$response = curl_exec($curl);
		$error = curl_error($curl);

		curl_close($curl);

		if ($error) {
			echo "cURL Error #:" . $error;
		} else {
			cb_logger('res=' . $response);
			return json_decode($response, true);
		}
	}
	
	function getUpsShipmentStatus($inquiryNumber, $trasactionId = 123)
	{
		$query = array(
			"locale" => "en_US"
		);

		$curl = curl_init();
		$token = $this->token;
		curl_setopt_array($curl, [
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer $token",
				"transId: $inquiryNumber",
				"transactionSrc: production"
			],
			CURLOPT_URL => "https://onlinetools.ups.com/api/track/v1/details/" . $inquiryNumber . "?" . http_build_query($query),
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST => "GET",
		]);

		$response = curl_exec($curl);
		$error = curl_error($curl);

		curl_close($curl);

		if ($error) {
			echo "cURL Error #:" . $error;
		} else {
			return json_decode($response, true);
		}
	}
}
