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

$datanote = check_note($cmpid);
$totalnotes = sizeof($datanote);
if (isset($_GET['type']) && $_GET['type'] == 'amazon') {
    $batch = $_GET['id'];
    $filepath = @fopen("./upload/cmp" . $cmpid . "_" . $batch . ".txt", 'r');
    @$content = fgets($filepath);
    $file = ("./upload/Export_" . $batch . ".txt");
    $fw = fopen($file, "w");
    fwrite($fw, "order-id\torder-item-id\tquantity\tship-date\tcarrier-code\tcarrier-name\ttracking-number\tship-method\ttransparency_code \n");
    while (@$content = fgetcsv($filepath, 1000, "\t")) {    //每次读取CSV里面的一行内容
        $sql = "SELECT carrier,tracking,service FROM daifaorders where batch='" . $batch . "' and (cmpid='" . $cmpid . "') and orderid='" . $content[0] . "'";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $text = $content[0] . "\t" . strval($content[1]) . "\t" . $content[14] . "\t" . $content[4] . "\t" . $row['carrier'] . "\t \t\"" . $row['tracking'] . "\"\t" . $row['service'] . "\n";
        fwrite($fw, $text);
    }
    fclose($fw);
} elseif (isset($_GET['type']) && $_GET['type'] == 'newegg') {
    $batch = $_GET['id'];
    $filepath = @fopen("./upload/cmp" . $cmpid . "_" . $batch . ".csv", 'r');
    @$content = fgets($filepath);
    $file = ("./upload/Export_" . $batch . ".csv");
    $fw = fopen($file, "w");
    fwrite($fw, "Order Number,Order Date & Time,Sales Channel,Fulfillment Option,Ship To Address Line 1,Ship To Address Line 2,	Ship To City,	Ship To State,	Ship To ZipCode,Ship To Country	,Ship To First Name,	Ship To LastName,	Ship To Company,	Ship To Phone Number,	Order Customer Email,	Order Shipping Method,	Item Seller Part #,	Item Newegg #,	Item Unit Price,	Extend Unit Price,	Item Unit Shipping Charge,	Extend Shipping Charge,	Extend VAT,	Extend Duty,	Order Shipping Total,Order Discount Amount,Sales Tax,VAT Total,Duty Total,Order Total,Quantity Ordered,Quantity Shipped,Actual Shipping Carrier,Actual Shipping Method,	Tracking Number\n");
    while (@$content = fgetcsv($filepath, 1000, ",")) {    //每次读取CSV里面的一行内容
        $sql = "SELECT carrier,tracking,service FROM daifaorders where batch='" . $batch . "' and (cmpid='" . $cmpid . "') and orderid='" . $content[0] . "'";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $text='';
        for($index=0;$index<=30;$index++){
            $text=$text.strval($content[$index]).",";
        }
        $text = $text.$content[30].",". $row['carrier'] . ",".$row['service'].",". $row['tracking']."\n";
        fwrite($fw, $text);
    }
    fclose($fw);
} else {
    if (isset($_GET['id']) && ($_GET['id'] != '')) {
        $batch = $_GET['id'];
        $sql = "SELECT * FROM daifaorders where batch='" . $batch . "' and (cmpid='" . $cmpid . "') ORDER by id DESC";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
        $result = mysqli_query($conn, $sql);
//$totalpage = ceil($totalrow / $perpage);

        while ($arr = mysqli_fetch_array($result)) {
            $data[] = $arr;
        }

        $file = ("./upload/Export_" . $batch . ".csv");
    } else {
        $sql = "SELECT * FROM daifaorders where cmpid='" . $cmpid . "' ORDER by id DESC";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
        $result = mysqli_query($conn, $sql);
//$totalpage = ceil($totalrow / $perpage);

        while ($arr = mysqli_fetch_array($result)) {
            $data[] = $arr;
        }

        $file = ("./upload/Export_Order_Summary.csv");
    }
    $sql = "SELECT status FROM daifa where batchname='" . $batch . "' and (cmpid='" . $cmpid . "')";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if ($row[0] == 'PENDING') {
        $fw = fopen($file, "w");
        fwrite($fw, "Order ID (required), Service,Ship To - Name	, Ship To - Address 1 , 	Ship To - Address 2 ,	Ship To - City	, Ship To - State/Province ,	Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz, Note, \n");

        for ($index = 0; $index < @count($data); $index++) {
            $text = "\"" . $data[$index]['orderid'] . "\"," . $data[$index]['service'] . ",\"" . $data[$index]['name'] . "\",\"" . $data[$index]['address'] . "\",\"" . $data[$index]['address2'] . "\",\"" . $data[$index]['city'] . "\",\"" . $data[$index]['state'] . "\",\t" . strval($data[$index]['zipcode']) . "\t,\"" . $data[$index]['phone'] . "\"," . $data[$index]['weight'] . ",\"" . $data[$index]['note'] . "\"\n";
            fwrite($fw, $text);
        }
    } else {


        $fw = fopen($file, "w");
        fwrite($fw, "Order ID (required), Service, Tracking No,Tracking Status, Cost,	Ship To - Name	, Ship To - Address 1 , 	Ship To - Address 2 ,	Ship To - City	, Ship To - State/Province ,	Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz, Note, \n");

        for ($index = 0; $index < @count($data); $index++) {
            $text = "\"" . $data[$index]['orderid'] . "\"," . $data[$index]['service'] . ",\t" . $data[$index]['tracking'] . "\t," . $data[$index]['status'] . "," . $data[$index]['cost'] . ",\"" . $data[$index]['name'] . "\",\"" . $data[$index]['address'] . "\",\"" . $data[$index]['address2'] . "\",\"" . $data[$index]['city'] . "\",\"" . $data[$index]['state'] . "\",\t" . strval($data[$index]['zipcode']) . "\t,\"" . $data[$index]['phone'] . "\"," . $data[$index]['weight'] . ",\"" . $data[$index]['note'] . "\"\n";

            fwrite($fw, $text);
        }
    }
    fclose($fw);
}

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
?>
