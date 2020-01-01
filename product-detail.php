<?php
require 'header.php';
?>


<?php
if (isset($_SESSION['yhy'])) {



    $user = $_SESSION['yhy'];
    $sql = "select firstname, lastname approved from employees where username='" . $user . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $fn = $row[0];
    $ln = $row[1];
} else {
    echo '<script> alert("Please Re-login!")</script>';
    print '<script> location.replace("index.php"); </script>';
}
?>

<?php
$perpage = 20;

if (isset($_POST['search'])) {
    $_SESSION['detailpagesearchtext'] = $_POST['searchtext'];
    $sql = "SELECT sku FROM product where sku LIKE '%" . $_SESSION['detailpagesearchtext'] . "%'";
    $result = mysqli_query($conn, $sql);
    $totalrow = mysqli_num_rows($result);
    $totalpage = ceil($totalrow / $perpage);
    if ($totalrow != 0) {
        while ($arr = mysqli_fetch_array($result)) {
            $data[] = $arr;
        }
        if (empty(@$_GET['page']) || !is_numeric(@$_GET['page']) || @$_GET['page'] < 1 || @$_GET['page'] > $totalpage) {
            $page = 1;
        } else
            $page = $_GET['page'];
    }
} else {
    $sql = "SELECT sku FROM product where sku LIKE '%" . @$_SESSION['detailpagesearchtext'] . "%'";
    $result = mysqli_query($conn, $sql);
    $totalrow = mysqli_num_rows($result);
    $totalpage = ceil($totalrow / $perpage);
    if ($totalrow != 0) {
        while ($arr = mysqli_fetch_array($result)) {
            $data[] = $arr;
        }
        if (empty(@$_GET['page']) || !is_numeric(@$_GET['page']) || @$_GET['page'] < 1 || @$_GET['page'] > $totalpage) {
            $page = 1;
        } else
            $page = $_GET['page'];
    }
}
?>



