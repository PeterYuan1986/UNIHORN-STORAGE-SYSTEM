<!doctype html>
<?php
require 'header.php';
session_unset();
session_destroy();

?>

<?php
if (isset($_POST["login"])) {
    session_unset();
    session_destroy();
    session_start();
    $user = $_POST["username"];
    $password = $_POST["password"];
    if (!isEmpty($user) && !isEmpty($password)) {
        $sql = "select password,approved,firstname, lastname, office, level,cmpid, childid from employees where username='" . $user . "'";
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            print "<script> alert('The username doesn\'t exist, please registe first!');</script>";
        } else {
            $row = mysqli_fetch_array($result);
            $var = $row[0];
            if ($password != $var) {
                print "<script> alert('The password is not right!');</script>";
            } elseif ($row[1] == 0) {
                print "<script> alert('You account is still waiting for validation by admin!');</script>";
            } else {
                $_SESSION['user_info']['userid'] = $user;
                $_SESSION['user_info']['firstname'] = $row[2];
                $_SESSION['user_info']['lastname'] = $row[3];
                $_SESSION['user_info']['office'] = $row[4];
                $_SESSION['user_info']['level'] = $row[5];
                $_SESSION['user_info']['cmpid'] = $row[6];
                $_SESSION['user_info']['childid'] = json_decode($row[7],true);
                $_SESSION['discard_after'] = time() + 900;
                header("Location:homepage.php");
            }
        }
    }
}
?>
<html class="no-js" lang="en">


    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login | Nalika - Material Admin Template</title>
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
        <!-- forms CSS
                    ============================================ -->
        <link rel="stylesheet" href="css/form/all-type-forms.css">
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

        <div class="color-line"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="back-link back-backend">
                        <a href="http://www.google.com" class="btn btn-primary">Back to www.unihorn.com</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                <div class="col-md-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="text-center m-b-md custom-login">   


                        <h3>YOU HAVE BEEN LOGGED OUT SUCCESSFULLY!</h3>

                        <p>This is the best app ever!</p>
                    </div>
                    <div class="hpanel">
                        <div class="panel-body">
                            <form name="form" method="post"  action="#" id="loginForm">
                                <div class="form-group">
                                    <label class="control-label" for="username">Username</label>
                                    <input type="text" placeholder="Please enter you username" title="Please enter you username" required="" value="" name="username" id="username" class="form-control">
                                    <span class="help-block small">Your unique username to app</span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password">Password</label>
                                    <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                                    <span class="help-block small">Your strong password</span>
                                </div>
                                <!--<div class="checkbox login-checkbox">
                                    <label>
                                        <input type="checkbox" class="i-checks"> Remember me </label>
                                    <p class="help-block small">(if this is a private computer)</p>
                                </div>-->
                                <div >
                                    <input type="submit" name="login" value="Login" class="btn btn-success btn-block loginbtn">  
                                    <a class="btn btn-default btn-block" href="register.php">Register</a> 

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
            </div>
            <div class="row">
                <div class="col-md-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p>Copyright © 2019 <a href="https://www.unihorn.tech">Unihorn </a>. All rights reserved.</p>
                    <p><?php print "Local Time(GMT-5): " . strftime($str); ?></p>
                    <img src="img/unihorn-1.gif">
                </div>
            </div>
        </div>

        <!-- jquery
                    ============================================ -->
        <script src="js/vendor/jquery-1.11.3.min.js"></script>
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
        <!-- tab JS
                    ============================================ -->
        <script src="js/tab.js"></script>
        <!-- icheck JS
                    ============================================ -->
        <script src="js/icheck/icheck.min.js"></script>
        <script src="js/icheck/icheck-active.js"></script>
        <!-- plugins JS
                    ============================================ -->
        <script src="js/plugins.js"></script>
        <!-- main JS
                    ============================================ -->
        <script src="js/main.js"></script>    

    </body>



</html>