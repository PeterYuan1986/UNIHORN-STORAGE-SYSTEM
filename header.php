<?php

session_start();

?>
<?php

require("libs/database_connection.php");
require ("libs/functions.php");
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'en_US');
$str = date("Y-m-d H:i:s", time());

$sql = "SELECT * FROM note where status= '1'";
$result = mysqli_query($conn, $sql);
$totalnotes = mysqli_num_rows($result);
//$totalpage = ceil($totalrow / $perpage);
if ($totalnotes != 0) {
    while ($arr = mysqli_fetch_array($result)) {
        $datanote[] = $arr;
    }
}

?>