<head>
  <title>admin page</title>
  <section>
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



    <!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script> -->

    <!-- <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script> -->



    <!-- Bootstrap File Upload CSS -->
    <link rel="stylesheet" href="/resources/canvas/HTML/css/components/bs-filestyle.css" type="text/css" />

    <!-- Bootstrap Switch CSS -->
    <link rel="stylesheet" href="/resources/canvas/HTML/css/components/bs-switches.css" type="text/css" />

    <!-- Radio Checkbox Plugin -->
    <link rel="stylesheet" href="/resources/canvas/HTML/css/components/radio-checkbox.css" type="text/css" />


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">


    <!-- http://www.quotecheck.tech/ -->
    <link rel="stylesheet" href="/resources/qc_global_v1.css"/>
    <link rel="stylesheet" href="/resources/qc_text.css"/>
    <link rel="stylesheet" href="/resources/xxxqc_jack_v1.css"/>
    <link rel="stylesheet" href="/resources/qc_animate.css"/>

    <link rel="shortcut icon" type="image/png" href="../../imgs/quotecheck/favicon.png" />
    <link rel="shortcut icon" type="image/png" href="http://www.quotecheck.tech/imgs/quotecheck/favicon.png" />

    <!-- External JavaScripts
    ============================================= -->
    <script type="text/javascript" src="/resources/canvas/HTML/js/jquery.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript"  src="/resources/qc_global_preloader.js"></script>
  </section>
</head>
<script>
jQuery(document).ready(function(event){
  jQuery("overlay_div").draggable().find("overlay_div").resizable();
});

</script>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<style>
.draggable { width: 90px; height: 90px; float: left; margin: 0 0 0 0; }
#draggable, #draggable2 { margin-bottom:20px; }
#draggable { cursor: n-resize; }
#draggable2 { cursor: e-resize; }
#containment-wrapper { width: 95%; height:150px; border:2px solid #ccc; padding: 10px; }
h3 { clear: left; }
</style>
>
<script>
$( function() {
//  $( "#draggable" ).draggable({ axis: "y" });
  $( "#draggable2" ).draggable({ axis: "x" });
  $( "#draggable3" ).draggable({ containment: "#containment-wrapper", scroll: false });
  $( "#draggable4" ).draggable({ containment: "parent" });
} );
</script>
</head>
<body>
  <?php
  $db = new database;
  $cmd = "update";
  $table_name = "test_table";
  $whereLocation = "id";
  $whereValue = "3";
  $whereOperator = "=";
  $fields = array("col_1", "col_2", "col_3");
  $values  = array("val4", "val5", "val6");
  $valueTypes = "sss";
  $db_sql = $db->execute_sql($cmd,$table_name,$whereLocation,$whereValue,$whereOperator,$fields,$values,$valueTypes);
  echo $db_sql;
  $db_sql = null;


  $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
  $sql = "update test_table set col_2=val5,col_2=val5,col_2=val5, WHERE id = 3;"


  ?>

  <p>"abc"</p>





  <?php
  $pspell = pspell_new('en','canadian','','utf-8',PSPELL_FAST);

  function spellCheckWord($word) {
    global $pspell;
    $autocorrect = TRUE;

    // Take the string match from preg_replace_callback's array
    $word = $word[0];

    // Ignore ALL CAPS
    if (preg_match('/^[A-Z]*$/',$word)) return $word;
    if (preg_match('/^[0-9]*$/',$word)) return $word;
    if (preg_match('/^[involce]*$/',$word)) return "invoice";
    // Return dictionary words
    if (pspell_check($pspell,$word))  return $word;

    // Auto-correct with the first suggestion, color green
    if ($autocorrect && $suggestions = pspell_suggest($pspell,$word))
    return '<span style="color:#00FF00;">'.current($suggestions).'</span>';

    // No suggestions, color red
    return '<span style="color:#FF0000;">'.$word.'</span>';
  }

  function spellCheck($string) {
    return preg_replace_callback('/\b\w+\b/','spellCheckWord',$string);
  }

  ?>

  <div class="contact-page-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="contact-form-area">
            <h4>Please upload the new company infomation</h4>
            <form method="post" name="contact_form" action="company_upload" enctype="multipart/form-data">
              <fieldset>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Company name </label><br />
                    <input type="text" name="company_name" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Company address</label><br />
                    <input type="text" name="company_address" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Company Phone number </label><br />
                    <input type="text" name="company_phone_number" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Delivery address </label><br />
                    <input type="text" name="delivery_address" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Company number </label><br />
                    <input type="text" name="company_number" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Invoice address</label><br />
                    <input type="text" name="invoice_address" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <button class="btn-send submit-buttom" type="submit">SEND INFOMATION</button>
                  </div>
                </div>

              </fieldset>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="contact-page-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="contact-form-area">
            <h4>Please upload the new Item infomation</h4>
            <form method="post" name="contact_form" action="item_upload" enctype="multipart/form-data">
              <fieldset>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Code </label><br />
                    <input type="text" name="code" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Name</label><br />
                    <input type="text" name="name" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Quote number </label><br />
                    <input type="text" name="quote_number" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Quote discount </label><br />
                    <input type="text" name="quote_discount" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Quote price </label><br />
                    <input type="text" name="quote_price" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Quote total price </label><br />
                    <input type="text" name="quote_total_price" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Invoice price </label><br />
                    <input type="text" name="invoice_price" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Invoice number</label><br />
                    <input type="text" name="invoice_number" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Invoice discount</label><br />
                    <input type="text" name="invoice_discount" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <label>Invoice total price</label><br />
                    <input type="text" name="invoice_total_price" class="form-control" required value="">
                  </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                  <div class="form-group">
                    <button class="btn-send submit-buttom" type="submit">SEND INFOMATION</button>
                  </div>
                </div>
              </div>
            </fieldset>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

