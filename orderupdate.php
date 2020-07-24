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

if (isset($_REQUEST['search'])) {
    $sku = $_POST['searcheditorder'];
    $sql = "SELECT `batch`, `service`,  `name`, `address`, `city`, `state`, `zipcode`, `phone`, `weight`, note  FROM `daifaorders` WHERE (cmpid='" . $cmpid . "') and orderid ='" . $sku . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $batch = $row['batch'];
    $category = $row['service'];
    $receiver = $row['name'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zipcode = $row['zipcode'];
    $phone = $row['phone'];
    $weight = $row['weight'];
    $note = $row['note'];
} else {
    $sku = 0;
    $batch = 0;
    $category = 0;
    $receiver = 0;
    $phone = 0;
    $weight = 0;
    $state = 0;
    $address = 0;
    $city = 0;
    $zipcode = 0;
    $note = 0;
}

$sql = "SELECT `batchname` FROM `daifa` where (cmpid='" . $cmpid . "') and paid='0' ORDER BY time DESC";
$result = mysqli_query($conn, $sql);
while ($arr = mysqli_fetch_array($result)) {
    $data[] = $arr;
}




if (isset($_POST["save"])) {
    $isku = @$_POST["isku"];
    $ibatch = @$_POST['ibatch'];
    $icategory = @$_POST['icategory'];
    $ireceiver = @$_POST["ireceiver"];
    $iaddress = @$_POST["iaddress"];

    $icity = @$_POST["icity"];
    $istate = @$_POST["istate"];
    $izipcode = @$_POST["izipcode"];
    $iphone = @$_POST["iphone"];
    $iweight = @$_POST["iweight"];
    $inote = @$_POST["inote"];
    if (checkinput($isku)) {
        $sql = "select * from daifaorders where (cmpid='" . $cmpid . "') and orderid='" . $isku . "'";
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            $sql = "select paid,class,type from daifa where (cmpid='" . $cmpid . "') and batchname='" . $ibatch . "'";
            $result = mysqli_query($conn, $sql);
            $tem = mysqli_fetch_array($result);
            if ($tem[0]) {
                print '<script>alert("此批次已结算，无法添加到此批次")</script>';
            } else {
                if ($tem[1] == 0) {
                    if ($tem[2] == "Letter") {
                        $fee = $letterfee;
                    } else {
                        $fee = $packagefee;
                    }
                    $sql = "INSERT INTO `daifaorders`(`orderid`, `batch` , `service`, `name`,`address`, `city`, `state`, `zipcode`, `phone`, `weight`, `cmpid`, note, fee) VALUES('" . $isku . "','" . $ibatch . "','" . $icategory . "','" . $ireceiver . "','" . $iaddress . "','" . $icity . "','" . $istate . "','" . $izipcode . "','" . $iphone . "','" . $iweight . "','" . $cmpid . "','" . $inote . "','" . $fee . "')";
                    $result = mysqli_query($conn, $sql);
                    $sql = "SELECT SUM(fee) FROM daifaorders where batch='" . $ibatch . "' and cmpid='" . $cmpid . "'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $sql = "UPDATE daifa SET time=CURRENT_TIME, orders= orders+1, servicefee=servicefee+" . $row[0] . " WHERE (cmpid='" . $cmpid . "') AND batchname='" . $ibatch . "'";
                    $result = mysqli_query($conn, $sql);
                    print '<script>alert("Add Successful!")</script>';
                    // print '<script> location.replace("orderupdate.php"); </script>';         
                } else {
                    $pattern = '/(\*\d+(;|；))/';  //匹配inote里的整数

                    if (preg_match_all($pattern, $inote, $match)) {
                        //echo '<pre>';
                        $fee = 0;
                        foreach ($match[0] as $x) {
                            $x = str_replace("*", "", $x);
                            $x = str_replace(";", "", $x);
                            $x = str_replace("；", "", $x);
                            $fee = $fee + $x;
                        }

                        $sql = "INSERT INTO `daifaorders`(`orderid`, `batch` , `service`, `name`,`address`, `city`, `state`, `zipcode`, `phone`, `weight`, `cmpid`, note, fee) VALUES('" . $isku . "','" . $ibatch . "','" . $icategory . "','" . $ireceiver . "','" . $iaddress . "','" . $icity . "','" . $istate . "','" . $izipcode . "','" . $iphone . "','" . $iweight . "','" . $cmpid . "','" . $inote . "','" . $fee . "')";
                        $result = mysqli_query($conn, $sql);
                        $sql = "SELECT SUM(fee) FROM daifaorders where batch='" . $ibatch . "' and cmpid='" . $cmpid . "'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $sql = "UPDATE daifa SET time=CURRENT_TIME, orders= orders+1, servicefee=servicefee+" . $row[0] . " WHERE (cmpid='" . $cmpid . "') AND batchname='" . $ibatch . "'";
                        $result = mysqli_query($conn, $sql);
                        print '<script>alert("Add Successful!")</script>';
                    } else {
                        print '<script>alert("请按照格式以下格式书写备注，商品名*数量；商品名*数量；...")</script>';
                    }
                }
            }
        } else {
            print '<script>alert("The Order ID has existed, please use a different ID or update it.")</script>';
        }
    }
}

