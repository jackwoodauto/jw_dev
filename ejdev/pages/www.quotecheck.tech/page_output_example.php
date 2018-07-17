<?php
if($_SESSION['user']['id']<0){
    //if user is not logged in, irect to standard home-page
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

    <!-- Meta tags dsfsdfdsfdsfaesdfdsf
    ============================================= -->
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="AutomationSquaerd.com" />

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

    <!-- <link rel="shortcut icon" type="image/png" href="../../imgs/quotecheck/favicon.png" /> -->
    <!-- <link rel="shortcut icon" type="image/png" href="https://www.quotecheck.tech/imgs/quotecheck/favicon.png" /> -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="/resources/canvas/HTML/js/jquery.js"></script>




    <!-- Additional header code
    ============================================= -->
    <?php
    include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/pr.php");
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
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Document Wrapper
    ============================================= -->
    <div   class="clearfix">
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
                            <ul class='norighdyrder norightpadding norightmargin'>
                                <?php if($_SESSION['user']['id']>0){ ?>
                                    <li><a href="https://www.quotecheck.tech/new_template">Templates</a></li>
                                    <li><a href="https://www.quotecheck.tech/my_home">Jobs</a></li>
                                    <!--<li><a href="https://www.quotecheck.tech/company_dashboard">Company Dashboard</a></li> !-->
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
        // $servername = "localhost";
        // $dbname = "ejdev_db";
        // $username = "ejdev_db";
        // $password = "autoSqua#D91E1801_db";
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

        <!--///////////////////////////////////////////////////////-->


        <!--///////////////////////////////////////////////////////-->
        <!-- <div class="container"> -->




        <!--///////////////////////////////////////////////////////-->
        <!-- <section>
        <div style="width: 100%;" >
        <h2> Col Table </h2>
        <table style="width: 100%; background:#ededed; white-space: normal; word-wrap: break-word;">
        <thead>
        <tr>
        <?php
        foreach ($_SESSION['pr_upload_final_array']as $key=>$row) {
        $row_count_for_foreach++;
        ?>
        <th id="ID-<?php echo $key?>">
        <?php echo "$key"?>
    </th>
    <?php
}
?>
</tr>
</thead>

<?php
echo "<tr style='background: linear-gradient(#ededed, #fff);'> ";
foreach ($_SESSION['pr_upload_final_array']as $key=>$row) {
$row_count_for_foreach++;
?>
<td valign="bottom" id="ID-<?php echo $key?>-info">
<?php echo "$row"?>
</td>
<?php
}
echo "</tr>";

?>

<tr>
</tr>
</table>
</div>
<style>
td, th {
max-width:140px;
border: 1px solid #dddddd;
text-align: left;
padding: 8px;
white-space: normal;
word-wrap: break-word;
}
</style>
</section>

<section>
<div style="width: 100%;" >
<h2> Row Table </h2>
<table style="width: 100%; background:#ededed; white-space: normal; word-wrap: break-word;">



<?php



foreach ($_SESSION['pr_upload_final_array_rows']as $key=>$row) {
echo "<tr> ";
$row_count_for_foreach++;
?>
<td valign="bottom" id="ID-<?php echo $key?>-info">
<?php echo "$row"?>
</td>
<?php
}
echo "</tr>";

?>

<tr>
</tr>
</table>
</div>
<style>
td, th {
max-width:140px;
border: 1px solid #dddddd;
text-align: left;
padding: 8px;
white-space: normal;
word-wrap: break-word;
}
</style>
</section> -->




<!-- <section>
<div style="width: 100%;" >
<h2> Final Table </h2>
<table style="width: 100%; background:#ededed; white-space: normal; word-wrap: break-word;"> <!-- jack - can we show this background colour to fade in the lower td tags? -->


<?php
// $col_count = count($_SESSION['pr_upload_final_array_col_row']);
// $row_count = count($_SESSION['pr_upload_final_array_col_row']['Quantity']['cells']);
//
// for ($k = 0 ; $k < $row_count; $k++){
//     echo "<tr>";
//
//
//     foreach ($_SESSION['pr_upload_final_array_col_row'] as $key => $value) {
//         echo "<td>";
//         echo $_SESSION['pr_upload_final_array_col_row'][$key]['cells'][$k]['Cell_text'] ;
//
//
//
//
//
//         echo '</td>';
//     }
//     echo "</tr>";
// }

?>

<!-- </table>
</div>
<style>
td, th {
max-width:140px;
border: 1px solid #dddddd;
text-align: left;
padding: 8px;
white-space: normal;
word-wrap: break-word;
}
</style>
</section> -->
<?php


function EchoTableHead(){
    echo "<thead>";
    echo "<tr>";
    echo "<th colspan='7' style='text-align:center'>Quote</th>";
    echo "<th colspan='7' style='text-align:center'>Invoice</th>";
    echo "<th  colspan='2' style='border-top:none; border-top:right;'bgcolor='white' align='center'></th>";
    echo "</tr>";
    echo "<tr>";
    echo "<th>Description</th>";
    echo "<th>Unit</th>";
    echo "<th>Quantity</th>";
    echo "<th>Price</th>";
    echo "<th>Per</th>";
    echo "<th>Discount</th>";
    echo "<th>Total</th>";
    echo "<th>Description</th>";
    echo "<th>Unit</th>";
    echo "<th>Quantity</th>";
    echo "<th>Price</th>";
    echo "<th>Per</th>";
    echo "<th>Discount</th>";
    echo "<th>Total</th>";
    echo "<th>Discrepancy</th>";
    echo "<th>Approved</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<!--finished-->";
}

//input it takes the infomation from Doquote and it contains the line item header the line item values and the line item infomation the line item infomation is just used to set up the relevent invoice variables
// the line item header is used to check where the function should be working and the line item values is used to campare against the invoice item

//process 1st thing the function does is set up the invoice infomation by pointing at the line item infomation the next thing it does is use the line item haader to find out what invoice variable is ogin to be used
//then it checks to see if the relevent infovice infomation is the same as the quote infomation and if it is not echo out the value with a rea background but if its fine just echo it normally

//output echos out the quote infomationbut if its diffrent to the invoice infomation add a red background

function QuoteVarCompareAgainstInvoiceVar($line_item_header , $line_item_values , $col_array , $line_item_information, $line_item_key )
{


    $quote_price =  $line_item_information['quote'][0]['Price'];
    $quote_per =  $line_item_information['quote'][0]['Per'];
    $quote_Discount =  $line_item_information['quote'][0]['Discount'];
    $quote_total = $line_item_information['quote'][0]['Total'];
    $quote_Quantity  =  $line_item_information['quote'][0]['Quantity'];

    switch ($line_item_header) {
        case 'Quantity':
        CheckAndShowValueInTableCell($quote_Quantity, $line_item_values, $line_item_key);
        break;
        case 'Price':
        CheckAndShowValueInTableCell($quote_price, $line_item_values, $line_item_key);
        break;
        case 'Per':
        CheckAndShowValueInTableCell($quote_per, $line_item_values, $line_item_key);
        break;
        case 'Discount':
        CheckAndShowValueInTableCell($quote_Discount, $line_item_values, $line_item_key);
        break;
        case 'Total':
        CheckAndShowValueInTableCell($quote_total, $line_item_values, $line_item_key);
        break;

        default:
        break;
    }

    //===========================================================================================================================
    //
    // $invoice_data = $line_item_information['invoice'][0][$line_item_header];
    // CheckAndShowValueInTableCell($invoice_data, $line_item_values);


}

function CheckAndShowValueInTableCell ($valueToCheckAgainst, $valueToShow) {
    //JACK - add some code to make sure the value is what we expect (eg make sure it's a number)
    $highlight = "";
    if ($valueToShow != "" && $valueToShow != $valueToCheckAgainst) {
        $highlight = "error";
    }
    EchoCell($valueToShow, $line_item_key, $highlight);
}

function EchoHighlightToggleCell($line_item_key, $highlight_from_database, $line_item_information){

    echo "<td>";
    echo "<script>
        function HighlightFunc" . $line_item_key . "() {
            $('tr.".$line_item_key."').children().toggleClass('NoHighlight');
             document.getElementById(". $line_item_key . ").classList.toggle('NoHighlight');


};
    function HighlightFuncOnLoad" . $line_item_key . "() {
        $('tr.".$line_item_key."').children().toggleClass('NoHighlight');
         document.getElementById(". $line_item_key . ").classList.toggle('NoHighlight');
    };
    </script>";



echo "<input type='checkbox' onclick='HighlightFunc" . $line_item_key . "()''></input>";


    echo "</td>";


if ($highlight_from_database == "false") {
    echo "<script>

    HighlightFuncOnLoad" . $line_item_key . "();
    </script>";
}





};

function EchoCell($cellValue, $line_item_key, $highlight = "normal") {

    switch (strtolower(trim($highlight))) {
        case "normal":
        $color = "#EDEDED";
        break;
        case "error":
        $color = "#F1D1D0";
        break;
        case 'warning':
        $color = "yellow";
        break;
        case 'info':
        $color = "green";
        break;// background-color: #EDEDED !important
        default:
        $color = "#EDEDED";
        break;
    }

    $style = " style = background-color:".$color."";

    echo "<td". $style . " row_name =". $line_item_key ." class=".$line_item_key. ">";
    echo $cellValue;
    echo "</td>";

}

function DiscrepancyCalc($line_item_information, $line_item_key){
    // echo "<pre>";
    // print_r($line_item_information);
    // echo "</pre>";  && $col_name != "Highlight"

$highlight_from_database = $line_item_information['quote'][0]['Highlight'];
$invoice_price = $line_item_information['invoice'][0]['Price'];
$invoice_per = $line_item_information['invoice'][0]['Per'];
$invoice_Discount = $line_item_information['invoice'][0]['Discount'];
$invoice_total = $line_item_information['invoice'][0]['Total'];
$invoice_Quantity = $line_item_information['invoice'][0]['Quantity'];
$quote_Quantity = $line_item_information['quote'][0]['Quantity'];
$total = $line_item_information['quote'][0]['Total'];
$quotedPer = 0;
$invoicePer = 0;

if ((is_numeric($quote_Quantity) && $quote_Quantity > 0) && (is_numeric($invoice_Quantity) && $invoice_Quantity > 0))
{
    $quotedPer = $total / $quote_Quantity;
    $invoicePer = $invoice_total / $invoice_Quantity;
    $discrepPer =  $quotedPer - $invoicePer;
    $discrepTotal = $discrepPer * $invoice_Quantity;
} else {
    $quotedPer = $total;
    $invoicePer = $invoice_total;
    $discrepTotal =  $quotedPer - $invoicePer;
    $discrepPer =  0;
}
$single_quote_total = round($discrepTotal,2);
if ($single_quote_total != 0) {
    $highlight = "error";
}
EchoCell($single_quote_total, $line_item_key, $highlight);
EchoHighlightToggleCell($line_item_key, $highlight_from_database, $line_item_information);
}

////inputs the invoice array that is being inputed and the string that should be unit, description or Final
// process the function is called 3 times 1st time with description as the input check then unit then final for each line item
//output should echo out the invoice array in order of description then unit then all of the other infomation
function PositionColumn($col_array,  $input_check, $invoice_or_quote, $line_item_information, $line_item_key) {
    foreach ($col_array as $col_name => $col_val) {
        if ($col_name == $input_check) {
            EchoCell($col_val, $line_item_key);
        } elseif ($input_check == "final") {
            if ($col_name != "Description" && $col_name != "Unit"  && $col_name != "Other" && $col_name != "file_type" && $col_name != "id" && $col_name != "fk_job_id" && $col_name != "fk_file_id" && $col_name != "Highlight" && $col_name != "insertiontime" ) { 
                if ($invoice_or_quote == "quote"){
                    EchoCell($col_val, $line_item_key);
                } elseif ($invoice_or_quote == "invoice") {
                    QuoteVarCompareAgainstInvoiceVar($col_name, $col_val, $col_array, $line_item_information, $line_item_key);
                }
            }
        }
    }
}

function OutputLineinformation($line_item_information, $quote_or_invoice, $line_item_key){
    if ($quote_or_invoice == "invoice") {
        $info = $line_item_information["invoice"];
    } elseif ($quote_or_invoice == "quote") {
        $info = $line_item_information["quote"];
    }


    if ($info[0] == ''){
        echo '<td colspan = "7" align="center"> item not quoted </td>';
    } elseif ($info[0] == 'false'){
        echo '<td colspan = "7" align="center"> item not quoted </td>';
        echo '<td> </td>';
    } else {

        if ($quote_or_invoice == "quote") {
            foreach ($info as $line_item) {
                PositionColumn($line_item , "Description", "quote" , $line_item_information, $line_item_key);
                PositionColumn($line_item , "Unit", "quote" , $line_item_information, $line_item_key);
                PositionColumn($line_item , "final", "quote" , $line_item_information, $line_item_key);
            }
        } elseif ($quote_or_invoice == "invoice") {
            foreach ($info as $line_item) {
                PositionColumn($line_item , "Description", "invoice" , $line_item_information, $line_item_key);
                PositionColumn($line_item  , "Unit", "invoice" , $line_item_information, $line_item_key);
                PositionColumn($line_item  , "final", "invoice", $line_item_information, $line_item_key);

            }
            DiscrepancyCalc($line_item_information, $line_item_key);
        }
    }
}













//input   the input should be the invoice infomation that will be one line item
//process   it goes to the right place in the array and echos out the +infomation in the right order
// //output     output the invoice infomation in the right format
// function OutputInvoiceLineinformation($invoice_info){
//     //$invoice_infomation has [0] infront of the actuall infomation
//     if ($invoice_info == ''){
//         echo '<td colspan = "5" align="center"> error - no $invoice_infomation</td>';
//     } else {
//         foreach ($invoice_info as $invoice_var_key => $invoice_var_array) {
//             PositionColumn($invoice_var_array , "Description");
//             PositionColumn($invoice_var_array , "Unit");
//             PositionColumn($invoice_var_array , "final");
//         }
//     }
// }
//
// //input the quote infomation that should conatin one quote line and the line item infomation to get the invoice infomation that it will be comparing
// //oricess 1st thing it does is check if there even is a relevent quote and if there is not echo out quote not found then it does the proper checking
// //and calls the function QuoteVarCompareAgainstInvoiceVar that does as in the name compare the inputed quote item with the relevent invoice item
// //output the quote infomation and colour code it if its diffrent from the invoice infomation





function OutputComparisonTable($invoice_against_quote_array){
// echo "<pre>";
// print_r($invoice_against_quote_array);
// echo "</pre>";

    echo "<h2> Comparison Table </h2>";
    echo "<table style='width: 100%; background:#ededed; white-space: normal; word-wrap: break-word;'>";
    EchoTableHead();
    //loop through every line  item -
    echo "<tbody>";
    foreach ($invoice_against_quote_array as $line_item_key => $line_item_information) {
        if ($line_item_key != '0') {

            echo '<tr class="'. $line_item_key . ' "id="'.$line_item_key .'"   ">';
            OutputLineinformation($line_item_information, "quote", $line_item_key);
            OutputLineinformation($line_item_information, "invoice", $line_item_key);


            echo "</tr>";
        }
    }
    echo "</tbody>";
    echo "</table>";

}
?>

<section>
    <div>
        <div >
            <div style="width: 100%;" align="left" >

                <?php
                $output_inv_id = $_GET['output_inv_id'];
                if ($output_inv_id != "") {
                    //    $database_table = base64_encode(serialize($comp_table));
                    $db = new database($servername, $username, $password, $dbname);

                    if ($db->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT database_table FROM qc_pr_invoices  WHERE id=?"; //  retuns all the times from when the booking date is x
                    $args = array("s", $output_inv_id);
                    $db = new database();
                    $db->query($sql, $args);
                    $db_new_table = $db->all();
                    $db = null;
                    $invoice_against_quote_array = unserialize(base64_decode($db_new_table[0]['database_table']));
                    // echo "<pre>";
                    // print_r($invoice_against_quote_array);
                    // echo "</pre>";


                } else {
                    $invoice_against_quote_array = $_SESSION['invoice_against_quote'];
                }

                if ($invoice_against_quote_array != "quote"){


                    OutputComparisonTable($invoice_against_quote_array);
                } else {
                    echo "<h2> New quote line items added to job </h2";
                }


                ?>

                <?php
                // // echo "<pre>";
                // // print_r($_SESSION);
                // // echo "</pre>";
                //                     foreach ($_SESSION['invoice_against_quote'] as $key => $value1) {
                //                         echo "<tr>";
                //                         foreach ($value1 as $key => $value2) {
                //                             if ($key == "invoice"){
                //                                 foreach ($value2 as $key => $value3) {
                //                                     foreach ($value3 as $key => $value4) {
                //                                         echo "<td>";
                //                                         echo $value4;
                //                                         echo "</td>";
                //                                     }
                //                                 }
                //                                 echo "</tr>";
                //                             }
                //                             if ($key == "quote"){
                //                                 if ($value2 == 'false'){
                //                                     foreach ($_SESSION['invoice_against_quote']['0']['invoice']['0'] as $key => $value1) {
                //                                         echo "<td>";
                //                                         echo "Not found";
                //                                         echo "</td>";
                //                                     }
                //                                 } else {
                //                                 foreach ($value2 as $key => $value3) {
                //                                     foreach ($value3 as $key5 => $value4) {
                //                                         if ($value3['Quantity'] == "Quantity"){
                //                                         continue;
                //                                         }
                //                                         if ($key5 == 'Description'){
                //                                             echo "<td>";
                //                                             echo "</td>";
                //                                         }
                //                                         if ($key5 != 'file_type' &&  $key5 != 'fk_job_id' && $key5 != 'id' && $key5 != 'Description' ) {
                //                                             echo "<td>";
                //                                             echo $value4;
                //                                             echo "</td>";
                //                                         }
                //                                     }
                //                                 }
                //                             }
                //                             echo "</tr>";
                //                             }
                //                         }
                //                     }
                ?>


            </div>
            <style>
            .NoHighlight{
            background-color: #EDEDED !important;
            }

            td, th {
                /* max-width:140px; */
                border: 1px solid #dddddd;

                padding: 8px;
                /* word-wrap: break-word; */
                /* white-space: normal; */
            }
            </style>
        </div>

    </section>
    <div id="user_data"> </div>
    <!--
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
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
    <!-- External JavaScripts
    ============================================= -->


    <!-- Footer Scripts
    ============================================= -->
    <!-- <script type="text/javascript" src="js/functions.js"></script> -->
    <?php
    //include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/select_user_info.php");
    ?>


</body>
</html>

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

<div style="height:100px"></div>
<script>
const background = document.querySelector('body');
const toggle = document.querySelector('.toggle');

toggle.style.transform = 'rotate(0)'; // offset initial rotation
toggle.addEventListener('click',()=>{
    toggle.removeAttribute('style');
    toggle.classList.toggle('toggled');
    background.classList.toggle('toggledBg');

    setTimeout(()=>{
        toggle.style.transform = 'rotate(0)';
    },600)
});

</script>
<?php

$additional_footer_code_array[] = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="resources\jquery-ui-1.12.1\jquery-ui.js"></script>

<script>$( function() {$( "#resizable" ).resizable();$( ".resizable" ).resizable();} );</script>
<script type="text/javascript" src="resources/pr.js"></script>

<script>
jQuery(document).ready(function(event){
    jQuery("overlay_div").draggable().find("overlay_div").resizable();
});
$( function() {
    $( "#draggable" ).draggable({ axis: "y" });
    $( "#draggable2" ).draggable({ axis: "x" });
    $( "#draggable3" ).draggable({ containment: "#containment-wrapper", scroll: false });
    $( "#draggable4" ).draggable({ containment: "parent" });
} );

$( function() {
    $( ".resizable" ).resizable({
        animate: true
    });
} );
</script>



';
?>



<?php
include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");
?>