</form>
<section>
</section>


<?php

$row_count = 0;
$servername = "localhost";
$username = "ejdev_db";
$password = "autoSquared01_db";
$dbname = "ejdev_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, quote, invoice FROM qc_job_data ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);


$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    $id = $row["id"];
    $invoice = $row["invoice"];
    $quote = $row["quote"];

  }
  $conn->close();
}
?>














<title>jQuery UI Resizable - Animate</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( ".resizable" ).resizable({
    animate: true
  });
} );
</script>

  <div id="2413" style="background-image:url(/imgs/quotecheck/uploads/Test_table.jpg); background-repeat:no-repeat; background-size: 100%; height:100%; !important" class=" containment-wrapper">

    <div id="draggable" style="opacity: 0.5; height:100%; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 1</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%;   margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 2</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%;  margin: 0 0 0 0; " class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 3</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%;  margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 4</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%;  margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 5</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%;  margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 6</p>
    </div>
    <div id="draggable" style="opacity: 0.5; height:100%; margin: 0 0 0 0;" class="draggable resizable ui-widget-content ui-resizable">
      <p>Col 7</p>
    </div>
  </div>

</div>

<!--
<div class="row">
  <h2> infomation </h2>
  <div class="col-md-6">
    <textarea rows="20" style="width:95%;"><?php //echo("QUOTE=".$quote); ?></textarea>
  </div>
  <div class="col-md-6">
    <textarea rows="20" style="width:95%;"><?php// echo("INVOICE=".$invoice); ?></textarea>
  </div>
</div>
!-->


<!--
<?php
////$spellcheckquote = spellCheck($quote);
//$spellcheckinvoice = spellCheck($invoice);
?>
<div class="row">
  <h2> spell check test mode </h2>
  <div class="col-md-6">

    <?php //echo("QUOTE=".$spellcheckquote); ?>

  </div>
  <div class="col-md-6">
    <?php// echo("INVOICE=".$spellcheckinvoice); ?> <!--  <textarea rows="20" style="width:95%;"></textarea> -->
  </div>
</div>
