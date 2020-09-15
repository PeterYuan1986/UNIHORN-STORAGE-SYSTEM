<?php
require_once 'header.php';
$pageoffice = 'all';           //设置页面属性 office ：  nc, sh, all
$pagelevel = 0;       // //设置页面等级 0： 只有admin可以访问； 1：库存系统用户； 2:代发用户
check_session_expiration();
$user = $_SESSION['user_info']['userid'];
$fn = $_SESSION['user_info']['firstname'];
$ln = $_SESSION['user_info']['lastname'];
$useroffice = $_SESSION['user_info']['office'];
$userlevel = $_SESSION['user_info']['level'];           //userlevel  0: admin; else;
$cmpid = $_SESSION['user_info']['cmpid'];
$childid = $_SESSION['user_info']['childid'];
check_access($useroffice, $userlevel, $pageoffice, $pagelevel);

if (isset($_GET['id'])) {
    $batch = $_GET['id'];
    $sql = "SELECT  class, type FROM `daifa` WHERE (cmpid='" . $cmpid . "') AND batchname='" . $batch . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $batchclass = $row[0];
    $batchtype = $row[1];
} else {
    header('location: data-table.php');
}

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

if (isset($_POST['modify'])) {

//class没变，看包裹类型是否变，如果变了的话，更新服务费
    if ($_POST['class'] == $batchclass) {
        if ($batchclass == 0) {
            if ($_POST['type'] == 0 && $batchtype != 'Letter') {
                $sql = "UPDATE daifaorders set fee='" . $letterfee . "'  where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "1".$sql;
                $result = mysqli_query($conn, $sql);
                $sql = "UPDATE daifa set type='Letter'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                //print "2".$sql;
                $result = mysqli_query($conn, $sql);
            }
            if ($_POST['type'] == 1 && $batchtype == 'Letter') {
                $sql = "UPDATE daifaorders set fee='" . $packagefee . "'  where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "3".$sql;
                $result = mysqli_query($conn, $sql);
                $sql = "UPDATE daifa set type='Package'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                //print "4".$sql;
                $result = mysqli_query($conn, $sql);
            }
        } else {
            if ($_POST['type'] == 0 && $batchtype != 'Letter') {

                $sql = "UPDATE daifa set type='Letter'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                //print "5".$sql;
                $result = mysqli_query($conn, $sql);
            }
            if ($_POST['type'] == 1 && $batchtype == 'Letter') {

                $sql = "UPDATE daifa set type='Package'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                //print "6".$sql;
                $result = mysqli_query($conn, $sql);
            }
        }
    } else {


//class变了，全部更新

        if ($_POST['class'] == 0) {
            if ($_POST['type'] == 0) {
                if ($batchtype != 'Letter') {
                    $sql = "UPDATE daifa set type='Letter', class='0' where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "7".$sql;
                    $result = mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE daifa set class='0'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "8".$sql;
                    $result = mysqli_query($conn, $sql);
                }
                $sql = "UPDATE daifaorders set fee='" . $letterfee . "'  where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "9".$sql;
                $result = mysqli_query($conn, $sql);
            } if ($_POST['type'] == 1) {

                if ($batchtype == 'Letter') {
                    $sql = "UPDATE daifa set type='Package', class='0'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "10".$sql;
                    $result = mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE daifa set class='0'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "11".$sql;
                    $result = mysqli_query($conn, $sql);
                }
                $sql = "UPDATE daifaorders set fee='" . $packagefee . "'  where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "12".$sql;
                $result = mysqli_query($conn, $sql);
            }
        } else {
            if ($_POST['type'] == 0) {
                if ($batchtype != 'Letter') {
                    $sql = "UPDATE daifa set type='Letter', class='1' where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "13".$sql;
                    $result = mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE daifa set class='1'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "14".$sql;
                    $result = mysqli_query($conn, $sql);
                }
                $sql = "UPDATE daifaorders set fee= amount*" . $amountfee . "+" . $originalpackagefee . " where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "15".$sql;
                $result = mysqli_query($conn, $sql);
            } if ($_POST['type'] == 1) {
                if ($batchtype == 'Letter') {
                    $sql = "UPDATE daifa set type='Package', class='1'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "16".$sql;
                    $result = mysqli_query($conn, $sql);
                } else {
                    $sql = "UPDATE daifa set class='1'  where (cmpid='" . $cmpid . "') and batchname='" . $batch . "'";
                    //print "17".$sql;
                    $result = mysqli_query($conn, $sql);
                }

                $sql = "UPDATE daifaorders set fee= amount*" . $amountfee . "+" . $originalpackagefee . " where (cmpid='" . $cmpid . "') and batch='" . $batch . "'";
                //print "18".$sql;

                $result = mysqli_query($conn, $sql);
            }
        }
    }
}











