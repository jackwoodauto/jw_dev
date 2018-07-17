<?php

include_once(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/pr_upload_func.php");
$mykey = "";
$found = false;
$job_id = $_POST['job_selected'];
$user_id  = $_SESSION['user']['id'];
$invoice_or_quote = $_POST['Quote_or_invoice']; //name of table eg qc_pr_quotes
$file_type = "";
$header_info = "";
if ($invoice_or_quote == 'qc_pr_quotes') {
$file_type = "quote";
$header_info = "https://www.quotecheck.tech/my_home";
} else if ($invoice_or_quote == 'qc_pr_invoices') {
$file_type = "invoice";
$header_info = "https://www.quotecheck.tech/output_example";
}
$file_type = $invoice_or_quote;
$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";
$wholesaler_id = $_POST['wholesaler_selected'];
$doc_id =  $_POST['doc_select'];
$relative_path = "imgs/quotecheck/uploads/";
$original_name = $_FILES['input_quote']['name'][0];
$tmp_name = $_FILES['input_quote']['tmp_name'][0];

if ($tmp_name == "")
{
    sleep(3);
    return null;
}

if($_FILES['input_quote']['type'][0]=="application/pdf"){
    sleep(3);

} else {

    $arr['dest_file_folder'] = "/quotecheck/uploads/";
    $arr['dest_file_name_string'] = "quote";////////////// make sure this is either invoice or quote

    if (strpos("invoice", $invoice_or_quote)!==false)
    $arr['dest_file_name_string'] = "invoice";
    $arr['create_thumb_nail'] = false;
    $arr['valid_image_types'] = array(IMAGETYPE_GIF => '.gif', IMAGETYPE_JPEG => '.jpg', IMAGETYPE_PNG => '.png', IMAGETYPE_BMP => '.bmp', IMAGETYPE_PDF => '.pdf');
    $arr['dest_max_width'] = 750;
    $arr['dest_max_height'] = 5000;
    $result = upload_file($arr, $_FILES['input_quote']);
    $quote_image = $result[0]['main']['filename'];
}

$imagefile = $result[0]['main']['filename'];
$ch = curl_init();
$api_key = "AIzaSyAlCaFZcnwXOLepsXNFAh14i3YC9sFru8Y";
$cvurl = "https://vision.googleapis.com/v1/images:annotate?key=" . $api_key;
$results = post_image_to_vision($ch, $imagefile, $cvurl);
$decoded_json_data = json_decode($results,true);
$text_only = $decoded_json_data['responses'][0]['textAnnotations']['0']['description'];
$destination_folder = DOC_ROOT . $relative_path;
$unique_id = get_unique_id();
$destination_filename_prefix = $quote_or_invoice.'-'.$unique_id; //quote or invoice
$destinationPDFname = $destination_filename_prefix.'.pdf' ;/////////////////////////////////////////////// here is the error i think  it is doing the pdf stuff even if is not a pdf
$destinationJPGname = $destination_filename_prefix.'.jpg' ;

if(move_uploaded_file($tmp_name, $destination_folder.$destinationPDFname)) {

    $imagick = new Imagick();
    $imagick->readImage($destination_folder.$destinationPDFname);
    $imagick->writeImages($destination_folder.$destinationJPGname , false);
    $returns['unique_id'] = $unique_id;
    $returns['jpg_count'] = 1;
    $returns['destination_filename_prefix'] = $destination_filename_prefix;
    $returns['upload_folder'] = "www.quotecheck.tech/". $relative_path;

}

else {
    sleep(3);
}

$input_file = $destination_filename_prefix.'.jpg';;
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$upload_time = date('m/d/Y h:i:s a', time());;
$old_name = $original_name;
$sql = "INSERT INTO $invoice_or_quote (fk_user_id, fk_job_id, input_file, old_name, upload_time, fk_wholesaler_id, fk_doc_id)
VALUES ('$user_id','$job_id','$input_file','$old_name','$upload_time','$wholesaler_id','$doc_id')";

if ($conn->query($sql) === TRUE) {
$file_id = $conn->insert_id;
} else {

    sleep(3);
}

$conn->close();
$conn = null;

// everything above is uploading the file to the databse/ setting variables up and getting the text out

$template_column_array = array(); //fox array has all of the columns that are set in the template and there x coords
$array_of_col_names = array();
$sql = "SELECT * FROM qc_pr_wholesaler_doc_col where fk_doc_id = ?";
$args = array("i",$doc_id);
$db = new database();
$db->query($sql,$args);
$results = $db->all();
$db = null;

if (count($results) > 0) {

    foreach ($results as $result) {

        array_push($array_of_col_names, $result['type']);
        $placeholder_for_array_push = $result['type'];
        $placeholder_for_array_push_col_text  = $result['col_text'];
        $placeholder_for_array_push_x_left = $result['x_left' ] ;
        $placeholder_for_array_push_y_top = $result['y_top'] ;
        $placeholder_for_array_push_x_right = $result['x_right'] ;
        $placeholder_for_array_push_y_bottom = $result['y_bottom'] ;
        $template_column_array[$placeholder_for_array_push]['Col_LeftX'] = $placeholder_for_array_push_x_left;
        $template_column_array[$placeholder_for_array_push]['Col_RightX'] = $placeholder_for_array_push_x_right;
        $template_column_array[$placeholder_for_array_push]['Col_BottomY'] = $placeholder_for_array_push_y_bottom;
        $template_column_array[$placeholder_for_array_push]['Col_TopY'] = $placeholder_for_array_push_y_top;
        $template_column_array[$placeholder_for_array_push]['Col_text'] = $placeholder_for_array_push_col_text;
    }
}

$symb_array = GetAllSymbols($decoded_json_data); // has every symbol from the decoded json data into a array

$symb_by_col_array = GetAllColumns($symb_array, $template_column_array);                // output_array contains every symbol sorted by column

$row_y_array = get_rows_y($symb_array, $template_column_array);   // contains every row y cords in a array

$symb_by_row_array = GetAllRows($symb_array, $row_y_array);  // contains every symbol sorted by row

$final_table = final_value($symb_array, $template_column_array, $row_y_array);


$upload_line_items = UploadLineItems($final_table, $job_id, $invoice_or_quote, $file_type, $file_id);
$comp_table = "";
// OldTableUpload();

// function OldTableUpload(){
if ($invoice_or_quote  == 'qc_pr_quotes'){
    $file_type = 'Quote';
    $comp_table = "quote";
} else {
    $file_type = 'Invoice';
    $comp_table = CompareNewInvoiceInfoAgainstQuote($upload_line_items, $job_id, $file_type);
    $database_table = base64_encode(serialize($comp_table));
    $db = new database($servername, $username, $password, $dbname);
    if ($db->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "UPDATE qc_pr_invoices SET database_table='$database_table'  WHERE upload_time='$upload_time'";
    $db = new database();
    $db->query($sql);
    $db = null;
}


$table_id = get_unique_id();

if ($comp_table != "quote") {

foreach ($comp_table as $key => $value) {
$invoice_line_item_id = $value['invoice'][0]['line_item_id'];
// echo "<pre>";
// print_r($comp_table);
// echo "</pre>";


$quote_line_item_id = $value['quote'][0]['id'];
if ($quote_line_item_id == ""){
$quote_line_item_id = "1";
}

$job_id = "22";
$highlight = true;
$db = new database($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
        $sql = "insert into qc_pr_table (table_id ,invoice_line_item_id, quote_line_item_id, highlight, job_id) values (?,?,?,?,?)";
        $args = array("iiisi", $table_id, $invoice_line_item_id, $quote_line_item_id, $highlight, $job_id);
        $db = new database();
        $db->query($sql,$args);
        echo $db->error();
        $insert_id = $db->get_insert_id();

$line_item_array[$key]["line_item_id"] = $insert_id ;






        $db = null;


}
}

$_SESSION['invoice_against_quote'] = $comp_table;
// }
function UploadTableToDB(){};




// header("Location:$header_info");
//  die();
?>
