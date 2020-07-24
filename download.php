<?php

$f = "template.csv";

$file = ("./upload/" . $f);

$fw = fopen($file, "w");

fwrite($fw, "Order ID (required),	Ship To - Name	, Ship To - Company , 	Ship To - Address 1 ,	Ship To - City	, Ship To - State/Province ,	"
        . "Ship To - Postal Code,	Ship To - Phone,	Total Weight in Oz, Product, amount, Product, amount, Product, amount,...");
fwrite($fw, "\n");
fwrite($fw, "1234,	Alex	, Unihorn , 	2500 w Market st,	Greensboro	, NC,	"
        . "27409,	9199088221,	17, mask, 10, cable, 20");
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
?>	