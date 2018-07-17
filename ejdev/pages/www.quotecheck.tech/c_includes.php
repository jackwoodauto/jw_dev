<?php

include(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_functions.php");
include(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_login_functions.php");

set_include_path (DOC_ROOT . "/pages/" . DOMAIN_DIR . "/classes");

spl_autoload_register ();

$additional_footer_scripts = array();

$additional_footer_code_array = array();

$additional_header_code_array = array();

$stripe =
 array(
  //"secret_key => " "sk_test_ODx3OuaCT2SfBoooKPlxQyZb"
  //"publishable_key" => "pk_test_HontjU0V6Ez1kRxWVOazetMn"

  "publishable_key" => "pk_test_HontjU0V6Ez1kRxWVOazetMn",
  "secret_key"      => "sk_test_ODx3OuaCT2SfBoooKPlxQyZb"
);

// Add includes for this domain here
//define(GMAP_API_MONEYPATCH,"AIzaSyCWf_HF5_dclbxSIaPCx_Y5oFDkafBzb8w");

/*define(GMAP_API_MONEYPATCH,"AIzaSyALpnrjB3Fh2YqoxCNR_z7LHFImOUL2Ojc");

define(PATCH_SIZE,$_SESSION['site_setting']['mp_patch_size']);

define(ZONE_SIZE,$_SESSION['site_setting']['mp_zone_size']);

$ip_info_array = ip_info();

if($ip_info_array["country"]=="United Kingdom"){
	//define(LOCAL_PRIZE,"£100");
	define("CURRENCY_SYMBOL", "&pound;");
}elseif($ip_info_array["country_code"]=="EU"){
	define("CURRENCY_SYMBOL", "&euro;");
}elseif($ip_info_array["country_code"]=="US"){
	define("CURRENCY_SYMBOL", "&#36;");
}else{
	define("CURRENCY_SYMBOL", "&pound;");
}

define(LOCAL_PRIZE,"£100");

if (
    strpos($_SERVER["HTTP_USER_AGENT"], "(iPod|iPhone|iPad)") !== false ||
    strpos($_SERVER["HTTP_USER_AGENT"], "FBAV") !== false
) {
    // it is probably Facebook
	define(IS_PROBABLY_FACEBOOK_BROWSER, true);
}
else {
    // that is not Facebook
	define(IS_PROBABLY_FACEBOOK_BROWSER, false);
}


define(PATCH_AVAILABLE_COLOR, "#f5a71d");
define(PATCH_OWNER_COLOR, "#00FF00");
define(PATCH_TAKEN_COLOR, "#ee365c");

define(RECAPTCHA_SITE_KEY,"6LcZUyQTAAAAACyTof1UPyl0HldbZ7Cax8ha7KD_");
define(RECAPTCHA_SECRET_KEY,"6LcZUyQTAAAAAOj6KG9Ig2PQ1VzNYviGzzKlxSqd");


$day_of_week = strtolower(date("l"));

$sql = "select * from mp_daily_messages where lower(day_of_week) = '$day_of_week'";
$result = mysql_query($sql);

if($row = mysql_fetch_assoc($result)){

	$_SESSION['site_setting']['mp_referral_bonus'] = $row['referral_bonus'];

}
*/

//$_SESSION['user']['id']=1;

define(RECAPTCHA_SITE_KEY,"6LcG8ygUAAAAAKCQVgA0Nvpv3nrjXA32kfUPaoYZ");
define(RECAPTCHA_SECRET_KEY,"6LcG8ygUAAAAAJl6ySwAnkfHtZrhO8pVo0CNhbqv");



define(DEBUG_PHP,"true");
define(DEBUG_JAVASCRIPT,"true");


?>
