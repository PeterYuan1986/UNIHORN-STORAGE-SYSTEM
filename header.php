<?php

session_start();
require("libs/database_connection.php");
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'en_US');
$str = date("Y-m-d H:i:s", time());
$letterfee = 0.2;
$packagefee = 0.4;
$amountfee = 0.3;
$originalpackagefee = 0.7;

function strexchange($a) {
    $b = str_replace("'", "\'", $a);
    $c = str_replace('"', '\"', $b);
    return $c;
}

function get_ups_status($trackingNumber) {
    global $conn;
//UPS 相关信息
    $access = "1D7F00B3B06A9135";   //UPC ACCESS
    $userid = "elephxp";            //UPS USER ID
    $passwd = "ABC123efg@";         //UPS USER PWD
//Configuration
//Configuration
    $wsdl = "./SCHEMAS-WSDLs/Track.wsdl";
    $operation = "ProcessTrack";
    $endpointurl = 'https://onlinetools.ups.com/webservices/Track';
    $outputFileName = "XOLTResult.xml";

    $req['RequestOption'] = '15';
    $tref['CustomerContext'] = 'Add description here';
    $req['TransactionReference'] = $tref;
    $request['Request'] = $req;
    $request['InquiryNumber'] = $trackingNumber;
    $request['TrackingOption'] = '02';
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
        $resp = $client->__soapCall($operation, array($request));

        //get status
        //echo "Response Status: " . $resp->Response->ResponseStatus->Description . "\n";
        $array = json_decode(json_encode($resp), true);
        $result = @$array['Shipment']['Package']['Activity']['0']['Status']['Description'];
        if (is_null($result)) {
            $sql = "UPDATE `daifaorders` SET status='Shipment Ready for UPS' WHERE `tracking`='" . $trackingNumber . "'";

            mysqli_query($conn, $sql);
            return 'Shipment Ready for UPS';
        } else {
            $sql = "UPDATE `daifaorders` SET status='" . $result . "' WHERE `tracking`='" . $trackingNumber . "'";

            mysqli_query($conn, $sql);
            return $result;
        }
        ;
    } catch (Exception $ex) {
        print_r($ex);
    }
}

function get_status($trackingNumber) {
    global $conn;
    $url = "http://production.shippingapis.com/shippingAPI.dll";
    $service = "TrackV2";

    $xml = rawurlencode("<TrackFieldRequest USERID='071UNIHO1781'><TrackID ID='" . $trackingNumber . "'></TrackID></TrackFieldRequest>");



    $request = $url . "?API=" . $service . "&XML=" . $xml;
// send the POST values to USPS
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// parameters to post

    $result = curl_exec($ch);
    curl_close($ch);

    $response = new SimpleXMLElement($result);

//print_r($result);
    $deliveryStatus = @$response->TrackInfo->TrackSummary->Event;

    if (strpos($deliveryStatus[0], ',')) {
        preg_match('/([^,]+?),/i', $deliveryStatus[0], $match);

        if (strpos($match[1], "Delivered") !== FALSE) {
            $sql = "UPDATE `daifaorders` SET status='Delivered' WHERE `tracking`='" . $trackingNumber . "'";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE `daifaorders` SET status='" . $match[1] . "' WHERE `tracking`='" . $trackingNumber . "'";
            mysqli_query($conn, $sql);
        }
        return $match[1];
    } else {
        if (strpos($deliveryStatus[0], "Delivered") !== FALSE) {
            $sql = "UPDATE `daifaorders` SET status='Delivered' WHERE `tracking`='" . $trackingNumber . "'";
            mysqli_query($conn, $sql);
        } else {
            $sql = "UPDATE `daifaorders` SET status='" . $deliveryStatus[0] . "' WHERE `tracking`='" . $trackingNumber . "'";
            mysqli_query($conn, $sql);
        }
        return $deliveryStatus[0];
    }
}

function isEmpty($val) {
    if (!is_string($val))
        return true; //是否是字符串类型 

    if (empty($val))
        return true; //是否已设定 

    if ($val == '')
        return true; //是否为空 

    return false;
}

function isEmail($val) {
    if (preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val)) {
        return TRUE;
    } else
        return FALSE;
}

function check_note($cmpid) {
    global $conn;
    $sql = "SELECT * FROM note where status= '1' and cmpid='" . $cmpid . "'";
    $result = mysqli_query($conn, $sql);
    $totalnotes = mysqli_num_rows($result);
    if ($totalnotes != 0) {
        while ($arr = mysqli_fetch_array($result)) {
            $datanote[] = $arr;
        }
        return $datanote;
    } else {
        return[];
    }
}

//检查session是否过期，15分钟
function check_session_expiration() {
    if (isset($_SESSION['user_info'])) {
        $now = time();
        if ((isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after'] ) || !isset($_SESSION['discard_after'])) {
            // this session has worn out its welcome; kill it and start a brand new one 
            header('Location:timeout.php');
        }
// either new or old, it should live at most for another hour
        else {
            $_SESSION['discard_after'] = $now + 900;  //过期15分钟session销毁跳到timeout
        }
    } else {
        echo '<script> alert("Please Re-login!")</script>';
        print '<script> location.replace("index.php"); </script>';
    }
}

function check_access($useroffice, $userlevel, $pageoffice, $pagelevel) {
    if ((($useroffice == $pageoffice || $pageoffice == 'all') && $userlevel <= $pagelevel) || $useroffice == 'admin') {
        
    } else {
        echo '<script> alert("You have no access for this page!")</script>';
        print '<script> location.replace("homepage.php"); </script>';
    }
}

?>