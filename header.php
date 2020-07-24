<?php

session_start();
require("libs/database_connection.php");
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'en_US');
$str = date("Y-m-d H:i:s", time());
$letterfee=0.2;
$packagefee=0.4;
$amountfee=1;

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
    if ((($useroffice == $pageoffice || $pageoffice == 'all') && $userlevel <= $pagelevel)||$useroffice=='admin') {
        
    } else {
        echo '<script> alert("You have no access for this page!")</script>';
        print '<script> location.replace("homepage.php"); </script>';
    }
}

?>