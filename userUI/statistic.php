<?php // content="text/plain; charset=utf-8"
require 'header.php';
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

$sql1 = "SELECT productlist FROM `shstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order' AND market='Amazon'";
$result1 = mysqli_query($conn, $sql1);
$sh01 = @mysqli_num_rows($result1);
$sql2 = "SELECT productlist FROM `shstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order' AND market='Ebay'";
$result2 = mysqli_query($conn, $sql2);
$sh02 = @mysqli_num_rows($result2);
$sql3 = "SELECT productlist FROM `shstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='NewEgg'";
$result3 = mysqli_query($conn, $sql3);
$sh03 = @mysqli_num_rows($result3);


$sql4 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='Amazon'";
$result4 = mysqli_query($conn, $sql4);
$sh11 = @mysqli_num_rows($result4);
$sql5 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='Ebay'";
$result5 = mysqli_query($conn, $sql5);
$sh12 = @mysqli_num_rows($result5);
$sql6 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='NewEgg'";
$result6 = mysqli_query($conn, $sql6);
$sh13 = @mysqli_num_rows($result6);

$sql7 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='Amazon'";
$result7 = mysqli_query($conn, $sql7);
$sh21 = @mysqli_num_rows($result7);
$sql8 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='Ebay'";
$result8 = mysqli_query($conn, $sql8);
$sh22 = @mysqli_num_rows($result8);
$sql9 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='NewEgg'";
$result9 = mysqli_query($conn, $sql9);
$sh23 = @mysqli_num_rows($result9);

$sql10 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='Amazon'";
$result10 = mysqli_query($conn, $sql10);
$sh31 = @mysqli_num_rows($result10);
$sql11 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='Ebay'";
$result11 = mysqli_query($conn, $sql11);
$sh32 = @mysqli_num_rows($result11);
$sql12 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='NewEgg'";
$result12 = mysqli_query($conn, $sql12);
$sh33 = @mysqli_num_rows($result12);

$sql13 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='Amazon'";
$result13 = mysqli_query($conn, $sql13);
$sh41 = @mysqli_num_rows($result13);
$sql14 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='Ebay'";
$result14 = mysqli_query($conn, $sql14);
$sh42 = @mysqli_num_rows($result14);
$sql15 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='NewEgg'";
$result15 = mysqli_query($conn, $sql15);
$sh43= @mysqli_num_rows($result15);

$sql16 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='Amazon'";
$result16 = mysqli_query($conn, $sql16);
$sh51 = @mysqli_num_rows($result16);
$sql17 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='Ebay'";
$result17 = mysqli_query($conn, $sql17);
$sh52 = @mysqli_num_rows($result17);
$sql18 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='NewEgg'";
$sh53 = @mysqli_num_rows($result18);

$sql19 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='Amazon'";
$result19 = mysqli_query($conn, $sql19);
$sh61 = @mysqli_num_rows($result19);
$sql20 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='Ebay'";
$result20 = mysqli_query($conn, $sql20);
$sh62 = @mysqli_num_rows($result20);
$sql21 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='NewEgg'";
$result21 = mysqli_query($conn, $sql21);
$sh63 = @mysqli_num_rows($result21);

$sql22 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='Amazon'";
$result22 = mysqli_query($conn, $sql22);
$sh71 = @mysqli_num_rows($result22);
$sql23 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='Ebay'";
$result23 = mysqli_query($conn, $sql23);
$sh72 = @mysqli_num_rows($result23);
$sql24 = "SELECT productlist FROM `shstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='NewEgg'";
$result24 = mysqli_query($conn, $sql24);
$sh73 = @mysqli_num_rows($result24);

$mysql1 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order' AND market='Amazon'";
$jieguo1 = mysqli_query($conn, $mysql1);
$nc01 = @mysqli_num_rows($jieguo1);
$mysql2 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order' AND market='Ebay'";
$jieguo2 = mysqli_query($conn, $mysql2);
$nc02 = @mysqli_num_rows($jieguo2);
$mysql3 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN CURRENT_DATE() AND ADDDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='NewEgg'";
$jieguo3 = mysqli_query($conn, $mysql3);
$nc03 = @mysqli_num_rows($jieguo3);


