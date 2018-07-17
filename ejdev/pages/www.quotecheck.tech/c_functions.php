<?php

function lookup_rosette($percentile){



	if($percentile <= 5){

		$rosette = 1;

	}elseif($percentile <= 10){

		$rosette = 2;

	}elseif($percentile <= 30){

		$rosette = 3;

	}elseif($percentile <= 70){

		$rosette = 4;

	}elseif($percentile <= 90){

		$rosette = 5;

	}else{

		$rosette = 6;

	}

	return $rosette;

}

function get_user_engagement_percentile($user_id){

	$sql = "select * from df_users where status = 1 and e_total > 5 order by e_total desc"; // only rank those worth ranking
	$db = new database();
	$db->query($sql);
	$result_users = $db->all();
	$total_users = count($result_users);
	foreach($result_users as $key => $value){

		$current_rank++;
		if($value['id']==$user_id){

			$user_found = true;
			break;

		}

	}

	$user_percentile = ($current_rank / $total_users) * 100;

	if(!$user_found){
		$user_percentile = 100;
	}

	return $user_percentile;

}

function update_engagements($user_id){

	$user_engagements['articles']['read'] = 0;
	$user_engagements['likes']['given'] = 0;
	$user_engagements['likes']['received'] = 0;
	$user_engagements['dislikes']['given'] = 0;
	$user_engagements['dislikes']['received'] = 0;


	if($user_id > 0){

		$sql = "SELECT count(*) as all_e, sum(liked) as likes, sum(disliked) as dislikes FROM df_feedback where fk_user_id = ?";
		$args = array("i",$user_id);
		$db = new database();
		$db->query($sql,$args);
		$result = $db->all();
		$db = null;
		if(count($result)>0){

			$user_engagements['articles']['read'] = $result[0]['all_e'];
			$user_engagements['likes']['given'] = $result[0]['likes'];
			//$user_engagements['likes']['received'] = $result[0]['all_e'];
			$user_engagements['dislikes']['given'] = $result[0]['dislikes'];
			//$user_engagements['dislikes']['received'] = $result[0]['all_e'];

		}

		$sql = "SELECT sum(liked) as likes, sum(disliked) as dislikes FROM df_feedback a join df_content b where a.fk_content_id = b.id and b.fk_user_id = ?";
		$args = array("i",$user_id);
		$db = new database();
		$db->query($sql,$args);
		$result = $db->all();
		$db = null;
		if(count($result)>0){

			$user_engagements['likes']['received'] = $result[0]['likes'];
			$user_engagements['dislikes']['received'] = $result[0]['dislikes'];

		}

		$sql = "SELECT sum(likes) as likes, sum(dislikes) as dislikes FROM df_content_comments where fk_user_id = ?";
		$args = array("i",$user_id);
		$db = new database();
		$db->query($sql,$args);
		$result = $db->all();
		$db = null;
		if(count($result)>0){

			$user_engagements['likes']['received'] += $result[0]['likes'];
			$user_engagements['dislikes']['received'] += $result[0]['dislikes'];

		}

		foreach($user_engagements as $sub_array_key => $sub_array){

			foreach($sub_array as $key => $value){

				$total_engagements += $value;

			}

		}


		$sql = "update df_users set e_articles_read = ?, e_likes_received = ?, e_likes_given = ?, e_dislikes_received = ?, e_dislikes_given = ?, e_total = ? where id = ?";
		$args = array("iiiiiii", $user_engagements['articles']['read'], $user_engagements['likes']['received'], $user_engagements['likes']['given'], $user_engagements['dislikes']['received'], $user_engagements['dislikes']['given'], $total_engagements, $user_id);
		$db = new database();
		$db->query($sql,$args);
		$db = null;

	}

}

