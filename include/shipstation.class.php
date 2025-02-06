<?php

class shipStation extends Functions
{

    private $orderNumber;
    private $orderDate;
    private $orderStatus;
    private $billTo;
    private $shipTo;
    private $items;
    private $orderTotal;
    private $amountPaid;
    private $taxAmount = 0.00;
    private $shippingAmount;
    private $weight;

    public function __construct(
        $orderNumber = null,
        $orderStatus = null,
        $billTo = null,
        $shipTo = null,
        $items = null,
        $orderTotal = null,
        $amountPaid = null,
        $shippingAmount = null,
        $weight = null
    ) {
        $this->orderDate = date('Y-m-d');
        $this->orderNumber = $orderNumber;
        $this->orderStatus = $orderStatus;
        $this->billTo = $billTo;
        $this->shipTo = $shipTo;
        $this->items = $items;
        $this->orderTotal = $orderTotal;
        $this->amountPaid = $amountPaid;
        $this->shippingAmount = $shippingAmount;
        $this->weight = $weight;
    }

    public function createOrderPaid($cartId = null)
    {
        try {
            //$data = [];
           
           /*  $cartDetails = new Cart();
            $cartDetails->getCartDetails($cartId); */
            
            //die(json_encode($cartDetails->getCartDetails($cartId)));
/*             $postFields = new stdClass();
            $postFields->orderNumber = $this->orderDate;
            $postFields->orderStatus = "awaiting_shipment";
            $postFields->items = $this->items;
            $postFields->orderTotal = $this->orderTotal;
            $postFields->billTo = $this->billTo;
            $postFields->shipTo = $this->shipTo;
            $postFields->orderTotal = $this->orderTotal;
            $postFields->shipTo = $this->shipTo;
            $postFields->amountPaid = $this->amountPaid;
            $postFields->taxAmount = $this->taxAmount;
            $postFields->shippingAmount = $this->shippingAmount;
            $postFields->weight = $this->weight; */

/*             $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://ssapi.shipstation.com/orders/createorder',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
            "orderNumber": "SWU-00002",
            "orderDate": "2023-04-26",
            "orderStatus": "awaiting_shipment",
            "billTo": {
                "name": "Joel Edwards",
                "company": "company",
                "street1": "street",
                "street2": "street2",
                "street3": "street3",
                "city": "kansas",
                "state": "georgia",
                "postalCode": "55685",
                "country": "US",
                "phone": "8888888",
                "residential": true
            },
            "shipTo": {
                "name": "Joel Edwards",
                "company": "company",
                "street1": "street",
                "street2": "street2",
                "street3": "street3",
                "city": "georgia",
                "state": "kansas",
                "postalCode": "55685",
                "country": "US",
                "phone": "8888888",
                "residential": true
            },
            "items": [
                {
                    "orderItemId": 1795601530,
                    "lineItemKey": "24581",
                    "sku": "852844007000",
                    "name": "10% Gel FBI Block",
                    "imageUrl": "https://www.clearballistics.com/wp-content/uploads/2016/03/799804943698-1-100x100.jpg",
                    "weight": {
                        "value": 17.2,
                        "units": "lbs",
                        "WeightUnits": 1
                    },
                    "quantity": 1,
                    "unitPrice": 67.98,
                    "taxAmount": null,
                    "shippingAmount": null,
                    "warehouseLocation": null,
                    "options": [],
                    "productId": 19062436,
                    "fulfillmentSku": null,
                    "adjustment": false,
                    "upc": null,
                    "createDate": "2023-04-02T08:14:58.46",
                    "modifyDate": "2023-04-02T08:14:58.46"
                }
            ],
            "orderTotal": 151.68,
            "amountPaid": 151.68,
            "taxAmount": 0.00,
            "shippingAmount": 53.70,
            "weight": {
                "value": 17.2,
                "units": "pounds",
                "WeightUnits": 1
            }
        }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl); */
/*             $data = [
                '' => ''
            ]; */
            //return $cartDetails->getCartDetails($cartId);
            cb_logger('dasdsadasdasdasdasdsadas');
            die();
        } catch (\Throwable $th) {
            cb_logger($th);
        }
    }
}

?>