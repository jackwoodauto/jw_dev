<?php

include_once("../components/c_includes.php");

$requested = empty($_SERVER['REQUEST_URI']) ? false : $_SERVER['REQUEST_URI'];



// Strip get paramters out
if (strpos($requested,"?")!==false){
	$url_params = substr($requested, strpos($requested,"?"));
	$requested = substr($requested, 0, strpos($requested,"?"));

}

$requested = strtolower(mysql_real_escape_string($requested));

// Cater for trailing "/" if not provided by the user
if (substr($requested,-1,1) != "/"){
	$requested = $requested . "/";
}

if($_GET['ref']!=""){

	$_SESSION['referral_id'] = 	$_GET['ref'];

}

if(DOMAIN_DIR == "www.quotecheck.tech"){


	if($requested=='/logout/'){



		$requested = "/";
		ss_logout();


		header("Location: https://" . DOMAIN_DIR);
		die();

	}


	if (($_GET['com1g'] > 0) && ($_GET['com2g']  > 0)){

		// Logon from email

		ss_login($_GET['com1g'], $_GET['com2g'] );


	}elseif (($_COOKIE['com1x'] > 0) && ($_COOKIE['com2x']  > 0)){

		// Logon from cookie

		ss_login($_COOKIE['com1x'], $_COOKIE['com2x']);


	}
}



if($_SESSION['user']['id'] > 0){

	define("SHOW_CURRENCY",$_SESSION['user']['currency']);

}else{

	define("SHOW_CURRENCY",CURRENCY_SYMBOL);

}


$page_found = false;
$sql = "select * from pages where domain = '" . DOMAIN_DIR . "' and url = '$requested' and status = 1";
if($_GET['preview']==1){

	$sql = "select * from pages where domain = '" . DOMAIN_DIR . "' and url = '$requested'";

}



$redirect_url = "";
$result = mysql_query($sql);
if ($page = mysql_fetch_assoc($result)){

	$_SESSION['page'] = $page;

	if ($page['redirect_id']>0){

		// Loop through the DB to find the first row without a redirect
		// for safety loop no more than the max number of rows + 1, then log page error if not found
		$sql = "select count(*) as rows from pages";
		$result_maxrows = mysql_query($sql);
		$maxrows = mysql_fetch_assoc($result_maxrows);
		for($row=1;$row<=$maxrows['rows']+1;$row++){
			$sql = "select * from pages where id = " . $page['redirect_id'];
			$result_redirect = mysql_query($sql);
			if (!$page = mysql_fetch_assoc($result_redirect)){
				break;
			}else{
				if ($page['redirect_id']==0){
					// Page found after 1 or more redirects
					$page_found = true;

					$redirect_url = $page['domain'] . $page['url'];
					break;
				}
			}
		}

		if ($row > $maxrows['rows']){
			//$LMPLog->LogError("Circular redirect for url $requested");
		}
	}else{
		// No redirects on the first page
		$page_found = true;
	}
}

if ($page_found){


	if ($redirect_url != ""){
		header("Location: http://" . $redirect_url);
		die();
	}


	$page_go = false;
	if ($page['is_secure']){

		$_SESSION['secure_page_url'] = $requested . $url_params;

		if($_SESSION['user']['id']>0){

			if($page['is_secure']==2 && $_SESSION['password_auth'] != 1 && $_GET['orchard'] != "60261"){

				include(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/page_password_login.php");
				// This needs to be upgraded to invoke the modal login form - perhaps create a page which invokes it via JS by default

			}else{

				$page_go = true;

			}
			//include(DOC_ROOT . "pages/" . $page['layout_file']);
		}else{

			//if(DOMAIN_DIR == "www.storysnippets.org"){

				header("Location: http://" . DOMAIN_DIR . "/login/");

			//}else{

			//	header("Location: http://" . DOMAIN_DIR . "/#login_tag");

			//}

			die();

			//include(DOC_ROOT . "/pages/layout_page_secure_login.php");
		}
	}else{
		$page_go = true;
	}

	if($page_go){


		include(DOC_ROOT . "/pages/" . $page['layout_file']);

	}

}else{

	header("HTTP/1.0 404 Not Found");
	include(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/error_404.php");

}


?>
