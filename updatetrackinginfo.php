<?php

require 'header.php';
$sql = "SELECT tracking, status FROM `daifaorders` where tracking>9400000000000000000000 and not(status='Delivered') and status='' order by tracking desc";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
$repeat = $total / 200;
while ($repeat > 0) {
    $sql = "SELECT tracking, status FROM `daifaorders` where tracking>9400000000000000000000 and not(status='Delivered') and status='' order by tracking desc";
    $result = mysqli_query($conn, $sql);
    while ($array = mysqli_fetch_array($result)) {
        get_status($array[0]);
        set_time_limit(0);
    }
    $repeat++;
}
print "Successful!";
?>
