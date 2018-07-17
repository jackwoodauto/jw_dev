<?php

function send_user_welcome($user_id, $email, $verification_code, $story_params, $email_verification_required=true){

	$from_email = "hello@dogfocus.co.uk";
	$from_name = "Hello DogFocus";
	$to_email = $email;
	$to_name = "Canine Enthusiast";

	$subject = "Welcome to DogFocus";

	$attach = "";

	$message = "Dear $to_name,<br><br>";
	$message .= "Welcome to DogFocus.<br><br>";
	$message .= "To complete your registration, please click the following link:<br><br>";
	$message .= "<a href='https://www.dogfocus.co.uk/login/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params ."'>Click here to complete your registration</a>.<br><br>";
	$message .= "All the best,<br>";
	$message .= "The DogFocus Team<br><br>";

	$message_nohtml = "Dear $to_name\r\n";
	$message_nohtml .= "Welcome to DogFocus.\r\n";
	$message_nohtml .= "To complete your registration, please click the following link:\r\n";
	$message_nohtml .= "https://www.dogfocus.co.uk/login/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params ." \r\n";
	$message_nohtml .= "All the best,\r\n";
	$message_nohtml .= "The DogFocus Team\r\n";

	//$message .= "<a href='https://www.storysnippets.com/subscription/?com1=" . $user_id . "&com2=" . $verification_code ."'>Unsubscribe</a>";

	sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,$message_nohtml,$message,"");


	$ret_arr['status']=1;

	$comment_landing = insert_comment_from_session($user_id,0);

	/*ob_start();
	?>
	<div class='alert alert-success'><i class='icon-thumbs-up'></i><strong>That worked</strong>, please now check your email (including spam).</div>
	<!-- Google Code for Licensor Site Signup Conversion Page -->

	<?php
	$ret_arr['message'] = ob_get_contents();
	ob_end_clean();
	*/
	if($email_verification_required){

		$ret_arr['message'] = "<div class='alert alert-success'><i class='icon-thumbs-up'></i><strong>That worked</strong>, please now check your email (including spam).</div>";

	}else{

		$ret_arr['message'] = "";
		$ret_arr['landing_page'] = "/login/?type=complete&com1=" . $user_id . "&com2=" . $verification_code . $story_params;

	}


	return $ret_arr;
}


