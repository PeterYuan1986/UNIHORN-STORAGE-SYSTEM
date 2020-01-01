<?php
require 'header.php';
?>
<?php
if (isset($_SESSION['yhy'])) {



    $user = $_SESSION['yhy'];
    $sql = "select firstname, lastname ,office from employees where username='" . $user . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $fn = $row[0];
    $ln = $row[1];
    $of = $row[2];
    if ($of == "nc" || $of == "admin") {
        
    } else {
        echo '<script> alert("You have no access for this page!")</script>';
        print '<script> location.replace("homepage.php"); </script>';
    }
} else {
    echo '<script> alert("Please Re-login!")</script>';
    print '<script> location.replace("index.php"); </script>';
}
?>
<?php
$sql = "SELECT date,tracking,productlist,log FROM shstock where ordernumber=1 And subject='export'";
$result = mysqli_query($conn, $sql);
$totalrow = mysqli_num_rows($result);
while ($arr = mysqli_fetch_array($result)) {
    $data[] = $arr;
}
?>
<?php
$sql = "SELECT sku,nc FROM product";
$result = mysqli_query($conn, $sql);
while ($arr = mysqli_fetch_array($result)) {
    $alldata[] = $arr;
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

                                                    <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><i class="icon nalika-alarm" aria-hidden="true"></i><span class="<?php if($totalnotes!=0)print 'indicator-nt'?>"></span></a>
                                                        <div role="menu" class="notification-author dropdown-menu animated zoomIn">
                                                            <div class="notification-single-top">
                                                                <h1>Notifications</h1>
                                                            </div>
                                                            <ul class="notification-menu">
                                                                <?php 
                                                                for($i=0;$i<count($datanote)&&$i<3;$i++){
                                                                print "<li>
                                                                    <a href='notification.php'>
                                                                        <div class='notification-icon'>
                                                                            <i class='icon nalika-tick' aria-hidden='true'></i>
                                                                        </div>
                                                                        <div class='notification-content'>                                                                            
                                                                            <h2>";print $datanote[$i]['date'];    print "</h2>
                                                                            <p>".$datanote[$i]['subject']."</p>
                                                                        </div>
                                                                    </a>
                                                                </li>";}
                                                                
                                                                ?>
                                                            </ul>
                                                             <div class="notification-view">
                                                            <?php  if(count($datanote)>3) print "<a href='notification.php'>View All Notification</a>";?>
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
                                            <div><h1 style="color:#fff">PENDING TRANSITION</h1>
                                                <table style="width: 90%;margin:auto;color: #fff">

                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Tracking No.</th>
                                                        <th>Producut List</th>
                                                        <th>Note</th>
                                                        <th>Accept</th>

                                                    </tr>

                                                    <?php
                                                    if ($totalrow != 0) {
                                                        for ($index = 0; $index < count($data); $index++) {
                                                            print '<tr>';
                                                            print "<td>{$data[$index]['date']}</td>";
                                                            print "<td>{$data[$index]['tracking']}</td>";
                                                            print "<td>{$data[$index]['productlist']}</td>";
                                                            print "<td>{$data[$index]['log']}</td>";
                                                            $check = "check" . $index;
                                                            ?>

                                                            <td>
                                                                <input  style="color:#000" name ="<?php print $check; ?>"   value="confirm" type="submit">
                                                            </td >
                                                            <?php
                                                            print '</tr>';
                                                        }
                                                    } else {
                                                        print "<p style='color:#ff4'>There is no transition.</p>";
                                                    }
                                                    ?>
                                                </table>
                                            </div>

                                            <div><h1 style="color:#fff"><br>CONFIRM AMOUNT</h1>
                                                <table style="width: 90%;margin:auto;color: #fff">

                                                    <tr>
                                                        <th>SKU</th>
                                                        <th>Amount</th>
                                                        <th>Accepted Amount </th>
                                                        <th>Check</th>
                                                    </tr>

                                                    <?php
                                                    $shu = 0;
                                                    for ($index = 0; $index < @count($data); $index++) {
                                                        $check = "check" . $index;
                                                        if (isset($_POST["{$check}"])) {
                                                            $_SESSION['suoyin'] = $index;
                                                            $prolist = json_decode($data[$index]['productlist']);
                                                            for ($i = 0; $i < count($prolist); $i++) {
                                                                print '<tr>';
                                                                print "<td>{$prolist[$i][0]}</td>";
                                                                print "<td>{$prolist[$i][1]}</td>";
                                                                $shu += $prolist[$i][1];
                                                                $dta = "inv" . $i;
                                                                $ceck = "che" . $i;
                                                                ?>
                                                                <td>
                                                                    <input  style="color:#000"  name ="<?php print $dta; ?>"    type="text">
                                                                </td >  
                                                                <td>
                                                                    <input  style="color:#000" name ="<?php print $ceck; ?>"   value="1" type="checkbox">
                                                                </td >                                                                
                                                                <?php
                                                                print '</tr>';
                                                            }
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                                <div class="custom-pagination "  >
                                                    <p style="color:#ff4">Total send amount: <?php print $shu; ?></p>
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
                                        <h1 style="color:#fff">Accept LIST</h1>
                                        <form method="post">
                                            <table style="width: 100%;margin:auto;color:#fff">
                                                <h3>Tracking No.: <?php print @$data[$_SESSION['suoyin']]['tracking']; ?></h3>
                                                <tr>
                                                    <th>SKU</th>
                                                    <th>Amount</th>
                                                </tr>
                                                <?php
//这段控制pickup表格
                                                $total = 0;
                                                if (isset($_POST['submit'])) {
                                                    $todo = array();
                                                    $prolist = json_decode($data[$_SESSION['suoyin']]['productlist']);

                                                    for ($i = 0; $i < count($prolist); $i++) {
                                                        $ceck = "che" . $i;
                                                        $dta = "inv" . $i;
                                                        if (@$_POST["{$ceck}"] != NULL) {
                                                            print '<tr>';
                                                            print "<td>{$prolist[$i][0]}</td>";
                                                            print "<td>" . @$_REQUEST["{$dta}"] . "</td></tr>";
                                                            $total += trim(@$_REQUEST["{$dta}"]);
                                                            $todo[] = array(@$prolist[$i][0], @$_REQUEST["{$dta}"]);
                                                        }
                                                        $_SESSION['todo'] = $todo;
                                                    }
                                                }

                                                //这段控制upload部分      将updoc中的重复项统计并查错                                          
                                                if (isset($_POST['subfile'])) {
                                                    $flag = true;
                                                    $a = 0;
                                                    $total = 0;
                                                    $todo = array();
                                                    for ($ind = 0; $ind < count($updoc); $ind++) {
                                                        $flagl = false;
                                                        for ($i = 0; $i < @count($alldata) && !$flagl; $i++) {
                                                            if ($updoc[$ind][0] == $alldata[$i]['sku'])
                                                                $flagl = true;
                                                        }
                                                        if (!$flagl) {
                                                            $flag = false;
                                                            printf("<script>alert('The product %s unexist!')</script>", $updoc[$ind][0]);
                                                            break;
                                                        }
                                                    }
                                                    if ($flag) {
                                                        for ($i = 0; $i < @count($alldata); $i++) {
                                                            $num = 0;
                                                            for ($ind = 0; $ind < count($updoc); $ind++) {
                                                                if ($alldata[$i]['sku'] == $updoc[$ind][0]) {
                                                                    $a = $i;
                                                                    $num++;
                                                                }
                                                            }
                                                            if ($num != 0) {
                                                                print '<tr>';
                                                                print "<td>{$alldata[$a]['sku']}</td>";
                                                                print "<td> $num  </td></tr>";
                                                                
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
                                                <label class="control-label" style="color:#fff"><br>Notes</label>
                                                <input type="text"  placeholder="Please leave the notes for your attention" value="" name="note"  class="form-control">

                                                <input name="confirm" type="submit" value="Click to confirm">
                                            </div>
                                        </form> 

                                        <?php
                                        if (@isset($_POST['confirm']) && @count($_SESSION['todo']) != 0) {
                                            $productlist = json_encode($_SESSION['todo']);
                                            $sql = "INSERT INTO ncstock (date, productlist, subject,ship, tracking,log) VALUES ('" . $str . "','" . $productlist . "','import' ,'DHL','" . @$data[$_SESSION['suoyin']]['tracking'] . "',' " . $_POST['note'] . "')";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                                $sql = "UPDATE note SET subject='" . $str . " Done. Note:" . $_POST['note'] . "', status='0' where date='" . @$data[$_SESSION['suoyin']]['date'] . "'";
                                                mysqli_query($conn, $sql);

                                                $pro = json_decode($productlist);
                                                for ($i = 0; $i < count($pro); $i++) {
                                                    $sql = "UPDATE product SET nc=nc+" . $pro[$i][1] . " where sku='" . $pro[$i][0] . "'";
                                                    mysqli_query($conn, $sql);
                                                }
                                                $pro = json_decode($data[$_SESSION['suoyin']]['productlist']);
                                                for ($i = 0; $i < count($pro); $i++) {
                                                    $sql = "UPDATE product SET transit=transit-" . $pro[$i][1] . " where sku='" . $pro[$i][0] . "'";
                                                    mysqli_query($conn, $sql);
                                                }
                                                $sql = "UPDATE shstock SET ordernumber=0 where date='" . @$data[$_SESSION['suoyin']]['date'] . "'";
                                                mysqli_query($conn, $sql);
                                                print "<script>alert('Successful!')</script>";
                                            } else {
                                                print "<script>alert('Failue, Please redo!')</script>";
                                            }
                                            unset($_SESSION['todo']);
                                        }
                                        ?>


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