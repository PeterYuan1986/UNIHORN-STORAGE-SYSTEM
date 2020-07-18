<?php
require_once 'header.php';
$pageoffice = 'all';           //设置页面属性 office ：  nc, sh, all
$pagelevel = 2;       // //设置页面等级 0： 只有admin可以访问； 1：库存系统用户； 2:代发用户
check_session_expiration();
$user = $_SESSION['user_info']['userid'];
$fn = $_SESSION['user_info']['firstname'];
$ln = $_SESSION['user_info']['lastname'];
$useroffice = $_SESSION['user_info']['office'];
$userlevel = $_SESSION['user_info']['level'];           //userlevel  0: admin; else;
$cmpid = $_SESSION['user_info']['cmpid'];
$childid = $_SESSION['user_info']['childid'];
$datanote = check_note($cmpid);
$totalnotes = sizeof($datanote);
check_access($useroffice, $userlevel, $pageoffice, $pagelevel);

    
    // 换cmpid在页面顶端
    if (sizeof($childid) > 1) {
    foreach ($childid as $x) {
        $title = "UCMP" . $x;
        if (isset($_POST["{$title}"])) {
            $_SESSION['user_info']['cmpid'] = $x;
            $cmpid = $_SESSION['user_info']['cmpid'];
        }
    }
}

if (isset($_GET['id']) && ($_GET['id'] != '')) {
    $batch = $_GET['id'];
    $sql = "SELECT * FROM daifaorders where batch='" . $batch . "' and (cmpid='". $cmpid."') ORDER by orderid ASC";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
    $result = mysqli_query($conn, $sql);
//$totalpage = ceil($totalrow / $perpage);

    while ($arr = mysqli_fetch_array($result)) {
        $data[] = $arr;
    }

    $file = ("./upload/Export_" . $batch . ".csv");
    $fw = fopen($file, "w");

    fwrite($fw, "Order ID (required), Service, Tracking No, Cost,	Ship To - Name	, Ship To - Company , 	Ship To - Address 1 ,	Ship To - City	, Ship To - State/Province ,	Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz,\n");

    for ($index = 0; $index < @count($data); $index++) {
        $text = "\"" . $data[$index]['orderid'] . "\"," . $data[$index]['service'] . ",\t" . $data[$index]['tracking'] . "\t," . $data[$index]['cost'] . "," . $data[$index]['name'] . "," . $data[$index]['company'] . ",\"" . $data[$index]['address'] . "\"," . $data[$index]['city'] . "," . $data[$index]['state'] . ",\"" . $data[$index]['zipcode'] . "\",\t" . $data[$index]['phone'] . "\t," . $data[$index]['weight'] . "\n";

        fwrite($fw, $text);
    }

    fclose($fw);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush(); // Flush system output buffer
    readfile($file);
    unlink($file);
} else {
    $sql = "SELECT * FROM daifaorders where cmpid='" . $cmpid . "' ORDER by orderid ASC";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
    $result = mysqli_query($conn, $sql);
//$totalpage = ceil($totalrow / $perpage);

    while ($arr = mysqli_fetch_array($result)) {
        $data[] = $arr;
    }

    $file = ("./upload/Export_Order_Summary.csv");
    $fw = fopen($file, "w");

    fwrite($fw, "Order ID (required),Batch, Service, Tracking No, Cost,	Ship To - Name	, Ship To - Company , 	Ship To - Address 1 ,	Ship To - City	, Ship To - State/Province ,	Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz,\n");

    for ($index = 0; $index < @count($data); $index++) {
        $text = "\"" . $data[$index]['orderid'] . "\",\"" . $data[$index]['service'] . "\",\t" . $data[$index]['tracking'] . "\t," . $data[$index]['cost'] . ",\"" . $data[$index]['name'] . "\",\"" . $data[$index]['company'] . "\",\"" . $data[$index]['address'] . "\",\"" . $data[$index]['city'] . "\",\"" . $data[$index]['state'] . "\",\"" . $data[$index]['zipcode'] . "\",\t" . $data[$index]['phone'] . "\t," . $data[$index]['weight'] . "\n";
        fwrite($fw, $text);
    }

    fclose($fw);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    flush(); // Flush system output buffer
    readfile($file);
    unlink($file);
}
?>
