<?php if($_SESSION['user']['id']>0){ header("Location: https://www.quotecheck.tech/my_home"); die();}  ?>
<?php


include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_login_ajax.php");



$title = $page['title'];
$description = $page['meta_description'];
$keywords = $page['meta_keywords'];
if($page['og_image']==""){

	$page['og_image'] = "";

}

$uri = $_SERVER['REQUEST_URI'];
$url = 'http://www.quotecheck.tech' . $uri;


?>
<!DOCTYPE html>
<html dir="ltr" lang="en"><head>

	<!-- Meta tags
	============================================= -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="AutomationSquared.com" />

	<meta name="description" content="<?php echo($description); ?>" />
    <meta name="keywords" content="<?php echo($keywords); ?>" />

    <meta property="og:title" content="<?php echo($title); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo($url); ?>" />


    <meta property="og:image" content="https://www.quotecheck.tech<?php echo($page['og_image']); ?>" />

    <meta property="og:description" content="<?php echo($description); ?>" />
    <meta property="og:site_name" content="quotecheck.tech" />


    <META HTTP-EQUIV="Content-Language" Content="en">

    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<meta name="google-site-verification" content="wyLRV2t8gUpQUfecEJH6_7dttnK30WVzgMo8kh0xgqs" />

	<?php
	if($page['for_site_map']==0){

		?>
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
		<?php

	}

	?>
	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/style.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/swiper.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="/resources/canvas/HTML/css/font-awesome.min.css" type="text/css" />


	<!-- Bootstrap File Upload CSS -->
	<link rel="stylesheet" href="/resources/canvas/HTML/css/components/bs-filestyle.css" type="text/css" />

	<!-- Bootstrap Switch CSS -->
	<link rel="stylesheet" href="/resources/canvas/HTML/css/components/bs-switches.css" type="text/css" />

	<!-- Radio Checkbox Plugin -->
	<link rel="stylesheet" href="/resources/canvas/HTML/css/components/radio-checkbox.css" type="text/css" />


	<link rel="stylesheet" href="/resources/canvas/HTML/css/df_responsive_v2.css" type="text/css" />
	<link rel="stylesheet" href="/resources/df_global_v18.css"/>


	<!-- http://www.quotecheck.tech/ -->
	<link rel="stylesheet" href="/resources/qc_global_v1.css"/>
	<link rel="stylesheet" href="/resources/qc_text.css"/>
	<link rel="stylesheet" href="/resources/xxxqc_jack_v1.css"/>
	<link rel="stylesheet" href="/resources/qc_animate.css"/>
	<link rel="stylesheet" href="/resources/qc_login.css"/>

	<link rel="shortcut icon" type="image/png" href="../../imgs/quotecheck/favicon.png" />
	<link rel="shortcut icon" type="image/png" href="http://www.quotecheck.tech/imgs/quotecheck/favicon.png" />

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/jquery.js"></script>
	<script type="text/javascript"  src="/resources/df_global_v5.js"></script>
	<script type="text/javascript"  src="/resources/qc_global_preloader.js"></script>

	<!-- Additional header code
	============================================= -->
	<?php

	foreach ($additional_header_code_array as $key => $value){

		echo($value);

	}

	unset($additional_header_code_array);

	?>


	<!-- Document Title
	============================================= -->
	<title><?php echo($title); ?></title>

</head>



<body class="stretched" data-loader-timeout="3000">
	<?php get_page_alert(); ?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=163082767568198";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<!-- Document Wrapper
	============================================= -->
	<div  id="wrapper" class="clearfix">


		<?php
		include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_login_form.php");
		?>

		<!-- Header
		============================================= -->
		<?php if($page['header_type']==1){ ?>

			<header id="header" class="full-header dark">

				<div id="header-wrap">

						<div class="container clearfix">

							<!-- Logo
							============================================= -->
							<div id="logo" style="border-right:0 !important;">
								<!-- <a href="/" class="standard-logo" data-dark-logo="../../imgs/quotecheck/quotecheck_logo.png"><img src="../../imgs/quotecheck/quotecheck_logo.png" alt="quote check logo"></a>
								<a href="/" class="retina-logo" data-dark-logo="../../imgs/quotecheck/quotecheck_logo.png"><img src="../../imgs/quotecheck/quotecheck_logo.png" alt="quote check logo"></a> -->
	              <a href="/" class="standard-logo" data-dark-logo="../../imgs/quotecheck/quotecheck_small.png"><img src="../../imgs/quotecheck/quotecheck_small.png" alt="quote check logo"></a>
	              <a href="/" class="retina-logo" data-dark-logo="../../imgs/quotecheck/quotecheck_large.png"><img src="../../imgs/quotecheck/quotecheck_large.png" alt="quote check logo"></a>
							</div><!-- #logo end -->

							<nav id="primary-menu">

								<ul>
									<?php /*
									<li class="<?php echo($main_menu_class['home']); ?>"><a href="/"><div>Home</div></a>

									</li>

									<li class="<?php echo($main_menu_class['shows']); ?>"><a href="#"><div>Showing</div></a>
										<ul>
											<li><a href="/shop/"><div>Fun &amp; Useful</div></a></li>

											<li><a href="/photo-shop/"><div>Photo Shop</div></a></li>

										</ul>
									</li>

									*/ ?>

								</ul>


								<ul class='norightborder norightpadding norightmargin'>
									<?php if($_SESSION['user']['id']>0){ ?>

										<li><a href="/logout/">Log Out</a></li>

									<?php }else{  ?>

										<li><a href="#" onclick="$('#modal_login').modal('show');" class="">Sign In / Sign Up</a></li>

									<?php } ?>
								</ul>

							</nav>

						</div>

					</div>
 			</header>

		<section  id="page-title" class="page-title-parallax"  style=" background-image: url('../../imgs/quotecheck/banner/stacks_of_paper_2.jpg'); background-size: cover; background-position: center center;" data-stellar-background-ratio="0.4">

		<div class="container clearfix top-header">
			<div class="heading-block center">
				<div class="qc-text-shadow animated fadeInUp">
					<h1 data-caption-animate="fadeInUp" class="fadeInUp animated main-title-black" >PAPER QUOTE TO INVOICE CHECKER</h1>
					<span data-caption-animate="fadeInUp" class="divcenter fadeInUp animated main-title-black">compare your paper quotes with their corresponding invoices to identify any discrepancies</span>
				</div>
			</div>
		</div>

		</section><!-- #page-title end -->
		<?php

		 } ?>
