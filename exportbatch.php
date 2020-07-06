<?php

require 'header.php';
?>
<?php

if (isset($_GET['id']) && ($_GET['id'] != '')) {
    $batch = $_GET['id'];
} else {
    header('location: data-table.php');
}

$sql = "SELECT * FROM daifaorders where batch='" . $batch."' ORDER by orderid ASC";  //SELECT * FROM daifaorders where batch='0704_UPS' ORDER by orderid ASC
$result = mysqli_query($conn, $sql);
//$totalpage = ceil($totalrow / $perpage);

while ($arr = mysqli_fetch_array($result)) {
    $data[] = $arr;
}

$file = ("./upload/Export_" . $batch . ".csv");
$fw = fopen($file, "w");

fwrite($fw, "Order ID (required), Service, Tracking No, Cost,	Ship To - Name	, Ship To - Company , 	Ship To - Address 1 ,	Ship To - City	, Ship To - State/Province ,	Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz,\n");

for ($index = 0; $index < @count($data); $index++) {
    $text = str_replace(",", " ",$data[$index]['orderid']) . "," . $data[$index]['service'] . ",'" . $data[$index]['tracking'] . "," . $data[$index]['cost'] . "," . $data[$index]['name'] . "," . $data[$index]['company'] . "," . str_replace(",", " ",$data[$index]['address'])  . "," . $data[$index]['city'] . "," . $data[$index]['state'] . "," . $data[$index]['zipcode'] . "," . $data[$index]['phone'] . "," . $data[$index]['weight'] . "\n";

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
?>
