<?php

require 'header.php';
$sql = "SELECT tracking, status FROM `daifaorders` where tracking>0 and not(status='Delivered') ";
$result = mysqli_query($conn, $sql);
try {
    while ($array = mysqli_fetch_array($result)) {

        if (strpos($array[1], "Delivered") !== FALSE) {
            
        } else {
            $status = get_status($array[0]);
        }
    }
} catch (Exception $ex) {
    $sql = "SELECT tracking, status FROM `daifaorders` where tracking>0 and not(status='Delivered') ";
    $result = mysqli_query($conn, $sql);
    try {
        while ($array = mysqli_fetch_array($result)) {

            if (strpos($array[1], "Delivered") !== FALSE) {
                
            } else {
                $status = get_status($array[0]);
            }
        }
    } catch (Exception $ex) {
        $sql = "SELECT tracking, status FROM `daifaorders` where tracking>0 and not(status='Delivered') ";
        $result = mysqli_query($conn, $sql);
        try {
            while ($array = mysqli_fetch_array($result)) {

                if (strpos($array[1], "Delivered") !== FALSE) {
                    
                } else {
                    $status = get_status($array[0]);
                }
            }
        } catch (Exception $ex) {
            print $ex;
        }
    }
}
print "Successful!";
?>
