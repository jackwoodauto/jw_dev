<?php

function log_error($error_arr){

	$domain = $_SERVER['HTTP_HOST'];

	$page_url = $_SERVER['REQUEST_URI'];

	$params = 	$_SERVER['QUERY_STRING'];

	$request = json_encode($_REQUEST);

	$error_json = json_encode($error_arr);

	$session_json = json_encode($_SESSION);

	$user_id = 0;
	if($_SESSION['user']['id'] > 0){

		$user_id = $_SESSION['user']['id'];

	}

	$sql = "insert into error_log (user_id, domain, url, params, request, error_info, session_info) values (?,?,?,?,?,?,?)";
	$args = array("issssss", $user_id, $domain, $page_url, $params, $request, $error_json, $session_json);
	$db = new database();
	$db->query($sql,$args);
	$db = nothing;

}

function ordinal_suffix($number){
	$ends = array('th','st','nd','rd','th','th','th','th','th','th');
	if (($number %100) >= 11 && ($number%100) <= 13){
	   return 'th';
	}else{
	   return $ends[$number % 10];
	}
}

function mp_is_market_promo($day){

	$uplift = 1;

	$sql = "select * from mp_market_promo where day = '$day'";
	$result = mysql_query($sql);
	if($row = mysql_fetch_assoc($result)){
		$uplift	= $row['uplift'];
	}

	//if($_SESSION['user']['id']<=2){
	//	$uplift = 2;
	//}

	return $uplift;

}

function mp_get_reward_type($advert,$uplift=1){



	if($advert['id'] & 1){
		if(date("j") & 1){
			$reward_type = 'patch_bonus';
		}else{
			$reward_type = 'personal_bonus';
		}
	}else{
		if(date("j") & 1){
			$reward_type = 'personal_bonus';
		}else{
			$reward_type = 'patch_bonus';
		}
	}


	if($reward_type == "patch_bonus"){
		if($uplift>1){

			$actual_reward = round($uplift * $advert[$reward_type],1);

			$reward_string = "<span class='mission_strikethrough'>" . $advert[$reward_type] . "</span> <span class='t_col_1'><b>" . $actual_reward . "</b></span> Extra Patches";

		}else{
			$reward_string = $advert[$reward_type] . " Extra Patches";
		}
	}elseif($reward_type == "personal_bonus"){
		if($uplift>1){

			$actual_reward = number_format($uplift * $advert[$reward_type],2);

			$reward_string = "<span class='mission_strikethrough'>&pound;" . $advert[$reward_type] . "</span> <span class='t_col_1'><b>&pound;" . $actual_reward . "</b></span> Personal Bonus";

		}else{
			$reward_string = "&pound;" . $advert[$reward_type] . " Personal Bonus";
		}
	}

	$return_array['reward_type'] = $reward_type;
	$return_array['reward_string'] = $reward_string;

	return $return_array;

}

function record_stp_transaction($source,$source_transaction_ref,$amount,$trans_type){

	// Enter unique record into stp, return trans_id or negative for failure

	$sql = "insert into stp (source, source_ref, amount, trans_type) values ('$source', '$source_transaction_ref', $amount,'$trans_type')";

	if(mysql_query($sql)===true){
		$trans_id = mysql_insert_id();
	}else{
		$trans_id = 0;
	}


	return $trans_id;


}

// Common framework functions
function check_int($int){

	// First check if it's a numeric value as either a string or number
	if(is_numeric($int) === TRUE){

		// It's a number, but it has to be an integer
		if((int)$int == $int){

			return TRUE;

		// It's a number, but not an integer, so we fail
		}else{

			return FALSE;
		}

	// Not a number
	}else{

		return FALSE;
	}
}

function notify($message,$sms=0){

	if($sms<2){

		sendemail("hello@storysnippets.org","antstonham@yahoo.co.uk","hello@storysnippets.org",$message,$message,$message,"");
		//sendemail("hello@storysnippets.org","stonhams@gmail.com","hello@storysnippets.org",$message,$message,$message,"");

	}


	if($sms==1 || $sms==2){

		sms("07880700132", "", "$message");
		//sms("07508446148", "", "$message");

	}

}

function sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,$body_nohtml,$body_html,$files){

	//require_once('/home/ejdev/PDRJ3F5B/htdocs/components/PHPMailer-master/src/PHPMailer.php');
	//require_once('/home/frame/V1X5FH6E/htdocs/resources/canvas/HTML/include/phpmailer/PHPMailerAutoload.php');

//echo "$DOC_ROOT. '/components/phpmailer/PHPMailerAutoload.php'";
//  require_once(DOC_ROOT. '/components/phpmailer/PHPMailerAutoload.php');
require_once('/home/ejdev/PDRJ3F5B/htdocs/components/phpmailer/PHPMailerAutoload.php');



	$mail = new PHPMailer(true);


	/*$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'frame.dns-systems.net';  			// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'hello-dogfocus-co-uk';                 // SMTP username
	$mail->Password = 'df-gCp-2017';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 465;                                    // TCP port to connect to
*/

	$mail->IsHTML(true);


	$mail->SetFrom( $from_email , $from_name );
	$mail->AddReplyTo( $from_email , $from_name );
	//foreach( $toemails as $toemail ) {
		$mail->AddAddress( $to_email , $to_name );
	//}
	$mail->Subject = $subject;



	// Runs only when File Field is present in the Contact Form
	if ( isset( $files['attach_file'] ) && $files['attach_file']['error'] == UPLOAD_ERR_OK ) {


		$mail->AddAttachment( $files['attach_file']['tmp_name'], $files['attach_file']['name'] );


	}



	$mail->Body    = $body_html;
	$mail->AltBody = $body_nohtml;



	if(!$mail->send()) {

		log_error($mail->ErrorInfo);


	}




}

function sendemail($from,$to,$reply,$subject,$body_nohtml,$body_html,$attach){

	if($to != ""){
		$attach_file_name = substr($attach, strrpos($attach,"/") + 1);

		// Add default address
		if($from==""){
			if($reply==""){
				$from="<postmaster@myluckypatch.com>";
			}else{
				$from = $reply;
			}
		}

		if($reply==""){
			$reply = "<NoReply@myluckypatch.com>";
		}

		$boundary = md5(date('r', time()));

		$eol = PHP_EOL;

		$content = chunk_split(base64_encode($content));
		$uid = md5(uniqid(time()));
		//$name = basename($file);



		$from_name = $from;
		$from_mail = $from;
		$replyto   = $reply;
		$mailto    = $to;
		$header    = "From: " . $from_name . " <" . $from_mail . ">\n";
		$header .= "Reply-To: " . $replyto . "\n";
		$header .= "MIME-Version: 1.0\n";
		$header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\n\n";
		$emessage = "--" . $uid . "\n";
		$emessage .= "Content-type:text/html; charset=iso-8859-1\n";
		//$emessage .= "Content-Transfer-Encoding: 7bit\n\n";
		$emessage .= "Content-Transfer-Encoding: base64\n\n";
		//$emessage .= $body_html . "\n\n";
		$emessage .= rtrim(chunk_split(base64_encode($body_html))) . "\n\n";
		$emessage .= "--" . $uid . "\n";
		//$emessage .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\n"; // use different content types here
		//$emessage .= "Content-Transfer-Encoding: base64\n";
		//$emessage .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\n\n";
		//$emessage .= $content . "\n\n";
		//$emessage .= "--" . $uid . "--";
		mail($mailto, $subject, $emessage, $header);

	/*
		$headers  = "From: $from\n".$eol;
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: multipart/alternative; boundary = $boundary\n";
		$headers .= "This is a MIME encoded message.\n\n";
		$headers .= "--$boundary\n" .
					"Content-Type: text/plain; charset=UTF-8\n" .
					"Content-Transfer-Encoding: base64\n\n";
		$headers .= chunk_split(base64_encode($body_nohtml));
		$headers .= "--$boundary\n" .
					"Content-Type: text/html; charset=utf-8\n" .
					"Content-Transfer-Encoding: base64\n\n";
		$headers .= chunk_split(base64_encode($body_html));
		$headers .= "--$boundary--\n";

		mail($to, $subject, $message, $headers, "-f $from");
		*/

	}

}


