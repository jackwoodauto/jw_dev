<?php if($_SESSION['user']['id']<0){ header("Location: https://www.quotecheck.tech"); die();}  ?>
	<?php
	include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_login_ajax.php");
	?>

	<?php

	$username_database = $_SESSION['user']['username'];
	$fk_user_id_set = $_SESSION['user']['id'];
	/*echo "<pre>";
	print_r($username_database);
	echo "</pre>";
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>"; */
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

								<nav id="primary-menu" class="">

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

					<section  id="page-title" class="page-title-llax"  style=" background-image: url('../../imgs/quotecheck/banner/stacks_of_paper_2.jpg'); background-size: cover; background-position: center center;" data-stellar-background-ratio="0.4">

						<div class="container clearfix top-header">
							<div class="heading-block center">
								<div class="qc-text-shadow animated fadeInUp">
									<h1 data-caption-animate="fadeInUp" class="fadeInUp animated main-title-black" >Welcome back <?php echo $username_database; ?></h1>
									<span data-caption-animate="fadeInUp" class="divcenter fadeInUp animated main-title-black">compare your paper quotes with their corresponding invoices to identify any discrepancies</span>
								</div>
							</div>
						</div>

					</section><!-- #page-title end -->
					<?php

				} ?>


				<?php

				//include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v2.0.php");

				?>

				<?php
				$servername = "localhost";
				$dbname = "ejdev_db";
				$username = "ejdev_db";
				$password = "autoSquared01_db";

				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}



				$sql = "SELECT username, id, number_of_quotes, money_saved, discrepancies_found FROM qc_users WHERE username=?"; //  retuns all the times from when the booking date is x
				$args = array("s",$username_database);
				$db = new database();
				$db->query($sql,$args);

				$row = $db->all();


				$db = null;

				$json = json_encode($row);
				$end_quote_number = $row[0][number_of_quotes];

				$end_money_number = $row[0][money_saved];

				$end_discrepancies_number = $row[0][discrepancies_found];






				?>
				<!-- HTML / CSS Goes here -->
				<!-- Alert messages -->



				<section>
					<script>
					$("#upload_button").hide();

					$("#new_job_button").click(function(){
						$("#upload_button").show();
						$("#new_job_button").hide();
						$("#edit_job_button").hide();
					});

					$("#edit_job_button").click(function(){
						$("#upload_button").show();
						$("#new_job_button").hide();
						$("#edit_job_button").hide();
					});

					$(".upload_button").hide();

					$(".new_job_button").click(function(){
						$(".upload_button").show();
						$(".new_job_button").hide();
						$(".edit_job_button").hide();
					});

					$(".edit_job_button").click(function(){
						$(".upload_button").show();
						$(".new_job_button").hide();
						$(".edit_job_button").hide();
					});


				</script>

				<div class="container clearfix">
				<div style="margin-top: 75px"></div>
				<h2>Create a New Job </h2>
				<div style="margin-top: 75px"></div>
			</div>
				<form method="post" action="new_job_name">



					<div class="content-wrap custom-top">
						<div class="container clearfix">
							<div class="row">

								<div class="col-md-12">
									<div class= "input_group">
										<div class="col-md-6"  style="margin-right: 0px !important; padding: 0px 0px 0px 0px;">
											<input type="text" name="job_name" class="form-control file-caption  kv-fileinput-caption" style=" display:inline; margin-right: 0px;">
										</div>
										<div class="col-md-6"  style="margin-left: 0px !important; padding: 0px 0px 0px 0px;">
											<button id="abc"class="input-group-btn btn btn-primary btn-file" style="width: 120px; padding: 0px 0px 0px 0px !important; display:inline; margin-left: 0px;" type="submit">New Job<i class="icon-plus"></i></button>
										</div>

										<script type="text/javascript">


										$('.abc').click(function(){
												var new_job_name_ajax = invalid;
										    document.getElementById('abc').value = new_job_name_ajax;
												var url = '?aj=new_job_name=' + new_job_name_ajax ;
												$.getJSON(url, function(result){ });
											});







										</script>

									</div>
								</div>
							</div>
						</div>

					</div>
				</form>
				<div class="container clearfix">
				<div style="margin-top: 75px;"></div>
				<h2>Select a Job</h2>
				<div style="margin-top: 75px;"></div>
			</div>
				<div class="col-md-12">
					<form method="post" action="edit_job_name">



						<div class="content-wrap custom-top">
							<div class="container clearfix">
								<div class="col-md-12" style="margin-right:0px !important; padding: 0px 0px 0px 0px !important; display: inline; padding-right: 0px !important;">
									<select>
										<?php
										$servername = "localhost";
										$dbname = "ejdev_db";
										$username = "ejdev_db";
										$password = "autoSquared01_db";
										$conn = new mysqli($servername, $username, $password, $dbname);
										// Check connection
										if ($conn->connect_error) {
											die("Connection failed: " . $conn->connect_error);
										}
										$sql = "SELECT job_name FROM qc_pr_job_names WHERE fk_user_id = $fk_user_id_set";
										$result = $conn->query($sql);
										if ($result->num_rows > 0) {// output data of each row
											while($row = $result->fetch_assoc()) {
												?>
												<?php $job_name = $row["job_name"] ?>

												<option><?php echo"$job_name"?></option>
												<?php
											} // if there is nothing do this
										} else {
											echo "0 results";
										}
										$conn->close();
										?>
									</select>
								</div>

								<div style="margin-top: 150px; margin-bottom: 75px" ></div>
								<h2 style="margin-top: 50px; margin-bottom: 0px">Upload a File</h2>



								<div class="col-md-6" style="margin-left:0px !important; padding: 0px 0px 0px 0px !important; display: inline; padding-left: 0px !important;">

									<div class="box-wrapper col-md-6" style="margin-left:0px !important; padding: -20px 0px 0px 0px !important; display: inline; padding-left: 0px !important; margin-right:0px;" >

										<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
										<div class="bottommargin">
											<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
										</div>

									</div>
									<div class="container Quote_or_invoice">
										<div class="switch switch--horizontal">
											<input id="radio-a" type="radio" name="first-switch" checked="checked"/>
											<label for="radio-a">Quote</label>
											<input id="radio-b" type="radio" name="first-switch"/>
											<label for="radio-b">Invoice</label><span class="toggle-outside"><span class="toggle-inside"></span></span>
										</div>
									</div>
									<div class="loader"></div>

									<div class="container-fluid center clearfix bottommargin nobor" id="uploadfiles">
										<div class="row">
											<div class="col-md-12 extra-space">
												<div class="promo promo-center">
													<div class = "box-wrapper">
														<div class="bottommargin">
															<!--<input style='color:#fff;' id="uploadfiles"  type="file" class="file-input-qc" >-->
															<button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload Files</button>
															<div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>

						</form>
					</div>
					<!--
					<div id="new_job_button" class="new_job_button">

					<div class="promo promo-center">
					<a  class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>New Job</a>
				</div>

			</div>





			<div id="edit_job_button" class="edit_job_button">

			<div class="promo promo-center">
			<a  class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>Edit Job</a>
		</div>

	</div>
	!-->
	<form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">


		<?php
		$servername = "localhost";
		$dbname = "ejdev_db";
		$username = "ejdev_db";
		$password = "autoSquared01_db";

		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		/*
		fk_user_id
		processing_flag
		finished_flag
		price_invoice_flie
		quote_file
		id
		qc_jobs
		*/

		$sql = "SELECT id, id, number_of_quotes, money_saved, discrepancies_found FROM qc_users WHERE fk_user_id =?"; //  retuns all the times from when the booking date is x
		$args = array("s",$user_id);
		$db = new database();
		$db->query($sql,$args);

		$row = $db->all();


		$db = null;
		?>

		<input type="hidden" name="formname" value="upload_files">
	</form>