function get_all_read($update_session=false){

	$read_articles = array();


	if($_SESSION['user']['id']>0 ){

		if(isset($_SESSION['all_users_read_articles']) && !$update_session){


			$read_articles = $_SESSION['all_users_read_articles'];


		}else{

			$user_id = $_SESSION['user']['id'];
			$sql = "select fk_content_id from df_feedback where content_type = ? and fk_user_id = ?";
			$args = array("si", "content", $user_id);
			$db = new database();
			$db->query($sql,$args);
			$rows = $db->all();
			foreach($rows as $key => $value){

				$read_content_id = $value['fk_content_id'];
				$read_articles[$read_content_id] = true;


			}
			$db = null;

			$_SESSION['all_users_read_articles'] =  $read_articles;

		}




	}

	return $read_articles;


}

function get_number_unread_articles(){

	$to_read = 0;

	if($_SESSION['user']['id']>0){

		$read_articles = get_all_read();

		$sql = "select id from df_content where status = 1 and insertiontime > ? and content_type != 'breed_note' and content_type != 'breed_critique' and content_type != 'photo_shop' ";
		$args = array("s", $_SESSION['user']['insertiontime']);
		$db = new database();
		$db->query($sql,$args);
		$rows = $db->all();
		foreach($rows as $key => $value){

			$content_id = $value['id'];
			if($read_articles[$content_id]!==true){

				$to_read ++;

			}


		}

		$db = null;


	}

	return $to_read;

}


function get_excluded_content_sql($content_id){

	// Get users read articles = just once and store in session, then add new reads to session (they are added to the DB automatically)
	if(!$_SESSION['user']['ex_retrieved_content_reads'] && $_SESSION['user']['id']>0){

		$user_id = $_SESSION['user']['id'];
		$sql = "select fk_content_id from df_feedback where content_type = ? and fk_user_id = ?";
		$args = array("si", "content", $user_id);
		$db = new database();
		$db->query($sql,$args);
		$rows = $db->all();
		foreach($rows as $key => $value){

			$read_content_id = $value['fk_content_id'];
			$_SESSION['df_articles_read'][$read_content_id] = $read_content_id;

		}
		$db = null;

	}

	$_SESSION['df_articles_read'][$content_id] = $content_id;

	$exclude_content_sql = "";
	$exclude_content_ids =  implode(",",$_SESSION['df_articles_read']);
	if($exclude_content_ids!=""){

		$exclude_content_sql = " and fk_content_id not in ($exclude_content_ids) ";

	}

	return $exclude_content_sql;

}

function get_insert_place($address_arr){

	$place_id = -1;

	foreach($address_arr as $key => $value){

		$address_arr[$key] = ucwords(trim($value));

	}

	// Allow lat, lng and postcode to be updated

	$sql = "select * from df_places where status = 1 and address_1 = ? and address_2 = ? and city = ? and county = ? and country = ?";
	$args = array("sssss", $address_arr['address_1'], $address_arr['address_2'], $address_arr['city'], $address_arr['county'], $address_arr['country']);
	$db = new database();
	$db->query($sql,$args);
	$place = $db->all();



	if(count($place)>0){



		$place_id = $place[0]["id"];



		if($address_arr['lat']!=""){

			$sql = "update df_places set lat = ?  where id = ?";
			$args = array("di", $address_arr['lat'],$place_id);
			$db = new database();
			$db->query($sql,$args);

		}

		if($address_arr['lng']!=""){

			$sql = "update df_places set lng = ? where id = ?";
			$args = array("di", $address_arr['lng'],$place_id);
			$db = new database();
			$db->query($sql,$args);

		}

		if($address_arr['postcode']!=""){

			$sql = "update df_places set postcode = ? where id = ?";
			$args = array("si", $address_arr['postcode'],$place_id);
			$db = new database();
			$db->query($sql,$args);

		}


	}else{



		$sql = "insert into df_places (status, address_1, address_2, city, county, country, lat, lng, postcode) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$args = array("isssssdds", 1, $address_arr['address_1'], $address_arr['address_2'], $address_arr['city'], $address_arr['county'], $address_arr['country'], $address_arr['lat'], $address_arr['lng'], $address_arr['postcode']);
		$db = new database();
		$db->query($sql,$args);


		$place_id = $db->get_insert_id();


	}


	return $place_id;
}