if (isset($_POST["update"])) {
    $isku = @$_POST["isku"];
    $ibatch = @$_POST['ibatch'];
    $icategory = @$_POST['icategory'];
    $ireceiver = @$_POST["ireceiver"];
    $iaddress = @$_POST["iaddress"];
    $icity = @$_POST["icity"];
    $istate = @$_POST["istate"];
    $izipcode = @$_POST["izipcode"];
    $iphone = @$_POST["iphone"];
    $iweight = @$_POST["iweight"];
    $inote = @$_POST["inote"];
    $sql = "select batch from daifaorders where (cmpid='" . $cmpid . "') and orderid='" . $isku . "'";
    $result = mysqli_query($conn, $sql);
    if (!$result || mysqli_num_rows($result) == 0) {

        print '<script>alert("This Order ID is not existed, Please add a new Order!")</script>';
    } else {
        $originalbatch = mysqli_fetch_array($result);
        $originalbatch = $originalbatch[0];
        $sql = "select paid,class,type from daifa where (cmpid='" . $cmpid . "') and batchname='" . $ibatch . "'";
        $result = mysqli_query($conn, $sql);
        $tem = mysqli_fetch_array($result);

        if ($tem[0]) {
            print '<script>alert("此批次已结算，无法添加到此批次")</script>';
        } else {
            $sql = "UPDATE daifaorders SET batch='tempbatch' WHERE (cmpid='" . $cmpid . "') AND orderid='" . $isku . "'";
            $result = mysqli_query($conn, $sql);
            $sql = "SELECT count(fee), sum(fee) from daifaorders  where (cmpid='" . $cmpid . "') and batch='" . $originalbatch . "'";
            $result = mysqli_query($conn, $sql);
            $updateoriginalbatch = mysqli_fetch_array($result);
            $sql = "UPDATE daifa SET orders='" . $updateoriginalbatch[0] . "', servicefee='" . $updateoriginalbatch[1] . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $originalbatch . "'";
            $result = mysqli_query($conn, $sql);

            if ($tem[1] == 0) {
                if ($tem[2] == "Letter") {
                    $fee = $letterfee;
                } else {
                    $fee = $packagefee;
                }
                $sql = "UPDATE `daifaorders` SET `batch`='" . $ibatch . "', `service`='" . $icategory . "', `name`='" . $ireceiver . "',`address`='" . $iaddress . "', `city`='" . $icity . "', `state`='" . $istate . "',  `zipcode`='" . $izipcode . "', `phone`='" . $iphone . "',  `weight`='" . $iweight . "', note='" . $inote . "',  fee='" . $fee . "'WHERE (cmpid='" . $cmpid . "') AND orderid='" . $isku . "'";
                $result = mysqli_query($conn, $sql);
                $sql = "SELECT count(fee), sum(fee) from daifaorders  where (cmpid='" . $cmpid . "') and batch='" . $ibatch . "'";
                $result = mysqli_query($conn, $sql);
                $updatenewbatch = mysqli_fetch_array($result);
                $sql = "UPDATE daifa SET orders='" . $updatenewbatch[0] . "', servicefee='" . $updatenewbatch[1] . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $ibatch . "'";
                $result = mysqli_query($conn, $sql);
                print '<script>alert("Edit Successful!")</script>';
                print '<script> location.replace("orderupdate.php"); </script>';
            } else {
                $pattern = '/(\*\d+(;|；))/';  //匹配inote里的整数

                if (preg_match_all($pattern, $inote, $match)) {
                    //echo '<pre>';
                    print_r($match);
                    $fee = 0;
                    foreach ($match[0] as $x) {
                        $x = str_replace("*", "", $x);
                        $x = str_replace(";", "", $x);
                        $x = str_replace("；", "", $x);
                        $fee = $fee + $x;
                    }
                    $sql = "UPDATE `daifaorders` SET `batch`='" . $ibatch . "', `service`='" . $icategory . "', `name`='" . $ireceiver . "',`address`='" . $iaddress . "', `city`='" . $icity . "', `state`='" . $istate . "',  `zipcode`='" . $izipcode . "', `phone`='" . $iphone . "',  `weight`='" . $iweight . "', note='" . $inote . "',  fee='" . $fee . "'WHERE (cmpid='" . $cmpid . "') AND orderid='" . $isku . "'";
                    $result = mysqli_query($conn, $sql);

                    $sql = "SELECT count(fee), sum(fee) from daifaorders  where (cmpid='" . $cmpid . "') and batch='" . $ibatch . "'";
                    $result = mysqli_query($conn, $sql);
                    $updatenewbatch = mysqli_fetch_array($result);
                    $sql = "UPDATE daifa SET orders='" . $updatenewbatch[0] . "', servicefee='" . $updatenewbatch[1] . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $ibatch . "'";
                    $result = mysqli_query($conn, $sql);
                    print '<script>alert("Edit Successful!")</script>';
                    print '<script> location.replace("orderupdate.php"); </script>';
                } else {
                    $sql = "UPDATE daifaorders SET batch='" . $originalbatch . "' WHERE (cmpid='" . $cmpid . "') AND orderid='" . $isku . "'";
                    $result = mysqli_query($conn, $sql);
                    $sql = "SELECT count(fee), sum(fee) from daifaorders  where (cmpid='" . $cmpid . "') and batch='" . $originalbatch . "'";
                    $result = mysqli_query($conn, $sql);
                    $updateoriginalbatch = mysqli_fetch_array($result);
                    $sql = "UPDATE daifa SET orders='" . $updateoriginalbatch[0] . "', servicefee='" . $updateoriginalbatch[1] . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $originalbatch . "'";
                    $result = mysqli_query($conn, $sql);
                    print '<script>alert("请按照格式以下格式书写备注，商品名*数量；商品名*数量；...")</script>';
                }
            }
        }
    }
}