$mysql4 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='Amazon'";
$jieguo4 = mysqli_query($conn, $mysql4);
$nc11 = @mysqli_num_rows($jieguo4);
$mysql5 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='Ebay'";
$jieguo5 = mysqli_query($conn, $mysql5);
$nc12 = @mysqli_num_rows($jieguo5);
$mysql6 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND CURRENT_DATE() AND subject='order' AND market='NewEgg'";
$jieguo6 = mysqli_query($conn, $mysql6);
$nc13 = @mysqli_num_rows($jieguo6);

$mysql7 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='Amazon'";
$jieguo7 = mysqli_query($conn, $mysql7);
$nc21 = @mysqli_num_rows($jieguo7);
$mysql8 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='Ebay'";
$jieguo8 = mysqli_query($conn, $mysql8);
$nc22 = @mysqli_num_rows($jieguo8);
$mysql9 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 1 day) AND subject='order'AND market='NewEgg'";
$jieguo9 = mysqli_query($conn, $mysql9);
$nc23 = @mysqli_num_rows($jieguo9);

$mysql10 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='Amazon'";
$jieguo10 = mysqli_query($conn, $mysql10);
$nc31 = @mysqli_num_rows($jieguo10);
$mysql11 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='Ebay'";
$jieguo11 = mysqli_query($conn, $mysql11);
$nc32 = @mysqli_num_rows($jieguo11);
$mysql12 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 2 day) AND subject='order' AND market='NewEgg'";
$jieguo12 = mysqli_query($conn, $mysql12);
$nc33 = @mysqli_num_rows($jieguo12);

$mysql13 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='Amazon'";
$jieguo13 = mysqli_query($conn, $mysql13);
$nc41 = @mysqli_num_rows($jieguo13);
$mysql14 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='Ebay'";
$jieguo14 = mysqli_query($conn, $mysql14);
$nc42 = @mysqli_num_rows($jieguo14);
$mysql15 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 3 day) AND subject='order' AND market='NewEgg'";
$jieguo15 = mysqli_query($conn, $mysql15);
$nc43= @mysqli_num_rows($jieguo15);

$mysql16 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='Amazon'";
$jieguo16 = mysqli_query($conn, $mysql16);
$nc51 = @mysqli_num_rows($jieguo16);
$mysql17 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='Ebay'";
$jieguo17 = mysqli_query($conn, $mysql17);
$nc52 = @mysqli_num_rows($jieguo17);
$mysql18 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 4 day) AND subject='order' AND market='NewEgg'";
$jieguo18 = mysqli_query($conn, $mysql18);
$nc53 = @mysqli_num_rows($jieguo18);

$mysql19 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='Amazon'";
$jieguo19 = mysqli_query($conn, $mysql19);
$nc61 = @mysqli_num_rows($jieguo19);
$mysql20 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='Ebay'";
$jieguo20 = mysqli_query($conn, $mysql20);
$nc62 = @mysqli_num_rows($jieguo20);
$mysql21 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 5 day) AND subject='order' AND market='NewEgg'";
$jieguo21 = mysqli_query($conn, $mysql21);
$nc63 = @mysqli_num_rows($jieguo21);

$mysql22 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='Amazon'";
$jieguo22 = mysqli_query($conn, $mysql22);
$nc71 = @mysqli_num_rows($jieguo22);
$mysql23 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='Ebay'";
$jieguo23 = mysqli_query($conn, $mysql23);
$nc72 = @mysqli_num_rows($jieguo23);
$mysql24 = "SELECT productlist FROM `ncstock` WHERE date BETWEEN SUBDATE(CURRENT_DATE(),INTERVAL 7 day) AND SUBDATE(CURRENT_DATE(),INTERVAL 6 day) AND subject='order' AND market='NewEgg'";
$jieguo24 = mysqli_query($conn, $mysql24);
$nc73 = @mysqli_num_rows($jieguo24);


