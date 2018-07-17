<?php

// echo "<pre>";
// print_r($_SESSION['user']['id']);
// echo "</pre>";
//
//
// echo "<pre>";
// print_r($_SESSION['user']['username']);
// echo "</pre>";



 ?>
<?php /*$stripe =
 array(

  "publishable_key" => "pk_test_HontjU0V6Ez1kRxWVOazetMn",
  "secret_key"      => "sk_test_ODx3OuaCT2SfBoooKPlxQyZb"
);

*/
 ?>

<?php
$total_cost = -1;


switch($_POST['formname']){

    case "Quote_Check_Stripe_Button_Payment":

        $email = $_POST['stripeEmail'];
        $price = $_POST['total_cost'];
        $email_location_upload_id = $_POST['job_id'];

        $sql = "UPDATE qc_jobs SET price='$price' , email_address='$email' WHERE id='$email_location_upload_id'";



    $db = new database();
    $db->query($sql);

    $db = null;

  /**$email_address = $_POST[email]
  $sql = "update into qc_job_data (fk_job_id,quote,invoice) values (?,?,?)";
  $args = array("iss", $job_id, $quote_text, $invoice_text);
  $db = new database();
  $db->query($sql);
  //echo $db->error();

  $db = null;
**/
 //send the email
 $from_email = "hello@quotecheck.tech";
     $from_name = "QuoteCheck";
     $to_email = $_POST['stripeEmail'];
     $to_name = "$email_location_upload_id";

     $subject = "Quotecheck Results";

     $attach = "";
    $message = getmsgforemail($to_name);
    $message_nohtml = getmsgforemail_nohtml($to_name);




     sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,$message_nohtml,$message,"");



  header('Location: http://www.quotecheck.tech/page_thank_you');
  die();
  break;
  case "upload_files":



	//the input settings* for the Quote as in the destination max height/width etc

	if($_FILES['input_quote']['name'][0]!=""){  // if anything is not equal to "" (nothing) do the code under

		if($_FILES['input_quote']['type'][0]=="application/pdf"){

			//we're dealing with a PDF file - generate PDF name and extract JPGS from pdf using imagemagick:
			$pdf_info = upload_pdf_and_convert_to_jpg($_FILES['input_quote'], "quote");
			/*pdf_info contains:
			unique_id
			jpg_count (number of jpgs created from pdf)
			destination_filename_prefix
			upload_folder
			*/

			//now we need to convert each of the JPGS
			$number_of_jpgs = $pdf_info['jpg_count'];
			$root_filename = $pdf_info['destination_filename_prefix'];
			$upload_folder = $pdf_info['upload_folder'];

			$ch = curl_init();
			$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
			$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

			$quote_text="";
			for ($image_count=1; $image_count <= $number_of_jpgs; $image_count++) {
				if ($number_of_jpgs == 1){
					$jpg_filename = $root_filename . ".jpg";
				}
				else {
					$jpg_filename = $root_filename . "-" . $image_count . ".jpg";
				}

				//put this in a function:
				$result_of_conversion = post_image_to_vision($ch, $jpg_filename, $cvurl);

				$decoded_json_data = json_decode($result_of_conversion, true);

				$text_only = $decoded_json_data['responses'][0]['textAnnotations']['0']['description'];
				$quote_text .= $text_only;

			}
			curl_close($ch);
		}
		else {

			$arr['dest_file_folder'] = "/quotecheck/uploads/";
			$arr['dest_file_name_string'] = "quote";//////////////
			$arr['create_thumb_nail'] = false;
			$arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
			$arr['dest_max_width'] = 750;
			$arr['dest_max_height'] = 5000;

			$result = upload_file($arr, $_FILES['input_quote']); // upload all of the above details in the arr array and the input invoice infomation below??


			$quote_image = $result[0]['main']['filename']; //setting the quote image to be used later in the results variable

			$ch = curl_init();
			$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
			$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

			// work out how much text is there by doing the post images to vision function by sending the infomation as
			$results = post_image_to_vision($ch, $quote_image, $cvurl);

			//decode json
			$decoded_json_data = json_decode($results,true);

			$quote_text = $decoded_json_data['responses'][0]['textAnnotations']['0']['description'];
      curl_close($ch);

		}
	}

	//the input settings* for the invoice as in the destination max height/width etc
	if($_FILES['input_invoice']['name'][0]!=""){
		if($_FILES['input_invoice']['type'][0]=="application/pdf"){
			//we're dealing with a PDF file - generate PDF name and extract JPGS from pdf using imagemagick:
      echo "avc";
      die();
			$pdf_info = upload_pdf_and_convert_to_jpg($_FILES['input_invoice'], "invoice");
			/*pdf_info contains:
			unique_id
			jpg_count (number of jpgs created from pdf)
			destination_filename_prefix
			upload_folder
			*/

			//now we need to convert each of the JPGS
			$number_of_jpgs = $pdf_info['jpg_count'];
			$root_filename = $pdf_info['destination_filename_prefix'];
			$upload_folder = $pdf_info['upload_folder'];

			$ch = curl_init();
			$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
			$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

			$invoice_text = "";
			for ($image_count=1; $image_count <= $number_of_jpgs; $image_count++) {
				if ($number_of_jpgs == 1){
					$jpg_filename = $root_filename . ".jpg";
				}
				else {
					$jpg_filename = $root_filename . "-" . $image_count . ".jpg";
				}

				//put this in a function:
				$result_of_conversion = post_image_to_vision($ch, $jpg_filename, $cvurl);

				$decoded_json_data = json_decode($result_of_conversion,true);

				$text_only = $decoded_json_data['responses'][0]['textAnnotations']['0']['description'];
				$invoice_text .= $text_only;
			}
			curl_close($ch);

		}
		else {

			$arr['dest_file_folder'] = "/quotecheck/uploads/";
			$arr['dest_file_name_string'] = "invoice";//////////////
			$arr['create_thumb_nail'] = false;
			$arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
			$arr['dest_max_width'] = 750;
			$arr['dest_max_height'] = 5000;

			$result = upload_file($arr, $_FILES['input_invoice']); // upload all of the above details in the arr array and the input invoice infomation below??
			$invoice_image = $result[0]['main']['filename']; //setting the quote image to be used later in the results variable

			$ch = curl_init();
			$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
			$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

			// work out how much text is there by doing the post images to vision function by sending the infomation as
			$results = post_image_to_vision($ch, $invoice_image, $cvurl);

			//decode json
			$invoice_array = json_decode($results, true);

			$invoice_text = $invoice_array['responses'][0]['textAnnotations']['0']['description'];
      curl_close($ch);
		}
	}

	// set a unique id to the job including both inputs

	//cost calculation

	///$quote_total_characters = strlen($quote_text);

	$job_id = get_unique_job_id($quote_image, $invoice_image);
  $job_id_fix = $job_id['id'];



	$invoice_total_characters = strlen($invoice_text);

	$total_characters = $invoice_total_characters;

	$total_cost = 5.0+($total_characters/1024);

  $total_cost = round($total_cost, 2);

	//echo "invoice total cost &pound;" . number_format($invoice_total_characters,2);



	//sql statement

	$sql = "insert into qc_job_data (fk_job_id,quote,invoice) values (?,?,?)";
	$args = array("iss", $job_id_fix, $quote_text, $invoice_text);
	$db = new database();
	$db->query($sql,$args);
	echo $db->error();

	$db = null;


	//header("Location: https://www.quotecheck.tech");
	//die();
