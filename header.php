<?php

session_start();

?>
<?php

require("libs/database_connection.php");
require ("libs/functions.php");
date_default_timezone_set('America/New_York');
setlocale(LC_ALL, 'en_US');
$str = date("Y-m-d H:i:s", time());
?>