if($_GET['aj']!=""){

	$switch_on = strtolower($_GET['aj']);

		switch($switch_on){

			case 'pwd_reset_verify':


				//$username = trim(mysql_real_escape_string($_GET['username']));
				$com0 = $_GET['com0'];
				$com1 = $_GET['com1'];
				$com2 = $_GET['com2'];

				$json_arr['status']=0;
				//$json_arr['message'] = "<span class='ss_bad_text'>There was a problem, please try again or <a class='underline' href='/contact/'>contact us</a></span>";
				//$json_arr['message'] = "<div class='alert alert-success'><i class='icon-gift'></i><strong>Well done!</strong> You successfully read this important alert message.</div>";
				$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please try again or <a class='underline' href='/contact/'>contact us</a>.</div>";

				if($com0!="" && check_int($com1) && check_int($com2)){

					$pwd_hash = md5($com0.$com2);

					//$sql = "update df_users set pwd = '$pwd_hash' where id = $com1 and verification_code = $com2";

					$sql = "update df_users set pwd = ? where id = ? and verification_code = ?";
					$args = array("sii", $pwd_hash, $com1, $com2);
					$db = new database();


					if($db->query($sql,$args) > 0){

						// Success
						$ret = ss_login($com1, $com2);
						if($ret == 1){

							$json_arr['status']=1;

							notify("DogFocus Password Reset: $com1");

							//$sql = "update df_users set bad_attempts = 0 where id = $com1";
							//mysql_query($sql);

							$sql = "update df_users set bad_attempts = 0 where id = ?";
							$args = array("i", $com1);
							$db = new database();
							$db->query($sql,$args);



							$_SESSION['alert']['message'] = "You've successfully changed your password, welcome back!";

							$json_arr['landing_page'] = "/daily-feed/";



						}


					}else{

						$json_arr['status']=-1;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username did not match this account.</div>";

					}

					$db = null;

				}

				$json = json_encode($json_arr);
				die($json);

			break;

			case "pwd_reset_req":

				$json_arr['status']=0;
				$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please <a class='underline' href='/contact/'>contact us</a></div>";

				//$email_for_db = mysql_escape_string($_GET['username']);
				$email_for_db = $_GET['username'];
				$email = $_GET['username'];

				if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){



					//$sql = "select * from df_users where email = '$email_for_db' or username = '$email_for_db'";
					//$json_arr['message'] = $sql;

					$sql = "select * from df_users where email = ? or username = ?";
					$args = array("ss", $email_for_db, $email_for_db);
					$db = new database();
					$db->query($sql,$args);

					$result = $db->all();

					if(count($result)>0){

						$row = $result[0];

						$user_id = $row['id'];
						$use_username = $row['username'];
						if($email_username!=""){

							$use_username = "Canine Enthusiast";

						}

						$story_id = $_GET['story_id'];
						$story_params = "";
						if($story_id>0){

							$story_params = "&story_id=" . $story_id;

						}

						if($row['pwd']==""){

							// User not setup yet

							$json_arr = send_user_welcome($user_id, $email, $row['verification_code'], $story_params);


						}else{

							$verification_code = rand(111111,999999);
							$sql = "update df_users set verification_code = ? where id = ?";
							$args = array("ii", $verification_code, $user_id);
							$db = new database();
							//$db->query($sql,$args);

							//$updated_rows = $db->query($sql,$args);


							//$sql = "update df_users set verification_code = $verification_code where id = $user_id";
							//mysql_query($sql);

							if($db->query($sql,$args) > 0){

								$from_email = "hello@dogfocus.co.uk";
								$from_name = "Hello DogFocus";
								$to_email = $email;
								$to_name = $use_username;


								$subject = "Password request for DogFocus";

								$attach = "";

								$message = "Dear $to_name<br><br>";
								$message .= "If you asked us to reset you password then please click the following link:<br><br>";

								$message .= "<a href='https://www.dogfocus.co.uk/login/?type=pwd_reset_form&com1=" . $user_id . "&com2=" . $verification_code . $story_params ."'>Click here to reset your password.</a><br><br>";

								$message .= "If you did not ask us to reset your password please <a href='https://www.dogfocus.co.uk/contact'>contact us here</a>.<br><br>";

								$message .= "All the best,<br>";
								$message .= "The DogFocus Team<br><br>";
								//$message .= "<a href='https://www.storysnippets.com/subscription/?com1=" . $user_id . "&com2=" . $verification_code ."'>Unsubscribe</a>";

								sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,"",$message,"");
								//sendemail($from,$to,$reply,$subject,$message,$message,$attach);

								$json_arr['status']=1;
								$json_arr['message'] = "<div class='alert alert-success'><i class='icon-gift'></i><strong>That worked</strong>, please now check your email.</div>";

							}
						}


					}else{

						// Email already registered
						$json_arr['status']=-1;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>It looks like that email is not registered. Did you mean to click 'Register'?</div>";



					}



				}

				$db = null;

				$json = json_encode($json_arr);
				die($json);


				break;


			case "register":

				$json_arr['status']=0;
				$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Please enter a valid email address.</div>";

				//$email_for_db = mysql_escape_string($_GET['email']);
				$email_for_db = $_GET['email'];
				$email = $_GET['email'];

				if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){

					$sql = "select * from df_users where email = ?";
					$args = array("s", $email_for_db);
					$db = new database();
					$db->query($sql,$args);

					//$sql = "select * from df_users where email = '$email_for_db'";
					$result = $db->all();
					$db = null;

					if(count($result)>0){

						// Email already registered
						$json_arr['status']=-1;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>It looks like that email is already registered. Did you mean to click 'login'?</div>";

					}else{

						$story_id = $_GET['story_id'];
						$story_params = "";
						if($story_id>0){

							$story_params = "&story_id=" . $story_id;

						}

						$verification_code = rand(111111,999999);
						$sql = "insert into df_users (email, verification_code) values (?, ?)";
						$args = array("si", $email, $verification_code);
						$db = new database();
						$db->query($sql,$args);
						$user_id = $db->get_insert_id();
						$db = null;
						//$sql = "insert into df_users (email, verification_code) values ('$email', $verification_code)";
						//mysql_query($sql);


						//$user_id = mysql_insert_id();
						if($user_id > 0){

							$json_arr = send_user_welcome($user_id, $email, $verification_code, $story_params,false);

						}
					}

				}

				$json = json_encode($json_arr);
				die($json);


			break;

			case 'complete':

				$username = strip_tags($_GET['username']);
				//$username = trim(mysql_real_escape_string($username));

				$com0 = $_GET['com0'];
				$com1 = $_GET['com1'];
				$com2 = $_GET['com2'];

				$json_arr['status']=0;
				$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please try again or <a class='underline' href='/contact/'>contact us</a>.</div>";

				if($com0!="" && check_int($com1) && check_int($com2)){


					if($username==""){

						$json_arr['status']=-1;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Please enter a username.</div>";

					}elseif(strpos($username,"@")!==false){

						$json_arr['status']=-1;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Your username cannot be your email address or contain an '@' symbol.</div>";

					}else{



						$pwd_hash = md5($com0.$com2);

						//$sql = "update df_users set status = 1, username = '$username', pwd = '$pwd_hash' where id = $com1 and verification_code = $com2 and username is null and pwd is null";
						$sql = "update df_users set username = ?, pwd = ? where id = ? and verification_code = ? and username is null and pwd is null";
						$args = array("ssii", $username, $pwd_hash, $com1, $com2);
						$db = new database();
						$result = $db->query($sql,$args);

						if($result>0){

						//mysql_query($sql);
						//if(mysql_affected_rows()>0){

							// Success
							$ret = ss_login($com1, $com2);
							if($ret == 1){

								$json_arr['status']=1;


								$_SESSION['alert']['message'] = ""; //You're account has been approved, welcome aboard! By the way, we use cookies to make your life easier.";

								$json_arr['landing_page'] = "/daily-feed/";

								// update all pending comments here
								$sql = "update df_content_comments set status = 1 where fk_user_id = ?";
								$args = array("i", $com1);
								$db = new database();
								$db->query($sql,$args);
								$db = null;


							}


						}else{

							//echo($sql);
							//print_r($args);
							$json_arr['status']=-1;
							$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username has already been taken, please try another.</div>";

							$sql = "select * from df_users where id = ?";
							$args = array("i", $com1);


							$db = new database();
							$db->query($sql,$args);
							$user_rows = $db->all();



							if(count($user_rows)>0){

								$user_arr = $user_rows[0];

								if($user_arr['pwd'] != "" && $user_arr['username']!=""){


									// This shouldn't occur as now redirected at /login/?type=complete from email link (don't confuse this with ajax complete)

									$json_arr['status']=-1;
									$json_arr['message'] = "<div class='alert alert-warning'><i class='icon-remove-sign'></i>It looks like your account has already been setup, try to <a href='/login/'>log on here.</a></div>";



								}else{

									$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username has already been taken, please try another</div>";
								}

							}

						}

					}

				}

				$db = null;

				$json = json_encode($json_arr);
				die($json);

			break;

			case 'login':



				//$username = trim(mysql_real_escape_string($_GET['username']));
				$username = trim($_GET['username']);
				$com0 = $_GET['com0'];

				$story_id = $_GET['story_id'];

				$json_arr['status']=0;
				$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Your password or username is incorrect. Have you registered?</div>";

				if($username != "" && $com0 != ""){

					//$sql = "select * from df_users where status != -1 and (email = '$username' or username = '$username')";

					$sql = "select * from df_users where status != -1 and (email = ? or username = ?)";
					$args = array("ss", $username, $username);
					$db = new database();
					$db->query($sql,$args);
					$result = $db->all();

					if(count($result)>0){
					//if($row = mysql_fetch_assoc($result)){
						$row = $result[0];

						$user_id = $row['id'];
						$user_status = $row['status'];
						$verification_code = $row['verification_code'];
						$pwd = $row['pwd'];
						$show_username = $row['username'];
						$bad_attempts = $row['bad_attempts'];

						$pwd_hash = md5($com0.$row['verification_code']);

						if($pwd==$pwd_hash && $bad_attempts < 20){

							// Success
							$ret = ss_login($user_id, $verification_code);
							if($ret == 1){

								$sql = "update df_users set bad_attempts = 0 where id = ?";
								$args = array("i", $user_id);

								$db = new database();
								$db->query($sql,$args);

								$db = null;
								//$sql = "update df_users set bad_attempts = 0 where id = $user_id";
								//mysql_query($sql);

								$json_arr['status']=1;

								$_SESSION['alert']['message'] = ""; //Welcome back $show_username.";

								$comment_landing = insert_comment_from_session($user_id,$user_status);

								if($comment_landing!=""){

									$json_arr['landing_page'] = $comment_landing;

								}else{

									$json_arr['landing_page'] = "/daily-feed/";

								}


							}

						}else{
							//$json_arr['status']=-1;
							$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>Wrong password</strong><br><br><span class='underline ss_cursor_pointer' onClick='pwd_request();'>Click here to reset your password.</a></div>";

							$sql = "update df_users set bad_attempts = bad_attempts + 1 where (email = ? or username = ?)";
							$args = array("ss", $username, $username);

							$db = new database();
							$db->query($sql,$args);

							$db = null;

							//$sql = "update df_users set bad_attempts = bad_attempts + 1 where (email = '$username' or username = '$username')";
							//mysql_query($sql);

						}

					}else{

						$json_arr['status']=0;
						$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>We could not find your account, did you mean to click <b class='ss_cursor_pointer' onClick='register();'><u>register?</u></b></div>";


					}



				}

				$json = json_encode($json_arr);
				die($json);



			break;

		}
	die();
}

