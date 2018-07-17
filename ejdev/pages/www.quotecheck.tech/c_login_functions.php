
<?php

function ss_login($user_id, $verification_code){

	$sql = "select * from qc_users where id = ? and verification_code = ? and status != ?";
	$args = array("iii", $user_id, $verification_code, -1);
	$db = new database();
	$db->query($sql,$args);
//echo "abc";
	$result = $db->all();

	if(count($result)>0){

		$row = $result[0];

		$_SESSION['user'] = $row;




		$sql = "select * from qc_users_attributes where fk_user_id = ?";
		$args = array("i",$user_id);
		$db = new database();
		if($db->query($sql,$args)){

			$results = $db->all();
			foreach ($results as $row_number => $row_data){

				$attribute_name = $row_data['attribute_name'];
				$attribute_value = $row_data['attribute_value'];
				$attribute_array[$attribute_name] = $attribute_value;

			}
		}
		$db = null;

		$_SESSION['user']['attribute'] = $attribute_array;


		//get_all_read(true);


		setcookie('com1x', $user_id, time()+60*60*24*60, '/', 'www.quotecheck.tech',false,true);
		setcookie('com2x', $verification_code, time()+60*60*24*60, '/', 'www.quotecheck.tech',false,true);
		$ret = 1;

	}else{

		ss_logout();
		$ret = 0;

	}

	return $ret;

}

function ss_logout(){

	// Remove cookies
	setcookie('com1x', 0, time() - 3600 * 24, '/', 'www.quotecheck.tech',false,true);
	setcookie('com2x', 0, time() - 3600 * 24, '/', 'www.quotecheck.tech',false,true);

	// Remove user session
	unset($_SESSION['user']);

}

function send_user_welcome($user_id, $email, $verification_code, $story_params, $email_verification_required=true){

	$from_email = "hello@quotecheck.tech";
	$from_name = "Quote Check";
	$to_email = $email;
	$to_name = "Customer";

	$subject = "Welcome to Quote Check";

	$attach = "";

	$message = "Dear $to_name,<br><br>";
	$message .= "Welcome to Quote Check.<br><br>";
	$message .= "To complete your registration, please click the following link:<br><br>";
	$message .= "<a href='https://www.quotecheck.tech/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params ."'>Click here to complete your registration</a>.<br><br>";
	$message .= "All the best,<br>";
	$message .= "The Quote Check Team<br><br>";

	$message_nohtml = "Dear $to_name\r\n";
	$message_nohtml .= "Welcome to Quote Check.\r\n";
	$message_nohtml .= "To complete your registration, please click the following link:\r\n";
	$message_nohtml .= "https://www.quotecheck.tech/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params ." \r\n";
	$message_nohtml .= "All the best,\r\n";
	$message_nohtml .= "The Quote Check Team\r\n";

	//$message .= "<a href='https://www.storysnippets.com/subscription/?com1=" . $user_id . "&com2=" . $verification_code ."'>Unsubscribe</a>";

	//die("$from_email,$from_name,$to_email,$to_name,$subject,$message_nohtml,$message");

	sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,$message_nohtml,$message,"");

	$ret_arr['status']=1;

	//$comment_landing = insert_comment_from_session($user_id,0);

	/*ob_start();
	?>
	<div class='alert alert-success'><i class='icon-thumbs-up'></i><strong>That worked</strong>, please now check your email (including spam).</div>
	<!-- Google Code for Licensor Site Signup Conversion Page -->

	<?php
	$ret_arr['message'] = ob_get_contents();
	ob_end_clean();
	*/
	if($email_verification_required){

		//$ret_arr['message'] = "<div class='alert alert-success'><i class='icon-thumbs-up'></i><strong>That worked</strong>, please now check your email (including spam).</div>";
		ob_start();
		?>
		<div class="notification-box notification-box-success">
			<p><i class="icon-ok"></i>That worked, please now check your email (including spam).</p>
			<a href="#" class="notification-close notification-close-success"><i class="icon-remove"></i></a>
		</div>
		<?php
		$ret_arr['message'] = ob_get_contents();

		ob_clean();
		$ret_arr['landing_page'] = "";


	}else{

		$ret_arr['message'] = "";
		$ret_arr['landing_page'] = "/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params;

	}


	return $ret_arr;
}
