<?php
require_once 'header.php';
$pageoffice = 'sh';           //设置页面属性 office ：  nc, sh, all
$pagelevel = 1;       // //设置页面等级 0： 只有admin可以访问； 1：库存系统用户； 2:代发用户
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

$sql = "SELECT sku,shanghai,transit,nc FROM product where (cmpid='" . $cmpid . "') and shanghai>0 ORDER BY shanghai DESC";
$result = mysqli_query($conn, $sql);
$totalrow = mysqli_num_rows($result);
while ($arr = mysqli_fetch_array($result)) {
    $data[] = $arr;
}
?>

<?php
$sql = "SELECT sku,shanghai,barcode FROM product where (cmpid='" . $cmpid . "')";
$result = mysqli_query($conn, $sql);
$totalrow = mysqli_num_rows($result);
while ($arr = mysqli_fetch_array($result)) {
    $alldata[] = $arr;
}
?>


<?php
if (@isset($_POST['confirm']) && @count($_SESSION['todo']) != 0) {
    $productlist = json_encode($_SESSION['todo']);
    $sql = "INSERT INTO shstock(date, productlist, subject, ship, tracking, ordernumber,log,cmpid) VALUES ('" . $str . "','" . $productlist . "','export' ,'DHL','" . $_POST['dhl'] . "','1','" . $_POST['note'] . "','" . $cmpid . "')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $sql = "INSERT INTO note (date, subject,status,cmpid) VALUES (' " . $str . "',' STOCK TRANSFER:" . $_POST['dhl'] . "+NOTE:" . $_POST['note'] . "','1', '" . $cmpid . "')";
        ;
        mysqli_query($conn, $sql);

        $pro = json_decode($productlist);
        for ($i = 0; $i < count($pro); $i++) {
            $sql = "UPDATE product SET shanghai=shanghai-" . $pro[$i][1] . " where (cmpid='" . $cmpid . "') AND sku='" . $pro[$i][0] . "'";
            mysqli_query($conn, $sql);
            $sql = "UPDATE product SET transit=transit+" . $pro[$i][1] . " where (cmpid='" . $cmpid . "') AND sku='" . $pro[$i][0] . "'";
            mysqli_query($conn, $sql);
        }
        print "<script>alert('Successful!')</script>";
    } else {
        print "<script>alert('Failue, Please redo!')</script>";
    }
    unset($_SESSION['todo']);
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
                            <li class="active">
                                <a class="has-arrow" href="mailbox.html" aria-expanded="false"><i class="icon nalika-mail icon-wrap"></i> <span class="mini-click-non">Export & Import</span></a>
                                <ul class="submenu-angle" aria-expanded="false">
                                    <li><a class="has-arrow" title="Import" href="supply.php"><span >Incoming</span></a>
                                        <ul class="submenu-angle" aria-expanded="false">     
                                            <li><a title="Supply" href="supply.php"><span class="mini-sub-pro">Supply & Return(NC)</span></a></li>
                                            <li><a title="Supply" href="supplysh.php"><span class="mini-sub-pro">Supply & Return(SH)</span></a></li>
                                            <li><a title="Import Stock" href="stockaccept.php"><span class="mini-sub-pro">Import Stock</span></a></li>                                             
                                        </ul>
                                    </li>
                                    <li class="active"><a class="has-arrow" title="Export" href="outgoingnc.php"><span >Outgoing</span></a>
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
                            <li>
                                <a class="has-arrow" href="static-table.html" aria-expanded="false"><i class="icon nalika-table icon-wrap"></i> <span class="mini-click-non">批量发货</span></a>
                                <ul class="submenu-angle" aria-expanded="false">

                                    <li><a title="Data Table" href="data-table.php"><span class="mini-sub-pro">批量发货汇总</span></a></li>
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
                                                            <?php }
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
                                                    <i class="icon nalika-share"></i>
                                                </div>
                                                <div class="breadcomb-ctn">
                                                    <h2>Stock Transfer</h2>
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

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-product-pr">
                            <div class="row">
                                <div class="col-lg-7 col-md-5 col-sm-5 col-xs-12">

                                    <div>

                                        <form action="" method="post" name="form" enctype="multipart/form-data">
                                            <div><h1 style="color:#fff">PICK UP FROM CURRENT INVENTORY</h1>
                                                <table style="width: 90%;margin:auto;color: #fff">

                                                    <tr>
                                                    <th>SKU</th>
                                                    <th>Inventory</th>
                                                    <th>Amount To Transfer</th>
                                                    <th>Check</th>

                                                    </tr>

                                                    <?php
                                                    for ($index = 0; $index < @count($data); $index++) {
                                                        print '<tr>';
                                                        print "<td>{$data[$index]['sku']}</td>";
                                                        print "<td>{$data[$index]['shanghai']}</td>";
                                                        $deta = "inven" . $index;
                                                        $check = "check" . $index;
                                                        ?>
                                                        <td>
                                                            <input  style="color:#000"  name ="<?php print $deta; ?>"    type="text">
                                                        </td >  
                                                        <td>
                                                            <input  style="color:#000" name ="<?php print $check; ?>"   value="1" type="checkbox">
                                                        </td >                                                        
                                                        <?php
                                                        print '</tr>';
                                                    }
                                                    ?>
                                                </table>
                                                <div class="custom-pagination "  >
                                                    <input name="submit" type="submit" value="Click to confirm">
                                                </div>
                                            </div>

                                            <div>
                                                <h1 style="color:#fff"><br>OR UPLOAD TXT/CSV FILE</h1>
                                                <input name="file" type="file" size="16" maxlength="200" accept="application/csv">
                                                <input name="subfile" type="submit" value="upload">
                                            </div>
                                        </form>
                                        <?php
                                        if (isset($_POST['subfile'])) {
                                            $allowedExts = array(
                                                'text/txt',
                                                'text/csv',
                                                'text/plain',
                                                'application/csv',
                                                'text/comma-separated-values',
                                                'application/excel',
                                                'application/vnd.ms-excel',
                                                'application/vnd.msexcel',
                                                'text/anytext',
                                                'application/octet-stream',
                                                'application/txt',
                                            );
                                            $temp = explode(".", @$_FILES["file"]["name"]);
                                            echo @$_FILES["file"]["size"];
                                            $extension = end($temp);     // 获取文件后缀名
                                            if (in_array(@$_FILES["file"]["type"], $allowedExts)) {
                                                if (@$_FILES["file"]["error"] > 0) {
                                                    echo "错误：: " . @$_FILES["file"]["error"] . "<br>";
                                                } else {
                                                    echo "上传文件名: " . @$_FILES["file"]["name"] . "<br>";
                                                    echo "文件类型: " . @$_FILES["file"]["type"] . "<br>";
                                                    echo "文件大小: " . (@$_FILES["file"]["size"] / 1024) . " kB<br>";
                                                    echo "文件临时存储的位置: " . @$_FILES["file"]["tmp_name"] . "<br>";

                                                    //判断当期目录下的 upload 目录是否存在该文件
                                                    //如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                                                    if (file_exists("upload/" . @$_FILES["file"]["name"])) {
                                                        echo @$_FILES["file"]["name"] . " 文件已经存在。 ";
                                                    } else {
                                                        // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                                                        move_uploaded_file(@$_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
                                                        echo "文件存储在: " . "upload/" . $_FILES["file"]["name"] . "<br>";
                                                    }
                                                }
                                            } else {
                                                echo "<script> alert('Please upload csv/txt file!')</script>";
                                            }
                                            $updoc = array();
                                            @$filepath = @fopen("upload/" . @$_FILES["file"]["name"], 'r');
                                            while (@$content = fgetcsv($filepath)) {    //每次读取CSV里面的一行内容   
                                                //print_r($content); //此为一个数组，要获得每一个数据，访问数组下标即可   
                                                $updoc[] = $content;
                                            }
                                            @fclose(@$filepath);
                                            @unlink("upload/" . @$_FILES["file"]["name"]);
                                        }
                                        ?>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                                    <div>
                                        <h1 style="color:#fff">TRANSFER LIST</h1>
                                        <form method="post">
                                            <table style="width: 100%;margin:auto;color:#fff">
                                                <tr>
                                                <th>SKU</th>
                                                <th>Inventory</th>
                                                <th>To Transfer</th>
                                                </tr>
                                                <?php