// Some data
$datay1 = array($sh71+$nc71, $sh61+$nc61, $sh51+$nc51, $sh41+$nc41, $sh31+$nc31, $sh21+$nc21,$sh11+$nc11,$sh01+$nc01);
$datay2 = array($sh72+$nc72, $sh62+$nc62, $sh52+$nc52, $sh42+$nc42, $sh32+$nc32, $sh22+$nc22,$sh12+$nc12,$sh02+$nc02);
$datay3 = array($sh73+$nc73, $sh63+$nc63, $sh53+$nc53, $sh43+$nc43, $sh33+$nc33, $sh23+$nc23,$sh13+$nc13,$sh03+$nc03);
//$datay4 = array($sh71+$nc71+$sh72+$nc72+$sh73+$nc73, $sh61+$nc61+$sh62+$nc62+$sh63+$nc63, $sh51+$nc51+$sh52+$nc52+$sh53+$nc53, $sh41+$nc41+$sh42+$nc42+$sh43+$nc43, $sh31+$nc31+$sh32+$nc32+$sh33+$nc33, $sh21+$nc21+$sh22+$nc22+$sh23+$nc23,$sh11+$nc11+$sh12+$nc12+$sh13+$nc13, $sh01+$nc01+$sh02+$nc02+$sh03+$nc03);



// Create the basic graph
$graph = new Graph(1200,590,'auto');
$graph->clearTheme();
$graph->SetScale("int");
$graph->img->SetMargin(40,80,30,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.5');
$graph->legend->SetFillColor('lightblue@0.3');


$seven = time()-7*24*60*60;
$six = time()-6*24*60*60;
$five = time()-5*24*60*60;
$four = time()-4*24*60*60;
$three = time()-3*24*60*60;
$two = time()-2*24*60*60;
$one = time()-1*24*60*60;
$onemore = time()+1*24*60*60;
$a= array(date("m/d/y",$seven),date("m/d/y",$six),date("m/d/y",$five),date("m/d/y",$four),date("m/d/y",$three),date("m/d/y",$two),date("m/d/y",$one),date("m/d/y"),date("m/d/y",$onemore));
$graph->xaxis->SetTickLabels($a);

// Set a nice summer (in Stockholm) image
$graph->SetBackgroundImage('img/navyblue.jpg',BGIMG_COPY);

// Set axis titles and fonts
$graph->xaxis->title->Set('');
$graph->xaxis->title->SetFont(FF_TIMES,FS_NORMAL,15);
$graph->xaxis->title->SetColor('white');

$graph->xaxis->SetFont(FF_TIMES,FS_NORMAL,15);
$graph->xaxis->SetColor('white');

$graph->yaxis->SetFont(FF_TIMES,FS_NORMAL,15);
$graph->yaxis->SetColor('white');

//$graph->ygrid->Show(false);
$graph->ygrid->SetColor('white@0.5');

// Setup graph title
$graph->title->Set('Order Statistic');
$graph->title->SetColor('white');
// Some extra margin (from the top)
$graph->title->SetMargin(10);
$graph->title->SetFont(FF_TIMES,FS_NORMAL,20);

// Create the three var series we will combine
$bplot1 = new BarPlot($datay1);
$bplot2 = new BarPlot($datay2);
$bplot3 = new BarPlot($datay3);

// Setup the colors with 40% transparency (alpha channel)
$bplot1->SetFillColor('orange@0.4');
$bplot2->SetFillColor('brown@0.4');
$bplot3->SetFillColor('darkgreen@0.4');

// Setup legends
$bplot1->SetLegend('Amazon');
$bplot2->SetLegend('Ebay');
$bplot3->SetLegend('New Egg');

// Setup each bar with a shadow of 50% transparency
$bplot1->SetShadow('black@0.2');
$bplot2->SetShadow('black@0.2');
$bplot3->SetShadow('black@0.2');

$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3));
$gbarplot->SetWidth(0.6);
$graph->Add($gbarplot);

$graph->Stroke();
?>
