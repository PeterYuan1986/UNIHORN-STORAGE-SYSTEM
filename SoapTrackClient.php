<?php

//Configuration
$access = "1D7F00B3B06A9135";   //UPC ACCESS
$userid = "elephxp";            //UPS USER ID
$passwd = "ABC123efg@";         //UPS USER PWD
//Configuration
//Configuration
$wsdl = "./SCHEMAS-WSDLs/Track.wsdl";
$operation = "ProcessTrack";
$endpointurl = 'https://onlinetools.ups.com/webservices/Track';
$outputFileName = "XOLTResult.xml";

function processTrack() {
    //create soap request
    $req['RequestOption'] = '15';
    $tref['CustomerContext'] = 'Add description here';
    $req['TransactionReference'] = $tref;
    $request['Request'] = $req;
    $request['InquiryNumber'] = '1ZRA45520396322151';
    $request['TrackingOption'] = '02';

    return $request;
}

try {

    $mode = array
        (
        'soap_version' => 'SOAP_1_1', // use soap 1.1 client
        'trace' => 1
    );

    // initialize soap client
    $client = new SoapClient($wsdl, $mode);

    //set endpoint url
    $client->__setLocation($endpointurl);


    //create soap header
    $usernameToken['Username'] = $userid;
    $usernameToken['Password'] = $passwd;
    $serviceAccessLicense['AccessLicenseNumber'] = $access;
    $upss['UsernameToken'] = $usernameToken;
    $upss['ServiceAccessToken'] = $serviceAccessLicense;

    $header = new SoapHeader('http://www.ups.com/XMLSchema/XOLTWS/UPSS/v1.0', 'UPSSecurity', $upss);
    $client->__setSoapHeaders($header);


    //get response
    $resp = $client->__soapCall($operation, array(processTrack()));

    //get status
    $array = json_decode(json_encode($resp), true);
  print_r ($array);
        $result = $array['Shipment']['Package']['Activity']['0']['Status']['Description'];
        print $result;
   
} catch (Exception $ex) {
    print_r($ex);
}
?>
