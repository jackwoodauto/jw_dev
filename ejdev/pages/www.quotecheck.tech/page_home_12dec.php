<?php
if($_POST['formname']=="upload_files"){
	//the input settings* for the Quote as in the destination max height/width etc
	if($_FILES['input_quote']['name'][0]!=""){  // if anything is not equal to "" (nothing) do the code under

		$arr['dest_file_folder'] = "/quotecheck/uploads/";
		$arr['dest_file_name_string'] = "quote";//////////////
		$arr['create_thumb_nail'] = false;

		$arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
		$arr['dest_max_width'] = 750;
		$arr['dest_max_height'] = 5000;

		$result = upload_file($arr,$_FILES['input_invoice']); // upload all of the above details in the arr array and the input invoice infomation below??

		$quote_image = $result[0]['main']['filename']; //setting the quote image to be used later in the results variable
	}

	//the input settings* for the invoice as in the destination max height/width etc
	if($_FILES['input_invoice']['name'][0]!=""){

		$arr['dest_file_folder'] = "/quotecheck/uploads/";
		$arr['dest_file_name_string'] = "invoice";//////////////
		$arr['create_thumb_nail'] = false;

		$arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
		$arr['dest_max_width'] = 750;
		$arr['dest_max_height'] = 5000;

		$result = upload_file($arr,$_FILES['input_quote']);

		$invoice_image = $result[0]['main']['filename']; //setting the invoice image to be used later in the results variable
	}

	// set a unique id to the job including both inputs
	$job_id = get_unique_job_id($quote_image,$invoice_image);

	// work out how much text is there by doing the post images to vision function by sending the infomation as
	$results = post_images_to_vision($quote_image, $invoice_image);

	$json_quote_text = $results['quote_text'];
	$json_invoice_text = $results['invoice_text'];

	//decode json
	$quote_array = json_decode($json_quote_text,true);

	$quote_text = $quote_array['responses'][0]['textAnnotations']['0']['description'];


	$invoice_array = json_decode($json_invoice_text,true);
	$invoice_text = $invoice_array['responses'][0]['textAnnotations']['0']['description'];

	//cost calculation

	///$quote_total_characters = strlen($quote_text);


	$invoice_total_characters = strlen($invoice_text);

	$total_characters = $invoice_total_characters;

	$total_cost = 5.0+($total_characters/1024);

	//echo "invoice total cost £" . number_format($invoice_total_characters,2);



	//sql statement

	$sql = "insert into qc_job_data (fk_job_id,quote,invoice) values (?,?,?)";
	$args = array("iss", $job_id, $quote_text, $invoice_text);
	$db = new database();
	$db->query($sql,$args);
	//echo $db->error();

	$db = null;


	//header("Location: https://www.quotecheck.tech");
	//die();

}

