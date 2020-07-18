<?php
require_once 'header.php';
$pageoffice = 'all';           //设置页面属性 office ：  nc, sh, all
$pagelevel = 1;       // //设置页面等级 0： 只有admin可以访问； 1：库存系统用户； 2:代发用户
check_session_expiration();
$user = $_SESSION['user_info']['userid'];
$fn = $_SESSION['user_info']['firstname'];
$ln = $_SESSION['user_info']['lastname'];
$useroffice = $_SESSION['user_info']['office'];
$userlevel = $_SESSION['user_info']['level'];
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

$columns = array('sku', 'brand', 'category', 'price', 'ram', 'cpu', 'quality', 'shanghai', 'transit', 'nc', 'sold');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'desc' ? 'DESC' : 'ASC';
$search = "";

if (isset($_POST['search'])) {

    $sql = "SELECT * FROM product where cmpid='" . $cmpid . "' and sku LIKE '%" . @$_POST['inventorysearchtext'] . "%' ORDER BY " . $column . ' ' . $sort_order;
} else {
    $sql = "SELECT * FROM product where cmpid='" . $cmpid . "' ORDER BY " . $column . ' ' . $sort_order;
}
$result = mysqli_query($conn, $sql);
$totalrow = mysqli_num_rows($result);
//$totalpage = ceil($totalrow / $perpage);
if ($totalrow != 0) {
    $up_or_down = str_replace(array('ASC', 'DESC'), array('up', 'down'), $sort_order);
    $asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
    $add_class = ' class="highlight"';

    while ($arr = mysqli_fetch_array($result)) {
        $data[] = $arr;
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
                            <li class="active">
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
                            <li>
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
        <!-- Mobile Menu end -->
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
                                                <button type="button"  class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="fa fa-bars"></i>
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
                                                            <?php }
                                                        } ?>
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
                                                    <i class="icon nalika-diamond"></i>
                                                </div>
                                                <div class="breadcomb-ctn">
                                                    <h2>Warehouse</h2>
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
                                <h4>Inventory</h4>

                                <div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            <div class="breadcome-heading">
                                                <form method="post" role="search" class="">


                                                    <div style="width:200px;float:left;"><input name="inventorysearchtext" type="text" placeholder="Search Content....." value="<?php
                                                        if (isset($_POST['inventorysearchtext'])) {
                                                            print $_POST['inventorysearchtext'];
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
                                <form action="" method="post" name="form">


                                    <table >

                                        <tr>
                                        <th><a style="color: #fff" href="inventory-1.php?column=sku&order=<?php echo $asc_or_desc; ?>">Product SKU <i class=" fa fa-sort<?php echo $column == 'sku' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=brand&order=<?php echo $asc_or_desc; ?>">Brand <i class=" fa fa-sort<?php echo $column == 'brand' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=category&order=<?php echo $asc_or_desc; ?>">Category <i class="fa fa-sort<?php echo $column == 'category' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=price&order=<?php echo $asc_or_desc; ?>">Original Price <i class="fa fa-sort<?php echo $column == 'price' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=ram&order=<?php echo $asc_or_desc; ?>">RAM Type <i class="fa fa-sort<?php echo $column == 'ram' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=cpu&order=<?php echo $asc_or_desc; ?>">Cpu Type <i class="fa fa-sort<?php echo $column == 'cpu' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=quality&order=<?php echo $asc_or_desc; ?>">Quality <i class="fa fa-sort<?php echo $column == 'quality' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=sold&order=<?php echo $asc_or_desc; ?>">Sold <i class="fa fa-sort<?php echo $column == 'sold' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=shanghai&order=<?php echo $asc_or_desc; ?>">SH Inventory <i class="fa fa-sort<?php echo $column == 'shanghai' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=transit&order=<?php echo $asc_or_desc; ?>">In Transit <i class="fa fa-sort<?php echo $column == 'transit' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                        <th><a style="color: #fff" href="inventory-1.php?column=nc&order=<?php echo $asc_or_desc; ?>">NC Inventory <i class="fa fa-sort<?php echo $column == 'nc' ? '-' . $up_or_down : ''; ?>"></i></a></th>

                                        </tr>



                                        <?php
                                        $ncall = 0;
                                        $shall = 0;
                                        $transitall = 0;
                                        $all = 0;
                                        if ($totalrow != 0) {
                                            //for ($i = 0; $i < $perpage; $i++) {
                                            //$index = ($page - 1) * $perpage + $i;
                                            //if ($index >= count($data))
                                            //break;
                                            //else {

                                            for ($index = 0; $index < count($data); $index++) {
                                                print '<tr>';

                                                print "<td>{$data[$index]['sku']}</td>";
                                                print "<td>{$data[$index]['brand']}</td>";
                                                print "<td>{$data[$index]['category']}</td>";
                                                print "<td>{$data[$index]['price']}</td>";
                                                print "<td>{$data[$index]['ram']}</td>";
                                                print "<td>{$data[$index]['cpu']}</td>";
                                                print "<td>{$data[$index]['quality']}</td>";
                                                print "<td>{$data[$index]['sold']}</td>";
                                                print "<td>{$data[$index]['shanghai']}</td>";
                                                print "<td>{$data[$index]['transit']}</td>";
                                                print "<td>{$data[$index]['nc']}</td>";

                                                print "</tr>";
                                                $transitall = $data[$index]['transit'] + $transitall;
                                                $shall = $data[$index]['shanghai'] + $shall;
                                                $ncall = $data[$index]['nc'] + $ncall;
                                                $all = $transitall + $shall + $ncall;
                                            }
                                        }
                                        ?>
                                    </table>
                                    <!-- <div class="custom-pagination "  >
                                         <ul class="pagination ">
 
                                    
                                    <?php
                                    for ($i = 1; $i <= $totalpage; $i++) {
                                        if ($i == $page) {
                                            printf("<li ><a >%d</a></li>", $i);
                                        } else {
                                            printf("<li class='page-item'><a class='page-link' href='%s?page=%d'>%d</a></li>", $_SERVER["PHP_SELF"], $i, $i);
                                        }
                                    }
                                    ?>
 
 
                                         </ul>
                                     </div>-->
                                    <p style="color:#ff4">  NC Inventory: <?php print $ncall; ?> &nbsp; &nbsp;&nbsp; SH Inventory: <?php print $shall; ?>  &nbsp; &nbsp;&nbsp; In Transit Total: <?php print $transitall; ?></p>

                                </form>
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