function sms($to, $from, $message){

	if ($from!=""){
		$from = " From: $from";
	}
	if (strlen($to) >= 10 && strlen($to) < 13){
		$subject = "Username:antstonham Password:fitsms11 To:$to $from";
		$body_nohtml = $message;
		sendemail("antstonham@yahoo.co.uk","sendsms@messaging.intellisoftware.co.uk","",$subject,$body_nohtml,$body_nohtml,"","");
		//return 1; // helpful for logging
	}else{
		//return  strlen($to) . " and " . is_numeric($to);
	}
}

function getmsgforemail($to_name){

$message = "Dear Customer  <br><br>\r\n";
$message .= "Regarding job reference " .$to_name.". <br><br>\r\n";
$message .= "We have compared your invoice and quote. Your results are down below. <br><br>\r\n";
$message .= "We hope the results are to your satisfaction <br><br>\r\n";
$message .= "All the best, <br><br>\r\n";
$message .= "The QuoteCheck Team <br><br>\r\n";





$message .= "
<meta charset='UTF-8'>


<link rel='stylesheet' href='http://www.quotecheck.tech/resources/canvas/HTML/css/bootstrap.css' type='text/css' />
<h3>Output Examples</h3>
<h4 class='no-bottom-margin'>Differences between quote and invoice</h4>
 <!--canvas!-->
 <table class='table table-bordered table-striped style='border: 1px solid #dddddd;padding: 8px;line-height: 1.42857143;vertical-align: top;''>
					 <colgroup>
					 <col class='col-xs-1'>
					 <col class='col-xs-10'>
					 </colgroup>
					 <thead>
					 <tr>
							 <th>Line#</th>
							 <th>Item code/</th>
						 <th colspan='4'>Quote</th>
						 <th colspan='4'>Invoice</th>
						 <th colspan='2'>Difference</th>
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
				 <td colspan='9' style='visibility:hidden;' ></td>
				 <td colspan='2' style='font-weight: bold;'>Total Impact</td>
				 <td>&pound;985.40</td>
			 </tr>
	 </tbody>

 </table>

<h4 class='no-bottom-margin'>Non-quoted items</h4>
 <!-- canvas 2 !-->
 <table class='table table-bordered table-striped style='border: 1px solid #dddddd;padding: 8px;line-height: 1.42857143;vertical-align: top;''>
					 <colgroup>
					 <col class='col-xs-1'>
					 <col class='col-xs-10'>
					 </colgroup>
					 <thead>
					 <tr>
							 <th>Line#</th>
							 <th>Item code/</th>
						 <th colspan='4'>Invoice</th>

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
				 <td>NLS4428EN NEWLEC 8X2' SCREW POZI RND HEAD TWIN THREAD ZINC P</td>
				 <td>80</td> <!--Qty!-->
				 <td>&pound;17.83</td> <!-- unit cost !-->
				 <td>60</td> <!--Discount !-->
				 <td>&pound;1426.40</td> <!--Cost !-->

			 </tr>

			 <tr>
				 <td colspan='3' style='visibility:hidden;' ></td>
				 <td colspan='2' style='font-weight: bold;'>Total Impact</td>
				 <td>&pound;2938.40</td>
			 </tr>

	 </tbody>
 </table>

<h4 class='no-bottom-margin'>Non-invoiced items</h4>
 <!-- canvas 3 -->
	 <table class='table table-bordered table-striped style='border: 1px solid #dddddd;padding: 8px;line-height: 1.42857143;vertical-align: top;''>
 <colgroup>
 <col class='col-xs-1'>
 <col class='col-xs-10'>
 </colgroup>
 <thead>
 <tr>
	 <th>Line#</th>
	 <th>Item code/</th>
	 <th colspan='4'>Quote</th>

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
	 <td>&pound;20.10</td> <!-- unit cost !-->
	 <td>30</td> <!--Discount !-->
	 <td>&pound;703.50</td> <!--Cost !-->

	 </tr>
	 <tr>
	 <td>50</td>
	 <td>20MM CONDUIT GALV HGSW 3.75M CLASS4</td>
	 <td>200</td> <!--Qty!-->
	 <td>&pound;30.20</td> <!-- unit cost !-->
	 <td>60</td> <!--Discount !-->
	 <td>&pound;2416.00</td> <!--Cost !-->

	 </tr>
	 <tr>
	 <td colspan='3' style='visibility:hidden;'' ></td>
	 <td colspan='2' style='font-weight: bold;''>Total Impact</td>
	 <td>&pound;3119.50</td>
	 </tr>
 </tbody>
</table>
\r\n";
return($message);
}



