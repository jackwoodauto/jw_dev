<?php

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
				//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please try again or <a class='underline' href='/contact/'>contact us</a>.</div>";

        ob_start();
        ?>
        <div class="notification-box notification-box-error">
          <p><i class="icon-remove-sign"></i>There was a problem, please try again or <a class='underline' href='/contact/'>contact us</a>.</p>
          <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
        </div>
        <?php
        $json_arr['message'] = ob_get_contents();
        ob_clean();


				if($com0!="" && check_int($com1) && check_int($com2)){

					$pwd_hash = md5($com0.$com2);

					//$sql = "update qc_users set pwd = '$pwd_hash' where id = $com1 and verification_code = $com2";

					$sql = "update qc_users set pwd = ? where id = ? and verification_code = ?";
					$args = array("sii", $pwd_hash, $com1, $com2);
					$db = new database();


					if($db->query($sql,$args) > 0){

						// Success
						$ret = ss_login($com1, $com2);
						if($ret == 1){

							$json_arr['status']=1;

							notify("Quote Check Password Reset: $com1");

							$sql = "update qc_users set bad_attempts = 0 where id = ?";
							$args = array("i", $com1);
							$db = new database();
							$db->query($sql,$args);

							$_SESSION['alert']['message'] = "You've successfully changed your password, welcome back!";

							$json_arr['landing_page'] = "/";

						}


					}else{

						$json_arr['status']=-1;
						//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username did not match this account.</div>";

            ob_start();
            ?>
            <div class="notification-box notification-box-error">
              <p><i class="icon-remove-sign"></i>That username did not match this account.</p>
              <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
            </div>
            <?php
            $json_arr['message'] = ob_get_contents();
            ob_clean();

					}

					$db = null;

				}

				$json = json_encode($json_arr);
				die($json);

			break;

			case "pwd_reset_req":

				$json_arr['status']=0;
				//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please <a class='underline' href='/contact/'>contact us</a></div>";

        ob_start();
        ?>
        <div class="notification-box notification-box-error">
          <p><i class="icon-remove-sign"></i>There was a problem, please <a class='underline' href='/contact/'>contact us</a></p>
          <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
        </div>
        <?php
        $json_arr['message'] = ob_get_contents();
        ob_clean();

				//$email_for_db = mysql_escape_string($_GET['username']);
				$email_for_db = $_GET['username'];
				$email = $_GET['username'];

				if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){



					//$sql = "select * from qc_users where email = '$email_for_db' or username = '$email_for_db'";
					//$json_arr['message'] = $sql;

					$sql = "select * from qc_users where email = ? or username = ?";
					$args = array("ss", $email_for_db, $email_for_db);
					$db = new database();
					$db->query($sql,$args);

					$result = $db->all();

					if(count($result)>0){

						$row = $result[0];

						$user_id = $row['id'];
						$use_username = $row['username'];
						if($email_username!=""){

							$use_username = "Viber";

						}

						$story_id = $_GET['story_id'];
						$story_params = "";
						if($story_id>0){

							$story_params = "&story_id=" . $story_id;

						}

						if($row['pwd']==""){

							// User not setup yet

							$json_arr = send_user_welcome($user_id, $email, $row['verification_code'], $story_params,true);


						}else{

							$verification_code = rand(111111,999999);
							$sql = "update qc_users set verification_code = ? where id = ?";
							$args = array("ii", $verification_code, $user_id);
							$db = new database();
							//$db->query($sql,$args);

							//$updated_rows = $db->query($sql,$args);


							//$sql = "update qc_users set verification_code = $verification_code where id = $user_id";
							//mysql_query($sql);

							if($db->query($sql,$args) > 0){

								$from_email = "hello@quotecheck.tech";
								$from_name = "Quote Check";
								$to_email = $email;
								$to_name = $use_username;


								$subject = "Password request for Quote Check";

								$attach = "";

								$message = "Dear $to_name<br><br>";
								$message .= "If you asked us to reset you password then please click the following link:<br><br>";

								$message .= "<a href='https://www.quotecheck.tech/login/?type=pwd_reset_form&com1=" . $user_id . "&com2=" . $verification_code . $story_params ."'>Click here to reset your password.</a><br><br>";

								$message .= "If you did not ask us to reset your password please <a href='https://www.quotecheck.tech/contact'>contact us here</a>.<br><br>";

								$message .= "All the best,<br>";
								$message .= "The Quote Check Team<br><br>";
								//$message .= "<a href='https://www.storysnippets.com/subscription/?com1=" . $user_id . "&com2=" . $verification_code ."'>Unsubscribe</a>";

								sendemail_v2($from_email,$from_name,$to_email,$to_name,$subject,"",$message,"");
								//sendemail($from,$to,$reply,$subject,$message,$message,$attach);

								$json_arr['status']=1;
								//$json_arr['message'] = "<div class='alert alert-success'><i class='icon-gift'></i><strong>That worked</strong>, please now check your email.</div>";

                ob_start();
                ?>
                <div class="notification-box notification-box-success">
  								<p><i class="icon-ok"></i>That worked, please now check your email.</p>
  								<a href="#" class="notification-close notification-close-success"><i class="icon-remove"></i></a>
  							</div>
                <?php
                $json_arr['message'] = ob_get_contents();
                ob_clean();

							}
						}


					}else{

						// Email already registered
						$json_arr['status']=-1;
						//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>It looks like that email is not registered. Did you mean to click 'Register'?</div>";

            ob_start();
            ?>
            <div class="notification-box notification-box-error">
              <p><i class="icon-remove-sign"></i>It looks like that email is not registered. Did you mean to click 'Register'?</p>
              <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
            </div>
            <?php
            $json_arr['message'] = ob_get_contents();
            ob_clean();


					}



				}

				$db = null;

				$json = json_encode($json_arr);
				die($json);


				break;


			case "register":

				$json_arr['status']=0;
				//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Please enter a valid email address.</div>";

        ob_start();
        ?>
        <div class="notification-box notification-box-error">
          <p><i class="icon-remove-sign"></i>Please enter a valid email address.</p>
          <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
        </div>
        <?php
        $json_arr['message'] = ob_get_contents();
        ob_clean();

				//$email_for_db = mysql_escape_string($_GET['email']);
				$email_for_db = $_GET['email'];
				$email = $_GET['email'];

				if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false){

					$sql = "select * from qc_users where email = ?";
					$args = array("s", $email_for_db);
					$db = new database();
					$db->query($sql,$args);

					//$sql = "select * from qc_users where email = '$email_for_db'";
					$result = $db->all();
					$db = null;

					if(count($result)>0){

						// Email already registered
						$json_arr['status']=-1;
						//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>It looks like that email is already registered. Did you mean to click 'login'?</div>";

            ob_start();
            ?>
            <div class="notification-box notification-box-error">
              <p><i class="icon-remove-sign"></i>It looks like that email is already registered. Did you mean to click 'login'?</p>
              <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
            </div>
            <?php
            $json_arr['message'] = ob_get_contents();
            ob_clean();


					}else{

						$story_id = $_GET['story_id'];
						$story_params = "";
						if($story_id>0){

							$story_params = "&story_id=" . $story_id;

						}

						$verification_code = rand(111111,999999);
						$sql = "insert into qc_users (email, verification_code) values (?, ?)";
						$args = array("si", $email, $verification_code);
						$db = new database();
						$db->query($sql,$args);
						$user_id = $db->get_insert_id();
						$db = null;
						//$sql = "insert into qc_users (email, verification_code) values ('$email', $verification_code)";
						//mysql_query($sql);


						//$user_id = mysql_insert_id();
						if($user_id > 0){

							$json_arr = send_user_welcome($user_id, $email, $verification_code, $story_params,true);

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
				//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>There was a problem</strong>, please try again or <a class='underline' href='/contact/'>contact us</a>.</div>";

        ob_start();
        ?>
        <div class="notification-box notification-box-error">
          <p><i class="icon-remove-sign"></i>There was a problem, please try again or <a class='underline' href='/contact/'>contact us</a>.</p>
          <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
        </div>
        <?php
        $json_arr['message'] = ob_get_contents();
        ob_clean();

				if($com0!="" && check_int($com1) && check_int($com2)){


					if($username==""){

						$json_arr['status']=-1;

	          ob_start();
	          ?>
	          <div class="notification-box notification-box-error">
	            <p><i class="icon-remove-sign"></i>Please enter a username.</p>
	            <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
	          </div>
	          <?php
	          $json_arr['message'] = ob_get_contents();
	          ob_clean();

					}elseif(strpos($username,"@")!==false){

						$json_arr['status']=-1;
						//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Your username cannot be your email address or contain an '@' symbol.</div>";


            ob_start();
            ?>
            <div class="notification-box notification-box-error">
              <p><i class="icon-remove-sign"></i>Your username cannot be your email address or contain an '@' symbol.</p>
              <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
            </div>
            <?php
            $json_arr['message'] = ob_get_contents();
            ob_clean();


					}else{



						$pwd_hash = md5($com0.$com2);

						//$sql = "update qc_users set status = 1, username = '$username', pwd = '$pwd_hash' where id = $com1 and verification_code = $com2 and username is null and pwd is null";
						$sql = "update qc_users set username = ?, pwd = ? where id = ? and verification_code = ? and username is null and pwd is null";
						$args = array("ssii", $username, $pwd_hash, $com1, $com2);
						$db = new database();
						$result = $db->query($sql,$args);

						if($result>0){

							// Success
							$ret = ss_login($com1, $com2);
							if($ret == 1){
								// Success

								$json_arr['status']=1;

								$_SESSION['alert']['message'] = ""; //You're account has been approved, welcome aboard! By the way, we use cookies to make your life easier.";

								$json_arr['landing_page'] = "/";

							}


						}else{

							//echo($sql);
							//print_r($args);
							$json_arr['status']=-1;
							//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username has already been taken, please try another.</div>";

              ob_start();
              ?>
              <div class="notification-box notification-box-error">
                <p><i class="icon-remove-sign"></i>That username has already been taken, please try another.</p>
                <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
              </div>
              <?php
              $json_arr['message'] = ob_get_contents();
              ob_clean();


							$sql = "select * from qc_users where id = ?";
							$args = array("i", $com1);


							$db = new database();
							$db->query($sql,$args);
							$user_rows = $db->all();



							if(count($user_rows)>0){

								$user_arr = $user_rows[0];

								if($user_arr['pwd'] != "" && $user_arr['username']!=""){


									// This shouldn't occur as now redirected at /login/?type=complete from email link (don't confuse this with ajax complete)

									$json_arr['status']=-1;
									//$json_arr['message'] = "<div class='alert alert-warning'><i class='icon-remove-sign'></i>It looks like your account has already been setup, try to <a href='/login/'>log on here.</a></div>";

                  ob_start();
                  ?>
                  <div class="notification-box notification-box-error">
                    <p><i class="icon-remove-sign"></i>It looks like your account has already been setup, try to login instead.</a></p>
                    <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
                  </div>
                  <?php
                  $json_arr['message'] = ob_get_contents();
                  ob_clean();


								}else{

									//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>That username has already been taken, please try another</div>";

                  ob_start();
                  ?>
                  <div class="notification-box notification-box-error">
                    <p><i class="icon-remove-sign"></i>That username has already been taken, please try another</p>
                    <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
                  </div>
                  <?php
                  $json_arr['message'] = ob_get_contents();
                  ob_clean();

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

				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$ip = $_SERVER['REMOTE_ADDR'];
				}

				//$username = trim(mysql_real_escape_string($_GET['username']));
				$username = trim($_GET['username']);
				$com0 = $_GET['com0'];

				$story_id = $_GET['story_id'];

				$json_arr['status']=0;
				//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>Your password or username is incorrect. Have you registered?</div>";

        ob_start();
        ?>
        <div class="notification-box notification-box-error">
          <p><i class="icon-remove-sign"></i>Your password or username is incorrect. Have you registered?</p>
          <a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
        </div>
        <?php
        $json_arr['message'] = ob_get_contents();
        ob_clean();

				if($username != "" && $com0 != ""){

					//$sql = "select * from qc_users where status != -1 and (email = '$username' or username = '$username')";

					$sql = "select * from qc_users where status != -1 and (email = ? or username = ?)";
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

								$sql = "update qc_users set bad_attempts = 0, user_ip = ? where id = ?";
								$args = array("si", $ip, $user_id);

								$db = new database();
								$db->query($sql,$args);

								$db = null;
								//$sql = "update qc_users set bad_attempts = 0 where id = $user_id";
								//mysql_query($sql);

								$json_arr['status']=1;

								$_SESSION['alert']['message'] = ""; //Welcome back $show_username.";

								//$comment_landing = insert_comment_from_session($user_id,$user_status);

								if($comment_landing!=""){

									$json_arr['landing_page'] = $comment_landing;

								}else{

									$json_arr['landing_page'] = "/";

								}


							}

						}else{
							//$json_arr['status']=-1;
							//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i><strong>Wrong password</strong><br><br><span class='underline ss_cursor_pointer' onClick='pwd_request();'>Click here to reset your password.</a></div>";

              ob_start();
              ?>
              <div class="notification-box notification-box-error">
  							<p><i class="icon-remove-sign"></i>Wrong password<br><br><span class='underline ss_cursor_pointer' onClick='pwd_request();'>Click here to reset your password</span></p>
  							<a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
  						</div>
              <?php
              $json_arr['message'] = ob_get_contents();
              ob_clean();

							$sql = "update qc_users set bad_attempts = bad_attempts + 1 where (email = ? or username = ?)";
							$args = array("ss", $username, $username);

							$db = new database();
							$db->query($sql,$args);

							$db = null;

							//$sql = "update qc_users set bad_attempts = bad_attempts + 1 where (email = '$username' or username = '$username')";
							//mysql_query($sql);

						}

					}else{

						$json_arr['status']=0;

            ob_start();
            ?>
            <div class="notification-box notification-box-error">
							<p><i class="icon-remove-sign"></i>We could not find your account, did you mean to click <b class='ss_cursor_pointer' onClick='register();'><u>register?</u></b></p>
							<a href="#" class="notification-close notification-close-error"><i class="icon-remove"></i></a>
						</div>
            <?php
            $json_arr['message'] = ob_get_contents();
            ob_clean();


						//$json_arr['message'] = "<div class='alert alert-danger'><i class='icon-remove-sign'></i>We could not find your account, did you mean to click <b class='ss_cursor_pointer' onClick='register();'><u>register?</u></b></div>";


					}



				}

				$json = json_encode($json_arr);
				die($json);



			break;

		}
	die();
}

?>
