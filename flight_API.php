<?php

//Store your XML Request in a variable
$input_xml = '<AvailRequest>
        <Trip>ONE</Trip>
        <Origin>BOM</Origin>
        <Destination>JFK</Destination>
        <DepartDate>2013-09-15</DepartDate>
        <ReturnDate>2013-09-16</ReturnDate>
        <AdultPax>1</AdultPax>
        <ChildPax>0</ChildPax>
        <InfantPax>0</InfantPax>
        <Currency>INR</Currency>
        <PreferredClass>E</PreferredClass>
        <Eticket>true</Eticket>
        <Clientid>777ClientID</Clientid>
        <Clientpassword>*Your API Password</Clientpassword>
        <Clienttype>ArzooINTLWS1.0</Clienttype>
        <PreferredAirline></PreferredAirline>
</AvailRequest>';


$url = "https://ssapi.shipstation.com/orders/createorder";

//setting the curl parameters.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// Following line is compulsary to add as it is:
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "xmlRequest=" . $input_xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
$data = curl_exec($ch);
curl_close($ch);

//convert the XML result into array
$array_data = json_decode(json_encode(simplexml_load_string($data)), true);

print_r('<pre>');
print_r($array_data);
print_r('</pre>');