if (isset($_POST["delete"])) {
    $isku = @$_POST["isku"];
    $ibatch = @$_POST['ibatch'];
    $icategory = @$_POST['icategory'];
    $ireceiver = @$_POST["ireceiver"];
    $iaddress = @$_POST["iaddress"];
    $icity = @$_POST["icity"];
    $istate = @$_POST["istate"];
    $izipcode = @$_POST["izipcode"];
    $iphone = @$_POST["iphone"];
    $iweight = @$_POST["iweight"];
    $inote = @$_POST["inote"];
    $sql = "select batch from daifaorders where (cmpid='" . $cmpid . "') and orderid='" . $isku . "'";
    $result = mysqli_query($conn, $sql);
    if (!$result || mysqli_num_rows($result) == 0) {

        print '<script>alert("This Order ID is not existed，Please check!")</script>';
    } else {
        $originalbatch = mysqli_fetch_array($result);
        $originalbatch = $originalbatch[0];

        $sql = "DELETE from daifaorders  WHERE (cmpid='" . $cmpid . "') AND orderid='" . $isku . "'";

        $result = mysqli_query($conn, $sql);
        $sql = "SELECT count(fee), sum(fee) from daifaorders  where (cmpid='" . $cmpid . "') and batch='" . $originalbatch . "'";
        $result = mysqli_query($conn, $sql);
        $updateoriginalbatch = mysqli_fetch_array($result);
        $sql = "UPDATE daifa SET orders='" . $updateoriginalbatch[0] . "', servicefee='" . $updateoriginalbatch[1] . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $originalbatch . "'";
        $result = mysqli_query($conn, $sql);
        print '<script>alert("Delete Successful!")</script>';
        print '<script> location.replace("orderupdate.php"); </script>';
    }
}