function html_reveal_edit_button($button_caption="<span class='icon-edit'></span> Edit"){
	?>
	<div onClick="reveal_edit();" class="df-hide-on-edit button button-border button-large button-rounded tright"><?php echo($button_caption); ?></div>
	<?php
}


function upload_file($arr,$files){

	$file_upload_max_mb = 3;
	$file_upload_max_bytes = $file_upload_max_mb * 1048576;

	$display_info = "";
	$display_info_class = "error_txt";
	$file_found = false;
	//$receipt_path = DOC_ROOT . $arr['path'];
	$valid_image_types = $arr['valid_image_types'];
	$total_file_count = 0;
	$good_file_count = 0;
	$bad_file_count = 0;
	$dest_file_extension = ".jpg";
	/*   Inputs
	=======================================


	$arr['dest_file_name_string'];
	$arr['create_thumb_nail'];
	$arr['dest_file_folder'];
	$arr['dest_max_width'];
	$arr['dest_max_height'];

	*/

	if($arr['dest_max_width']==""){

		$arr['dest_max_width'] = 1000;

	}
	if($arr['dest_max_height']==""){

		$arr['dest_max_height'] = 1000;

	}

	$dest_file_name_string_safe = str_replace(" ", "-", $arr['dest_file_name_string']);

	$dest_file_name_string_safe = strtolower(preg_replace("/[^a-z0-9.-]+/i", "", $dest_file_name_string_safe));


	$dest_image_path = DOC_ROOT . "/imgs" . $arr['dest_file_folder'];

	foreach($valid_image_types as $key => $value){
			$valid_image_string .= $value . " ";
		}

	$valid_image_string = substr($valid_image_string,0,-1);


//	if($_SESSION['user']['id'] > 0){

	 	$total_file_count = 0;


		foreach ($files["error"] as $key => $error)
		{


		   $tmp_name = $files["tmp_name"][$key];

		   if (!$tmp_name){

			  $return_arr[$total_file_count]['error']['message'] = "File not found.";
			  $return_arr[$total_file_count]['error']['type'] = "bad";

		   }else{
				$file_found = true;


				$dest_file_name_string = $dest_file_name_string_safe . "_" . get_unique_id();
				$dest_file_name = $dest_file_name_string . $dest_file_extension;
				$return_arr[$total_file_count]['main']['filename'] = $dest_file_name;
				if($arr['create_thumb_nail']){
					$dest_thumb_file_name = $dest_file_name_string . "_thumb$dest_file_extension";
					$return_arr[$total_file_count]['thumb']['filename'] = $dest_thumb_file_name;
				}

				$orig_name = basename($files["name"][$key]);

				if ($error == UPLOAD_ERR_OK){

					// Validate correct file type and size
					$file_type_constant = exif_imagetype($tmp_name);



					if(!$file_type_constant){
						$file_type_constant =pdf;
					}


					//if(!$file_type_constant){
						//$file_type_constant = -1;
					//}

					if (!array_key_exists($file_type_constant,$valid_image_types)) {


						$msg .= " File &quot;". $orig_name."&quot; is not a valid image file, valid formats are " . $valid_image_string;
						$msg_type = "error";

						echo $msg;
					}elseif($_FILES["size"][$key] > $file_upload_max_bytes){

						$msg .= "File &quot;". $orig_name."&quot; is too large. ";
						$msg_type = "error";
						echo $msg;
					}else{

						save_angle($tmp_name,$dest_image_path . $dest_file_name,$arr['dest_max_width'],$arr['dest_max_height'],0);
						if (file_exists ($dest_image_path . $dest_file_name)){

							$msg .= "Uploaded file &quot;".$orig_name."&quot; successfully$uploaded_for_message.";
							$msg_type = "good";
							$good_file_count ++;

						}

						if($dest_thumb_file_name!=""){
							//echo("Saving $dest_image_path$dest_thumb_file_name<br>");
							save_angle($tmp_name, $dest_image_path . $dest_thumb_file_name, 300, 300, 0);
							if (file_exists ($dest_image_path . $dest_file_name)){

								$msg .= "Uploaded file &quot;".$orig_name."&quot; successfully$uploaded_for_message.";
								$msg_type = "good";
								$good_file_count ++;

							}
						}



					}



				}else{
					$msg .= "Upload error [".$error."] on file &quot;".$orig_name."&quot; ";
					$msg_type = "bad";
				}



			   $return_arr[$total_file_count]['error']['message'] .= $msg;
			   $return_arr[$total_file_count]['error']['type'] .= $msg_type;

			   $total_file_count ++;

		   }
		}

//	}

	return $return_arr;


}

