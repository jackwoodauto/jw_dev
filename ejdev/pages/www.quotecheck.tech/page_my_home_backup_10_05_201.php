<?php
if($_SESSION['user']['id']<0){
    //if user is not logged in, redirect to standard home-page
    header("Location: https://www.quotecheck.tech");
    die();
}

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
        <form id="qc_upload" method="post" action="pr_upload" enctype="multipart/form-data">

            <div class="container"> <!-- Job selection-->
                <div class="row">
                    <h3>Select a Job</h3>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <select id="job_selected" name="job_selected" style="padding:6px 0px 8px 0px; width:100%; minimum-width:300px">
                            <?php
                            // Build select box containing a list of available jobs.
                            $servername = "localhost";
                            $dbname = "ejdev_db";
                            $username = "ejdev_db";
                            $password = "autoSquared01_db";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT job_name, id FROM qc_pr_job_names WHERE fk_user_id = $fk_user_id_set";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {// output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $job_name = $row["job_name"];
                                    $job_id = $row["id"];
                                    $user_job_array += [$job_name=> $job_id];
                                    ?>

                                    <option value=<?php echo "$job_id"?><?php if ($job_id==11) echo ' selected="selected" ';?>><?php echo "$job_name"?></option>

                                    <?php
                                    ;
                                }
                            } else {
                                echo "No Jobs Found";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <div class="col-xs-12">
                            <div class= "input_group">
                                <div class="col-sm-6 col-xs-10" style="margin-right: 0px !important; width:80%;padding: 0px 0px 0px 0px;">
                                    <input type="text" id="new_job_name" name="new_job_name" class="form-control file-caption kv-fileinput-caption" placeholder="Enter New Job Name" style="display:inline-block!important; margin-right: 0px;">

                                </div>
                                <div class="col-sm-6 col-xs-2" style="margin-left: 0px !important; width:20%;padding: 0px 0px 0px 0px;">
                                    <button id="submitNewJob" class="input-group-btn btn btn-primary btn-file submitNewJob" style="width: 100%; min-width:45px; max-width:180px; padding: 0px 0px 0px 0px !important; margin-left: 0px;" type="submitNewJob"><i class="icon-plus"></i><span class="hidden-xs hidden-sm">New Job</span></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div> <!--row -->
            </div> <!--container -->

            <?php //this section exists just to create some seperation ?>
            <section>

                <!-- job information is shown here -->
                <section class="nobottommargin nobottompadding">
                    <div class="container" id="job_status_area">
                        <h4>no job info found</h4>
                    </div>
                </section>


                <div class="container"> <!-- Select new file to upload-->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- <form id="qc_upload" method="post" action="pr_upload" enctype="multipart/form-data"> -->
                            <div class="content-wrap">
                                <h4>Select a New File To Upload</h4>
                                <div class="row">
                                    <div class="col-md-6" >
                                        <div class="box-wrapper col-md-6" style="margin-left:0px !important; padding: -20px 0px 0px 0px !important; display: inline; padding-left: 0px !important; margin-right:0px;" >

                                            <input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >

                                        </div>
                                    </div>
                                    <div class="upload_area">
                                    <div class="col-md-12">
                                        <div class="row Quote_or_invoice">
                                            <div class="col-xs-5">
                                                <input id="quote_selected_toggle" type="radio" name="Quote_or_invoice" checked="checked" value="qc_pr_quotes"/>
                                                <label for="quote_selected_toggle">Quote</label>
                                            </div>
                                            <div class="col-xs-5">
                                                <input id="invoice_selected_toggle" type="radio" name="Quote_or_invoice" value="qc_pr_invoices"/>
                                                <label for="invoice_selected_toggle">Invoice</label><span class="toggle-outside"><span class="toggle-inside"></span></span>
                                            </div>
                                        </div> <!--row-->
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <select id="wholesaler_selected_uq" name="wholesaler_selected_uq" style="padding:6px 0px 8px 0px; width:100%; minimum-width:300px">
                                                <?php
                                                // FIND DETAILS OF wholesaler AND DISPLAY
                                                $servername = "localhost";
                                                $dbname = "ejdev_db";
                                                $username = "ejdev_db";
                                                $password = "autoSquared01_db";
                                                $conn = new mysqli($servername, $username, $password, $dbname);
                                                // Check connection
                                                if ($conn->connect_error) {
                                                    die("Connection failed: " . $conn->connect_error);
                                                }

                                                $sql = "SELECT wholesaler_name, id FROM qc_pr_wholesaler";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {// output data of each row
                                                    while($row = $result->fetch_assoc()) {
                                                        $wholesaler_name = $row["wholesaler_name"];
                                                        $wholesaler_id = $row["id"];
                                                        //  $user_wholesaler_array += [$wholesaler_name=> $wholesaler_id];
                                                        ?>
                                                        <option value=<?php echo"$wholesaler_id"?><?php if ($wholesaler_id==11) echo ' selected="selected" ';?>><?php echo"$wholesaler_name"?></option>
                                                        <?php
                                                        ;
                                                    }
                                                } else {
                                                    echo "No Wholesalers found";
                                                }

                                                $conn->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <form>
                                                <select id='doc_select_uq' name='doc_select_uq' style='padding:6px 0px 8px 0px; width:100%; minimum-width:300px'>
                                                    <!--existing document templates are listed here -->
                                                </select>
                                            </form>
                                        </div>
                                    </div> <!--row -->
                                  </div>
                                </div> <!--row-->

                                <div class="loader"></div> <!--preloader -->

                                <div class="container-fluid center clearfix bottomxxxmargin" id="uploadfiles"> <!-- buttons for upload panel-->
                                    <div class="row">
                                        <div class="col-md-12 extra-space">
                                            <div class="promo promo-center"> <!-- provides a bit of spacing-->
                                                <div class = "box-wrapper">
                                                    <div class="bottoxxxmmargin">

                                                        <button name="file-select-submit" class="button button-3d button-green nomargin upload-files-qc"  value="upload">Upload File</button>
                                                        <div class ="preloader"><img src="imgs\quotecheck\preloader.gif"></img></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div> <!---container-->
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div> <!-- container -->
            </section>
        </form>

        <form id="upload_button" action="#" method="post" enctype="multipart/form-data " class="upload_button">

            <?php
            /*
            $sql = "SELECT id, number_of_quotes, money_saved, discrepancies_found FROM qc_users WHERE fk_user_id =?"; //  retuns all the times from when the booking date is x
            $args = array("s", $user_id);
            $db = new database();
            $db->query($sql,$args);

            $row = $db->all();

            $db = null;

            */
            ?>

            <input type="hidden" name="formname" value="upload_files">
        </form>

        <!--///////////////////////////////////////////////////////-->

        <form id="qc_upload" method="post" action="pr_upload" enctype="multipart/form-data">

            <div class="container">

                <div class="row">
                    <h4>Select a Wholesaler</h4>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <select id="wholesaler_selected" name="wholesaler_selected" style="padding:6px 0px 8px 0px; width:100%; minimum-width:300px">
                            <?php
                            // FIND DETAILS OF wholesaler AND DISPLAY
                            $servername = "localhost";
                            $dbname = "ejdev_db";
                            $username = "ejdev_db";
                            $password = "autoSquared01_db";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT wholesaler_name, id FROM qc_pr_wholesaler";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {// output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $wholesaler_name = $row["wholesaler_name"];
                                    $wholesaler_id = $row["id"];
                                    //  $user_wholesaler_array += [$wholesaler_name=> $wholesaler_id];
                                    ?>
                                    <option value=<?php echo"$wholesaler_id"?><?php if ($wholesaler_id==11) echo ' selected="selected" ';?>><?php echo"$wholesaler_name"?></option>
                                    <?php
                                    ;
                                }
                            } else {
                                echo "No Wholesalers found";
                            }

                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-6">
                        <div class="col-xs-12">
                            <div class= "input_group">
                                <div class="col-sm-6 col-xs-10"  style="margin-right: 0px !important;width:60%; padding: 0px 0px 0px 0px;">
                                    <input type="text" id="new_wholesaler_name" name="new_wholesaler_name" class="form-control file-caption  kv-fileinput-caption" style=" display:inline; margin-right: 0px;">
                                </div>
                                <div class="col-sm-6 col-xs-2"  style="margin-left: 0px !important;width:40%; padding: 0px 0px 0px 0px;">
                                    <button id="submitNewWholesaler" class="input-group-btn btn btn-primary btn-file submitNewWholesaler" style="width: 100%; min-width:45px; ; padding: 0px 0px 0px 0px !important; display:inline; margin-left: 0px;" type="submitNewWholesaler"><i class="icon-plus"></i><span class="hidden-xs hidden-sm ">New Wholesaler</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!--row -->
            </div> <!--container -->
        </form>
        <!--///////////////////////////////////////////////////////-->
        <!-- <div class="container"> -->
        <section id="wholesaler_status_area3">
            <div class="container">
                <div class="row">
                    <h4>Select a Document Template</h4>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <form>
                            <select id='doc_select' name='doc_select' style='padding:6px 0px 8px 0px; width:100%; minimum-width:300px'>
                                <!--existing document templates are listed here -->
                            </select>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <div class="col-xs-12">
                            <div class= "input_group">
                                <div class="col-sm-6 col-xs-10"  style="margin-right: 0px !important;width:60%; padding: 0px 0px 0px 0px;">
                                    <input type="text" id="new_document_name" name="new_document_name" class="form-control file-caption  kv-fileinput-caption" style=" display:inline; margin-right: 0px;">
                                </div>
                                <div class="col-sm-6 col-xs-2"  style="margin-left: 0px !important; width:40%; padding: 0px 0px 0px 0px;">
                                    <button id="submitNewDocument" class="input-group-btn btn btn-primary btn-file submitNewDocument" style="width: 100%; min-width:45px;  padding: 0px 0px 0px 0px !important; margin-left: 0px;" type="submitNewDocument"><i class="icon-plus"></i><span class="hidden-xs hidden-sm">New Document</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!--///////////////////////////////////////////////////////-->


    <section>
        <div class="container">
            <div class="row">
                <h4>Add a Column</h4>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class= "input_group">
                        <div class="col-sm-6 col-xs-10"  style="margin-right: 0px !important;  width:80%; padding: 0px 0px 0px 0px;">
                            <input type="text" id="new_column_name" name="new_column_name" class="form-control file-caption  kv-fileinput-caption" placeholder="Enter Column Header" style="display:inline-block!important; margin-right: 0px;">
                        </div>
                        <div class="col-sm-6 col-xs-2"  style="margin-left: 0px !important; width:20%;padding: 0px 0px 0px 0px;">
                            <button id="submitNewColumn" class="input-group-btn btn btn-primary btn-file submitNewColumn" style="width: 100%; min-width:45px; max-width:180px; padding: 0px 0px 0px 0px !important; margin-left: 0px;" type="submitNewColumn"><i class="icon-plus"></i><span class="hidden-xs hidden-sm">New Column</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <section id="document_visual_layout_section">
                <!-- <div class="container-fluid center clearfix"> -->
                <h3>Document template columns</h3>
                <!-- </div> -->
            </section>
        </div>
    </section>
    <div id="user_data"> </div>
    <!--
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <!-- <script type="text/javascript" src="js/plugins.js"></script> -->

    <!-- Footer Scripts
    ============================================= -->
    <!-- <script type="text/javascript" src="js/functions.js"></script> -->
    <?php
    //include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/select_user_info.php");
    ?>
    <script type="text/javascript">



    $(document).ready(function(){

        $(function() {
            $( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
            $( ".tab-linker" ).click(function() {
                $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
                return false;
            });
        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#submitNewJob").click(function(){
            var jq_newjobname = $('#new_job_name');
            var new_job_name = jq_newjobname.val();
            // Returns successful data submission message when the entered information is stored in database.
            var dataString = 'new_job_name1=' + new_job_name;
            if (new_job_name == '') {
                alert("Please provide a job name");
            } else {
                // AJAX code to submit form.
                $.ajax({
                    type: "POST",
                    url: "new_job_name",
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        //add the new job to the dropdown list:
                        var incoming_data = JSON.parse(html);
                        var ob = $("#job_selected");
                        ob.prepend("<option value='" + incoming_data.NewJobID + "'>" + incoming_data.ReturnJob + "</option>");

                        //select the newly created new_job_name
                        ob.val(incoming_data.NewJobID);
                        jq_newjobname.val(''); //blank out the new job name box
                    }
                });
                $("#job_selected").trigger("change");
            }
            return false;
        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //update the job info  shown in the page
        function JobSelected() {

            var dropdown = $('#job_selected');
            var selected_job_id = dropdown.val();

            $.ajax({
                type:"POST",
                url: "select_job",
                data: { 'jobid': selected_job_id },
                success: function(newdata) {
                    var resulttext = JSON.stringify(newdata);
                    var posErr = resulttext.indexOf("ErrorStatus");
                    if (posErr == -1){
                        alert ("error reading data" + newdata);
                        returnedHTML = "<p>Error reading database.</p>";
                    }
                    var return_data = JSON.parse(newdata);
                    var job_status_area = $('#job_status_area');
                    var returnedHTML = return_data['html'];

                    job_status_area.html(returnedHTML).fadeIn(1500);

                    //ensure preview buttons are hooked up
                    $(".previewbutton").on('click', function() {
                        $('#imgSrc').attr('src', $(this).data('src'));
                        $('#modalFileTitle').html($(this).data('src'));
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {

                    alert(xhr.status);
                    alert(thrownError);

                    var returnedHTML = "<div><p>No Files Uploaded</p></div>";
                    job_status_area.html(returnedHTML).fadeIn(1500);
                }
            });

        }; //job_selected function

        $("#job_selected").change(function(){
            JobSelected();
        });




        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $("#submitNewWholesaler").click(function(){
            var jq_newwholesalername = $('#new_wholesaler_name');
            var new_wholesaler_name = jq_newwholesalername.val();
            // Returns successful data submission message when the entered information is stored in database.
            var dataString = 'new_wholesaler_name1=' + new_wholesaler_name;
            if (new_wholesaler_name == '') {
                alert("Please provide a wholesaler name");
            } else {
                // AJAX code to submit form.
                $.ajax({
                    type: "POST",
                    url: "new_wholesaler_name",
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        //add the new wholesaler to the dropdown list:
                        var incoming_data = JSON.parse(html);
                        var ob = $("#wholesaler_selected");
                        ob.prepend("<option value='" + incoming_data.NewWholesalerID + "'>" + incoming_data.ReturnWholesaler + "</option>");
                        var ob_uq = $("#wholesaler_selected_uq");
                        ob_uq.prepend("<option value='" + incoming_data.NewWholesalerID + "'>" + incoming_data.ReturnWholesaler + "</option>");
                        //select the newly created new_wholesaler_name
                        ob.val(incoming_data.NewWholesalerID);

                        jq_newwholesalername.val(''); //blank out the new wholesaler name box
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    },
                    async: false
                });

                WholesalerSelected();
            }
            return false;
        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function WholesalerSelected() {
            //update the wholesaler info shown in the page
            var dropdown = $('#wholesaler_selected');
            var selected_wholesaler_id = dropdown.val();

            $.ajax({
                type: "POST",
                url: "select_wholesaler",
                data: { 'wholesalerid': selected_wholesaler_id },
                success: function(newdata) {
                    var return_data = JSON.parse(newdata);
                    var wholesaler_status_area = $('#wholesaler_status_area');
                    var doc_select = $('#doc_select');
                    var returnedHTML = return_data['html'];
                    var returnedHTML2 = return_data['html2'];

                    wholesaler_status_area.html(returnedHTML).fadeIn(1500);
                    doc_select.html(returnedHTML2).fadeIn(1500);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
                async: false
            });
            DocSelected();

        }; //wholesaler_selected function

        $("#wholesaler_selected").change(function(){
            WholesalerSelected();

        });

        function WholesalerSelected_uq() {
            //update the wholesaler info shown in the page
            var dropdown = $('#wholesaler_selected_uq');
            var selected_wholesaler_id_uq = dropdown.val();

            $.ajax({
                type: "POST",
                url: "select_wholesaler",
                data: { 'wholesalerid': selected_wholesaler_id_uq },
                success: function(newdata) {
                    var return_data = JSON.parse(newdata);
                    var wholesaler_status_area = $('#wholesaler_status_area');
                    var doc_select_uq = $('#doc_select_uq');
                    var returnedHTML = return_data['html'];
                    var returnedHTML2 = return_data['html2'];

                    wholesaler_status_area.html(returnedHTML).fadeIn(1500);
                    doc_select_uq.html(returnedHTML2).fadeIn(1500);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
                async: false
            });
            DocSelected_uq();

        }; //wholesaler_selected function

        $("#wholesaler_selected_uq").change(function(){
            WholesalerSelected_uq();

        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $("#submitNewDocument").click(function(){
            var jq_newdocumentname = $('#new_document_name');
            var new_document_name = jq_newdocumentname.val();
            // Returns successful data submission message when the entered information is stored in database.
            var dataString = new_document_name;
            var selected_wholesaler_id = $('#wholesaler_selected').val();
            var info = [selected_wholesaler_id,dataString] ;


            if (new_document_name == '') {
                alert("Please provide a document name");
            } else {
                // AJAX code to submit form.
                $.ajax({
                    type: "POST",
                    url: "new_document_name",
                    data: {info,info},
                    cache: false,
                    success: function(html) {
                        //add the new wholesaler to the dropdown list:
                        var incoming_data = JSON.parse(html);
                        var ob = $("#doc_select");
                        ob.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");
                        var wholesaler_selected_doc_update_check_uq = $("#wholesaler_selected_uq").val();
                        if (selected_wholesaler_id == wholesaler_selected_doc_update_check_uq) {
                          var ob_uq = $("#doc_select_uq");
                          ob_uq.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");
                        }
                      //  var ob_uq = $("#doc_select_uq");
                      //  ob_uq.prepend("<option value='" + incoming_data.NewDocumentID + "'>" + incoming_data.ReturnDocument + "</option>");

                        //select the newly created new_wholesaler_name
                        ob.val(incoming_data.NewDocumentID);

                        jq_newdocumentname.val(''); //blank out the new wholesaler name box
                    }

                });
                $( "#doc_select" ).trigger("change");
                $( "#doc_select_uq" ).trigger("change");
            }
            return false;
        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function DocSelected() {
            //show the layout of the selected document
            var dropdown = $('#doc_select');
            var selected_doc_id = dropdown.val();

            $.ajax({
                type:"POST",
                url: "select_document",
                data: { 'docid': selected_doc_id },
                success: function(newdata) {
                    var return_data = JSON.parse(newdata);
                    var document_visual_layout_section = $('#document_visual_layout_section');
                    var returnedHTML = return_data['html3'];
                    document_visual_layout_section.html(returnedHTML).fadeIn(1500);

                    // JACK - do we need these variables:
                    // var return_data = JSON.parse(newdata);
                    // var wholesaler_status_area = $('#wholesaler_status_area');
                    // var doc_select = $('#doc_select');
                    // var returnedHTML = return_data['html'];
                    // var returnedHTML2 = return_data['html2'];
                },
                //JACK - add an error function in here... what if there is an error? what should the user see?
            });
        };
        $("#doc_select").change(function(){
            DocSelected();
        });

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#submitNewColumn").click(function(){

            var jq_newcolumnname = $('#new_column_name');
            var new_column_name = jq_newcolumnname.val();
            // Returns successful data submission message when the entered information is stored in database.
            var dataString = new_column_name;
            var dropdown = $('#doc_select');
            var selected_wholesaler_id = dropdown.val();
            var info = [selected_wholesaler_id,dataString ];
            //var info[0] = dropdown;
            //  var info[1] = selected_wholesaler_id;

            if (new_column_name == '') {
                alert("Please provide a Column name");
            } else {
                // AJAX code to submit form.
                $.ajax({
                    type: "POST",
                    url: "new_column_name",
                    data: {info,info},
                    cache: false,
                    success: function(html) {
                        //add the new job to the dropdown list:
                        //  jq_newcolumnname.val(''); //blank out the new job name box

                    }
                });
            }
            DocSelected()
            return false;
        });

        JobSelected(); //when a job is in the selected box use ajax to run a php file that uses sql to get the infomation out of the database

        WholesalerSelected(); //when a Wholesaler is in the selected box use ajax to run a php file that uses sql to get the infomation out of the database

    });

</script>

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
