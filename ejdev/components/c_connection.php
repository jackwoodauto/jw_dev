<?php
$hostname_conp = "localhost";
$database_conp = "ejdev_db";
$username_conp = "ejdev_db";
$password_conp = "autoSquared01_db";
$conp = mysql_pconnect($hostname_conp, $username_conp, $password_conp) or die(mysql_error());
mysql_select_db($database_conp, $conp);

// For OO
define(DB_HOST, $hostname_conp);
define(DB_DB, $database_conp);
define(DB_USER, $database_conp);
define(DB_PASS, $password_conp);


?>