function get_or_insert_content_extra($master_content_id,$extra_content_type){

	$sql_select = "select * from df_content_extra where fk_content_id = ? and content_type = ?";
	$select_args = array("is",$master_content_id,$extra_content_type);
	$db = new database();
	$db->query($sql_select,$select_args);

	if(!$rows = $db->all()){
		$db = null;
		$sql_insert = "insert into df_content_extra (status, fk_content_id,content_type,fk_user_id) values (1, ?, ?, ?)";
		$insert_args = array("isi",$master_content_id,$extra_content_type,$_SESSION['user']['id']);
		$db = new database();
		$db->query($sql_insert,$insert_args);

		$db = new database();
		$db->query($sql_select,$select_args);
		$rows = $db->all();

	}

	$db = null;

	return $rows;

}

function html_to_db($string,$allow_h2=false,$allow_a=false){

	/*$string = str_replace("&","&amp;",$string);
	$string = str_replace("'","&apos",$string);
	$string = str_replace("-","&#45;",$string);
	$string = str_replace("<","&lt;",$string);
	$string = str_replace(">","&gt;",$string);*/
	$string = htmlentities($string,ENT_QUOTES);

	// Allow certain safe(ish) tags
	if($allow_h2){

		$string = str_replace(array("&lt;h2&gt;", "&lt;/h2&gt;"), array("<h2>", "</h2>"), $string);

	}
	if($allow_a){

		$string = str_replace(array("&lt;a&gt;", "&lt;/a&gt;"), array("<a>", "</a>"), $string);

	}
	/*if($allow_img){

		$string = str_replace(array("&lt;img&gt;", "&lt;/img&gt;"), array("<img>", "</img>"), $string);

	}
	if($allow_div){

		$string = str_replace(array("&lt;div&gt;", "&lt;/div&gt;"), array("<div>", "</div>"), $string);

	}*/


	// Allow block quotes
	$string = str_replace(array("&lt;blockquote&gt;", "&lt;/blockquote&gt;"), array("<blockquote>", "</blockquote>"), $string);




	$string = str_replace("\\\\", "\\", $string);
	$string = str_replace("\r\n", "<br/>", $string);

	$string = mysql_real_escape_string($string);

	$string = trim($string);

	return ($string);

}

function db_to_textarea($string){

	/*$string = str_replace("&","&amp;",$string);
	$string = str_replace("'","&quot;",$string);
	$string = str_replace("-","&#45;",$string);
	$string = str_replace("<","&lt;",$string);
	$string = str_replace(">","&gt;",$string);
	$string = htmlentities($string,ENT_QUOTES);*/
	$string = str_replace("<br/>", "\r\n", $string);
	$string = trim($string);
	//$string = mysql_real_escape_string($string);

	return ($string);

}


