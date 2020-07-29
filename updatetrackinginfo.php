<?php

require 'header.php';

$sql = "SELECT tracking, status FROM `daifaorders` where tracking>0 and not(status='Delivered')";
$result = mysqli_query($conn, $sql);
while ($array = mysqli_fetch_array($result)) {
    if (strpos($array[1], "Delivered") !== false) {
        $status = get_status($array[0]);
        $sql = "UPDATE `daifaorders` SET status='" . $status . "' WHERE `tracking`='" . $array[0] . "'";
        mysqli_query($conn, $sql);
    } else {

        $sql = "UPDATE `daifaorders` SET status='Delivered' WHERE `tracking`='" . $array[0] . "'";
        mysqli_query($conn, $sql);
    }
}
?>
