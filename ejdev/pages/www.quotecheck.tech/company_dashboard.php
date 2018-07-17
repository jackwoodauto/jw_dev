<?php
if($_SESSION['user']['id']<0){
  //if user is not logged in, redirect to standard home-page
  header("Location: https://www.quotecheck.tech");
  die();
}

  $us_id = $_SESSION['user']['id'];
  $sql = "SELECT fk_company_id FROM qc_users WHERE id=?";
  $args = array("i", $us_id);
  $db = new database();
  $db->query($sql, $args);

  $row = $db->all();
  $db = null;
  $json = json_encode($row);
  $fk_comp_id = $row[0]['fk_company_id'];

  if($fk_comp_id == 0){
    //if user is not logged in, redirect to standard home-page
    header("Location: https://www.quotecheck.tech/company_dashboard_noid");
    die();
  }
  echo "<pre>";
  print_r($json);
  echo "</pre>";
  $sql = "SELECT id, name, phone_number, address, invoice_address, delivery_address, company_number, fk_creation_user_id FROM company WHERE id=?";
  $args = array("i", $fk_comp_id);
  $db = new database();
  $db->query($sql, $args);

  $row = $db->all();
  $db = null;
  $json = json_encode($row);
  $fk_comp_id = $row[0]['fk_company_id'];
  echo "<pre>";
  print_r($json);
  echo "</pre>";
  echo "<pre>";
  print_r($row[0]);
  echo "</pre>";

$comp_info_id =  $row[0]['id'];
$comp_info_name =  $row[0]['name'];
$comp_info_phone_number =  $row[0]['phone_number'];
$comp_info_address = $row[0]['address'];
$comp_info_invoice_address = $row[0]['invoice_address'];
$comp_info_delivery_address = $row[0]['delivery_address'];
$comp_info_company_number = $row[0]['company_number'];
$comp_info_fk_creation_user_id = $row[0]['fk_creation_user_id'];

$sql = "SELECT id, job_name, fk_user_id FROM qc_pr_job_names WHERE fk_company_id=?";
$args = array("i", $comp_info_id);
$db = new database();
$db->query($sql, $args);
$row = $db->all();
$result = $db->query($sql);

?>
<?php
include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/c_login_ajax.php");
?>