function getmsgforemail_nohtml($to_name){
$message_nohtml = "Dear Customer\r\n";
$message_nohtml .= "Regarding job reference " .$to_name.".\r\n";
$message_nohtml .= "We have compared your invoice and quote. Your results are down below.\r\n";
$message_nohtml .= "We hope the results are to your satisfaction\r\n";
$message_nohtml .= "All the best,\r\n";
$message_nohtml .= "The QuoteCheck Team\r\n";

$message_nohtml .= "
<meta charset='UTF-8'>
<link rel='stylesheet' href='http://www.quotecheck.tech/resources/canvas/HTML/css/bootstrap.css' type='text/css' />

<h3>Output Examples</h3>
<h4 class='no-bottom-margin'>Differences between quote and invoice</h4>
	<!--canvas!-->
	<table class='table table-bordered table-striped' style=border: 1px solid #dddddd; padding: 8px; line-height: 1.42857143; vertical-align: top;'>


						<colgroup>
						<col class='col-xs-1'>
						<col class='col-xs-10'>
						</colgroup>
						<thead>
						<tr>
								<th>Line#</th>
								<th>Item code/</th>
							<th colspan='4'>Quote</th>
							<th colspan='4'>Invoice</th>
							<th colspan='2'>Difference</th>
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
					<td colspan='9' style='visibility:hidden;' ></td>
					<td colspan='2' style='font-weight: bold;'>Total Impact</td>
					<td>&pound;985.40</td>
				</tr>
		</tbody>

	</table>

<h4 class='no-bottom-margin'>Non-quoted items</h4>
	<!-- canvas 2 !-->
	<table class='table table-bordered table-striped' style='border: 1px solid #dddddd;padding: 8px;line-height: 1.42857143;vertical-align: top;'>
						<colgroup>
						<col class='col-xs-1'>
						<col class='col-xs-10'>
						</colgroup>
						<thead>
						<tr>
								<th>Line#</th>
								<th>Item code/</th>
							<th colspan='4'>Invoice</th>

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
					<td>NLS4428EN NEWLEC 8X2' SCREW POZI RND HEAD TWIN THREAD ZINC P</td>
					<td>80</td> <!--Qty!-->
					<td>&pound;17.83</td> <!-- unit cost !-->
					<td>60</td> <!--Discount !-->
					<td>&pound;1426.40</td> <!--Cost !-->

				</tr>

				<tr>
					<td colspan='3' style='visibility:hidden;' ></td>
					<td colspan='2' style='font-weight: bold;'>Total Impact</td>
					<td>&pound;2938.40</td>
				</tr>

		</tbody>
	</table>

<h4 class='no-bottom-margin'>Non-invoiced items</h4>
	<!-- canvas 3 -->
	<table class='table table-bordered table-striped' style='border: 1px solid #dddddd;padding: 8px;line-height: 1.42857143;vertical-align: top;'>
	<colgroup>
	<col class='col-xs-1'>
	<col class='col-xs-10'>
	</colgroup>
	<thead>
	<tr>
		<th>Line#</th>
		<th>Item code/</th>
		<th colspan='4'>Quote</th>

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
		<td>&pound;20.10</td> <!-- unit cost !-->
		<td>30</td> <!--Discount !-->
		<td>&pound;703.50</td> <!--Cost !-->

		</tr>
		<tr>
		<td>50</td>
		<td>20MM CONDUIT GALV HGSW 3.75M CLASS4</td>
		<td>200</td> <!--Qty!-->
		<td>&pound;30.20</td> <!-- unit cost !-->
		<td>60</td> <!--Discount !-->
		<td>&pound;2416.00</td> <!--Cost !-->

		</tr>
		<tr>
		<td colspan='3' style='visibility:hidden;'' ></td>
		<td colspan='2' style='font-weight: bold;''>Total Impact</td>
		<td>&pound;3119.50</td>
		</tr>
	</tbody>
</table>
\r\n";
return($message_nohtml);
}
?>
