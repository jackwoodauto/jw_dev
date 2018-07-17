<?php session_start();


date_default_timezone_set("Europe/London");

//$doc_root = "/home/frame/V1X5FH6E/htdocs";
$doc_root = "/home/ejdev/PDRJ3F5B/htdocs/";


define(DOC_ROOT, $doc_root);

include_once(DOC_ROOT . '/components/c_connection.php');
include_once(DOC_ROOT . '/components/c_functions.php');

// Define dynamic roots for website and file system - needed becauses this changes in a strange way between https http staging and live
setlocale(LC_MONETARY, 'en_GB');


// Set up some dynamice global settings
$sql = "select * from site_settings";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$_SESSION['site_setting'][strtolower($row['setting_name'])] = strtolower($row['setting_value']);
}

$replace_items = array("/"," "); // unusable directory characters
$domain_dir = str_replace($replace_items,"", strtolower($_SERVER['HTTP_HOST']));
if($domain_dir == ""){
	define(DOMAIN_DIR, $CRON_DOMAIN_DIR);
}else{
	define(DOMAIN_DIR, $domain_dir);
}

if(DOMAIN_DIR != ""){ // Excludes cron jobs
	
	include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_includes.php");

}


?>