function save_angle($filename,$dest,$max_width,$max_height,$degrees){

	$ret = image_resize($filename,$max_width,$max_height);

	$width = $ret['width'];
	$width_orig = $ret['width_orig'];
	$height = $ret['height'];
	$height_orig = $ret['height_orig'];
	$type = $ret['type'];

	/// Rotation logic ////
		// open correct format
	switch ($type)
	{
	case IMAGETYPE_BMP: {
	$image = imagecreatefrombmp($filename);
	break;
	}
	case IMAGETYPE_GIF: {
	$image = imagecreatefromgif($filename);
	break;
	}
	case IMAGETYPE_JPEG: {
	$image = imagecreatefromjpeg($filename);
	break;
	}
	case IMAGETYPE_PNG: {
	$image = imagecreatefrompng($filename);
	break;
	}
	case IMAGETYPE_PDF: {
	$image = imagecreatefrompdf($filename);
	break;
	}
	default:

	//debug_session("function save_angle failed at imagecreatefrombmp with $type");
	die();
	break;
	}

	if (($degrees == 90) || ($degrees == 180) || ($degrees == 270)){


		// Memory errors can occur here that cause a white screen of death...we've asked our host provider to increase the allowance.
		$image = imagerotate($image,$degrees,0);// or debug_session("Jurassic park");




		// If angle is 90 or 270 then crop image after rotation
		if (($degrees == 90) || ($degrees == 270)){

			$temp = $width_orig;
			$width_orig = $height_orig;
			$height_orig = $temp;

			$width = $width_orig;
			$height = $height_orig;

			if ($width > $max_width){
				$width = $max_width;
			}
			if ($height > $max_height){
				$height = $max_height;
			}

			$ratio_orig = $width_orig/$height_orig;

			if ($width/$height > $ratio_orig) {
				$width = $height*$ratio_orig;
			} else {
				$height = $width/$ratio_orig;
			}

		}

	}
	/// End of rotation logic ///

	// Resample
	$image_x = imagecreatetruecolor($width, $height);

	// open correct format
	switch ($type)
	{
	case IMAGETYPE_BMP: {
	//$image = imagecreatefrombmp($filename);
	imagecopyresampled($image_x, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	//image2wbmp($image_x, $dest);
	break;
	}
	case IMAGETYPE_GIF: {
	//$image = imagecreatefromgif($filename);
	imagecopyresampled($image_x, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	//imagegif($image_x, $dest);
	break;
	}
	case IMAGETYPE_JPEG: {
	//$image = imagecreatefromjpeg($filename);
	imagecopyresampled($image_x, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	//imagejpeg($image_x, $dest);
	break;
	}
	case IMAGETYPE_PNG: {
	//$image = imagecreatefrompng($filename);
	imagecopyresampled($image_x, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	//imagepng($image_x, $dest,9);
	break;
  }
	case IMAGETYPE_PDF: {
	//$image = imagecreatefrompng($filename);
	imagecopyresampled($image_x, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	//imagepng($image_x, $dest,9);
	break;
	}
	default:
	//debug_session("function save_angle failed at imagecopyresampled with with $type");
	die();
	break;
	}

	imagejpeg($image_x, $dest, 95);

	imagedestroy($image);
	imagedestroy($image_x);
}

function image_resize($filename,$max_width,$max_height){
// Get dimensions


	list($width_orig, $height_orig, $type) = getimagesize($filename);

	// Set resize paramters if supplied

	$width = $width_orig;
	$height = $height_orig;

	if ($width > $max_width){
		$width = $max_width;
	}
	if ($height > $max_height){
		$height = $max_height;
	}

	$ratio_orig = $width_orig/$height_orig;

	if ($width/$height > $ratio_orig) {
		$width = $height*$ratio_orig;
	} else {
		$height = $width/$ratio_orig;
	}

	return array('width_orig'=>round($width_orig), 'width'=>round($width), 'height_orig'=>round($height_orig), 'height'=>round($height), 'type'=>round($type));

}


function get_unique_id(){

	$return = -1;
	$sql = "insert into qc_unique_id (insertiontime) values (now())";
	$db = new database();
	if($db->query($sql)){

		if($db->get_insert_id()>0){

			$return = $db->get_insert_id();
		}

	}
	$db = null;
	return $return;

}

function get_unique_job_id($invoice_id, $quote_id){

	$return['id'] = -1;
	$sql = "insert into qc_jobs (insertiontime, quote_file, invoice_file) values (now(), '$quote_id', '$invoice_id')";
	$db = new database();
	if($db->query($sql)){

		if($db->get_insert_id()>0){

			$return['id'] = $db->get_insert_id();
			$return['quote_id'] = $quote_id;
			$return['invoice_id'] = $invoice_id;
		}

	}
	$db = null;
	return $return;

}
function text_summary($html,$word_count){


	//

	$html = str_replace("\r\n", " ", $html);

	$html = str_replace("<br>", " ", $html);

	$html = str_replace("<br/>", " ", $html);

	$html = strip_tags($html);

	$word_array = split(" ", $html);
	for($word=0;$word<=$word_count;$word++){

		$summary_text .= $word_array[$word] . " ";

	}

	$summary_text .= "...";



	return $summary_text;


}




function get_page_alert(){

	if($_SESSION['alert']['message']!=""){

		$notification_class = "good";
		if($_SESSION['alert']['type']!=""){

			$notification_class = $_SESSION['alert']['type'];

		}

		$alert_message = $_SESSION['alert']['message'];

		if($notification_class=="bad"){

			$alert_class = "alert-danger";
			$alert_icon = "icon-remove-sign";

		}elseif($notification_class=="warning"){

			$alert_class = "alert-warning";
			$alert_icon = "icon-warning-sign";

		}elseif($notification_class=="good"){

			$alert_class = "alert-success";
			$alert_icon = "icon-thumbs-up";
		}

		?>
		<div onClick="$(this).hide();" class='ss_alert'>
			<div class="alert <?php echo($alert_class); ?>">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			  <i class="<?php echo($alert_icon); ?>"></i><?php echo($alert_message); ?>
			</div>
			<div class='clear'></div>
		</div>

		<?php

		unset($_SESSION['alert']);

	}

}


function throw_fatal_error($url){

	die("Whoops: $url");

}


function html_field($details){

	//type
	//name
	//data_source: ajax reference
	//verification_ref_array number, max, min
	//


	switch ($details['type']){


		case 'typeahead':


		break;


		case 'date':


		break;


	}





}


	/*function ss_login($user_id, $verification_code){

		//$sql = "select id, username, email, can_comment from df_users where id = $user_id and verification_code = $verification_code and status != -1";
		//$result = mysql_query($sql);
		//if($row = mysql_fetch_assoc($result)){

		//update_engagements($user_id);

		//$sql = "select id, username, email, can_comment,  from df_users where id = ? and verification_code = ? and status != ?";
		$sql = "select * from df_users where id = ? and verification_code = ? and status != ?";
		$args = array("iii", $user_id, $verification_code, -1);
		$db = new database();
		$db->query($sql,$args);

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


			get_all_read(true);


			setcookie('com1x', $user_id, time()+60*60*24*60, '/', 'www.dogfocus.co.uk',false,true);
			setcookie('com2x', $verification_code, time()+60*60*24*60, '/', 'www.dogfocus.co.uk',false,true);
			$ret = 1;

		}else{

			ss_logout();
			$ret = 0;

		}

		return $ret;

	}

	function ss_logout(){

		// Remove cookies
		setcookie('com1x', 0, time() - 3600 * 24, '/', 'www.dogfocus.co.uk',false,true);
		setcookie('com2x', 0, time() - 3600 * 24, '/', 'www.dogfocus.co.uk',false,true);

		// Remove user session
		unset($_SESSION['user']);


	}*/



	function prepare_for_db_html($string){

		/*$string = str_replace("&","&amp;",$string);
		$string = str_replace("'","&quot;",$string);
		$string = str_replace("-","&#45;",$string);
		$string = str_replace("<","&lt;",$string);
		$string = str_replace(">","&gt;",$string);*/
		$string = htmlentities($string,ENT_QUOTES);
		$string = mysql_real_escape_string($string);

		return ($string);

	}


	function html_nav(){

	$ss_nav_hidden = "";

	if($_SERVER['REQUEST_URI'] == "/"){
		$ss_nav_hidden = "ss_nav_hidden";
	}


?>
    <nav class="navbar navbar-fixed-top <?php echo($ss_nav_hidden); ?>">
      <div class="container-fluid ">
        <div class="navbar-header ">
            <button  type="button" class="navbar-toggle " data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a style='position:relative;z-index:1;' class="navbar-brand" href="/">

				<img class='bos_home_logo' src="/imgs/ls_whitelabel_1_image_1.jpg" />

            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">

          <ul class="nav navbar-nav navbar-right nav_hidden" >

          	<?php if($_SERVER['REQUEST_URI'] != "/"){ ?>

			<li><a href="http://shop.stagescripts.com"><span class="glyphicon glyphicon-home"></span> Home</a></li>

            <?php } ?>

            <?php if(($_SERVER['REQUEST_URI'] != "/cases/") && $_SESSION['user']['id']>0){ ?>

			<li><a href="/licenses/"><span class="fa fa-id-card"></span> Licenses</a></li>

            <?php } ?>


            <?php if($_SESSION['user']['id'] > 0) { ?>

			<li><a href="/logout/"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>

            <?php }else{ ?>

			<li><a href="/login/"><span class="glyphicon glyphicon-log-out"></span> Log In / Register</a></li>

			<?php } ?>

          <li><a href="http://shop.stagescripts.com/pages/contact-us/how-to-contact-us.html"><span class="glyphicon glyphicon-phone-alt"></span> Contact</a></li>

          </ul>

        </div>
      </div>
    </nav>

    <?php
    if($_GET['nm']!=""){

        $notification_class = "good";
        if($_GET['nc']!=""){

            $notification_class = $_GET['nc'];

        }

        ?>

        <div class='notify <?php echo($notification_class); ?>'>
            <p><?php echo($_GET['nm']); ?></p>
        </div>

        <?php
    }
}


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

?>



<?php

// uploads two images to google vision api in order to extract text
//inputs: 2 files - 1 is a quote, 1 is an invoice
//returns: an array containing 2 json objects representing
//         the text from each of the 2 files input
//         the text in each json object will need decoding
function post_images_to_vision($quote_image_filename, $invoice_image_filename) {

	$ch = curl_init();
	$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
	$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;

	$res['quote_text'] = post_image_to_vision($ch, $quote_image_filename, $cvurl);

	$res['invoice_text'] = post_image_to_vision($ch, $invoice_image_filename, $cvurl);

	curl_close($ch);

	return $res;
}

//return the results of uploading a single file to vision
//input: the name of the file to be uploaded
//return: Details of the conversion by vision. Should be a load of text if the original document contained any.
function post_image_to_vision($ch, $image_filename, $cvurl) {

	$json_object = set_base64_and_type($image_filename);
	curl_setopt($ch, CURLOPT_URL, $cvurl);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_object);

	$results = curl_exec ($ch);

	return $results;
}

//JW: Put comments at the top of every function you write
//  Describe the following things in your comments:
//    1. what the function is supposed to do
//    2. what the input arguments are (the input arguments are the values you're passing into the function)
//    3. what value the function returns (mention all the possible values that can be returned and what they mean)

// here's an example:

// function to convert a temperature from centigrade to farenheit
// inputs: centigrade value
// returns: farenheit value (any number is valid - could be non-integer)
//          returns the same value as input if errors occur




//please add comments to any functions you write
// including the one below
// please also change it's name so it's more descriptive.





// function to fix the content and type of a variable
// inputs: 1 variable
// returns: a edited $r_json array that has a fixed type and content variable (aka type to TEXT_DETECTION and content to base64)
//


function set_base64_and_type($image_filename) {

		$fname = $image_filename;

		$file_get_contents_path = "http://quotecheck:qc!@www.quotecheck.tech/imgs/quotecheck/uploads/".$fname;

		$data = file_get_contents($file_get_contents_path);
		$base64 = base64_encode($data);
		$type = "TEXT_DETECTION";

		$r_json ='{
			"requests": [{
			  				"image": {
										"content":"' . $base64. '"
					 				 },
			  				"features": [{
											"type": "' .$type. '",
											"maxResults": 200
			  							}]
										}]
				  }';

		return $r_json;
	}
	// function to convert a pdf file into multiple jpgs
	// inputs: 1 pdf
	// returns: nothing but outputs the pdf as multiple jpgs under the name finished-1.jpg finished-2.jpg etc
	//
/*
	function pdf_to_jpg($inputed_pdf){
		$imagick = new Imagick();
		$imagick->readImage($inputed_pdf);
		$imagick->writeImages('/home/jwdev/9VN0EDP8/htdocs/pdfs/'$inputed_pdf'.jpg', false);
	}
	*/
/*
	// function to count the file types and then output them by echoing
	// inputs: none it takes its infomation from the folder
	// returns: nothing but in the function it echos what the count is of both jpgs and pdfs
	//
	function count_file_types(){
		$count_jpg = count(glob("/home/jwdev/9VN0EDP8/htdocs/pdfs/*.jpg"));
	  $count_pdf = count(glob("/home/jwdev/9VN0EDP8/htdocs/pdfs/*.pdf"));
		echo "$count_jpg jpgs";
		echo "$count_pdf pdfs";
	}
*/
	// function toset a unique pdf name
	// inputs: none it makes its own infomation up
	// returns: a unique pdf name
	//
/*
	function custom_pdf_name(){

		$newname = "pdf".$unique_id.".pdf";
		$
	return $newname,$unique_id;
  };
	*/
/*
// function to upload the pdf to the server
// inputs: takes the file aray as a input
// returns: the unique name of the pdf
//
function upload_PDF($files2){

	$file_upload_max_mb = 3;
	$file_upload_max_bytes = $file_upload_max_mb * 1048576;

	$display_info = "";
	$display_info_class = "error_txt";
	$file_found = false;
	//$receipt_path = DOC_ROOT . $arr['path'];

	$total_file_count = 0;
	$good_file_count = 0;
	$bad_file_count = 0;
	$dest_file_extension = ".pdf";
	$tmp_name = $files2["tmp_name"];

	echo "<pre>";
	print_r($files2["tmp_name"]);
	echo "</pre>";

	$new_name = custom_pdf_name();

	$dest_image_path = DOC_ROOT . "/imgs" . $arr['dest_file_folder'];


	move_uploaded_file ($tmp_name ,$dest_image_path."/".$new_name);


	return $new_name;

}*/

// function to upload the pdf to the server
// inputs: takes the file type variable thats either going to be "quote" or "invoice"
// returns: nothing but the folder on the server should have  unique
//
function upload_pdf_and_convert_to_jpg($uploaded_file, $quote_or_invoice){

  $relative_path = "imgs/quotecheck/uploads/";

	$original_name = $uploaded_file['name'];
	$tmp_name = $uploaded_file['tmp_name'][0];
	if ($tmp_name == "")
	{
		echo "no file found to upload<br>";
		die($uploaded_file);
		return null;
	}

  $destination_folder = DOC_ROOT . $relative_path;
  $unique_id = get_unique_id();

  $destination_filename_prefix = $quote_or_invoice.'-'.$unique_id; //quote or invoice
  $destinationPDFname = $destination_filename_prefix.'.pdf' ;
  $destinationJPGname = $destination_filename_prefix.'.jpg' ;

 	if(move_uploaded_file($tmp_name, $destination_folder.$destinationPDFname )) {
	 	$imagick = new Imagick();


	 	$imagick->readImage($destination_folder.$destinationPDFname);
	 	$imagick->writeImages($destination_folder.$destinationJPGname , false);

	 	$returns['unique_id'] = $unique_id;
	 	$returns['jpg_count'] = 1; //JACK: how do we get the jpg count?
	 	$returns['destination_filename_prefix'] = $destination_filename_prefix;
		$returns['upload_folder'] = "www.quotecheck.tech/". $relative_path;
	 	return $returns;
	}
 	else {
	 	echo "Problem uploading file";
	 	return NULL;
 	}
}

?>