//这段控制pickup表格
                                                $total = 0;
                                                if (isset($_POST['submit'])) {
                                                    $todo = array();
                                                    for ($ind = 0; $ind < count($data); $ind++) {
                                                        $deta = "inven" . $ind;
                                                        $check = "check" . $ind;
                                                        if (@$_POST["{$check}"] != NULL) {
                                                            print '<tr>';
                                                            print "<td>{$data[$ind]['sku']}</td>";
                                                            print "<td>{$data[$ind]['shanghai']}</td>";
                                                            print "<td>" . @$_REQUEST["{$deta}"] . "</td></tr>";
                                                            $total += trim(@$_REQUEST["{$deta}"]);
                                                            $todo[] = array(@$data[$ind]['sku'], @$_REQUEST["{$deta}"]);
                                                        }
                                                    }
                                                    $_SESSION['todo'] = $todo;
                                                }

                                                //这段控制upload部分      将updoc中的重复项统计并查错                                          
                                                if (@isset($_POST['subfile'])) {
                                                    $flag = true;
                                                    $a = 0;
                                                    $total = 0;
                                                    $todo = array();
                                                    for ($ind = 0; $ind < count($updoc); $ind++) {
                                                        $flagl = true;
                                                        for ($i = 0; $i < @count($alldata) && $flagl; $i++) {
                                                            $tem = "UN" . str_pad($alldata[$i]['barcode'], 11, "0", STR_PAD_LEFT);
                                                            if (strtoupper(trim($updoc[$ind][0])) == $tem || strtoupper($updoc[$ind][0]) == strtoupper($alldata[$i]['sku'])) {
                                                                $flagl = FALSE;
                                                            }
                                                        }
                                                        if ($flagl) {
                                                            $flag = false;
                                                            printf("<script>alert('The product %s unexist!')</script>", $updoc[$ind][0]);
                                                            break;
                                                        }
                                                    }
                                                    if ($flag) {
                                                        for ($i = 0; $i < @count($alldata); $i++) {
                                                            $num = 0;
                                                            $tem = "UN" . str_pad($alldata[$i]['barcode'], 11, "0", STR_PAD_LEFT);
                                                            for ($ind = 0; $ind < count($updoc); $ind++) {
                                                                if ($tem == strtoupper($updoc[$ind][0]) || strtoupper($alldata[$i]['sku']) == strtoupper($updoc[$ind][0])) {
                                                                    $a = $i;
                                                                    $num++;
                                                                }
                                                            }
                                                            if ($num != 0) {
                                                                print '<tr>';
                                                                print "<td>{$alldata[$a]['sku']}</td>";
                                                                print "<td>{$alldata[$a]['shanghai']}</td>";
                                                                if ($num <= $alldata[$a]['shanghai']) {
                                                                    print "<td> $num  </td></tr>";
                                                                } else {
                                                                    print "<td><a style='color:#ff4500'> $num </a> </td></tr>";
                                                                }
                                                                $todo[] = array($alldata[$a]['sku'], $num);
                                                                $total += $num;
                                                            }
                                                        }
                                                    }
                                                    $_SESSION['todo'] = $todo;
                                                }
                                                ?>
                                            </table>     

                                            <div class="custom-pagination "  >
                                                <p style="color:#ff4"><br>Total Amount: <?php print $total; ?></p>
                                                <h1 style="color:#fff"><br>Conrimation </h1>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label" style="color:#fff">DHL Traking No.</label>
                                                <input type="text"  title="You need to input tracking No to confirm" required="" value="" name="dhl" id="username" class="form-control">
                                                <label class="control-label" style="color:#fff"><br>Notes</label>
                                                <input type="text"  placeholder="Please leave the notes for your attention" value="" name="note"  class="form-control">
                                                <input name="confirm" type="submit" value="Click to confirm">
                                            </div>
                                        </form> 

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