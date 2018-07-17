<?php
require('/home/rwdev/27O9OOWL/htdocs/components/stripe-php-5.7.0/init.php');
?>

<?php

$stripe = array(
  //"secret_key => " "sk_test_ODx3OuaCT2SfBoooKPlxQyZb"
  //"publishable_key" => "pk_test_HontjU0V6Ez1kRxWVOazetMn"

  "publishable_key" => "pk_test_HontjU0V6Ez1kRxWVOazetMn",
  "secret_key"      => "sk_test_ODx3OuaCT2SfBoooKPlxQyZb"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);


if (isset( $_POST['buttonname']) )
{
 	$buttonpress = $_POST['buttonname'];
	if ($buttonpress == 'basic')
	{
	    $token  = $_POST['stripeToken'];

	$customer = \Stripe\Customer::create(array(
		'email' => 'customer@example.com',
		'source'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
		'customer' => $customer->id,
		'amount'   => 1,
		'currency' => 'gbp'
  ));

  echo '<h1>Successfully charged !</h1>';
	echo "token = ".$token;
}
}
?>

<?php
$additional_header_code_array[] = '<link rel="stylesheet" href="/resources/remix_local/css/rxstyle.css">';
$headerpath = DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v1.0.php";
include_once($headerpath);
?>

<div class="under_header">
	<img src="/imgs/puzgo/subscriptionplan.jpg" alt="#">
</div><!-- under header -->

<div class="page-content back_to_up">
	<div class="row clearfix mb">
		<div class="breadcrumbIn">
			<ul>
				<li><a href="/" class="toptip" title="Homepage"> <i class="icon-home"></i> </a></li>
				<li> Subscription Plans </li>
			</ul>
		</div><!-- breadcrumb -->
	</div><!-- row -->

	<div class="row-fluid clearfix mbf">
		<div class="container clearfix">

			<div class="heading-block center">
				<h2>Vibe Success Plans</h2>

			</div>

			<div class="pricing bottommargin clearfix">

				<div class="col-md-4">
					<div class="pricing-box">
						<div class="pricing-title">
							<h3>Beginner</h3>
						</div>
						<div class="pricing-price">
							<span class="price-unit">&pound;</span>4.00<span class="price-tenure">/mo</span>
						</div>
						<div class="pricing-features">
							<ul>
								<li>Multimedia Profile</li>
								<li>Event Bookings</li>
								<li>Ticket Sales</li>
								<li>One Video</li>
								<li>5 Audio Tracks</li>
								<li>&#45; &#45; &#45;</li>
								<li>&#45; &#45; &#45;</li>
								<li>&#45; &#45; &#45;</li>
								<li>&#45; &#45; &#45;</li>
								<li>&#45; &#45; &#45;</li>
							</ul>
						</div>

            <form method="post" id="payment-form">
							<br>
							<input type="hidden" name="buttonName" value = "basic">
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="<?php echo $stripe['publishable_key']; ?>"
								data-description="basic access for £4/month"
								data-currency = 'GBP'
								data-amount="400"
								data-locale="auto"></script>
						</form>
					</div>

				</div>
				<div class="col-md-4">

					<div class="pricing-box best-price">
						<div class="pricing-title">
							<h3>Professional</h3>
							<span>Most Popular</span>
						</div>
						<div class="pricing-price">
							<span class="price-unit">&pound;</span>60<span class="price-tenure">/mo</span>
						</div>
						<div class="pricing-features">
							<ul>
								<li><strong>Managed</strong> Multimedia Profile</li>
								<li>Event Bookings</li>
								<li>Ticket Sales</li>
								<li>One Video</li>
								<li>10 Audio Tracks</li>
								<li><strong>4hr</strong> studio time per year</li>
								<li>Professional <strong>Photo</strong> Shoot</li>
								<li>&#45; &#45; &#45;</li>
								<li>Merchandise Sales</li>
								<li>&#45; &#45; &#45;</li>

							</ul>
						</div>
						<form method="post" id="payment-form" class="highlight_price">
							<br>
							<input type="hidden" name="buttonName" value = "enhanced">
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="<?php echo $stripe['publishable_key']; ?>"
								data-description="enhanced membership for £60/month"
								data-currency = 'GBP'
								data-amount="6000"
								data-locale="auto"></script>
							<!--<button class="btn btn-danger btn-block btn-lg">Submit Payment</button>-->

						</form>
					</div>

				</div>
				<div class="col-md-4">
					<div class="pricing-box">
						<div class="pricing-title">
							<h3>Professional</h3>
							<span>Most Cost Effective</span>
						</div>
						<div class="pricing-price">
							<span class="price-unit">&pound;</span>90<span class="price-tenure">/mo</span>
						</div>
						<div class="pricing-features">
							<ul>
								<li><strong>Managed</strong> Multimedia Profile</li>
								<li>Event Bookings</li>
								<li>Ticket Sales</li>
								<li>One Video</li>
								<li>100 Audio Tracks</li>
								<li><strong>8hr</strong> studio time per year</li>
								<li>Professional Photo Shoot</li>
								<li>Professional <strong>Video</strong> Shoot</li>
								<li>Merchandise Sales</li>

							</ul>
						</div>
						<form method="post" id="payment-form">
							<br>
							<input type="hidden" name="buttonName" value = "professional">
							<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="<?php echo $stripe['publishable_key']; ?>"
								data-description="Professional membership for £90/month"
								data-currency = 'GBP'
								data-amount="9000"
								data-locale="auto"></script>
							<!--<button class="btn btn-danger btn-block btn-lg">Submit Payment</button>-->

						</form>
					</div>
				</div>
			</div>
		</div>
	</div><!-- row clearfix -->
</div><!-- end page content -->

<?php

  $additional_footer_code_array[] = '<script src="https://js.stripe.com/v3/"></script>';
	$additional_footer_code_array[] = '<script src="va_stripe_config.js"></script>';



?>
