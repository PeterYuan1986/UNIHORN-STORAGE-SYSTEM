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
$datanote = check_note($cmpid);
$totalnotes = sizeof($datanote);
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

if (isset($_POST['payoff'])) {

    if ($userlevel != 0) {
        print "<script> alert('请联系管理员进行操作!')</script>";
    } else {
        $sql = "UPDATE daifa SET paid='1' where status='SHIPPED' and cmpid='" . $cmpid . "'";
        mysqli_query($conn, $sql);
    }
}
?>
<?php
$columns = array('batchname', 'time', 'type', 'dhltracking', 'orders', 'status', 'paid');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[1];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
//$perpage = 20;

if(!isset($_SESSION['data-table_searchtest'])){
    $_SESSION['data-table_searchtest']='';
}
if (isset($_POST['search'])) {
    $_SESSION['data-table_searchtest'] = $_POST['searchtext'];
    $pendingsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and status='PENDING' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%'  or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
    $shippedsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and status='SHIPPED' and paid ='0' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
    $paidsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and paid ='1' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
} else {
    $pendingsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and status='PENDING' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%'  or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
    $shippedsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and status='SHIPPED' and paid ='0' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
    $paidsql = "SELECT * FROM daifa where cmpid='" . $cmpid . "' and paid ='1' and (batchname LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or dhltracking LIKE '%" . $_SESSION['data-table_searchtest'] . "%' or type LIKE '%" . $_SESSION['data-table_searchtest'] . "%') ORDER BY " . $column . ' ' . $sort_order;
    $_SESSION['data-table_searchtest'] = '';
}

$pendingresult = mysqli_query($conn, $pendingsql);
$shippedresult = mysqli_query($conn, $shippedsql);
$paidresult = mysqli_query($conn, $paidsql);
$totalrow = mysqli_num_rows($pendingresult);
//$totalpage = ceil($totalrow / $perpage);


$up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
$add_class = ' class="highlight"';

while ($arr1 = mysqli_fetch_array($pendingresult)) {
    $pendingdata[] = $arr1;
}
while ($arr2 = mysqli_fetch_array($shippedresult)) {
    $shippeddata[] = $arr2;
}
while ($arr3 = mysqli_fetch_array($paidresult)) {
    $paiddata[] = $arr3;
}

//    if (empty(@$_GET['page']) || !is_numeric(@$_GET['page']) || @$_GET['page'] < 1 || @$_GET['page'] > $totalpage) {
//       $page = 1;
//    } else
//        $page = $_GET['page'];
?>




<?php
// for ($i = 0; $i < $perpage; $i++) {
//      $ind = ($page - 1) * $perpage + $i;
//   if ($ind >= count($data))
//        break;
//   else {

