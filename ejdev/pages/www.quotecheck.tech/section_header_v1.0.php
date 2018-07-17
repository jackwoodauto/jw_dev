<?php 


$title = $page['title'];
$description = $page['meta_description'];
$keywords = $page['meta_keywords'];
if($page['og_image']==""){
	
	$page['og_image'] = "/imgs/dogfocus/dog_focus_facebook.png";
	
}


$uri = $_SERVER['REQUEST_URI'];
$url = 'https://www.dogfocus.co.uk' . $uri;





?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

	<!-- Meta tags
	============================================= -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="AutomationSquared.com" />

	<meta name="description" content="<?php echo($description); ?>" />
    <meta name="keywords" content="<?php echo($keywords); ?>" />
    
    <meta property="og:title" content="<?php echo($title); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo($url); ?>" />
    
    
    <meta property="og:image" content="https://www.dogfocus.co.uk<?php echo($page['og_image']); ?>" />
    
    <meta property="og:description" content="<?php echo($description); ?>" />
    <meta property="og:site_name" content="dogfocus.co.uk" /> 
    <meta property="fb:app_id" content="163082767568198" />    
    
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
	
	<link rel="shortcut icon" type="image/png" href="/imgs/dogfocus/favicon.png" />
	<link rel="shortcut icon" type="image/png" href="https://www.dogfocus.co.uk/imgs/dogfocus/favicon.png" />
	
	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="/resources/canvas/HTML/js/jquery.js"></script>
	<script type="text/javascript"  src="/resources/df_global_v5.js"></script>

	
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
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<?php if($page['header_type']==1){ 
		
		?>
			<header id="header" class="transparent-header full-header" data-sticky-class="not-dark">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="/" class="standard-logo" data-dark-logo="/resources/canvas/HTML/images/logo-dark.png"><img src="/resources/canvas/HTML/images/logo.png" alt="Dog Focus Logo"></a>
						<a href="/" class="retina-logo" data-dark-logo="/resources/canvas/HTML/images/logo-dark@2x.png"><img src="/resources/canvas/HTML/images/logo@2x.png" alt="Dog Focus Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="">

						<ul>
							<?php if($_SESSION['user']['id']>0){ 
								
								$to_read_badge = "";
								$to_read = get_number_unread_articles();
								if($to_read>0){
									$to_read_badge = " <div class='badge df-badge-danger'>$to_read</div>";
								}
			
							?>
							
							<li class="<?php echo($main_menu_class['daily feed']); ?>"><a href="/daily-feed/"><div>Daily Feed<?php echo($to_read_badge); ?></div></a>
								
							</li>
							
							<?php }else{ ?>
							
							<li class="<?php echo($main_menu_class['home']); ?>"><a href="/"><div>Home</div></a>
								
							</li>
							
							<?php } ?>
							<?php /* <li class="<?php echo($main_menu_class['news']); ?>"><a href="/coming-soon/"><div>News <div class="badge">12</div></div></a>
								
							</li> 
							<li><a href="/"><div>Showing</div></a>
								
							</li>*/ ?>
							
							<li class="<?php echo($main_menu_class['shows']); ?>"><a href="#"><div>Showing</div></a>
								<ul>
									<li><a href="/showing/dog-shows/"><div>Shows</div></a></li>
						
									<li><a href="/showing/breed-notes/"><div>Breed Notes</div></a>
									
									</li>
									
									<li><a href="/showing/breed-critiques/"><div>Breed Critiques</div></a>
									
									</li>
									
									
								</ul>
							</li>
							<li class="<?php echo($main_menu_class['companion dogs']); ?>"><a href="#"><div>Companion Dogs</div></a>
								<ul>
									<li><a href="/companion-dogs/finding-puppies/"><div>Finding Puppies</div></a></li>
									<li><a href="/companion-dogs/old-dogs/"><div>Old Dogs</div></a></li>
									<li><a href="/companion-dogs/dog-training/"><div>Dog Training</div></a></li>
									<li><a href="/companion-dogs/dog-activities/"><div>Activities</div></a></li>
									<li><a href="/companion-dogs/dog-health/"><div>Health</div></a></li>
								</ul>
							</li>	
							<li class="<?php echo($main_menu_class['articles']); ?>"><a href="#"><div>Viewpoint</div></a>
								
								<ul>
								
								<li><a href="https://www.dogfocus.co.uk/dog-articles/guest-writers/anne-roslin-williams/7531/flatcatcher/"><div>Anne Roslin-Williams</div><div class='small'>Flatcatcher</div></a></li>
								
								<?php
									
									$sql = "select * from pages a join df_users b on a.fk_user_id = b.id where a.page_type = 'article_index' and a.status = 1";
									$db = new database();
									if($db->query($sql)){

										$article_menus = $db->all();
										

									}
	
									
									$db = null;
	
	
										  
									foreach($article_menus as $key => $article_menu_item){
											  
										  
										?>

										<li><a href="<?php echo($article_menu_item['url']); ?>"><div><?php echo($article_menu_item['title']); ?></div><div class='small'>by <?php echo($article_menu_item['username']); ?></div></a></li>
										
										<?php
									
									}
									
									?>	  
									
									<li><a href="/dog-articles/guest-articles/"><div>Assorted Writings</div><div class='small'>by Guest Writers</div></a></li>
		
								
								</ul>
							</li>
							
							<li class="<?php echo($main_menu_class['focus on']); ?>"><a href="#"><div>Focus On</div></a>
								<ul>
									<li><a href="/breaking-dog-news/"><div>Breaking Dog News</div></a></li>
								
									<li><a href="/focus-on/features/"><div>Features</div></a></li>
								
									<li><a href="/focus-on/debbie-mathews/lost-stolen-found-dogs/"><div>Lost, Stolen &amp; Found</div></a></li>
						
									<li><a href="/focus-on/rescue-dogs/"><div>Rescue Dogs</div></a></li>
									
									<li><a href="/focus-on/companion-dogs/"><div>Companion Dogs</div></a></li>
									
									<li><a href="/focus-on/dogs-at-work/"><div>Dogs At Work</div></a></li>
									
									<li><a href="/dog-articles/martina-hamburger/ask-the-pack/"><div>Ask The Pack</div></a></li>
									
									<li><a href="/focus-on/kennel-club/"><div>Kennel Club</div></a></li>
									
									<li><a href="/focus-on/ireland/"><div>Ireland</div></a></li>
									
									<li><a href="/sponsors/"><div>Sponsor's Timeline</div></a></li>
									
									
								</ul>
							</li>
							
							<li class="<?php echo($main_menu_class['showcase']); ?>"><a href="/coming-soon/"><div>Showcase</div></a>
								
							</li>
							
							
							<li class="<?php echo($main_menu_class['shop']); ?>"><a href="#"><div>Shop</div></a>
								<ul>
									<li><a href="/shop/"><div>Fun &amp; Useful</div></a></li>
								
									<li><a href="/photo-shop/"><div>Photo Shop</div></a></li>
						
								</ul>
							</li>
						</ul>
					
						<ul class='norightborder norightpadding norightmargin'>
							<?php if($_SESSION['user']['id']>0){ ?>
								
								<li><a href="/logout/">Log Out</a></li>
							
							<?php }else{  ?>
							
								<li><a href="/login/">Log In / Register</a></li>
							
							<?php } ?>
						</ul>
						
						<?php /* <!-- Top Cart
						============================================= -->
						<div id="top-cart">
							<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
							<div class="top-cart-content">
								<div class="top-cart-title">
									<h4>Shopping Cart</h4>
								</div>
								<div class="top-cart-items">
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="/resources/canvas/HTML/images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Blue Round-Neck Tshirt</a>
											<span class="top-cart-item-price">$19.99</span>
											<span class="top-cart-item-quantity">x 2</span>
										</div>
									</div>
									<div class="top-cart-item clearfix">
										<div class="top-cart-item-image">
											<a href="#"><img src="/resources/canvas/HTML/images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>
										</div>
										<div class="top-cart-item-desc">
											<a href="#">Light Blue Denim Dress</a>
											<span class="top-cart-item-price">$24.99</span>
											<span class="top-cart-item-quantity">x 3</span>
										</div>
									</div>
								</div>
								<div class="top-cart-action clearfix">
									<span class="fleft top-checkout-price">$114.95</span>
									<button class="button button-3d button-small nomargin fright">View Cart</button>
								</div>
							</div>
						</div><!-- #top-cart end -->
						
						<!-- Top Search
						============================================= -->
						<div id="top-search">
							<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
							<form action="search.html" method="get">
								<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
							</form>
						</div><!-- #top-search end -->
						*/ ?>
					</nav><!-- #primary-menu end -->

				</div>

			</div>
		
	
		<?php 
		
											  
			
		?>
		</header>
		<?php
		
		 } ?>
		
		
		