break;
}
?>



<?php

include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v2.0.php");

?>
<!-- HTML / CSS Goes here -->
<!-- Alert messages -->
<div class="container clearfix hidden-block">
	<div class="row ">
		<div class="col-md-10 col-md-offset-1">

			<div class="style-msg successmsg">
			<div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Well done!</strong> You successfully read this important alert message.</div>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>

			<div class="style-msg errormsg">
				<div class="sb-msg"><i class="icon-remove"></i><strong>Oh snap!</strong> Change a few things up and try submitting again.</div>
			</div>

			<div class="style-msg infomsg">
				<div class="sb-msg"><i class="icon-info-sign"></i><strong>Heads up!</strong> This alert needs your attention, but it's not super important.</div>
			</div>

			<div class="style-msg alertmsg">
				<div class="sb-msg"><i class="icon-warning-sign"></i><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
			</div>
		</div>
	</div>
</div>

<?php if ($total_cost < 0) { ?>
<section>
<form id="qc_upload" action="#" method="post" enctype="multipart/form-data">

	<div class="content-wrap custom-top">
		<div class="container clearfix">
			<div class="row">
				<div class="col-md-6 extra-space">
					<div class="promo promo-border promo-center box-border ">
						<div class="box-wrapper">
							<div class="portfolio-desc">
								<h3>Select a Quote</h3>
							</div>

							<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
							<div class="bottommargin">
								<input name="input_quote[]" style='color:#fff;' id="input-quote"  type="file" class="file-input-qc" >
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 extra-space">
					<div class="promo promo-border promo-center box-border ">
						<div class="box-wrapper">
							<div class="portfolio-desc">
								<h3>Select an Invoice</h3>
							</div>

							<!--<h5 class="bottommargin">Upload your <span>invoice</span> by selecting the file</h5> !-->
							<div class="bottommargin">
								<input name="input_invoice[]" id="input-invoice" type="file" class="file-input-qc" >
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

	<input type="hidden" name="formname" value="upload_files">
</form>
</section>
<?php } else { ?>
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

		<div class="row">
			<div class="col-md-12 ">
				<div class="pricing-box pricing-extended clearfix">
					<div class="pricing-desc col-ms-8 box-border">
						<div class="pricing-title">
							<h3>Included Checks &amp; Pricing</h3>
						</div>
						<div class="pricing-features">
							<ul class="clearfix">
								<li><i class="icon-ok"></i>Line item unit price</li>
								<li><i class="icon-ok"></i>Items invoiced that were not on the quote</li>
								<li><i class="icon-ok"></i>Discount mismatches</li>
								<li><i class="icon-ok"></i>Items quoted that were not on the invoice</li>

							</ul>
							<div style='height:30px;'></div>
						</div>
            <div class="pricing-title">
							<h3>Your results will be emailed to you at the email provided in your stripe payment</h3>
						</div>
					</div>

					<div class="pricing-action-area col col-md-4 box-border">

						<div class="pricing-price">
							<span class="price-unit"></span>&pound;<?php echo number_format($total_cost,2); ?><span class="price-tenure">Only.</span>
						</div>

						<form method="post" id="payment-form">
							<br>
              <input type="hidden" name="formname" value="Quote_Check_Stripe_Button_Payment">
							<input type="hidden" name="buttonName" value = "basic">
              <input type="hidden" name="job_id" value = <?php echo $job_id['id'] ?>>
              <input type="hidden" name="total_cost" value= <?php echo $total_cost ?>>
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button "
								data-key="<?php echo $stripe['publishable_key']; ?>"
								data-description='Total cost &pound;<?php echo number_format($total_cost,2); ?>'
								data-currency = 'GBP'
								data-amount="<?php $end_cost = $total_cost * 100;
                  echo number_format($end_cost,2); ?>"
								data-locale="auto"
                data-image="../../imgs/quotecheck/quotecheck_small.png"
                data-name="quotecheck"
                data-currency="GBP"




                >


                </script>

						</form>



					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

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
	<div class="row clearfix">

		<?php

			$start_date = strtotime("27 February 2018");

			$quotes_per_day = 100;

			$seconds_in_day = 24*60*60;

			$quotes_per_second =  $quotes_per_day  /  $seconds_in_day;

			$now = time();

			$start_quote_number = round(($now - $start_date) * $quotes_per_second);

			$end_quote_number = round($start_quote_number + $quotes_per_day);


			$money_random = 550;
			$discrepancies_random = 359;


			$start_money_number = ($start_quote_number + $money_random);

			$start_discrepancies_number = ($start_quote_number + $discrepancies_random);

			$end_money_number = ($end_quote_number + $money_random);

			$end_discrepancies_number = ($end_quote_number + $discrepancies_random);

		?>

		<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(87, 111, 158); height: 326px; animated bounceInLeft">
			<div>
				<i class="i-plain i-xlarge divcenter icon-line-bar-graph-2"></i>
				<div class="counter counter-lined animate "><span data-from="<?php echo($start_quote_number) ;?>" data-to="<?php echo($end_quote_number) ;?>" data-refresh-interval="2" data-speed="2300"><?php echo($start_quote_number) ;?></span></div>
				<h5>Quotes Uploaded</h5>
			</div>
		</div>

		<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(102, 151, 185); height: 326px;">
			<div>


				<i class="i-plain i-xlarge divcenter icon-line-search"></i>


				<div class="counter counter-lined"><span data-from="<?php echo($start_discrepancies_number) ;?>" data-to="<?php echo($end_discrepancies_number) ;?>" data-refresh-interval="2" data-speed="2500">408</span></div>
				<h5>Discrepancies Found</h5>
			</div>
		</div>

		<div class="col-md-4 col-sm-4 dark center col-padding" style="background-color: rgb(136, 195, 216); height: 326px; ">
			<div>
				<i class="i-plain i-xlarge divcenter fa fa-gbp"></i>
				<div class="counter counter-lined"><a style="color: #004421!important;">&pound;</a><span data-from="<?php echo($start_money_number ) ;?>" data-to="<?php echo($end_money_number) ;?>" data-refresh-interval="2" data-speed="2500">408</span></div>
				<h5>Total saved</h5>
			</div>
		</div>

	</div>
</section>


 <section id="price-display">
	<div class="container clearfix">
		<div class="row">
			<div class="col-md-12 ">
				<div class="pricing-box pricing-extended clearfix">
					<div class="pricing-desc col-ms-8 box-border">
						<div class="pricing-title">
							<h3>Subscribe now for better features</h3>
						</div>
						<div class="pricing-features">
							<ul class="clearfix">
								<li><i class="icon-ok"></i>Upload multiple files for comparison</li>
								<li><i class="icon-ok"></i>Easy login/uploading/file viewing</li>
								<li><i class="icon-ok"></i>We don't limit upload speeds, it's as fast as your connection</li>
								<li><i class="icon-ok"></i>Unlimited File size</li>
								<li><i class="icon-ok"></i>Files previewed or played in a browser</li>
								<li><i class="icon-ok"></i>Upload multiple invoices to compare to one quote</li>
								<li><i class="icon-ok"></i>Keep track of jobs you're working on</li>
								<li><i class="icon-ok"></i>Only monthly pages no on spot fees</li>
							</ul>
						</div>
					</div>

					<div class="pricing-action-area col col-md-4 box-border">
						<div class="pricing-meta">
							As Low as
						</div>
						<div class="pricing-price">
							<span class="price-unit">&pound;</span>50<span class="price-tenure">Only</span>
						</div>
						<div class="pricing-action">
							<a href="#" class="button button-3d button-rounded button-green button-xlarge btn-block nomargin" onclick="$('#modal_login').modal('show');">Subscribe now</a>
						</div>
					</div>
				</div>
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
</section>



<!-- HTML / END -->

<?php

	 include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");

?>
<?php
if($_SESSION['user']['id']>0){
header("https://www.quotecheck.tech/my_home");
};


 ?>
<?php

  $additional_footer_code_array[] = '<script src="https://js.stripe.com/v3/"></script>';
	$additional_footer_code_array[] = '<script src="qc_stripe_config.js"></script>';



?>