else
{
	$total_cost = -1;
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

		<div class="row">

			<h2> Demo Only </h2>

			<div class="col-md-6">
				<textarea rows="20" style="width:95%;"><?php echo("QUOTE=".$quote_text); ?></textarea>

			</div>
			<div class="col-md-6">

				<textarea rows="20" style="width:95%;"><?php echo("INVOICE=".$invoice_text); ?></textarea>

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
					</div>

					<div class="pricing-action-area col col-md-4 box-border">

						<div class="pricing-price">
							<span class="price-unit">&pound; </span><?php echo number_format($total_cost,2); ?><span class="price-tenure">Only.</span>
						</div>
						<div class="pricing-action">
							<a href="#" class="button button-3d button-rounded button-green button-xlarge btn-block nomargin">Pay Now</a>
						</div>
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

			$start_date = strtotime("31 October 2017");

			$quotes_per_day = 100;

			$seconds_in_day = 24*60*60;

			$quotes_per_second =  $quotes_per_day  /  $seconds_in_day;

			$now = time();

			$start_quote_number = round(($now - $start_date) * $quotes_per_second);

			$end_quote_number = round($start_quote_number + $quotes_per_day);


			$money_random = 1035;
			$discrepancies_random = 421;


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
				<div class="counter counter-lined"><a style="color: #004421!important;">£</a><span data-from="<?php echo($start_money_number ) ;?>" data-to="<?php echo($end_money_number) ;?>" data-refresh-interval="2" data-speed="2500">408</span></div>
				<h5>Total saved</h5>
			</div>
		</div>

	</div>
</section>


<!-- <section id="price-display">
	<div class="container clearfix">
		<div class="row">
			<div class="col-md-12 ">
				<div class="pricing-box pricing-extended clearfix">
					<div class="pricing-desc col-ms-8 box-border">
						<div class="pricing-title">
							<h3>Features</h3>
						</div>
						<div class="pricing-features">
							<ul class="clearfix">
								<li><i class="icon-ok"></i> Upload your files immediately, no registration required</li>
								<li><i class="icon-ok"></i>More TBC</li>
								<li><i class="icon-ok"></i> We don't limit upload speeds, it's as fast as your connection</li>
								<li><i class="icon-ok"></i>File size up to 20GB</li>
								<li><i class="icon-ok"></i>Files previewed or played in a browser</li>
								<li><i class="icon-ok"></i>More TBC</li>
								<li><i class="icon-ok"></i>More TBC</li>
								<li><i class="icon-ok"></i> More TBC</li>
							</ul>
						</div>
					</div>

					<div class="pricing-action-area col col-md-4 box-border">
						<div class="pricing-meta">
							As Low as
						</div>
						<div class="pricing-price">
							<span class="price-unit">&pound;</span>5<span class="price-tenure">Only</span>
						</div>
						<div class="pricing-action">
							<a href="#" class="button button-3d button-rounded button-green button-xlarge btn-block nomargin">Pay Now</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>-->


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
							<td>£12.30</td> <!-- unit cost (quote) !-->
							<td>70</td> <!--Discount(quote) !-->
							<td>£129.00</td> <!--cost(quote)!-->
							<td>35</td> <!--Qty(invoice)!-->
							<td>£12.30</td> <!-- unit cost(invoice) !-->
							<td>0</td> <!--Discount(invoice) !-->
							<td>£430.00</td> <!--cost(invoice)!-->
							<td>£3.70</td> <!-- per unit !-->
							<td>£301.50</td> <!-- total !-->
						</tr>
						<tr>
							<td>10</td> <!-- line#!-->
							<td>SC20GP SMITH M20 SOLID COUPLER GALVANISED</td> <!-- item code !-->
							<td>150</td> <!--Qty!-->
							<td>£33.49</td> <!-- unit cost !-->
							<td>25</td> <!--Discount !-->
							<td>£5023.00</td> <!--cost(quote)!-->
							<td>170</td> <!--Qty!-->
							<td>£33.49</td> <!-- unit cost !-->
							<td>25</td> <!--Discount !-->
							<td>£5706.90</td> <!--cost(invoice)!-->
							<td>£0.00</td> <!-- per unit !-->
							<td>£683.90</td> <!-- total !-->
						</tr>
						<tr>
							<td colspan="9" style="visibility:hidden;" ></td>
							<td colspan="2" style="font-weight: bold;">Total Impact</td>
							<td>£985.40</td>
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
							<td>£43.20</td> <!-- unit cost !-->
							<td>50</td> <!--Discount !-->
							<td>£1512.00</td> <!--Cost !-->

						</tr>
						<tr>
							<td>200</td>
							<td>NLS4428EN NEWLEC 8X2" SCREW POZI RND HEAD TWIN THREAD ZINC P</td>
							<td>80</td> <!--Qty!-->
							<td>£17.83</td> <!-- unit cost !-->
							<td>60</td> <!--Discount !-->
							<td>£1426.40</td> <!--Cost !-->

						</tr>

						<tr>
							<td colspan="3" style="visibility:hidden;" ></td>
							<td colspan="2" style="font-weight: bold;">Total Impact</td>
							<td>£2938.40</td>
						</tr>

				</tbody>
			</table>

		<h4 class="no-bottom-margin">Non-invoiced items</h4>
			<!-- canvas 3 -->
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

				</tr>
				</thead>
				<tbody>
					<tr>
					<td></td>
					<td></td>
					<td>Qty</td>
					<td>Unit Cost</td>
					<td>Discount %</td>
					<td>Total Cost</td>
					</tr>
					<tr>
					<td>70</td>
					<td>MSB20SP SMITH M20 BRASS BUSH MALE SHORT</td>
					<td>50</td> <!--Qty!-->
					<td>£20.10</td> <!-- unit cost !-->
					<td>30</td> <!--Discount !-->
					<td>£703.50</td> <!--Cost !-->

					</tr>
					<tr>
					<td>50</td>
					<td>20MM CONDUIT GALV HGSW 3.75M CLASS4</td>
					<td>200</td> <!--Qty!-->
					<td>£30.20</td> <!-- unit cost !-->
					<td>60</td> <!--Discount !-->
					<td>£2416.00</td> <!--Cost !-->

					</tr>
					<tr>
					<td colspan="3" style="visibility:hidden;" ></td>
					<td colspan="2" style="font-weight: bold;">Total Impact</td>
					<td>£3119.50</td>
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