</section>



<div class="container-fluid center clearfix bottommargin" id="actionrun2">
	<!-- <a href="#" class="button button-3d button-rounded button-green button-xlarge pulse animated"><i class="icon-rocket"></i>Compare</a>-->
	<div class="container clearfix">
		<!--
		<div class="row">

		<h2> Demo Only </h2>

		<div class="col-md-6">
		<h3>Quote</h3>
		<textarea rows="20" style="width:95%;"><?php/// echo($quote_text); ?></textarea>

	</div>
	<div class="col-md-6">
	<h3>Invoice</h3>
	<textarea rows="20" style="width:95%;"><?php/// echo($invoice_text); ?></textarea>
	!-->
</div>
</div>
</div>
</div>


<section>
	<div class="parallax nomargin notopborder" style="background: url('../../imgs/quotecheck/banner/stacks_of_paper.jpg') center center;background-size: cover; background-color: white; background-repeat: no-repeat;"  data-stellar-background-ratio="0.4">


		<div class="container-fluid center clearfix">

			<div class="heading-block animated fadeInUp">
				<div style='height:60px;'></div>
				<div class="qc-text-shadow">
					<h2>See how much time you could save now</h2>
					<span>Annoyed that you're invoiced more than you were quoted? <br /> Upload a scan of your invoice and the original quote <br />
						Click a button and we can do the checking for you</span>
						<div class="clear"></div>
					</div>
				</div>

				<div class="clear"></div>
				<div class="promo promo-center">
					<a href="#" class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>Get Started</a>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container-fluid center clearfix">
			<h2>job box</h2>
			<div class="">
				<!-- Latest News Area End Here -->
				<?php
				$count=1;
				$count2=2;
				$count3=3;
				$count4=4;
				$count5=5;
				$job_number = 1;
				$servername = "localhost";
				$dbname = "ejdev_db";
				$username = "ejdev_db";
				$password = "autoSquared01_db";
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}
				$sql = "SELECT job_name FROM qc_pr_job_names WHERE fk_user_id = $fk_user_id_set";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {// output data of each row
					while($row = $result->fetch_assoc()) {
						?>
						<?php $job_name = $row["job_name"] ?>

						<!--			<div class=row>
						///					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 test133" id="<?php// echo"$job_name"?>">
						///						<p><?php// echo"$job_name"?></p>
						///					</div>
						///					 </div> !-->

						<section id="content <?php echo"$job_name"?>" style="margin-bottom: 0px;">

							<div class="content-wrap">

								<div class="container clearfix">
									<h2>Job Number: <?php echo"$count"?> Job Name:  <?php echo"$job_name"?></h2>
									<div id="processTabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
										<ul class="process-steps bottommargin clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
											<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab<?php echo"$count"?>" aria-labelledby="ui-id-<?php echo"$count"?>" aria-selected="false" aria-expanded="false">
												<a href="#ptab<?php echo"$count"?>" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?php echo"$count"?>">1</a>
												<h5>Upload Quote</h5>
											</li>
											<li class="ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="ptab<?php echo"$count2"?>" aria-labelledby="ui-id-<?php echo"$count2"?>" aria-selected="true" aria-expanded="true">
												<a href="#ptab<?php echo"$count2"?>" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?php echo"$count2"?>">2</a>
												<h5>Upload Invoices</h5>
											</li>
											<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab<?php echo"$count3"?>" aria-labelledby="ui-id-<?php echo"$count3"?>" aria-selected="false" aria-expanded="false">
												<a href="#ptab<?php echo"$count3"?>" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?php echo"$count3"?>">3</a>
												<h5>Start The Automatic Process</h5>
											</li>
											<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab<?php echo"$count4"?>" aria-labelledby="ui-id-<?php echo"$count4"?>" aria-selected="false" aria-expanded="false">
												<a href="#ptab<?php echo"$count4"?>" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?php echo"$count4"?>">4</a>
												<h5>Wait around 24 hours</h5>
											</li>
											<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab<?php echo"$count5"?>" aria-labelledby="ui-id-<?php echo"$count5"?>" aria-selected="false" aria-expanded="false">
												<a href="#ptab<?php echo"$count5"?>" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-<?php echo"$count5"?>">5</a>
												<h5>View Results</h5>
											</li>
										</ul>
										<div>
											<div id="ptab<?php echo"$count"?>" aria-labelledby="ui-id-<?php echo"$count"?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpane<?php echo"$count"?>" aria-hidden="true" style="display: none;">

												<p> upload your invocies here</p>
												<form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">

													<div class="content-wrap custom-top">
														<div class="container clearfix">
															<div class="row">
																<div class="col-md-6 extra-space">
																	<div class="promo promo-border promo-center box-border ">
																		<div class="box-wrapper">
																			<div class="portfolio-desc">
																				<h3>Select a File</h3>
																			</div>
																			<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
																			<div class="bottommargin">
																				<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
																			</div>
																		</div>
																	</div>
																</div>
																<div class="loader"></div>
																<div class="container-fluid center clearfix bottommargin nobor" id="uploadfiles">
																	<div class="row">
																		<div class="col-md-12 extra-space">
																			<div class="promo  promo-center">
																				<div class = "box-wrapper">
																					<div class="bottommargin">
																						<!--<input style='color:#fff;' id="uploadfiles"  type="file" class="file-input-qc" >-->
																						<button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload Files</button>
																						<div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<input type="hidden" name="formname" value="upload_files">
													</form>
													<a href="#" class="button button-3d nomargin fright tab-linker" rel="2">Upload Quotes</a>
												</div>
											</div>
											<div id="ptab<?php echo"$count2"?>" aria-labelledby="ui-id-<?php echo"$count2"?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: block;">
												<p>upload your quotes here</p>
												<form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">

													<div class="content-wrap custom-top">
														<div class="container clearfix">
															<div class="row">
																<div class="col-md-6 extra-space">
																	<div class="promo promo-border promo-center box-border ">
																		<div class="box-wrapper">
																			<div class="portfolio-desc">
																				<h3>Select a File</h3>
																			</div>
																			<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
																			<div class="bottommargin">
																				<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
																			</div>
																		</div>
																	</div>
																</div>
																<div class="loader"></div>

																<div class="container-fluid center clearfix bottommargin nobor" id="uploadfiles">
																	<div class="row">
																		<div class="col-md-12 extra-space">
																			<div class="promo  promo-center">
																				<div class = "box-wrapper">
																					<div class="bottommargin">
																						<!--<input style='color:#fff;' id="uploadfiles"  type="file" class="file-input-qc" >-->
																						<button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload Files</button>
																						<div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>

															</div>
														</div>
													</div>
													<div class="line"></div>
													<a href="#" class="button button-3d nomargin tab-linker" rel="1">Upload Quote</a>
													<a href="#" class="button button-3d nomargin fright tab-linker" rel="3">Start Process</a>
												</div>
												<div id="ptab<?php echo"$count3"?>" aria-labelledby="ui-id-<?php echo"$count3"?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
													<p>Start the automated process by clicking the button below</p>
													<div class="clear"></div>
													<div class="promo promo-center">
														<a href="#" class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>Get Started</a>
													</div>
												</div>


											</div>
											<div id="ptab<?php echo"$count4"?>" aria-labelledby="ui-id-<?php echo"$count4"?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
												<div class="alert alert-success">
													Your job is being processed
												</div>
											</div>
											<div id="ptab<?php echo"$count5"?>" aria-labelledby="ui-id-<?php echo"$count5"?>" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
												<div class="alert alert-success">
													Here are your results
												</div>
											</div>
										</div>
									</div>
								</div>


							</section><!-- #content end -->
							<?php

							$count  = $count + 5;
							$count2 = $count2 + 5;
							$count3 = $count3 + 5;
							$count4 = $count4 + 5;
							$count5 = $count5 + 5;
							$job_number = $job_number + 1;

							?>
							<?php
						} // if there is nothing do this
					} else {
						echo "0 results";
					}
					$conn->close();
					?>
				</div></div>
			</section>


			<!-- Content
			============================================= -->
			<section id="content" style="margin-bottom: 0px;">

				<div class="content-wrap">

					<div class="container clearfix">

						<div id="processTabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
							<ul class="process-steps bottommargin clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
								<li class="ui-state-default ui-corner-top  ui-tabs-active ui-state-active" role="tab" tabindex="-1" aria-controls="ptab1" aria-labelledby="ui-id-1" aria-selected="false" aria-expanded="false">
									<a href="#ptab1" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">1</a>
									<h5>Upload Quote</h5>
								</li>
								<li class="ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="ptab2" aria-labelledby="ui-id-2" aria-selected="true" aria-expanded="true">
									<a href="#ptab2" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">2</a>
									<h5>Upload Invoices</h5>
								</li>
								<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false">
									<a href="#ptab3" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">3</a>
									<h5>Start The Automatic Process</h5>
								</li>
								<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false">
									<a href="#ptab4" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">4</a>
									<h5>Wait around 24 hours</h5>
								</li>
								<li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="ptab5" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false">
									<a href="#ptab5" class="i-circled i-bordered i-alt divcenter ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5">5</a>
									<h5>View Results</h5>
								</li>
							</ul>
							<div>
								<div id="ptab1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">

									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, ipsa, fuga, modi, corporis maiores illum fugit ratione cumque dolores sint obcaecati quod temporibus. Expedita, sapiente, veritatis, impedit iusto labore sed itaque sunt fugiat non quis nihil hic quos necessitatibus officiis mollitia nesciunt neque! Minus, mollitia at iusto unde voluptate repudiandae.</p>
									<form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">

										<div class="content-wrap custom-top">
											<div class="container clearfix">
												<div class="row">
													<div class="col-md-6 extra-space">
														<div class="promo promo-border promo-center box-border ">
															<div class="box-wrapper">
																<div class="portfolio-desc">
																	<h3>Select a File</h3>
																</div>
																<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
																<div class="bottommargin">
																	<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
																</div>
															</div>
														</div>
													</div>
													<div class="loader"></div>
													<div class="container-fluid center clearfix bottommargin nobor" id="uploadfiles">
														<div class="row">
															<div class="col-md-12 extra-space">
																<div class="promo  promo-center">
																	<div class = "box-wrapper">
																		<div class="bottommargin">
																			<!--<input style='color:#fff;' id="uploadfiles"  type="file" class="file-input-qc" >-->
																			<button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload Files</button>
																			<div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" name="formname" value="upload_files">
										</form>
										<a href="#" class="button button-3d nomargin fright tab-linker" rel="2">Upload Invoice</a>
									</div>
								</div>
								<div id="ptab2" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="false" style="display: block;">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, ipsa, fuga, modi, corporis maiores illum fugit ratione cumque dolores sint obcaecati quod temporibus. Expedita, sapiente, veritatis, impedit iusto labore sed itaque sunt fugiat non quis nihil hic quos necessitatibus officiis mollitia nesciunt neque! Minus, mollitia at iusto unde voluptate repudiandae.</p>
									<form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">

										<div class="content-wrap custom-top">
											<div class="container clearfix">
												<div class="row">
													<div class="col-md-6 extra-space">
														<div class="promo promo-border promo-center box-border ">
															<div class="box-wrapper">
																<div class="portfolio-desc">
																	<h3>Select a File</h3>
																</div>
																<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
																<div class="bottommargin">
																	<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
																</div>
															</div>
														</div>
													</div>
													<div class="loader"></div>

													<div class="container-fluid center clearfix bottommargin nobor" id="uploadfiles">
														<div class="row">
															<div class="col-md-12 extra-space">
																<div class="promo  promo-center">
																	<div class = "box-wrapper">
																		<div class="bottommargin">
																			<!--<input style='color:#fff;' id="uploadfiles"  type="file" class="file-input-qc" >-->
																			<button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload Files</button>
																			<div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>

												</div>
											</div>
										</div>
										<div class="line"></div>
										<a href="#" class="button button-3d nomargin tab-linker" rel="1">Upload Quote</a>
										<a href="#" class="button button-3d nomargin fright tab-linker" rel="3">Start Process</a>
									</div>
									<div id="ptab3" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, sit, culpa, placeat, tempora quibusdam molestiae cupiditate atque tempore nemo tenetur facere voluptates autem aliquid provident distinctio beatae odio maxime pariatur eos ratione quae itaque quod. Distinctio, temporibus, cupiditate, eaque vero illo molestiae vel doloremque dolorum repellat ullam possimus modi dicta eum debitis ratione est in sunt et corrupti adipisci quibusdam praesentium optio laborum tempora ipsam aut cum consectetur veritatis dolorem.</p>
										<div class="clear"></div>
										<div class="promo promo-center">
											<a href="#" class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>Get Started</a>
										</div>
									</div>


								</div>
								<div id="ptab4" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
									<div class="alert alert-success">
										Your job is being processed
									</div>
								</div>
								<div id="ptab5" aria-labelledby="ui-id-5" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-hidden="true" style="display: none;">
									<div class="alert alert-success">
										Here are your results
									</div>
								</div>
							</div>
						</div>
					</div>


				</section><!-- #content end -->






				<!-- External JavaScripts
				============================================= -->
				<script type="text/javascript" src="js/jquery.js"></script>
				<script type="text/javascript" src="js/plugins.js"></script>

				<!-- Footer Scripts
				============================================= -->
				<script type="text/javascript" src="js/functions.js"></script>

				<script type="text/javascript">
				$(function() {
					$( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
					$( ".tab-linker" ).click(function() {
						$( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
						return false;
					});
				});
				</script>

























				<section>
					<div class="row clearfix">


						<?php

						$start_date = strtotime("21 March 2018");

						$start_quote_number = 0;

						$start_money_number =  0;

						$start_discrepancies_number = 0;


						?>

						<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(87, 111, 158); height: 326px; animated bounceInLeft">
							<div>
								<i class="i-plain i-xlarge divcenter icon-line-bar-graph-2"></i>
								<div class="counter counter-lined animate "><span data-from="<?php echo($start_quote_number) ;?>" data-to="<?php echo($end_quote_number) ;?>" data-refresh-interval="2" data-speed="2300"><?php echo($start_quote_number) ;?></span></div>
								<h5>Your Quotes Uploaded</h5>
							</div>
						</div>

						<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(102, 151, 185); height: 326px;">
							<div>


								<i class="i-plain i-xlarge divcenter icon-line-search"></i>


								<div class="counter counter-lined"><span data-from="<?php echo($start_discrepancies_number) ;?>" data-to="<?php echo($end_discrepancies_number) ;?>" data-refresh-interval="2" data-speed="2500">408</span></div>
								<h5>Your Discrepancies Found</h5>
							</div>
						</div>

						<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(136, 195, 216); height: 326px; ">
							<div>
								<i class="i-plain i-xlarge divcenter fa fa-gbp"></i>
								<div class="counter counter-lined"><a style="color: #004421!important;">&pound;</a><span data-from="<?php echo($start_money_number ) ;?>" data-to="<?php echo($end_money_number) ;?>" data-refresh-interval="2" data-speed="2500">408</span></div>
								<h5>Your Total saved</h5>
							</div>
						</div>

					</div>
				</section>



				<section id="paymeny_method">
					<div class="container clearfix">
						<section id="data_table">

							<h3>Output Examples</h3>
							<h4 class="no-bottom-margin">Differences between quote and invoice</h4>
							<!--canvas!-->
							<table class="table table-bordered table-striped">
								<colgroup>
									<col class="col-xs-1">
									<col class="col-xs-10">
								</colgroup>
								<thead>
									<tr>
										<th>Line#</th>
										<th>Item code/</th>
										<th colspan="4">Quote</th>
										<th colspan="4">Invoice</th>
										<th colspan="2">Difference</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td>Qty</td>
										<td>Unit cost</td>
										<td>Discount %</td>
										<td>Cost</td>
										<td>Qty</td>
										<td>Unit cost</td>
										<td>Discount %</td>
										<td>Cost</td>
										<td>Per Unit</td>
										<td>Total Cost</td>
									</tr>
									<tr>
										<td>173</td> <!-- Line# !-->
										<td>METRE CABLE 6943LSH 1.5MM LSF SWA HARMONISED</td> <!-- item code !-->
										<td>35</td> <!--Qty (quote)!-->
										<td>&pound;12.30</td> <!-- unit cost (quote) !-->
										<td>70</td> <!--Discount(quote) !-->
										<td>&pound;129.00</td> <!--cost(quote)!-->
										<td>35</td> <!--Qty(invoice)!-->
										<td>&pound;12.30</td> <!-- unit cost(invoice) !-->
										<td>0</td> <!--Discount(invoice) !-->
										<td>&pound;430.00</td> <!--cost(invoice)!-->
										<td>&pound;3.70</td> <!-- per unit !-->
										<td>&pound;301.50</td> <!-- total !-->
									</tr>
									<tr>
										<td>10</td> <!-- line#!-->
										<td>SC20GP SMITH M20 SOLID COUPLER GALVANISED</td> <!-- item code !-->
										<td>150</td> <!--Qty!-->
										<td>&pound;33.49</td> <!-- unit cost !-->
										<td>25</td> <!--Discount !-->
										<td>&pound;5023.00</td> <!--cost(quote)!-->
										<td>170</td> <!--Qty!-->
										<td>&pound;33.49</td> <!-- unit cost !-->
										<td>25</td> <!--Discount !-->
										<td>&pound;5706.90</td> <!--cost(invoice)!-->
										<td>&pound;0.00</td> <!-- per unit !-->
										<td>&pound;683.90</td> <!-- total !-->
									</tr>
									<tr>
										<td colspan="9" style="visibility:hidden;" ></td>
										<td colspan="2" style="font-weight: bold;">Total Impact</td>
										<td>&pound;985.40</td>
									</tr>
								</tbody>

							</table>

							<h4 class="no-bottom-margin">Non-quoted items</h4>
							<!-- canvas 2 !-->
							<table class="table table-bordered table-striped">
								<colgroup>
									<col class="col-xs-1">
									<col class="col-xs-10">
								</colgroup>
								<thead>
									<tr>
										<th>Line#</th>
										<th>Item code/</th>
										<th colspan="4">Invoice</th>

									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td>Qty</td>
										<td>Unit cost</td>
										<td>Discount %</td>
										<td>Total Cost</td>

									</tr>
									<tr>
										<td>40</td>
										<td>6491B DRAKA 2.5MM NRM 100M CU LSF 450/740V BS7211</td>
										<td>70</td> <!--Qty!-->
										<td>&pound;43.20</td> <!-- unit cost !-->
										<td>50</td> <!--Discount !-->
										<td>&pound;1512.00</td> <!--Cost !-->

									</tr>
									<tr>
										<td>200</td>
										<td>NLS4428EN NEWLEC 8X2" SCREW POZI RND HEAD TWIN THREAD ZINC P</td>
										<td>80</td> <!--Qty!-->
										<td>&pound;17.83</td> <!-- unit cost !-->
										<td>60</td> <!--Discount !-->
										<td>&pound;1426.40</td> <!--Cost !-->

									</tr>

									<tr>
										<td colspan="3" style="visibility:hidden;" ></td>
										<td colspan="2" style="font-weight: bold;">Total Impact</td>
										<td>&pound;2938.40</td>
									</tr>

								</tbody>
							</table>



						</section><!-- #data_table" -->
					</div>
				</section >



				<!-- HTML / END -->

				<?php

				include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");

				?>