if (isEmpty(@$pendingdata)) {
    for ($i = 0; $i < @count(@$pendingdata); $i++) {
        $tem = "pendingtrash" . $i;
        if (isset($_POST["{$tem}"])) {
            $_POST["{$tem}"] = 0;
            $sql = "DELETE FROM daifa WHERE cmpid='" . $cmpid . "' and batchname='" . $pendingdata[$i]['batchname'] . "'";
            print $sql;
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM daifaorders WHERE  cmpid='" . $cmpid . "' and batch='" . $pendingdata[$i]['batchname'] . "'";
            mysqli_query($conn, $sql);
            unlink("./upload/" . $pendingdata[$i]['batchname'] . ".csv");
            header('location: ' . $_SERVER['HTTP_REFERER']);
            break;
        }
    }

    for ($i = 0; $i < @count(@$pendingdata); $i++) {
        $tem = "pendingedit" . $i;
        if (isset($_POST["{$tem}"])) {
            print "<script>window.open('./update-batch.php?id=" . $pendingdata[$i]['batchname'] . "')</script>";
            break;
        }
    }
}
?>
<?php
if (isEmpty(@$shippeddata)) {
    for ($a = 0; $a < @count(@$shippeddata); $a++) {
        $temm = "ship" . $a;
        if (isset($_POST["{$temm}"])) {
            print $a . "+++++++++++++++++++++++++++++++";
            print "<script>window.open('./update-batch.php?id=" . $shippeddata[$a]['batchname'] . "')</script>";
            break;
        }
    }

    for ($a = 0; $a < @count(@$shippeddata); $a++) {

        $tem = "shippay" . $a;
        if (isset($_REQUEST["{$tem}"])) {
            $_REQUEST["{$tem}"] = 0;
            $cost = $pendingdata[$a]['shippingcost'] + $shippeddata[$a]['servicefee'];
            if ($cost > 0) {
                print "<script>window.open('./pay/pay.php?id=" . $shippeddata[$a]['batchname'] . "&cost=" . $cost . "')</script>";
            } else {
                echo "<script> alert('请等待快递单号上传后结算！')</script>";
            }

            break;
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
                                                    <h2>一件代发汇总</h2>
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

            <div class="product-status mg-b-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-status-wrap">
                                <h4>一件代发汇总</h4>
                                <div class="add-product" >
                                    <a  href="add-batch.php">添加批次</a>
                                </div>
                                <div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            <div class="breadcome-heading">
                                                <form method="post" role="search" class="">


                                                    <div style="width:200px;float:left;"><input name="searchtext" type="text" placeholder="Search Content....." value="<?php
                                                                if (isset($_SESSION['data-table_searchtest'])) {
                                                                    print $_SESSION['data-table_searchtest'];
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

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="product-payment-inner-st">
                                        <ul id="myTab4" class="tab-review-design">
                                            <li class="active"><a href="#pending">PENDING</a></li>
                                            <li><a href="#shipped"> SHIPPED</a></li>
                                            <li><a href="#paid">PAID</a></li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content custom-product-edit">

                                            <div class="product-tab-list tab-pane fade active in" id="pending">
                                                <form action="" method="post" name="form">
                                                    <div>
                                                        <table >
                                                            <tr>
                                                            <th><a style="color: #fff" href="data-table.php?column=batchname&order=<?php echo $asc_or_desc; ?>">批次名称<i class=" fa fa-sort<?php echo $column == 'batchname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=time&order=<?php echo $asc_or_desc; ?>">上次更新时间 <i class=" fa fa-sort<?php echo $column == 'time' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=type&order=<?php echo $asc_or_desc; ?>">邮寄类型 <i class="fa fa-sort<?php echo $column == 'type' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=orders&order=<?php echo $asc_or_desc; ?>">订单总数<i class="fa fa-sort<?php echo $column == 'orders' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=dhltracking&order=<?php echo $asc_or_desc; ?>">Tracking No. <i class="fa fa-sort<?php echo $column == 'dhltracking' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" >批次USPS邮费</a></th>
                                                            <th><a style="color: #fff" >批次服务费</a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=status&order=<?php echo $asc_or_desc; ?>">状态<i class="fa fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th>Setting</th>



                                                            </tr>



                                                            <?php
// if ($totalrow != 0) {
//    for ($i = 0; $i < $perpage; $i++) {
//       $index = ($page - 1) * $perpage + $i;
//      if ($index >= count($data))
//           break;
//      else {
                                                            for ($index = 0; $index < @count($pendingdata); $index++) {
                                                                print '<tr>';
                                                                print "<td><a href='batchinfo.php?id={$pendingdata[$index]['batchname']}' style='color: #ff0'>{$pendingdata[$index]['batchname']}</a></td>";
                                                                print "<td>{$pendingdata[$index]['time']}</td>";
                                                                print "<td>{$pendingdata[$index]['type']}</td>";
                                                                print "<td>{$pendingdata[$index]['orders']}</td>";
                                                                print "<td><a style='color:#ff4' onclick=\"openNewWin('https://www.dhl.com/en/express/tracking.html?brand=DHL&AWB={$pendingdata[$index]['dhltracking']}')\" >{$pendingdata[$index]['dhltracking']}</td>";
                                                                print "<td>{$pendingdata[$index]['shippingcost']}</td>";
                                                                if ($pendingdata[$index]['type'] == "Letter") {
                                                                    $rate = 0.2;
                                                                } else {
                                                                    $rate = 0.4;
                                                                }
                                                                print "<td>" . $rate * $pendingdata[$index]['orders'] . "</td>";
                                                                print "<td>{$pendingdata[$index]['status']}</td>";
                                                                $edit = "pendingedit" . $index;
                                                                $trash = "pendingtrash" . $index;
                                                                ?>

                                                                <td>
                                                                <button data-toggle="tooltip" name ="<?php print $edit; ?>"    type="submit" title="上传单号" onclick="return confirmation()" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                                <button data-toggle="tooltip" name ="<?php print $trash; ?>"    type="submit" title="删除批次" onclick="return confirmation()" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></button>

                                                                </td >
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </table>
                                                    </div> 
                                                </form>
                                            </div>
                                            <div class="product-tab-list tab-pane fade" id="shipped">
                                                <form action="" method="post" name="form">
                                                    <div>
                                                        <table >
                                                            <tr>
                                                            <th><a style="color: #fff" href="data-table.php?column=batchname&order=<?php echo $asc_or_desc; ?>">批次名称<i class=" fa fa-sort<?php echo $column == 'batchname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=time&order=<?php echo $asc_or_desc; ?>">上次更新时间 <i class=" fa fa-sort<?php echo $column == 'time' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=type&order=<?php echo $asc_or_desc; ?>">邮寄类型 <i class="fa fa-sort<?php echo $column == 'type' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=orders&order=<?php echo $asc_or_desc; ?>">订单总数<i class="fa fa-sort<?php echo $column == 'orders' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=dhltracking&order=<?php echo $asc_or_desc; ?>">Tracking No. <i class="fa fa-sort<?php echo $column == 'dhltracking' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" >批次USPS邮费</a></th>
                                                            <th><a style="color: #fff" >批次服务费</a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=status&order=<?php echo $asc_or_desc; ?>">状态<i class="fa fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=paid&order=<?php echo $asc_or_desc; ?>">结算<i class="fa fa-sort<?php echo $column == 'paid' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th>Setting</th>
                                                            </tr>

                                                            <?php
// if ($totalrow != 0) {
//    for ($i = 0; $i < $perpage; $i++) {
//       $index = ($page - 1) * $perpage + $i;
//      if ($index >= count($shippeddata))
//           break;
//      else {/*
                                                            $shipping_unpaid_shipped = 0;
                                                            $service_unpaid_shipped = 0;
                                                            for ($shippedindex = 0; $shippedindex < @count($shippeddata); $shippedindex++) {
                                                                print '<tr>';
                                                                print "<td><a href='batchinfo.php?id={$shippeddata[$shippedindex]['batchname']}' style='color: #ff0'>{$shippeddata[$shippedindex]['batchname']}</a></td>";
                                                                print "<td>{$shippeddata[$shippedindex]['time']}</td>";
                                                                print "<td>{$shippeddata[$shippedindex]['type']}</td>";
                                                                print "<td>{$shippeddata[$shippedindex]['orders']}</td>";
                                                                print "<td><a style='color:#ff4' onclick=\"openNewWin('https://www.dhl.com/en/express/tracking.html?brand=DHL&AWB={$shippeddata[$shippedindex]['dhltracking']}')\" >{$shippeddata[$shippedindex]['dhltracking']}</td>";
                                                                print "<td>{$shippeddata[$shippedindex]['shippingcost']}</td>";
                                                                $shipping_unpaid_shipped = $shipping_unpaid_shipped + $shippeddata[$shippedindex]['shippingcost'];
                                                                if ($shippeddata[$shippedindex]['type'] == "Letter") {
                                                                    $rate = 0.2;
                                                                } else {
                                                                    $rate = 0.4;
                                                                }
                                                                print "<td>" . $rate * $shippeddata[$shippedindex]['orders'] . "</td>";
                                                                $service_unpaid_shipped = $service_unpaid_shipped + $rate * $shippeddata[$shippedindex]['orders'];
                                                                print "<td>{$shippeddata[$shippedindex]['status']}</td>";
                                                                if (!$shippeddata[$shippedindex]['paid']) {
                                                                    $pay = "shippay" . $shippedindex;
                                                                    ?>
                                                                    <td>
                                                                    <button data-toggle="tooltip" name ="<?php print $pay; ?>"    type="submit" title="结算" onclick="return confirmation()" class="pd-setting-ed"><i class="fa fa-money" aria-hidden="true"></i></button>


                                                                    <?php
                                                                } else {
                                                                    print "<td>PAID</td>";
                                                                }

                                                                $edit = "ship" . $shippedindex;
                                                                ?>

                                                                <td>
                                                                <button data-toggle="tooltip"   name ="<?php print $edit; ?>"  type="submit" title="上传USPS单号" onclick="return confirmation()" class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                                </td >
                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </table>
                                                    </div>
                                                    <div> <a>邮费共计: <?php print '$' . $shipping_unpaid_shipped; ?>：</a>
                                                        <a>服务费共: <?php print '$' . $service_unpaid_shipped; ?>：</a>
                                                        <a>总计: <?php print '$' . ($shipping_unpaid_shipped + $service_unpaid_shipped); ?></a> </div>
                                                    <div> <input   type="submit" name="payoff" value="结算"  >  </div>
                                                </form>
                                            </div>
                                            <div class="product-tab-list tab-pane fade" id="paid">
                                                <form action="" method="post" name="form">
                                                    <div>
                                                        <table >
                                                            <tr>
                                                            <th><a style="color: #fff" href="data-table.php?column=batchname&order=<?php echo $asc_or_desc; ?>">批次名称<i class=" fa fa-sort<?php echo $column == 'batchname' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=time&order=<?php echo $asc_or_desc; ?>">上次更新时间 <i class=" fa fa-sort<?php echo $column == 'time' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=type&order=<?php echo $asc_or_desc; ?>">邮寄类型 <i class="fa fa-sort<?php echo $column == 'type' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=orders&order=<?php echo $asc_or_desc; ?>">订单总数<i class="fa fa-sort<?php echo $column == 'orders' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=dhltracking&order=<?php echo $asc_or_desc; ?>">Tracking No. <i class="fa fa-sort<?php echo $column == 'dhltracking' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" >批次USPS邮费</a></th>
                                                            <th><a style="color: #fff" >批次服务费</a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=status&order=<?php echo $asc_or_desc; ?>">状态<i class="fa fa-sort<?php echo $column == 'status' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                            <th><a style="color: #fff" href="data-table.php?column=paid&order=<?php echo $asc_or_desc; ?>">结算<i class="fa fa-sort<?php echo $column == 'paid' ? '-' . $up_or_down : ''; ?>"></i></a></th>




                                                            </tr>



                                                            <?php
// if ($totalrow != 0) {
//    for ($i = 0; $i < $perpage; $i++) {
//       $index = ($page - 1) * $perpage + $i;
//      if ($index >= count($paiddata))
//           break;
//      else {
                                                            for ($index = 0; $index < @count($paiddata); $index++) {
                                                                print '<tr>';
                                                                print "<td><a href='batchinfo.php?id={$paiddata[$index]['batchname']}' style='color: #ff0'>{$paiddata[$index]['batchname']}</a></td>";
                                                                print "<td>{$paiddata[$index]['time']}</td>";
                                                                print "<td>{$paiddata[$index]['type']}</td>";
                                                                print "<td>{$paiddata[$index]['orders']}</td>";
                                                                print "<td><a style='color:#ff4' onclick=\"openNewWin('https://www.dhl.com/en/express/tracking.html?brand=DHL&AWB={$paiddata[$index]['dhltracking']}')\" >{$paiddata[$index]['dhltracking']}</td>";
                                                                print "<td>{$paiddata[$index]['shippingcost']}</td>";
                                                                if ($paiddata[$index]['type'] == "Letter") {
                                                                    $rate = 0.2;
                                                                } else {
                                                                    $rate = 0.4;
                                                                }
                                                                print "<td>" . $rate * $paiddata[$index]['orders'] . "</td>";
                                                                print "<td>{$paiddata[$index]['status']}</td>";
                                                                if (!$paiddata[$index]['paid']) {
                                                                    $pay = "pay" . $index;
                                                                    ?>
                                                                    <td>
                                                                    <button data-toggle="tooltip" name ="<?php print $pay; ?>"    type="submit" title="结算" onclick="return confirmation()" class="pd-setting-ed"><i class="fa fa-money" aria-hidden="true"></i></button>


                                                                    <?php
                                                                } else {
                                                                    print "<td>PAID</td>";
                                                                }
                                                                ?>

                                                                </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                        </table>
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

                                                                function confirmation(url) {

                                                                    return confirm('Are you sure?');
                                                                }


        </script>
    </body>

</html>