<?php
require 'header.php';
require "vendor/autoload.php";
$Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
$code = $Bar->getBarcode($_SESSION['detailbar'], $Bar::TYPE_CODE_128);
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
                <div class="col-md-6 " style="background: white; padding: 0px;">
                    <div class="panel-heading">
                        <h3><?php print $_SESSION['detailsku']; ?></h3>
                        <?php echo $code ?>
                        <h4>NOTICE BEFORE OPEN THE BOX</h4>
                        <p><i class="fa fa-pencil-square-o" aria-hidden="true">1.Please make sure the CPU lid is on when you unpack the motherboard and be carefull when you take the CPU lid off and don't touch the CPU pins.</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">2.Please make sure the CPU pins is good when you take off the lid, otherwise, please send us a picture and don't use the Mobo if the pins were damaged.</i></p>                        
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">3.Please clean the RAM, unplug the CMOS battery, and replug it after 3 mins if the Mobo can't be POST. That will reset the CMOS which will solve most of the problems.</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">4.Please put the CPU lid on and wrap the Mobo carefully if you want to return it.</i></p>
                        <p> <i class="fa fa-pencil-square-o" aria-hidden="true">5.Feel free to contact us if you have any issues.</i></p>
                        <p><i>Email:contact@unihorn.tech (Preferred)</i></p>
                        <p><i>TEL:+1(832)841-0760</i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>