if (isset($_POST['save'])) {
    if (!isset($_FILES["file"])) {
        echo "<script> alert('请上传csv文件!')</script>";
    } else { {
            $allowedExts = array(
                'text/txt',
                'text/csv',
                'text/plain',
                'application/csv',
                'text/comma-separated-values',
                'application/excel',
                'application/xlsx',
                'application/vnd.ms-excel',
                'application/vnd.msexcel',
                'text/anytext',
                'application/octet-stream',
                'application/txt',
            );
            $temp = explode(".", @$_FILES["file"]["name"]);
            $_FILES["file"]["size"];
            $extension = end($temp);     // 获取文件后缀名
            if (in_array(@$_FILES["file"]["type"], $allowedExts)) {
                if (@$_FILES["file"]["error"] > 0) {
// echo "错误：: " . @$_FILES["file"]["error"] . "<br>";
                    echo "<script> alert('Error,请联系管理员！')</script>";
                } else {
// echo "上传文件名: " . @$_FILES["file"]["name"] . "<br>";
// echo "文件类型: " . @$_FILES["file"]["type"] . "<br>";
// echo "文件大小: " . (@$_FILES["file"]["size"] / 1024) . " kB<br>";
// echo "文件临时存储的位置: " . @$_FILES["file"]["tmp_name"] . "<br>";
//判断当期目录下的 upload 目录是否存在该文件
//如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                    move_uploaded_file(@$_FILES["file"]["tmp_name"], "./upload/tempupload.csv");
//echo "文件存储在: " . "upload/" . $_SESSION['daifabatchname'].".csv". "<br>";


                    @$filepath = @fopen("./upload/tempupload.csv", 'r');
                    @$content = fgetcsv($filepath);
                    try {
                        while (@$content = fgetcsv($filepath)) {    //每次读取CSV里面的一行内容      
                            $sql = "UPDATE daifaorders SET carrier='" . $content[24] . "', service='" . $content[25] . "', tracking='" . $content[3] . "', cost='" . str_replace('$', '', $content[4]) . "' WHERE (cmpid='" . $cmpid . "') AND orderid='" . $content[27] . "'";
                            $result = mysqli_query($conn, $sql);
                            if ($_POST['checkbox'] != NULL) {
                                $pattern = '/(([a-zA-Z0-9]|\-|\.)+\*)/';  //匹配inote里的整数
                                preg_match($pattern, $content[28], $match);
                                $prex = str_replace("*", "", $match[0]);
                                $pattern = '/(\*\d+(;|；))/';  //匹配inote里的整数
                                preg_match($pattern, $content[28], $match);
                                $prey = str_replace("*", "", $match[0]);
                                $prey = str_replace(";", "", $prey);
                                $prey = str_replace("*", "", $prey);
                                $productlist = json_encode(array($prex, $prey));
                                $sql = "INSERT INTO `ncstock`(date, productlist, subject, ordernumber, market, tracking, ship, cmpid) VALUES ('" . $str . "','" . $productlist . "','order' ,'" . $content[27] . "','" . $_POST['mkt'] . "','" . $content[3] . "','" . $content[24] . "','" . $cmpid . "')";
                                $result = mysqli_query($conn, $sql);
                                $sql = "UPDATE product SET nc=nc-" . $prey . " where (cmpid='" . $cmpid . "') AND sku='" . $prex . "'";
                                mysqli_query($conn, $sql);
                                $sql = "UPDATE product SET sold=sold+" . $prey . " where (cmpid='" . $cmpid . "') AND sku='" . $prex . "'";
                                mysqli_query($conn, $sql);
                            }
                        }
                        if ($result) {
                            $sql = "SELECT cost, fee FROM daifaorders where (cmpid='" . $cmpid . "') AND batch='" . $batch . "'";
                            $result = mysqli_query($conn, $sql);
                            while ($arr = mysqli_fetch_array($result)) {
                                $data[] = $arr;
                            }
                            $totalcost = 0;
                            $totalfee = 0;
                            for ($index = 0; $index < @count($data); $index++) {
                                $totalcost = $totalcost + $data[$index][0];
                                $totalfee = $totalfee + $data[$index][1];
                            }
                            $sql = "UPDATE daifa SET time=CURRENT_TIME, status='SHIPPED', shippingcost='" . $totalcost . "', servicefee='" . $totalfee . "' WHERE (cmpid='" . $cmpid . "') AND batchname='" . $batch . "'";
                            $result = mysqli_query($conn, $sql);
                            echo "<script> alert('文件上传成功！')</script>";
                            print '<script> location.replace("data-table.php"); </script>';
                        }
                    } catch (Exception $ex) {
                        
                    }


                    @fclose(@$filepath);
                    @unlink("./upload/tempupload.csv");
                }
            } else {
                echo "<script> alert('请上传csv文件!')</script>";
            }
        }
    }
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

                            <li>
                                <a class="has-arrow" href="homepage.php">
                                    <i class="icon nalika-home icon-wrap"></i>
                                    <span class="mini-click-non">Dashboard</span>
                                </a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Dashboard" href="homepage.php"><span class="mini-sub-pro">Dashboard</span></a></li>                                
                                    <li><a title="Notification" href="notification.php"><span class="mini-sub-pro">Notification</span></a></li>
                                </ul>
                            </li>

                            <li>
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
                                            <li><a title="Batch Order" href="add-batch.php"><span class="mini-sub-pro">Batch Order</span></a></li>
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
                                <a class="has-arrow" href="static-table.html" aria-expanded="false"><i class="icon nalika-table icon-wrap"></i> <span class="mini-click-non">批量发货</span></a>
                                <ul class="submenu-angle" aria-expanded="false">

                                    <li><a title="Data Table" href="data-table.php"><span class="mini-sub-pro">批量发货汇总</span></a></li>
                                    <li><a href="add-batch.php"><span class="mini-sub-pro">添加批次</span></a></li>            
                                    <li><a href="orderupdate.php"><span class="mini-sub-pro">订单更新</span></a></li>                                    
                                    <li><a href="orderinfo.php"><span class="mini-sub-pro">订单汇总</span></a></li>
                                </ul>
                            </li>
                            <li id="removable">
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
                                                    <h2>批次信息上传</h2>
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
                                <div class="review-tab-pro-inner">
                                    <ul id="myTab3" class="tab-review-design">
                                        <li class="active"><a href="#description"><i class="icon nalika-edit" aria-hidden="true"></i> UPLOAD Batch INFO</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content custom-product-edit">

                                        <div class="product-tab-list tab-pane fade active in" id="description">
                                            <form name="form" method="post" action="" enctype="multipart/form-data">
                                                <div class="row">

                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="review-content-section">                                                            

                                                            <div class="input-group mg-b-pro-edt">
                                                                <input name="file" type="file" size="16" maxlength="200" accept="application/csv" style="color:yellow">

                                                            </div><div>
                                                                <input name="checkbox" type="checkbox" value="1"> <a style="color:white">真仓(选中将从实际库存中扣除相应数量)&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <a style="color:white">销售平台</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="mkt" type="radio" value="Amazon"  checked><a style="color:yellow">Amazon</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="mkt" type="radio" value="Newegg"  ><a style="color:yellow">Newegg</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>  
                                                                <input name="mkt" type="radio" value="Ebay"  ><a style="color:yellow">Ebay</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="text-center custom-pro-edt-ds">
                                                                <input name="save" type="submit" class="btn btn-ctl-bt waves-effect waves-light m-r-10" value="ADD NEW">                                                            
                                                                <a href='data-table.php' class="btn btn-ctl-bt waves-effect waves-light">Discard
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="review-content-section">                                                            
                                                            <div class="input-group mg-b-pro-edt">
                                                                <a style="color:white">批次包裹类型</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="type" type="radio" value="0" <?php if ($batchtype == "Letter") print "checked"; ?> ><a style="color:yellow">Letter</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="type" type="radio" value="1" <?php if ($batchtype != "Letter") print "checked"; ?> ><a style="color:yellow">Package</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>           
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">
                                                                <a style="color:white">批次计费类型</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="class" type="radio" value="0" <?php if ($batchclass != 1) print "checked"; ?> ><a style="color:yellow">By Package Type</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>
                                                                <input name="class" type="radio" value="1" <?php if ($batchclass == 1) print "checked"; ?> ><a style="color:yellow">By Amount</a>
                                                                <a>&nbsp;&nbsp;&nbsp;</a>        
                                                            </div>
                                                            <div class="input-group mg-b-pro-edt">

                                                                <input name="modify" type="submit" value="修改">            
                                                            </div>

                                                        </div>
                                                    </div>



                                            </form>
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