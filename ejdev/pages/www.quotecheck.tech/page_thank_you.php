






<?php

include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v2.0.php");

?>
<!-- HTML / CSS Goes here -->
<!-- Alert messages -->

<div >
					<div class="promo promo-border promo-center box-border ">
						<div class="box-wrapper">
							<div class="portfolio-desc">
								<h2>Thank You for your order</h2>
								<h3>Your Order Progress</h3>
							</div>
							<ul class="process-steps process-3 bottommargin clearfix">
													<li>
														<a href="#" class="i-bordered i-rounded divcenter">1</a>
														<h5>Upload Quote/Invoice and pay</h5>
													</li>
													<li class="active">
														<a href="#" class="i-rounded i-alt divcenter bgcolor">2</a>
														<h5>Quotes and invoices are compared</h5>
													</li>
													<li>
														<a href="#" class="i-bordered i-rounded divcenter">3</a>
														<h5>The results will be emailed in 24hr</h5>
													</li>
												</ul>
							<!--<h5 class="bottommargin">Upload your <span>Quote</span> by selecting the file</h5> !-->
							<div class="bottommargin">

   </div>
</div></div>
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
					<h2>Your Reqults will be emailed to you in around 24hr</h2>
				<span>orders will be processed as fast as possible on a first come first served basis the speed depends on the amount of requests and could be subject to change.</span>
				<div class="clear"></div>
				</div>
			</div>

			<div class="clear"></div>
			<div class="promo promo-center">
				<a href="http://www.quotecheck.tech" class="button button-3d button-rounded button-green button-xlarge"><i class="icon-plus"></i>Return to front page</a>
			</div>
		</div>
	</div>
</section>



<!-- HTML / END -->

<?php

	 include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");

?>
<?php

  $additional_footer_code_array[] = '<script src="https://js.stripe.com/v3/"></script>';
	$additional_footer_code_array[] = '<script src="qc_stripe_config.js"></script>';



?>
