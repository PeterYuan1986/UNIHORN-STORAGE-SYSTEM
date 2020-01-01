<?php 
require 'header.php';
?>


<?php
$user = @$_POST["user"];
$fn=@$_POST['fn'];
$ln=@$_POST['ln'];
$pwd1 = @$_POST["pwd1"];
$pwd2 = @$_POST["pwd2"];
$email1 = @$_POST["email1"];
$email2 = @$_POST["email2"];
if (@$_POST["register"] == "Register") {
    if (checkinput($user, $fn, $ln, $pwd1, $pwd2, $email1, $email2)) {
        require('libs/database_connection.php');
        $sql = "select * from employees where username='" . $user . "'";
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            
            $sql = "insert into employees(username,firstname, lastname, password, email,time) values('" . $user . "','" . $fn . "','" . $ln . "','" . $pwd1 . "','" . $email1 . "','".$str."')";
                        $result = mysqli_query($conn, $sql);
            print '<script>alert("Registration Successful! Please wait the administrator to approve!")</script>';
            print '<script> location.replace("index.php"); </script>';
        } else {
            print '<script>alert("The user name has existed, please change another username.")</script>';
        }
    }
}

function checkinput($user, $fn, $ln, $pwd1, $pwd2, $email1, $email2) {
    if (isEmpty($user)) {
        print '<script>alert("The user name should not be empty!")</script>';
        return FALSE;
    }
    if (isEmpty($fn)|| isEmail($ln)) {
        print '<script>alert("Please input your first name and last name!")</script>';
        return FALSE;
    }
    
    if (isEmpty($pwd1) || isEmpty($pwd2)) {
        print '<script>alert("The password should not be empty!")</script>';
        return FALSE;
    } else {
        if ($pwd1 !== $pwd2) {
            print '<script> alert("The password should be same!")</script>';
            return FALSE;
        }
    }
    if (isEmpty($email1) || isEmpty($email2)) {
        print '<script>alert("The email should not be empty!")</script>';
        return FALSE;
    } else {
        if (!isEmail($email1) || !isEmail($email2)) {
            print '<script> alert("The email format not match!")</script>';
            return FALSE;
        } else {
            if ($email1 != $email2) {
                print '<script> alert("The email should be same!")</script>';
                return FALSE;
            }
        }
    }
    return TRUE;
}
?>



<html class="no-js" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Register</title>
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
                        <a href="index.php" class="btn btn-primary">Go Back to Login Page</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                <div class="col-md-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="text-center custom-login">
                        <h3>Registration</h3>
                        <p>Admin template with very clean and aesthetic style prepared for your next app. </p>
                    </div>
                    <div class="hpanel">
                        <div class="panel-body">
                            <form name="form" method="post" action="#" id="loginForm">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>Username</label>
                                        <input name="user" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>First Name</label>
                                        <input name="fn" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Last Name</label>
                                        <input name="ln" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Password</label>
                                        <input name="pwd1" type="password" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Repeat Password</label>
                                        <input name="pwd2" type="password" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Email Address</label>
                                        <input name="email1" type="text" class="form-control">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Repeat Email Address</label>
                                        <input name="email2" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <input name="register" value="Register" type="submit"  class="btn btn-success loginbtn">
                                    <button class="btn btn-default">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright © 2019 <a href="https://www.unihorn.tech">Unihorn</a> All rights reserved.</p>
                    <p><?php print "Local Time(GMT-5): " . strftime($str); ?></p>
                    <p><image src="img/unihorn-1.gif"</p>
                </div>
            </div>
        </div>


    </body>

</html>