<?php
$username_database = $_SESSION['user']['username'];
$fk_user_id_set = $_SESSION['user']['id'];

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

  <meta HTTP-EQUIV="Content-Language" Content="en" />

  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <meta name="google-site-verification" content="wyLRV2t8gUpQUfecEJH6_7dttnK30WVzgMo8kh0xgqs" />

  <?php
  if($page['for_site_map']==0){
    ?>
    <meta name="robots" content="noindex" />
    <meta name="googlebot" content="noindex" />
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
  <!-- <link rel="stylesheet" href="/resources/df_global_v18.css"/> -->

  <!-- http://www.quotecheck.tech/ -->
  <link rel="stylesheet" href="/resources/qc_global_v1.css"/>
  <link rel="stylesheet" href="/resources/qc_text.css"/>
  <link rel="stylesheet" href="/resources/qc_global_v1.css"/>
  <link rel="stylesheet" href="/resources/xxxqc_jack_v1.css"/>
  <link rel="stylesheet" href="/resources/qc_animate.css"/>
  <link rel="stylesheet" href="/resources/qc_login.css"/>
  <link rel="shortcut icon" type="image/png" href="../../imgs/quotecheck/favicon.png" />
  <link rel="shortcut icon" type="image/png" href="http://www.quotecheck.tech/imgs/quotecheck/favicon.png" />

  <!-- External JavaScripts
  ============================================= -->
  <script type="text/javascript" src="/resources/canvas/HTML/js/jquery.js"></script>
  <!-- <script type="text/javascript"  src="/resources/df_global_v5.js"></script> -->
  <!-- <script type="text/javascript"  src="/resources/qc_global_preloader.js"></script> -->

  <!-- Additional header code
  ============================================= -->
  <?php
  include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/pr.php");
  include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/company_get.php");
  ?>

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
              <ul class='norightborder norightpadding norightmargin'>
                <?php if($_SESSION['user']['id']>0){ ?>

                  <li><a href="https://www.quotecheck.tech/new_template">New Template</a></li>
                  <li><a href="https://www.quotecheck.tech/company_dashboard">Company Dashboard</a></li>
                  <li><a href="/logout/">Log Out</a></li>

                <?php }else{  ?>

                  <li><a href="#" onclick="$('#modal_login').modal('show');" class="">Sign In / Sign Up</a></li>

                <?php } ?>
              </ul>
            </nav>
          </div>
        </div>
      </header>



      <style>
      .section{/*height:100px !important;
        padding: 0px 0px 0px 0px !important;
        overflow:hidden !important;}
        .container{/*height:100px !important;
        padding: 0px 0px 0px 0px !important;
        overflow:hidden !important;}
        .clearfix{/*height:100px !important;
        padding: 0px 0px 0px 0px !important;
      overflow:hidden !important;}*/}

      </style>
      <section  id="page-title" class="page-title-llax"  style=" background-image: url('../../imgs/quotecheck/banner/stacks_of_paper_2.jpg'); background-size: cover; background-position: center center;" data-stellar-background-ratio="0.4">
        <div class="container clearfix top-header">
          <div class="heading-block center">
            <div class="qc-text-shadow animated fadeInUp">
              <h1 data-caption-animate="fadeInUp" class="fadeInUp animated main-title-black" >Company Dashboard</h1>
              <span data-caption-animate="fadeInUp" class="divcenter fadeInUp animated main-title-black">Welcome to the <?php echo $company_name;?> dashboard </span>
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
    $user_job_array = array("job_name"=>"job_id");
    // $servername = "localhost";
    // $dbname = "ejdev_db";
    // $username = "ejdev_db";
    // $password = "autoSquared01_db";
    //
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    $sql = "SELECT username, id, number_of_quotes, money_saved, discrepancies_found FROM qc_users WHERE username=?"; //  retuns all the times from when the booking date is x
    $args = array("s", $username_database);
    $db = new database();
    $db->query($sql, $args);

    $row = $db->all();

    $db = null;

    $json = json_encode($row);
    $end_quote_number = $row[0][number_of_quotes];

    $end_money_number = $row[0][money_saved];

    $end_discrepancies_number = $row[0][discrepancies_found];
    ?>

    <!-- ==================== START ==================================== -->
    <?php
    $sql = "SELECT fk_company_id FROM qc_users WHERE id=?"; //  retuns all the times from when the booking date is x
    $args = array("i", $fk_user_id_set);
    $db = new database();
    $db->query($sql, $args);

    $row = $db->all();
    $company_id = $row[0]['fk_company_id'];


    $db = null;


    //if ()  ?>
































    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <!-- <script type="text/javascript" src="js/plugins.js"></script> -->
    <script type="text/javascript" src="resources/pr.js"></script>
    <!-- Footer Scripts
    ============================================= -->
    <!-- <script type="text/javascript" src="js/functions.js"></script> -->
    <?php
    //include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/select_user_info.php");
    ?>


    <!--modal image preview dialog -->
    <div id='mymodalID' class='modal fade' role='dialog' style="max-height:100%">
      <div class='modal-dialog'>
        <div class='modal-content' style="max-height:90%">
          <div class='modal-header'>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>
            <h4 class='modal-title'>File Preview: <span class="subtitle" id="modalFileTitle">Filename</span></h4>
          </div>
          <div class="modal-body feature-box fbox-center fbox-effect nobottomborder nobottommargin" style="padding: 00px;">
            <img id="imgSrc" src="" alt="" style="max-width:80%">
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
          </div>
        </div>
      </div>
    </div>



    <?php
    include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");
    ?>
