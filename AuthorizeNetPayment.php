<?php
require './vendor/autoload.php';

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizeNetPayment
{

    private $APILoginId;
    private $APIKey;
    private $refId;
    private $merchantAuthentication;
    public $responseText;


    public function __construct()
    {
        // echo "__construct";
        // require_once "config.php";
        include('config.php');
        $this->APILoginId = API_LOGIN_ID;
        $this->APIKey = TRANSACTION_KEY;
        $this->refId = 'ref' . time();

        $this->merchantAuthentication = $this->setMerchantAuthentication();
        $this->responseText = array("1" => "Approved", "2" => "Declined", "3" => "Error", "4" => "Held for Review");
    }

    public function setMerchantAuthentication()
    {
        // echo "setMerchantAuthentication";
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($this->APILoginId);
        $merchantAuthentication->setTransactionKey($this->APIKey);

        return $merchantAuthentication;
    }

    public function setCreditCard($cardDetails)
    {
        // echo "setCreditCard";
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardDetails["card_number"]);
        //$creditCard->setExpirationDate($cardDetails["year"] . "-" . $cardDetails["month"]);
        $expiryDate = explode("/", $cardDetails["expiry_date"]);
        $creditCard->setExpirationDate("20" . $expiryDate[1] . "-" . $expiryDate[0]);
        $creditCard->setCardCode($cardDetails["card_code"]);
        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        return $paymentType;
    }

    public function setTransactionRequestType($paymentType, $amount, $shipTo, $billTo, $order_no)
    {
        // Set the customer's Ship To address
        $customerAddressShipTo = new AnetAPI\CustomerAddressType();
        $customerAddressShipTo->setFirstName($shipTo['firstName']);
        $customerAddressShipTo->setLastName($shipTo['lastName']);
        $customerAddressShipTo->setCompany($shipTo['company']);
        $customerAddressShipTo->setAddress($shipTo['address']);
        $customerAddressShipTo->setCity($shipTo['city']);
        $customerAddressShipTo->setState($shipTo['state']);
        $customerAddressShipTo->setZip($shipTo['postalCode']);
        $customerAddressShipTo->setCountry($shipTo['country']);

        // Set the customer's Bill To address
        $customerAddressBillTo = new AnetAPI\CustomerAddressType();
        $customerAddressBillTo->setFirstName($billTo['firstName']);
        $customerAddressBillTo->setLastName($billTo['lastName']);
        $customerAddressBillTo->setCompany($billTo['company']);
        $customerAddressBillTo->setAddress($billTo['address']);
        $customerAddressBillTo->setCity($billTo['city']);
        $customerAddressBillTo->setState($billTo['state']);
        $customerAddressBillTo->setZip($billTo['postalCode']);
        $customerAddressBillTo->setCountry($billTo['country']);

        // Create order information
        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($order_no);
        $order->setDescription("Clear Ballistics - Order " . $order_no);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentType);
        $transactionRequestType->setShipTo($customerAddressBillTo);
        $transactionRequestType->setBillTo($customerAddressShipTo);
        $transactionRequestType->setOrder($order);

        return $transactionRequestType;
    }

    public function chargeCreditCard($cardDetails, $shipTo, $billTo, $order_no)
    {
        // echo "chargeCreditCard";


        // echo "<pre>";
        // print_r($cardDetails);
        $paymentType = $this->setCreditCard($_POST);
        $transactionRequestType = $this->setTransactionRequestType($paymentType, $_POST["amount"], $shipTo, $billTo, $order_no);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($this->merchantAuthentication);
        $request->setRefId($this->refId);
        $request->setTransactionRequest($transactionRequestType);
        cb_logger('AuthorizeNetPayment.chargeCreditCard>Request=' . json_encode($request));
        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        return $response;
    }
}
