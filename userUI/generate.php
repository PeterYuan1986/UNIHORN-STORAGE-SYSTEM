<?php
require 'header.php';
require "vendor/autoload.php";
$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
$code = $Bar->getBarcode($_SESSION['detailsku'], $Bar::TYPE_CODE_128);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>UniHorn  Email:Unihornstore@gmail.com</title>
        <style>
            body, html {
                height: 100%;
            }
            .bg {                
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            #qrbox>div {
                margin: auto;
            }
        </style>
    </head>
    <body class="bg">
        <div class="container" id="panel">
            
            <div class="row">
                <div class="col-md-6 offset-md-3" style="background: white; padding: 0px;">
                    <div class="panel-heading">
                        <h1><?php print $_SESSION['detailsku']; ?></h1>
                    </div>
                    <div >
                        <?php echo $code ?>
                    </div>
                    <div>
                        <h2>Check List</h2>
                        <p><i class="fa fa-pencil-square-o" aria-hidden="true">>>USB,STAT,VGA,HDMI PORTS,.ETC</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">>>RAM SLOTS</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">>>CPU PINS</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">>>SCREEN POST</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">>>BIOS UPDATES</i></p>
                        <p><?php print "Local Time(GMT-5): " . strftime($str); ?></p> 
                        <p>Email:Unihornstore@gmail.com</i></p>
                        <p>TEL:+1(832)841-0760</i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>