<?php
for ($i = 0; $i < $perpage; $i++) {
    $ind = ($page - 1) * $perpage + $i;
    $tem = "sss" . $ind;
    if ($i > count($data)) {
        break;
    } else if (isset($_POST["{$tem}"])) {
        $_SESSION['detailsku'] = $data[$ind]['sku'];
        $sql = "select * from product where sku='" . $_SESSION['detailsku'] . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $_SESSION['detailbrand'] = $row[1];
        $_SESSION['detailcategory'] = $row[2];
        $_SESSION['detailprice'] = $row[3];
        $_SESSION['detailram'] = $row[4];
        $_SESSION['detailcpu'] = $row[5];
        $_SESSION['detailquality'] = $row[6];
        $_SESSION['detailnc'] = $row[7];
        $_SESSION['detailtransit'] = $row[8];
        $_SESSION['detailshanghai'] = $row[9];
        $_SESSION['detailsold'] = $row[10];
        $_SESSION['detailweb'] = $row[11];
        break;
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

                            <li class="active">
                                <a class="has-arrow" href="homepage.php">
                                    <i class="icon nalika-home icon-wrap"></i>
                                    <span class="mini-click-non">Dashboard</span>
                                </a>
                                <ul>
                                    <li><a title="Dashboard" href="homepage.php"><span class="mini-sub-pro">Dashboard</span></a></li>
                                </ul>
                                <ul>
                                    <li><a title="Notification" href="notification.php"><span class="mini-sub-pro">Notification</span></a></li>
                                </ul>
                            </li>

                            <li class="active">
                                <a class="has-arrow" href="homepage.php">

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

                                    <li><a class="has-arrow" title="Import" href="stocktrans.php"><span >Incoming</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">     
                                            <li><a title="Supply" href="supply.php"><span class="mini-sub-pro">Supply & Return(NC)</span></a></li>
                                            <li><a title="Supply" href="supplysh.php"><span class="mini-sub-pro">Supply & Return(SH)</span></a></li>
                                            <li><a title="Import Stock" href="stockaccept.php"><span class="mini-sub-pro">Import Stock</span></a></li>                                             
                                        </ul>
                                    </li>
                                    <li><a class="has-arrow" title="Export" href="mailbox.html"><span >Outgoing</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">   
                                            <li><a title="Order & Replacement" href="outgoingnc.php"><span class="mini-sub-pro">Order & Replacement(NC)</span></a></li>
                                            <li><a title="Order & Replacement" href="outgoingsh.php"><span class="mini-sub-pro">Order & Replacement(SH)</span></a></li>
                                            <li><a title="Export Stock" href="stocktrans.php"><span class="mini-sub-pro">Export Stock</span></a></li>                                             
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow" href="mailbox.html" aria-expanded="false"><i class="icon nalika-diamond icon-wrap"></i> <span class="mini-click-non">Warehouse</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Inventory" href="inventory-1.php"><span class="mini-sub-pro">Inventory</span></a></li>
                                    <li><a title="Shanghai" href="recordsh.php"><span class="mini-sub-pro">Record SH</span></a></li>
                                    <li><a title="Greensboro" href="recordnc.php"><span class="mini-sub-pro">Record NC</span></a></li>
                                </ul>
                            </li>

                            <li>
                                <a class="has-arrow" href="mailbox.html" aria-expanded="false"><i class="icon nalika-bar-chart icon-wrap"></i> <span class="mini-click-non">Charts</span></a>
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
                                <a class="has-arrow" href="mailbox.html" aria-expanded="false"><i class="icon nalika-table icon-wrap"></i> <span class="mini-click-non">Data Tables</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a title="Peity Charts" href="static-table.html"><span class="mini-sub-pro">Static Table</span></a></li>
                                    <li><a title="Data Table" href="data-table.html"><span class="mini-sub-pro">Data Table</span></a></li>
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
                                                <button type="button"  class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                                    <i class="fa fa-bars"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                            <div class="header-top-menu tabl-d-n">
                                                <ul class="nav navbar-nav mai-top-nav">
                                                    <li class="nav-item"><a href="#" class="nav-link">Home</a>
                                                    </li>
                                                    <li class="nav-item"><a href="#" class="nav-link">About</a>
                                                    </li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Services</a>
                                                    </li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Support</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                                            <div class="header-right-info">
                                                <ul class="nav navbar-nav mai-top-nav header-right-menu">

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
                                                    <li class="nav-item nav-setting-open"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="icon nalika-menu-task"></i></a>


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
                                                    <h2>Product Detail</h2>
                                                    <p>Welcome to Unihorn Management System <span class="bread-ntd"></span></p>
                                                    <p>---------------------------------------------------------------------<span class="bread-ntd"></span></p>
                                                    <form method="post" role="search" class="">


                                                        <div style="width:200px;float:left;"><input name="searchtext" type="text" placeholder="Search Content....." value="<?php
                                                            if (isset($_SESSION['detailpagesearchtext'])) {
                                                                print $_SESSION['detailpagesearchtext'];
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single pro tab start-->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-product-pr">
                            <div class="row">
                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                    <div id="myTabContent1" class="tab-content" style="width:250px" >

                                        <form action="" method="post" name="form">


                                            <table style="width: 100%;margin:auto;color: #fff">

                                                <tr>
                                                    <th>Product SKU </th>
                                                    <!--<th><a style="color: #fff" href="product-detail.php?column=brand&order=<?php echo $asc_or_desc; ?>">CN STOCK <i class=" fa fa-sort<?php echo $column == 'brand' ? '-' . $up_or_down : ''; ?>"></i></a></th>
                                                    <th><a style="color: #fff" href="product-detail.php?column=category&order=<?php echo $asc_or_desc; ?>">IN TRANSIT <i class="fa fa-sort<?php echo $column == 'category' ? '-' . $up_or_down : ''; ?>"></i></a></th> 
                                                    <th><a style="color: #fff" href="product-detail.php?column=price&order=<?php echo $asc_or_desc; ?>">US STOCK <i class="fa fa-sort<?php echo $column == 'price' ? '-' . $up_or_down : ''; ?>"></i></a></th>-->
                                                    <th>CHECK</th>


                                                </tr>



                                                <?php
                                                if ($totalrow != 0) {
                                                    for ($i = 0; $i < $perpage; $i++) {
                                                        $index = ($page - 1) * $perpage + $i;
                                                        if ($index >= count($data))
                                                            break;
                                                        else {


                                                            print "<td>{$data[$index]['sku']}</td>";
                                                            // print "<td>{$data[$index]['shanghai']}</td>";
                                                            // print "<td>{$data[$index]['transit']}</td>";
                                                            // print "<td>{$data[$index]['nc']}</td>";
                                                            $detail = "sss" . $index;
                                                        }
                                                        ?>

                                                        <td>
                                                            <button data-toggle="tooltip" name ="<?php print $detail; ?>"    type="submit" title="detail"  class="pd-setting-ed"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

                                                        </td >  
                                                        <?php
                                                        print '</tr>';
                                                    }
                                                }
                                                ?>
                                            </table>
                                            <div class="custom-pagination "  >
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
                                            </div>

                                        </form>

                                    </div>

                                </div>


                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                    <div class="single-product-details res-pro-tb">
                                        <h1><?php print @$_SESSION['detailsku']; ?></h1>
                                        <span class="single-pro-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                        <div class="single-pro-price">
                                            <span class="single-regular"><?php print "￥" . @$_SESSION['detailprice']; ?></span>
                                        </div>
                                        <div class="single-pro-size">
                                            <h4 style="color:#fff" ><?php print @$_SESSION['detailbrand'] . "_" . @$_SESSION['detailcategory']; ?></h4>
                                            <h4 style="color:#fff"  >Sold: <?php print @$_SESSION['detailsold']; ?></h4>
                                        </div>
                                        <div class="color-quality-pro">
                                            <div class="color-quality-details">
                                                <h5>RAM/CPU</h5>
                                                <a style="color:#000" class="white"><?php print @$_SESSION['detailram'] ?></a>
                                                <a style="color:#000" class="red"><?php print @$_SESSION['detailcpu'] ?></a>
                                                <a> &nbsp;&nbsp;&nbsp; </a>
                                            </div>     
                                        </div>
                                        <div class="color-quality-pro">
                                            <div class="color-quality-details">
                                                <h5>  &nbsp&nbsp&nbsp &nbsp&nbspStock</h5>
                                                <a style="color:#fff ">    <?php print @$_SESSION['detailshanghai'] ?></a>
                                                <a style="color:#fff" > &nbsp;&GT;&GT;&nbsp;&nbsp; </a>
                                                <a style="color:#fff ">    <?php print @$_SESSION['detailtransit'] ?></a>
                                                <a style="color:#fff" > &nbsp;&GT;&GT;&nbsp;&nbsp; </a>
                                                <a style="color:#fff ">    <?php print @$_SESSION['detailnc'] ?></a>
                                                <a> &nbsp;&nbsp;&nbsp; </a>

                                            </div>     
                                        </div>

                                        <div class="clear"></div>
                                        <div >
                                            <div >  
                                                <a href="#" onclick="openNewWin('generate.php');"><i class="icon pro-button" Style="color:#fff">PRINT LABEL</i></a>                                             

                                            </div>
                                            <div class="pro-viwer">
                                                <a href="#" onclick="openNewWin('<?php print @$_SESSION['detailweb'] ?>');">
                                                <i class="fa fa-internet-explorer">Click</i></a>
                                                
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="single-social-area">
                                            <h3>share this on</h3>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-google-plus"></i></a>
                                            <a href="#"><i class="fa fa-feed"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                        </div>
                                    </div>
                                    <div class="single-pro-cn">
                                        <h3>OVERVIEW</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Single pro tab End-->
            <!-- Single pro tab review Start-->
            <div class="single-pro-review-area mt-t-30 mg-b-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single-tb-pr">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ul id="myTab" class="tab-review-design">
                                            <li class="active"><a href="#description">description</a></li>
                                            <li><a href="#reviews"><span><i class="fa fa-star"></i><i class="fa fa-star"></i></span> reviews (1) <span><i class="fa fa-star"></i><i class="fa fa-star"></i></span></a></li>
                                            <li><a href="#INFORMATION">INFORMATION</a></li>
                                        </ul>
                                        <div id="myTabContent" class="tab-content">
                                            <div class="product-tab-list product-details-ect tab-pane fade active in" id="description">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="review-content-section">
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                                                                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                                                mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
                                                                beatae vitae dicta sunt explicabo.</p>
                                                            <p class="pro-b-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labo nisi ut aliquip ex
                                                                ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ut labore et dolore magna aliqua. Ut enim ad , quis nostrud exercitation ullamco
                                                                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="myTabContent" class="tab-content">
                                                <div class="product-tab-list tab-pane fade" id="reviews">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="review-content-section">
                                                                <div class="review-content-section">
                                                                    <div class="card-block">
                                                                        <div class="text-muted f-w-400">
                                                                            <p>No reviews yet.</p>
                                                                        </div>
                                                                        <div class="m-t-10">
                                                                            <div class="txt-primary f-18 f-w-600">
                                                                                <p>Your Rating</p>
                                                                            </div>
                                                                            <div class="stars stars-example-css detail-stars">
                                                                                <div class="review-rating">
                                                                                    <fieldset class="rating">
                                                                                        <input type="radio" id="star5" name="rating" value="5">
                                                                                        <label class="full" for="star5"></label>
                                                                                        <input type="radio" id="star4half" name="rating" value="4 and a half">
                                                                                        <label class="half" for="star4half"></label>
                                                                                        <input type="radio" id="star4" name="rating" value="4">
                                                                                        <label class="full" for="star4"></label>
                                                                                        <input type="radio" id="star3half" name="rating" value="3 and a half">
                                                                                        <label class="half" for="star3half"></label>
                                                                                        <input type="radio" id="star3" name="rating" value="3">
                                                                                        <label class="full" for="star3"></label>
                                                                                        <input type="radio" id="star2half" name="rating" value="2 and a half">
                                                                                        <label class="half" for="star2half"></label>
                                                                                        <input type="radio" id="star2" name="rating" value="2">
                                                                                        <label class="full" for="star2"></label>
                                                                                        <input type="radio" id="star1half" name="rating" value="1 and a half">
                                                                                        <label class="half" for="star1half"></label>
                                                                                        <input type="radio" id="star1" name="rating" value="1">
                                                                                        <label class="full" for="star1"></label>
                                                                                        <input type="radio" id="starhalf" name="rating" value="half">
                                                                                        <label class="half" for="starhalf"></label>
                                                                                    </fieldset>
                                                                                </div>
                                                                                <div class="clear"></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="input-group mg-b-15 mg-t-15">
                                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                                            <input type="text" class="form-control" placeholder="User Name">
                                                                        </div>
                                                                        <div class="input-group mg-b-15">
                                                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                                            <input type="text" class="form-control" placeholder="Last Name">
                                                                        </div>
                                                                        <div class="input-group mg-b-15">
                                                                            <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                                                            <input type="text" class="form-control" placeholder="Email">
                                                                        </div>
                                                                        <div class="form-group review-pro-edt mg-b-0-pr">
                                                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-tab-list tab-pane fade" id="INFORMATION">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="review-content-section">
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                                                                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                                                    mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
                                                                    beatae vitae dicta sunt explicabo.</p>
                                                                <p class="pro-b-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labo nisi ut aliquip ex
                                                                    ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ut labore et dolore magna aliqua. Ut enim ad , quis nostrud exercitation ullamco
                                                                    laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit.</p>
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