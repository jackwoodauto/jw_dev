<?php
// $servername = "localhost";
// $dbname = "ejdev_db";
// $username = "ejdev_db";
// $password = "autoSquared01_db";
//
// $conn = new mysqli($servername, $username, $password, $dbname);
$return="";
$name= $_POST["info"][1];
$fk_doc_id = $_POST["info"][0];
$type = "InvQuo";
$drag_map_picture = "upload_image_below.jpg";
//$fk_doc_id = $_SESSION['user']['id'];
//add new document to the DB. Check for duplicates here and return error if necessary
$sql = "INSERT INTO qc_pr_wholesaler_doc (fk_wholesaler_id, type, name, drag_map_picture) VALUES (?, ?, ?, ? )";
$args = array("isss", $fk_doc_id, $type, $name, $drag_map_picture);
$conn = new database();

if ($conn->connect_error) {
    $return = "Connection failed: " . $conn->connect_error;
} else if ($conn->query($sql, $args)) {
    if ($conn->get_insert_id() > 0) {
        $newDocumentID = $conn->get_insert_id();
        $conn = null;
        $arrayS['ErrorStatus'] = "0";
        $arrayS['ReturnDocument'] = $name; //same name we provided to the function
        $arrayS['NewDocumentID'] = $newDocumentID;
        $return = json_encode($arrayS);
    }else{
        $conn = null;
        $return = "Error: No document added ";
    }
} else {
    $conn = null;
    $return = "Error: ". $sql . "<br>" . $conn->error;
}

die($return);

// $conn->close();
 ?>