// Defaults
$hide_class = 'ss_login_hidden';

$login_title = 'Login or Register';
$login_message = 'To login or register please provide the information below. We will not share your personal data.';
$hidden_class_arr['email'] = '';
$hidden_class_arr['username'] = $hide_class;
$hidden_class_arr['pwd'] = $hide_class;
$hidden_class_arr['pwd_verify'] = $hide_class;
$hidden_class_arr['btn_register'] = '';
$hidden_class_arr['btn_login'] = '';
$hidden_class_arr['btn_complete_reg'] = $hide_class;
$hidden_class_arr['btn_pwd_reset'] = $hide_class;
$username_autocomplete_off = "";
$login_type = $_GET['type'];
switch ($login_type){


	case 'complete':

		$login_title = 'Last step...';
		$login_message = 'To complete your registration, please provide the following details.';

		$hidden_class_arr['email'] = $hide_class;
		$hidden_class_arr['username'] = '';
		$hidden_class_arr['pwd'] = '';
		$hidden_class_arr['pwd_verify'] = '';
		$hidden_class_arr['btn_register'] = $hide_class;
		$hidden_class_arr['btn_login'] = $hide_class;
		$hidden_class_arr['btn_complete_reg'] = '';
		$username_autocomplete_off = "autocomplete='off'";

		//$sql = "update df_users set status = 1, username = '$username', pwd = '$pwd_hash' where id = $com1 and verification_code = $com2 and username is null and pwd is null";
		$sql = "update df_users set status = 1 where id = ? and verification_code = ?";
		$args = array("ii", $_GET['com1'],$_GET['com2']);
		$db = new database();
		$db->query($sql,$args);
		$db = null;


		$sql = "select * from df_users where id = ?";
		$args = array("i", $_GET['com1']);
		$db = new database();
		$db->query($sql,$args);
		$result = $db->all();
		if(count($result)>0){

			if($result[0]['pwd']!="" && $result[0]['username']!=""){

				// Redirect to logon
				header("Location: https://www.dogfocus.co.uk/login/");
				die();


			}

		}





	break;

	case 'pwd_reset_form':

		$login_title = 'Last step...';
		$login_message = 'To reset your password, please provide the following details.';

		$hidden_class_arr['email'] = $hide_class;
		$hidden_class_arr['username'] = $hide_class;
		$hidden_class_arr['pwd'] = '';
		$hidden_class_arr['pwd_verify'] = '';
		$hidden_class_arr['btn_register'] = $hide_class;
		$hidden_class_arr['btn_login'] = $hide_class;
		$hidden_class_arr['btn_complete_reg'] = $hide_class;
		$hidden_class_arr['btn_pwd_reset'] = '';

	break;

	case 'rate':

		$login_message = 'To rate this story please either register or login. We will not share your personal data.';

		$hidden_class_arr['email'] = '';
		$hidden_class_arr['username'] = $hide_class;
		$hidden_class_arr['pwd'] = $hide_class;
		$hidden_class_arr['pwd_verify'] = $hide_class;
		$hidden_class_arr['btn_register'] = '';
		$hidden_class_arr['btn_login'] = '';
		$hidden_class_arr['btn_complete_reg'] = $hide_class;

	break;


}


