
<?php

// $_POST['info']['col'][1] (col 1_)
// $_POST['info']['col'][2]  (col 2)
// $_POST['info']['col'][1]['width'] (width)
// $_POST['info']['col'][1]['x_left'] (x_left)
// $_POST['info']['col'][1]['x_right'] (x_right)
// $_POST['info']['col'][1]['id'] (x_right)
// $_POST['id_arr'];
// $_POST['wid_arr'];
$hig_arr = $_POST['info'][2];
$col_id_arr = $_POST['info'][0];
$width_arr = $_POST['info'][1];
$top_marg_arr = $_POST['info'][3];
$last_div_width = 0;
foreach($width_arr as $key => $value) {
echo "width_arr parameter = '$value' <br>" ;
echo "col_id_arr parameter = $col_id_arr[$key]' <br>";
$height = $hig_arr[$key];
$col_id  = $col_id_arr[$key];
$width = $value;

$col_id  = substr($col_id , 3);
$top_marg = $top_marg_arr[$key];



$width_upload = "width = $width";
$X_left  = "x_left = $last_div_width";

$right = $last_div_width +  $width;
$height = $height + 2;
$y_bottom_calc = $top_marg + $height;
$height = "height = $height";
$X_right = "x_right = $right";
$y_top = "y_top = $top_marg";

$y_bottom = "y_bottom = $y_bottom_calc";
//  $x_left = $col[1]['x_left'];
//  $x_right = $col[1]['x_right'];
//  $col_id = $col[1]['id'];
//  $width = $col[1]['width'];


/// x_left = $x_left , x_right = $x_righ
//$setvar = width = $width;

$sql = "UPDATE qc_pr_wholesaler_doc_col SET $width_upload , $X_left , $X_right, $height, $y_top, $y_bottom WHERE id = ?";
$args = array("i",$col_id);

$db = new database();

if ($db->query($sql, $args))																								//doing the query
{																		//if it works return a succcess string
}
else
{       															// if it fails return the database errorr and close connection to the database
}
$db = null;
//}
$last_div_width = $last_div_width + $width;
}

?>