function checkinput($isku) {
    if (isEmpty($isku)) {
        print '<script>alert("The user name should not be empty!")</script>';
        return FALSE;
    }
    return TRUE;
}
?>

<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Unihorn| Manage System</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- favicon
                    ============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <!-- Google Fonts
                    ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- Bootstrap CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <!-- nalika Icon CSS
                ============================================ -->
        <link rel="stylesheet" href="css/nalika-icon.css">
        <!-- owl.carousel CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/owl.theme.css">
        <link rel="stylesheet" href="css/owl.transitions.css">
        <!-- animate CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/animate.css">
        <!-- normalize CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/normalize.css">
        <!-- meanmenu icon CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/meanmenu.min.css">
        <!-- main CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/main.css">
        <!-- morrisjs CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/morrisjs/morris.css">
        <!-- mCustomScrollbar CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/scrollbar/jquery.mCustomScrollbar.min.css">
        <!-- metisMenu CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/metisMenu/metisMenu.min.css">
        <link rel="stylesheet" href="css/metisMenu/metisMenu-vertical.css">
        <!-- calendar CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/calendar/fullcalendar.min.css">
        <link rel="stylesheet" href="css/calendar/fullcalendar.print.min.css">
        <!-- style CSS
                    ============================================ -->
        <link rel="stylesheet" href="style.css">
        <!-- responsive CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/responsive.css">
        <!-- modernizr JS
                    ============================================ -->
        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>

    <body>
        <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
        <div class="left-sidebar-pro">
            <nav id="sidebar" class="">              
                <div class="nalika-profile">
                    <div class="profile-dtl">
                        <a href="homepage.php"><img src="img/uni.jpg" alt="" /></a>
                        <h2> <?php print $fn; ?> &nbsp;<span class="min-dtn"> <?php print $ln; ?></span></h2>
                    </div>
                    <div class="profile-social-dtl">
                        <ul class="dtl-social">
                            <li><a href="#" onclick="openNewWin('http://www.facebook.com');"><i class="icon nalika-facebook"></i></a></li>
                            <li><a href="#" onclick="openNewWin('http://www.twitter.com');"><i class="icon nalika-twitter"></i></a></li>
                            <li><a href="#" onclick="openNewWin('http://www.linkedin.com');"><i class="icon nalika-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="left-custom-menu-adp-wrap comment-scrollbar">
                    <nav class="sidebar-nav left-sidebar-menu-pro">
                        <ul class="metismenu" id="menu1">

                            <li >
                                <a class="has-arrow" href="homepage.php">
                                    <i class="icon nalika-home icon-wrap"></i>
                                    <span class="mini-click-non">Dashboard</span>
                                </a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Dashboard" href="homepage.php"><span class="mini-sub-pro">Dashboard</span></a></li>                                
                                    <li><a title="Notification" href="notification.php"><span class="mini-sub-pro">Notification</span></a></li>
                                </ul>
                            </li>

                            <li >
                                <a class="has-arrow" href="product-list.php">

                                    <i class="icon nalika-table icon-wrap"></i>
                                    <span class="mini-click-non">Product</span>
                                </a>
                                <ul class="submenu-angle" aria-expanded="false">                                   
                                    <li><a title="Product List" href="product-list.php"><span class="mini-sub-pro">Product List</span></a></li>
                                    <li><a title="Product Edit" href="product-edit.php"><span class="mini-sub-pro">Product Edit</span></a></li>
                                    <li><a title="Product Detail" href="product-detail.php"><span class="mini-sub-pro">Product Detail</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="mailbox.html" aria-expanded="false"><i class="icon nalika-mail icon-wrap"></i> <span class="mini-click-non">Export & Import</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a class="has-arrow" title="Import" href="supply.php"><span >Incoming</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">     
                                            <li><a title="Supply" href="supply.php"><span class="mini-sub-pro">Supply & Return(NC)</span></a></li>
                                            <li><a title="Supply" href="supplysh.php"><span class="mini-sub-pro">Supply & Return(SH)</span></a></li>
                                            <li><a title="Import Stock" href="stockaccept.php"><span class="mini-sub-pro">Import Stock</span></a></li>                                             
                                        </ul>
                                    </li>
                                    <li><a class="has-arrow" title="Export" href="outgoingnc.php"><span >Outgoing</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">   
                                            <li><a title="Order & Replacement" href="outgoingnc.php"><span class="mini-sub-pro">Order & Replace(NC)</span></a></li>
                                            <li><a title="Order & Replacement" href="outgoingsh.php"><span class="mini-sub-pro">Order & Replace(SH)</span></a></li>
                                            <li><a title="Export Stock" href="stocktrans.php"><span class="mini-sub-pro">Export Stock</span></a></li>                                             
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="inventory-1.php" aria-expanded="false"><i class="icon nalika-diamond icon-wrap"></i> <span class="mini-click-non">Warehouse</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Inventory" href="inventory-1.php"><span class="mini-sub-pro">Inventory</span></a></li>
                                    <li><a title="Shanghai" href="recordsh.php"><span class="mini-sub-pro">Record SH</span></a></li>
                                    <li><a title="Greensboro" href="recordnc.php"><span class="mini-sub-pro">Record NC</span></a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="has-arrow" href="bar-charts.html" aria-expanded="false"><i class="icon nalika-bar-chart icon-wrap"></i> <span class="mini-click-non">Charts</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Bar Charts" href="bar-charts.html"><span class="mini-sub-pro">Bar Charts</span></a></li>
                                    <li><a title="Line Charts" href="line-charts.html"><span class="mini-sub-pro">Line Charts</span></a></li>
                                    <li><a title="Area Charts" href="area-charts.html"><span class="mini-sub-pro">Area Charts</span></a></li>
                                    <li><a title="Rounded Charts" href="rounded-chart.html"><span class="mini-sub-pro">Rounded Charts</span></a></li>
                                    <li><a title="C3 Charts" href="c3.html"><span class="mini-sub-pro">C3 Charts</span></a></li>
                                    <li><a title="Sparkline Charts" href="sparkline.html"><span class="mini-sub-pro">Sparkline Charts</span></a></li>
                                    <li><a title="Peity Charts" href="peity.html"><span class="mini-sub-pro">Peity Charts</span></a></li>
                                </ul>
                            </li>
                            <li class="active">
                                <a class="has-arrow" href="static-table.html" aria-expanded="false"><i class="icon nalika-table icon-wrap"></i> <span class="mini-click-non">一件代发</span></a>
                                <ul class="submenu-angle" aria-expanded="false">

                                    <li><a title="Data Table" href="data-table.php"><span class="mini-sub-pro">一件代发汇总</span></a></li>
                                    <li><a href="add-batch.php"><span class="mini-sub-pro">添加批次</span></a></li>              
                                    <li><a href="orderupdate.php"><span class="mini-sub-pro">订单更新</span></a></li>                        
                                    <li><a href="orderinfo.php"><span class="mini-sub-pro">订单汇总</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="#" aria-expanded="false"><i class="icon nalika-new-file icon-wrap"></i> <span class="mini-click-non">Website Link</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Finance" href="bookmark.php"><span class="mini-sub-pro">Bookmark</span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </nav>
        </div>
        <!-- Start Welcome area -->
        <div class="all-content-wrapper">

            <div class="header-advance-area">
                <div class="header-top-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="header-top-wraper">
                                    <div class="row">

                                        <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                            <div class="menu-switcher-pro">
                                                <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="icon nalika-menu-task"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                            <form method="post">
                                                <div class="header-top-menu tabl-d-n">

                                                    <ul class="nav navbar-nav mai-top-nav">
                                                        <li><a>ACCOUNT_ID：</a></li>
                                                        <?php
                                                        foreach ($childid as $x) {
                                                            $title = "UCMP" . $x;
                                                            if ($cmpid == $x) {
                                                                ?>
                                                                <li ><a style='color:rgba(204, 154, 129, 55)'><?php print $title; ?></a>
                                                                </li>
                                                            <?php } else { ?>
                                                                <li ><a><input type="submit" style='background-color:rgba(204, 154, 129, 0);color:fff' name='<?php print $title; ?>' value='<?php print $title; ?>' /></a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                            <div class="header-right-info">
                                                <ul class="nav navbar-nav mai-top-nav header-right-menu">

                                                    <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="icon nalika-menu-task"></i></a>
                                                        <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                            <li><a href="#"><span class="icon nalika-home author-log-ic"></span> Dashboard</a>
                                                                <a title="Dashboard" href="homepage.php"><span class="mini-sub-pro">Dashboard</span></a>                       
                                                                <a title="Notification" href="notification.php"><span class="mini-sub-pro">Notification</span></a>
                                                            </li>

                                                            <li><a href="#"><span class="icon nalika-diamond author-log-ic"></span> Warehouse</a>
                                                            <li><a title="Inventory" href="inventory-1.php"><span class="mini-sub-pro">Inventory</span></a>
                                                                <a title="Shanghai" href="recordsh.php"><span class="mini-sub-pro">Record SH</span></a>
                                                                <a title="Greensboro" href="recordnc.php"><span class="mini-sub-pro">Record NC</span></a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="icon nalika-alarm" aria-hidden="true"></i><span class="<?php if ($totalnotes != 0) print 'indicator-nt' ?>"></span></a>
                                                        <div role="menu" class="notification-author dropdown-menu animated zoomIn">
                                                            <div class="notification-single-top">
                                                                <h1>Notifications</h1>
                                                            </div>
                                                            <ul class="notification-menu">
                                                                <?php
                                                                for ($i = 0; $i < count($datanote) && $i < 3; $i++) {
                                                                    print "<li>
                                                                    <a href='notification.php'>
                                                                        <div class='notification-icon'>
                                                                            <i class='icon nalika-tick' aria-hidden='true'></i>
                                                                        </div>
                                                                        <div class='notification-content'>                                                                            
                                                                            <h2>";
                                                                    print $datanote[$i]['date'];
                                                                    print "</h2>
                                                                            <p>" . $datanote[$i]['subject'] . "</p>
                                                                        </div>
                                                                    </a>
                                                                </li>";
                                                                }
                                                                ?>
                                                            </ul>
                                                            <div class="notification-view">
                                                                <?php if (count($datanote) > 3) print "<a href='notification.php'>View All Notification</a>"; ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                                            <i class="icon nalika-user"></i>
                                                            <span class="admin-name"><?php print $user ?></span>
                                                            <i class="icon nalika-down-arrow nalika-angle-dw"></i>
                                                        </a>
                                                        <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                            <li><a href="register.php"><span class="icon nalika-home author-log-ic"></span> Register</a>
                                                            </li>
                                                            <li><a href="#"><span class="icon nalika-user author-log-ic"></span> My Profile</a>
                                                            </li>
                                                            <li><a href="lock.php"><span class="icon nalika-diamond author-log-ic"></span> Lock</a>
                                                            </li>
                                                            <li><a href="#"><span class="icon nalika-settings author-log-ic"></span> Settings</a>
                                                            </li>
                                                            <li><a href="logout.php"><span class="icon nalika-unlocked author-log-ic"></span> Log Out</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu start -->

                <!-- Mobile Menu end -->
                <div class="breadcome-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="breadcome-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="breadcomb-wp">
                                                <div class="breadcomb-icon">
                                                    <i class="icon nalika-edit"></i>
                                                </div>
                                                <div class="breadcomb-ctn">
                                                    <h2>添加/修改订单信息</h2>
                                                    <p>Welcome to Unihorn Management System <span class="bread-ntd"></span></p>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single pro tab start-->
            <div class="single-product-tab-area mg-b-30">
                <!-- Single pro tab review Start-->
                <div class="single-pro-review-area">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            <div class="breadcome-heading">
                                                <form method="post" role="search" class="">


                                                    <div style="width:200px;float:left;"><input name="searcheditorder" type="text" placeholder="搜索订单号" value="<?php
                                                        if (isset($_SESSION['orderidserchtext'])) {
                                                            print $_SESSION['orderidserchtext'];
                                                        }
                                                        ?>" ></div>
                                                    <div style="color:#fff;width:000px;float:left;">
                                                        <button name="search" type="submit" value="search" class="pd-setting-ed"><i class="fa fa-search-plus" aria-hidden="true"></i></button>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="review-tab-pro-inner">

                                    <div id="myTabContent" class="tab-content custom-product-edit">

                                        <div class="product-tab-list tab-pane fade active in" id="description">
                                            <form name="form" method="post" action="">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="review-content-section">

                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="icon nalika-edit" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">订单号</span>
                                                                <input name='isku' type="text" required="" class="form-control" placeholder="请输入订单号" <?php
                                                                if ($sku) {
                                                                    print "value='" . $sku . "'";
                                                                }
                                                                ?>>
                                                            </div>

                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="icon nalika-menu" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">批次</span>
                                                                <select name="ibatch" class="form-control pro-edt-select form-control-primary">
                                                                    <?php
                                                                    for ($index = 0; $index < @count($data); $index++) {
                                                                        print "<option value='" . $data[$index]['batchname'] . "'";
                                                                        if ($batch == $data[$index]['batchname']) {
                                                                            print " selected";
                                                                        }

                                                                        print ">" . $data[$index]['batchname'] . "</option>";
                                                                    }
                                                                    ?>                                                                   

                                                                </select></div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="icon nalika-info" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">邮寄类型</span>
                                                                <select name="icategory" class="form-control pro-edt-select form-control-primary">

                                                                    <option value="Letter"    <?php
                                                                    if ($category === 'Letter') {
                                                                        print "selected";
                                                                    }
                                                                    ?>>Letter</option>
                                                                    <option value="First Class Package"    <?php
                                                                    if ($category === 'First Class Package') {
                                                                        print "selected";
                                                                    } elseif ($category =='0') {
                                                                        print "selected";
                                                                    }
                                                                    ?>>First Class Package</option>
                                                                    <option value="Priority Package"    <?php
                                                                    if ($category === 'Priority Package') {
                                                                        print "selected";
                                                                    }
                                                                    ?>>Priority Package</option>
                                                                    <option value="UPS Package"  <?php
                                                                    if ($category === 'UPS Package') {
                                                                        print "selected";
                                                                    }
                                                                    ?>>UPS Package</option>

                                                                </select>
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="fa fa-newspaper-o" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">备注</span>
                                                                <input name="inote" type="text"  class="form-control" placeholder="商品名*数量；商品名*数量；..." <?php
                                                                if ($note) {
                                                                    print "value='" . $note . "'";
                                                                }
                                                                ?>>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="review-content-section">                                                            
                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="fa fa-male" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">收件人</span>
                                                                <input name="ireceiver" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($receiver) {
                                                                    print "value='" . $receiver . "'";
                                                                }
                                                                ?>>
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">地址</span>
                                                                <input name="iaddress" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($address) {
                                                                    print "value='" . $address . "'";
                                                                }
                                                                ?>>
                                                            </div>   

                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">城市</span>
                                                                <input name="icity" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($city) {
                                                                    print "value='" . $city . "'";
                                                                }
                                                                ?>>
                                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">州</span>
                                                                <input name="istate" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($city) {
                                                                    print "value='" . $state . "'";
                                                                }
                                                                ?>>
                                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">邮编</span>
                                                                <input name="izipcode" type="text" class="form-control" placeholder="" <?php
                                                                if ($zipcode) {
                                                                    print "value='" . $zipcode . "'";
                                                                }
                                                                ?>>
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">手机</span>
                                                                <input name="iphone" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($phone) {
                                                                    print "value='" . $phone . "'";
                                                                }
                                                                ?>>
                                                                <span class="input-group-addon"><i class="fa fa-car" aria-hidden="true"></i></span>
                                                                <span class="input-group-addon">重量</span>
                                                                <input name="iweight" type="text" required="" class="form-control" placeholder="" <?php
                                                                if ($weight) {
                                                                    print "value='" . $weight . "'";
                                                                }
                                                                ?>>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="text-center custom-pro-edt-ds">
                                                            <input name="save" type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="添加新订单">
                                                            <input name="update" type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="更新订单">
                                                            <input name="delete" type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="删除订单">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div>
                                                <a>说明：<br></a>
                                                <a>1.可添加新订单到选定批次，或者更新现有订单信息。<br></a>
                                                <a>2.服务费根据批次类型定义。<br></a>
                                                <a>3.如需指定订单货物明细，请详细填写备注，格式：商品名*数量；...</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer-copy-right">
                                <p>Copyright © 2019 <a href="https://www.unihorn.tech">Unihorn</a> All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jquery
                    ============================================ -->
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
        <!-- bootstrap JS
                    ============================================ -->
        <script src="js/bootstrap.min.js"></script>
        <!-- wow JS
                    ============================================ -->
        <script src="js/wow.min.js"></script>
        <!-- price-slider JS
                    ============================================ -->
        <script src="js/jquery-price-slider.js"></script>
        <!-- meanmenu JS
                    ============================================ -->
        <script src="js/jquery.meanmenu.js"></script>
        <!-- owl.carousel JS
                    ============================================ -->
        <script src="js/owl.carousel.min.js"></script>
        <!-- sticky JS
                    ============================================ -->
        <script src="js/jquery.sticky.js"></script>
        <!-- scrollUp JS
                    ============================================ -->
        <script src="js/jquery.scrollUp.min.js"></script>
        <!-- mCustomScrollbar JS
                    ============================================ -->
        <script src="js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="js/scrollbar/mCustomScrollbar-active.js"></script>
        <!-- metisMenu JS
                    ============================================ -->
        <script src="js/metisMenu/metisMenu.min.js"></script>
        <script src="js/metisMenu/metisMenu-active.js"></script>
        <!-- sparkline JS
                    ============================================ -->
        <script src="js/sparkline/jquery.sparkline.min.js"></script>
        <script src="js/sparkline/jquery.charts-sparkline.js"></script>
        <!-- calendar JS
                    ============================================ -->
        <script src="js/calendar/moment.min.js"></script>
        <script src="js/calendar/fullcalendar.min.js"></script>
        <script src="js/calendar/fullcalendar-active.js"></script>
        <!-- float JS
                ============================================ -->
        <script src="js/flot/jquery.flot.js"></script>
        <script src="js/flot/jquery.flot.resize.js"></script>
        <script src="js/flot/curvedLines.js"></script>
        <script src="js/flot/flot-active.js"></script>
        <!-- plugins JS
                    ============================================ -->
        <script src="js/plugins.js"></script>
        <!-- main JS
                    ============================================ -->
        <script src="js/main.js"></script>


        <script type="text/javascript">
                                function openNewWin(url)
                                {
                                    window.open(url);
                                }
        </script>
    </body>

</html>