$story_id = 0;
if($_GET['story_id']>0){
	$story_id = $_GET['story_id'];
}


include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_header_v1.0.php");


?>



		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap nopadding">

				<div class="section nopadding nomargin" style="width: 100%; height: 100%; position: absolute; left: 0; top: 0; background: url('/resources/canvas/HTML/images/slider/swiper/1_goldie_dark.jpg') center center no-repeat; background-size: cover;"></div>

				<div class="section nobg full-screen nopadding nomargin">
					<div class="container vertical-middle divcenter clearfix">


						<?php get_page_alert();	?>


						<div class="row center">
							<a href="/"><img src="/resources/canvas/HTML/images/logo-dark.png" alt="Dog Focus Logo"></a>
						</div>

						<div class="panel panel-default divcenter noradius noborder" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
							<div class="panel-body" style="padding: 40px;">
								<form id="login-form" name="login-form" class="nobottommargin ss_login_form">

									<input id="story_id" type="hidden" value='<?php echo($story_id); ?>'/>
									<input id="com1" type="hidden" value='<?php echo($_GET['com1']); ?>'/>
									<input id="com2" type="hidden" value='<?php echo($_GET['com2']); ?>'/>

									<h3 class='center'><?php echo($login_title); ?></h3>

									<div class='col_full ss_message_hold center'>
									<p id="ss_login_message">
										<?php echo($login_message); ?>
									</p>
									</div>

									<div class="col_full input_hold <?php echo($hidden_class_arr['username']); ?>">
										<label for="username">Username:</label>
										<input <?php echo($username_autocomplete_off); ?> type="text" id="username" name="login-form-username" value="" class="form-control not-dark" />
									</div>

									<div class="col_full input_hold <?php echo($hidden_class_arr['email']); ?> ">
										<label for="email">Email:</label>
										<input type="text" id="email" name="login-form-email" value="<?php echo($_POST['widget-subscribe-form-email']); ?>" class="form-control not-dark" />
									</div>

									<div class="col_full input_hold <?php echo($hidden_class_arr['pwd']); ?>">
										<label for="pwd">Password:</label>
										<input type="password" id="pwd" value="" class="form-control not-dark" />
									</div>

									<div class="col_full input_hold <?php echo($hidden_class_arr['pwd_verify']); ?>">
										<label for="pwd_verify">Verify Password:</label>
										<input type="password" id="pwd_verify" value="" class="form-control not-dark" />
									</div>

									<div class="col_full nobottommargin">
										<div onClick="register();" class='btn <?php echo($hidden_class_arr['btn_register']); ?>'>Register</div>
										<div onClick="login();" class='btn btn-action <?php echo($hidden_class_arr['btn_login']); ?>'>Login</div>
										<div id="complete_reg" onClick="complete_reg();" class='btn btn-action <?php echo($hidden_class_arr['btn_complete_reg']); ?>'>Complete Registration</div>
										<div id="reset_password" onClick="pwd_reset_verify();" class='btn btn-action <?php echo($hidden_class_arr['btn_pwd_reset']); ?>'>Reset Password</div>

									</div>
								</form>


							</div>
						</div>

						<div class="row center dark"><small>Copyrights &copy; All Rights Reserved by DogFocus.co.uk</small></div>

					</div>
				</div>

			</div>

		</section> <!--  #content end -->

	<!-- </div>#wrapper end -->



<?php

	include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/section_footer_v1.0.php");

?>
