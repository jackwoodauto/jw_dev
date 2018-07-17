
<?php

$file_type = $invoice_or_quote;
$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";
$wholesaler_id = $_POST['wholesaler_selected'];
$doc_id =  $_POST['doc_select'];
$relative_path = "imgs/quotecheck/uploads/";
$original_name = $_FILES['input_template_image']['name'][0];
$tmp_name = $_FILES['input_template_image']['tmp_name'][0];
$arr['dest_file_folder'] = "/quotecheck/uploads/";
$arr['create_thumb_nail'] = false;
$arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
$arr['dest_max_width'] = 750;
$arr['dest_max_height'] = 5000;
$arr['dest_file_folder'] = "/quotecheck/uploads/";
$arr['dest_file_name_string'] = "quote";////////////// make sure this is either invoice or quote

$file_array = array();
//$file_array['input_template_image'] = $_FILES['input_template_image'];
$file_array['input_template_image']['error'][0] = $_FILES['input_template_image']['error'];
$file_array['input_template_image']['type'][0] = $_FILES['input_template_image']['type'];
$file_array['input_template_image']['tmp_name'][0] = $_FILES['input_template_image']['tmp_name'];
$file_array['input_template_image']['name'][0] = $_FILES['input_template_image']['name'];
$file_array['input_template_image']['size'][0] = $_FILES['input_template_image']['size'];
$old_name = $_FILES['input_template_image']['name'];

$result = upload_file($arr, $file_array['input_template_image']);

$imagesize = getimagesize($_FILES['input_template_image']['tmp_name'], $arr);
$height = $imagesize[1];
$width = $imagesize[0];

$height2 = $height / $width;
$height = $height2 * 750;

// $height = 750;
$width = 750;

$servername = "localhost";
$username = "ejdev_db";
$password = "autoSquared01_db";
$dbname = "ejdev_db";
$new_name = "fail";
$picture_name = "fail";
$newname = $result[0]['main']['filename'];
$picture_name = $old_name;

$size = $file_array['input_template_image']['size'][0];
//$wholesaler_doc_id = $_POST[''];
$wholesaler_doc_id = $_POST['doc_select'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "$lawyer_status_update";


$sql = "UPDATE qc_pr_wholesaler_doc SET drag_map_picture='$newname' , old_name='$picture_name' , width ='$width' , height ='$height' WHERE id='$wholesaler_doc_id'";


if ($conn->query($sql) === TRUE) {
    echo "New record updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


 header("Location:" . "https://www.quotecheck.tech/new_template");

?>
