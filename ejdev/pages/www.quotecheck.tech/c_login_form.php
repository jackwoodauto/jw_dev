<?php
if ($_SESSION['user']['id'] > 0){

//   Users logged in - dont show form

if($result[0]['pwd']!="" && $result[0]['username']!=""){

 //   Redirect to logon
  header("Location: https://www.quotecheck.tech");
 die();


}
 return;


}else{


// Defaults
$hide_class = 'ss_login_hidden';

$login_title = 'Login or Register';
//$login_message = "To login or register please provide the information below. We'll not share your personal data however you will be opting-in to occasional emails from Vibe.Army from which you can opt-out at any point. ";
$login_message = "To login or register please provide the information below. We will not share your personal data.";
$hidden_class_arr['email'] = '';
$hidden_class_arr['username'] = $hide_class;
$hidden_class_arr['pwd'] = $hide_class;
$hidden_class_arr['pwd_verify'] = $hide_class;
$hidden_class_arr['btn_register'] = '';
$hidden_class_arr['btn_login'] = '';
$hidden_class_arr['btn_complete_reg'] = $hide_class;
$hidden_class_arr['btn_pwd_reset'] = $hide_class;
$hidden_class_arr['link_pwd_reset'] = "";

$show_on_page_load = false;

$username_autocomplete_off = "";
$login_type = $_GET['type'];




switch ($login_type){


  case 'complete':

    $show_on_page_load = true;

    $login_title = 'Last step...';
    $login_message = 'To complete your registration, please provide the following details.';

    $hidden_class_arr['email'] = $hide_class;
    $hidden_class_arr['username'] = '';
    $hidden_class_arr['pwd'] = '';
    $hidden_class_arr['pwd_verify'] = '';
    $hidden_class_arr['btn_register'] = $hide_class;
    $hidden_class_arr['btn_login'] = $hide_class;
    $hidden_class_arr['btn_complete_reg'] = '';
    $hidden_class_arr['link_pwd_reset'] = $hide_class;
    $username_autocomplete_off = "autocomplete='off'";

    //$sql = "update df_users set status = 1, username = '$username', pwd = '$pwd_hash' where id = $com1 and verification_code = $com2 and username is null and pwd is null";
    $sql = "update qc_users set status = 1 where id = ? and verification_code = ?";
    $args = array("ii", $_GET['com1'],$_GET['com2']);
    $db = new database();
    $db->query($sql,$args);
    $db = null;


    $sql = "select * from qc_users where id = ?";
    $args = array("i", $_GET['com1']);
    $db = new database();
    $db->query($sql,$args);
    $result = $db->all();
    if(count($result)>0){

    //  if($result[0]['pwd']!="" && $result[0]['username']!=""){

      //   Redirect to logon
  //      header("Location: https://www.quotecheck.tech");
  //      die();


//      }

    }

    break;

  case 'pwd_reset_form':

    $show_on_page_load = true;

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
    $hidden_class_arr['link_pwd_reset'] = $hide_class;

  break;




}



?>

<?php if($show_on_page_load){


  ob_start();

  ?>

  <script>
    $(document).ready(function () {

        $('#modal_login').modal('show');

    });
  </script>

  <?php

  $additional_footer_code_array[] = ob_get_contents();
  ob_end_clean();


} ?>



<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <form id="login-form" class="nobottommargin ">
    <input type="hidden" id="formname" name="formname" value="login_form" />
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?php echo($login_title); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <input id="com1" type="hidden" value='<?php echo($_GET['com1']); ?>'/>
            <input id="com2" type="hidden" value='<?php echo($_GET['com2']); ?>'/>



            <div class='col_full ss_message_hold center'>
            <div id="ss_login_message">
              <?php echo($login_message); ?>
            </div>
            </div>

            <div class="col-sm-12 input_hold <?php echo($hidden_class_arr['username']); ?>">
              <p class="nobottommargin">Username:</p>
              <input <?php echo($username_autocomplete_off); ?> type="text" id="username" name="login-form-username" value="" class="form-control" />
            </div>

            <div class="col-sm-12 input_hold <?php echo($hidden_class_arr['email']); ?>">
              <p class="nobottommargin">Email:</p>
              <input type="text" id="email" name="login-form-email" value="<?php echo($default_email); ?>" class="form-control" />
            </div>

            <div class="col-sm-12 input_hold <?php echo($hidden_class_arr['pwd']); ?>">
              <p class="nobottommargin">Password:</p>
              <input placeholder="" type="password" id="pwd" value="" class="form-control" />
              <div class="<?php echo($hidden_class_arr['link_pwd_reset']); ?>" onClick="pwd_request();" style='font-size:12px;color:#777777;text-align:center;width:100%;margin-top:10px;cursor:pointer;'>Reset Password</div>
            </div>

            <div class="col-sm-12 input_hold <?php echo($hidden_class_arr['pwd_verify']); ?>">
              <label for="pwd_verify">Verify Password:</label>
              <input type="password" id="pwd_verify" value="" class="form-control" />
            </div>

            <div class='clear'></div>

            <p style='margin:0px;margin-top:10px;width:100%;text-align:center;'><a style='color:#7A7A7A;text-align:center;font-size:12px;margin-top:10px;margin-bottom:10px;' href="/privacy/">Privacy Policy</a></p>

        </div>
        <div class="modal-footer">
          <div onClick="register();" class='btn btn-secondary btn-login-fix <?php echo($hidden_class_arr['btn_register']); ?>'>Register</div>
          <div onClick="login();" class='btn btn-primary btn-login-fix <?php echo($hidden_class_arr['btn_login']); ?>'>Login </div>
          <div id="complete_reg" onClick="complete_reg();" class='btn btn-primary btn-login-fix <?php echo($hidden_class_arr['btn_complete_reg']); ?>'>Complete Registration</div>
          <div id="reset_password" onClick="pwd_reset_verify();" class='btn btn-primary <?php echo($hidden_class_arr['btn_pwd_reset']); ?>'>Reset Password</div>
        </div>
      </div>
    </div>
  </form>
</div>

<?php if($show_on_page_load){

  ob_start();

  ?>

  <script>
    $(document).ready(function () {

        $('#modal_login').modal('show');

    });
  </script>

  <?php

  $additional_footer_code_array[] = ob_get_contents();
  ob_end_clean();


} ?>



<?php } ?>
