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

                                                    <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="icon nalika-alarm" aria-hidden="true"></i><span class="indicator-nt"></span></a>
                                                        <div role="menu" class="notification-author dropdown-menu animated zoomIn">
                                                            <div class="notification-single-top">
                                                                <h1>Notifications</h1>
                                                            </div>
                                                            <ul class="notification-menu">
                                                                <li>
                                                                    <a href="#">
                                                                        <div class="notification-icon">
                                                                            <i class="icon nalika-tick" aria-hidden="true"></i>
                                                                        </div>
                                                                        <div class="notification-content">
                                                                            <span class="notification-date">16 Sept</span>
                                                                            <h2><?php print $user; ?></h2>
                                                                            <p>Please done this project as soon possible.</p>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <div class="notification-icon">
                                                                            <i class="icon nalika-cloud" aria-hidden="true"></i>
                                                                        </div>
                                                                        <div class="notification-content">
                                                                            <span class="notification-date">16 Sept</span>
                                                                            <h2>Sulaiman din</h2>
                                                                            <p>Please done this project as soon possible.</p>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <div class="notification-icon">
                                                                            <i class="icon nalika-folder" aria-hidden="true"></i>
                                                                        </div>
                                                                        <div class="notification-content">
                                                                            <span class="notification-date">16 Sept</span>
                                                                            <h2>Victor Jara</h2>
                                                                            <p>Please done this project as soon possible.</p>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        <div class="notification-icon">
                                                                            <i class="icon nalika-bar-chart" aria-hidden="true"></i>
                                                                        </div>
                                                                        <div class="notification-content">
                                                                            <span class="notification-date">16 Sept</span>
                                                                            <h2>Victor Jara</h2>
                                                                            <p>Please done this project as soon possible.</p>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <div class="notification-view">
                                                                <a href="#">View All Notification</a>
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
                                                            <li><a href="register.html"><span class="icon nalika-home author-log-ic"></span> Register</a>
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
                                                    <i class="icon nalika-home"></i>
                                                </div>
                                                
                                                <div class="breadcomb-ctn">
                                                   
                                                    <h2>Dashboard</h2>
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
            
            <div class="section-admin container-fluid">
                <div class="row admin text-center">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="admin-content analysis-progrebar-ctn res-mg-t-15">
                                    <h4 class="text-left text-uppercase"><b>Orders</b></h4>
                                    <div class="row vertical-center-box vertical-center-box-tablet">
                                        <div class="col-xs-3 mar-bot-15 text-left">
                                            <label class="label bg-green">30% <i class="fa fa-level-up" aria-hidden="true"></i></label>
                                        </div>
                                        <div class="col-xs-9 cus-gh-hd-pro">
                                            <h2 class="text-right no-margin">10,000</h2>
                                        </div>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 78%;" class="progress-bar bg-green"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-bottom:1px;">
                                <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                    <h4 class="text-left text-uppercase"><b>Tax Deduction</b></h4>
                                    <div class="row vertical-center-box vertical-center-box-tablet">
                                        <div class="text-left col-xs-3 mar-bot-15">
                                            <label class="label bg-red">15% <i class="fa fa-level-down" aria-hidden="true"></i></label>
                                        </div>
                                        <div class="col-xs-9 cus-gh-hd-pro">
                                            <h2 class="text-right no-margin">5,000</h2>
                                        </div>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 38%;" class="progress-bar progress-bar-danger bg-red"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                    <h4 class="text-left text-uppercase"><b>Revenue</b></h4>
                                    <div class="row vertical-center-box vertical-center-box-tablet">
                                        <div class="text-left col-xs-3 mar-bot-15">
                                            <label class="label bg-blue">50% <i class="fa fa-level-up" aria-hidden="true"></i></label>
                                        </div>
                                        <div class="col-xs-9 cus-gh-hd-pro">
                                            <h2 class="text-right no-margin">$70,000</h2>
                                        </div>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar bg-blue"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="admin-content analysis-progrebar-ctn res-mg-t-30">
                                    <h4 class="text-left text-uppercase"><b>Yearly Sales</b></h4>
                                    <div class="row vertical-center-box vertical-center-box-tablet">
                                        <div class="text-left col-xs-3 mar-bot-15">
                                            <label class="label bg-purple">80% <i class="fa fa-level-up" aria-hidden="true"></i></label>
                                        </div>
                                        <div class="col-xs-9 cus-gh-hd-pro">
                                            <h2 class="text-right no-margin">$100,000</h2>
                                        </div>
                                    </div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar bg-purple"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-sales-area mg-tb-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="product-sales-chart">
                                <div class="portlet-title">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="caption pro-sl-hd">
                                                <span class="caption-subject text-uppercase"><b>Product Sales</b></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="actions graph-rp">
                                                <div class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-grey active">
                                                        <input type="radio" name="options" class="toggle" id="option1" checked="">Today</label>
                                                    <label class="btn btn-grey">
                                                        <input type="radio" name="options" class="toggle" id="option2">Week</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="curved-line-chart" class="flot-chart-sts flot-chart curved-chart-statistic"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="white-box analytics-info-cs mg-b-30 res-mg-t-30">
                                <h3 class="box-title">Total Visit</h3>
                                <ul class="list-inline two-part-sp">
                                    <li>
                                        <div id="sparklinedash"></div>
                                    </li>
                                    <li class="text-right sp-cn-r"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter sales-sts-ctn">8659</span></li>
                                </ul>
                            </div>
                            <div class="white-box analytics-info-cs mg-b-30">
                                <h3 class="box-title">Total Page Views</h3>
                                <ul class="list-inline two-part-sp">
                                    <li>
                                        <div id="sparklinedash2"></div>
                                    </li>
                                    <li class="text-right"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter sales-sts-ctn">7469</span></li>
                                </ul>
                            </div>
                            <div class="white-box analytics-info-cs mg-b-30">
                                <h3 class="box-title">Unique Visitor</h3>
                                <ul class="list-inline two-part-sp">
                                    <li>
                                        <div id="sparklinedash3"></div>
                                    </li>
                                    <li class="text-right"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="counter sales-sts-ctn">6011</span></li>
                                </ul>
                            </div>
                            <div class="white-box analytics-info-cs">
                                <h3 class="box-title">Bounce Rate</h3>
                                <ul class="list-inline two-part-sp">
                                    <li>
                                        <div id="sparklinedash4"></div>
                                    </li>
                                    <li class="text-right"><i class="fa fa-level-down" aria-hidden="true"></i> <span class="sales-sts-ctn">18%</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="traffic-analysis-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="white-box tranffic-als-inner">
                                <h3 class="box-title"><small class="pull-right m-t-10 text-success last-month-sc cl-one"><i class="fa fa-sort-asc"></i> 18% last month</small> Site Traffic</h3>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <h6>Overall Growth</h6>
                                        <b>80.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Montly</h6>
                                        <b>15.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Day</h6>
                                        <b>5.50%</b></div>
                                </div>
                                <div id="sparkline8"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="white-box tranffic-als-inner res-mg-t-30">
                                <h3 class="box-title"><small class="pull-right m-t-10 text-danger last-month-sc cl-two"><i class="fa fa-sort-desc"></i> 18% last month</small>Site Traffic</h3>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <h6>Overall Growth</h6>
                                        <b>80.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Montly</h6>
                                        <b>15.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Day</h6>
                                        <b>5.50%</b></div>
                                </div>
                                <div id="sparkline9"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="white-box tranffic-als-inner res-mg-t-30">
                                <h3 class="box-title"><small class="pull-right m-t-10 text-success last-month-sc cl-three"><i class="fa fa-sort-asc"></i> 18% last month</small>Site Traffic</h3>
                                <div class="stats-row">
                                    <div class="stat-item">
                                        <h6>Overall Growth</h6>
                                        <b>80.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Montly</h6>
                                        <b>15.40%</b></div>
                                    <div class="stat-item">
                                        <h6>Day</h6>
                                        <b>5.50%</b></div>
                                </div>
                                <div id="sparkline10"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-new-list-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="single-new-trend mg-t-30">
                                <a href="#"><img src="img/new-product/5.png" alt=""></a>
                                <div class="overlay-content">
                                    <a href="#">
                                        <h2>$280</h2>
                                    </a>
                                    <a href="#" class="btn-small">Now</a>
                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a data-toggle="tooltip" title="Shopping" href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                            </li>
                                            <li>
                                                <a data-toggle="tooltip" title="Quick view" href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a class="pro-tlt" href="#">
                                        <h4>Princes Diamond</h4>
                                    </a>
                                    <div class="pro-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="single-new-trend mg-t-30">
                                <a href="#"><img src="img/new-product/5.png" alt=""></a>
                                <div class="overlay-content">
                                    <a href="#">
                                        <h2>$280</h2>
                                    </a>
                                    <a href="#" class="btn-small">Now</a>
                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a data-toggle="tooltip" title="Shopping" href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                            </li>
                                            <li>
                                                <a data-toggle="tooltip" title="Quick view" href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="#">
                                        <h4>Princes Diamond</h4>
                                    </a>
                                    <div class="pro-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="single-new-trend mg-t-30">
                                <a href="#"><img src="img/new-product/5.png" alt=""></a>
                                <div class="overlay-content">
                                    <a href="#">
                                        <h2>$280</h2>
                                    </a>
                                    <a href="#" class="btn-small">Now</a>
                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a data-toggle="tooltip" title="Shopping" href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                            </li>
                                            <li>
                                                <a data-toggle="tooltip" title="Quick view" href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="#">
                                        <h4>Princes Diamond</h4>
                                    </a>
                                    <div class="pro-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="single-new-trend mg-t-30">
                                <a href="#"><img src="img/new-product/5.png" alt=""></a>
                                <div class="overlay-content">
                                    <a href="#">
                                        <h2>$280</h2>
                                    </a>
                                    <a href="#" class="btn-small">Now</a>
                                    <div class="product-action">
                                        <ul>
                                            <li>
                                                <a data-toggle="tooltip" title="Shopping" href="#"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                            </li>
                                            <li>
                                                <a data-toggle="tooltip" title="Quick view" href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="#">
                                        <h4>Princes Diamond</h4>
                                    </a>
                                    <div class="pro-rating">
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="fa fa-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star color"></i>
                                        <i class="icon nalika-half-filled-rating-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-sales-area mg-tb-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="product-sales-chart">
                                <div class="portlet-title">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="caption pro-sl-hd">
                                                <span class="caption-subject text-uppercase"><b>Order Statistic</b></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="actions graph-rp">
                                                <a href="#" class="btn btn-dark-blue btn-circle active tip-top" data-toggle="tooltip" title="Upload">
                                                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="btn btn-dark btn-circle active tip-top" data-toggle="tooltip" title="Refresh">
                                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                                </a>
                                                <a href="#" class="btn btn-blue-grey btn-circle active tip-top" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="line-chart" class="flot-chart flot-chart-sts line-chart-statistic"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="analytics-rounded mg-b-30 res-mg-t-30">
                                <div class="analytics-rounded-content">
                                    <h5>Percentage distribution</h5>
                                    <h2><span class="counter">60</span>/20</h2>
                                    <div class="text-center">
                                        <div id="sparkline51"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="analytics-rounded">
                                <div class="analytics-rounded-content">
                                    <h5>Percentage division</h5>
                                    <h2><span class="counter">150</span>/<span class="counter">54</span></h2>
                                    <div class="text-center">
                                        <div id="sparkline52"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="author-area-pro">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="personal-info-wrap">
                                <div class="widget-head-info-box">
                                    <div class="persoanl-widget-hd">
                                        <h2>Jon Royita</h2>
                                        <p>Founder of Uttara It Park</p>
                                    </div>
                                    <img src="img/notification/5.jpg" class="img-circle circle-border m-b-md" alt="profile">
                                    <div class="social-widget-result">
                                        <span>100 Tweets</span> |
                                        <span>350 Following</span> |
                                        <span>610 Followers</span>
                                    </div>
                                </div>
                                <div class="widget-text-box">
                                    <h4>Jhon Royita</h4>
                                    <p>To all the athaists attacking me right now, I can't make you believe in God, you have to have faith.</p>
                                    <div class="text-right like-love-list">
                                        <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="author-widgets-single res-mg-t-30">
                                <div class="author-wiget-inner">
                                    <div class="perso-img">
                                        <img src="img/notification/6.jpg" class="img-circle circle-border m-b-md" alt="profile">
                                    </div>
                                    <div class="persoanl-widget-hd persoanl1-widget-hd">
                                        <h2>Fire Foxy</h2>
                                        <p>Founder of Uttara It House</p>
                                    </div>
                                    <div class="social-widget-result social-widget1-result">
                                        <span>100 Tweets</span> |
                                        <span>350 Following</span> |
                                        <span>610 Followers</span>
                                    </div>
                                </div>
                                <div class="widget-text-box">
                                    <h4>Fire Foxy</h4>
                                    <p>To all the athaists attacking me right now, I can't make you believe in God, you have to have faith.</p>
                                    <div class="text-right like-love-list">
                                        <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="personal-info-wrap personal-info-ano res-mg-t-30">
                                <div class="widget-head-info-box">
                                    <div class="persoanl-widget-hd">
                                        <h2>Jon Royita</h2>
                                        <p>Founder of Uttara It Park</p>
                                    </div>
                                    <img src="img/contact/2.jpg" class="img-circle circle-border m-b-md" alt="profile">
                                    <div class="social-widget-result">
                                        <span>100 Tweets</span> |
                                        <span>350 Following</span> |
                                        <span>610 Followers</span>
                                    </div>
                                </div>
                                <div class="widget-text-box">
                                    <h4>Jhon Royita</h4>
                                    <p>To all the athaists attacking me right now, I can't make you believe in God, you have to have faith.</p>
                                    <div class="text-right like-love-list">
                                        <a class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                        <a class="btn btn-xs btn-primary"><i class="fa fa-heart"></i> Love</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="calender-area mg-tb-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="calender-inner">
                                <div id='calendar'></div>
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
                                <p>Copyright © 2019 <a href="https://www.unihorn.com">Unihorn</a> All rights reserved.</p>
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