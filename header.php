<?php

session_start();

require("libs/database_connection.php");
require ("libs/functions.php");
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'en_US');
$str = date("Y-m-d H:i:s", time());

$sql = "SELECT * FROM note where status= '1'";
$result = mysqli_query($conn, $sql);
$totalnotes = mysqli_num_rows($result);
//$totalpage = ceil($totalrow / $perpage);
if ($totalnotes != 0) {
    while ($arr = mysqli_fetch_array($result)) {
        $datanote[] = $arr;
    }
}

//检查session是否过期，15分钟
function check_session_expiration() {
    $now = time();
    if ((isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after'] ) || !isset($_SESSION['discard_after'])) {
        // this session has worn out its welcome; kill it and start a brand new one 
        header('Location:index.php');
    }
// either new or old, it should live at most for another hour
    else {
        $_SESSION['discard_after'] = $now + 900;  //过期15分钟session销毁跳到timeout
    }
}
?>