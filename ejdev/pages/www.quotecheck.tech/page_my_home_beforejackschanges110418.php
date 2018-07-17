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
        <!-- <link rel="stylesheet" href="/resources/df_global_v18.css"/> -->

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




                <div class="content-wrap custom-top">
                    <div class="container clearfix">
                        <div class="row">

                            <div class="col-md-12">
                                <div class= "input_group">
                                    <div class="col-md-6"  style="margin-right: 0px !important; padding: 0px 0px 0px 0px;">
                                        <input type="text" id="new_job_name" name="new_job_name" class="form-control file-caption  kv-fileinput-caption" style=" display:inline; margin-right: 0px;">
                                    </div>
                                    <div class="col-md-6"  style="margin-left: 0px !important; padding: 0px 0px 0px 0px;">
                                        <button id="submitNewJob" class="input-group-btn btn btn-primary btn-file submitNewJob" style="width: 120px; padding: 0px 0px 0px 0px !important; display:inline; margin-left: 0px;" type="submitNewJob">New Job<i class="icon-plus"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="container clearfix">
                    <div style="margin-top: 75px;"></div>
                    <h2>Select a Job</h2>
                    <div style="margin-top: 75px;"></div>
                </div>
                <div class="col-md-12">
                    <form id="qc_upload" method="post" action="pr_upload" enctype="multipart/form-data">

                        <div class="content-wrap custom-top">
                            <div class="container clearfix">
                                <div class="col-md-6" style="margin-right:0px !important; padding: 0px 0px 0px 0px !important; display: inline;">

                                    <select id="job_selected" name="job_selected" style="padding:6px 0px 8px 0px; width:100%; minimum-width:300px">


                                        <?php
                                        // FIND DETAILS OF JOB AND DISPLAY
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
                                                <option value=<?php echo"$job_id"?><?php if ($job_id==11) echo ' selected="selected" ';?>><?php echo"$job_name"?></option>
                                                <?php

                                                ;
                                            } // if there is nothing do this
                                        } else {
                                            echo "no job details found";
                                        }

                                        $conn->close();
                                        ?>
                                    </select>
                                </div>

                                <div style="margin-top: 150px; margin-bottom: 75px" ></div>
                                <h2 style="margin-top: 50px; margin-bottom: 0px">Upload a File</h2>

                                <div class="col-md-6" style="margin-left:0px !important; padding: 0px 0px 0px 0px !important; display: inline; padding-left: 0px !important;">
                                    <div class="box-wrapper col-md-6" style="margin-left:0px !important; padding: -20px 0px 0px 0px !important; display: inline; padding-left: 0px !important; margin-right:0px;" >
                                        <div class="bottommargin">
                                            <input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
                                        </div>
                                    </div>
                                    <div class="container Quote_or_invoice">
                                        <div class="switch switch--horizontal">
                                            <input id="quote_selected_toggle" type="radio" name="Quote_or_invoice" checked="checked" value="qc_pr_quotes"/>
                                            <label for="quote_selected_toggle">Quote</label>
                                            <input id="invoice_selected_toggle" type="radio" name="Quote_or_invoice" value="qc_pr_invoices"/>
                                            <label for="invoice_selected_toggle">Invoice</label><span class="toggle-outside"><span class="toggle-inside"></span></span>
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

                <section id="job_status_area">
                    <div class="container-fluid center clearfix">
                        <h2>Job Status</h2>
                        <div>
                            <h4>no job info found</h4>
                        </div>
                    </div>
                </section>




                <!-- External JavaScripts
                ============================================= -->
                <script type="text/javascript" src="js/jquery.js"></script>
                <!-- <script type="text/javascript" src="js/plugins.js"></script> -->

                <!-- Footer Scripts
                ============================================= -->
                <!-- <script type="text/javascript" src="js/functions.js"></script> -->

                <script type="text/javascript">


                $(function() {
                    $( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
                    $( ".tab-linker" ).click(function() {
                        $( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
                        return false;
                    });
                });

                $(document).ready(function(){

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
                        }
                        return false;
                    });

                    $("#job_selected").change(function(){
                        //update the job info  shown in the page

                        var dropdown = $('#job_selected');
                        var selected_job_id = dropdown.val();

                        $.ajax({
                            type:"POST",
                            url: "select_job",
                            data: { 'jobid': selected_job_id },
                            success: function(newdata) {
                                var return_data = JSON.parse(newdata);
                                var job_status_area = $('#job_status_area');
                                var returnedHTML = return_data['html'];
                                job_status_area.html(returnedHTML).fadeIn(1500);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });

                    }); //job_selected function
                });




                </script>


                <?php
                include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");
                ?>
