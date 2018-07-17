
<?php
// $servername = "localhost";
// $dbname = "ejdev_db";
// $username = "ejdev_db";
// $password = "autoSquared01_db";
//
// $conn = new mysqli($servername, $username, $password, $dbname);
$type= "test";
$return="";
$name= $_POST["info"][1];
$fk_doc_id = $_POST["info"][0];
$type = $_POST["info"][2];


//$fk_doc_id = $_SESSION['user']['id'];
$x_right = "1";
$x_left = "4";
$pos = "2";
$y_top = "3";
$y_bottom = "5";
$height = "295";
$width = "90";

//add new column to the DB. Check for duplicates here and return error if necessary
$last_pos = "0";



$sql2 =  "SELECT MAX(position) From qc_pr_wholesaler_doc_col WHERE fk_doc_id = ?";
$args2 = array("i", $fk_doc_id);
$conn2 = new database();
if ($conn2->connect_error) {
    $return = "Connection failed: " . $conn2->connect_error;
} else {
    $conn2->query($sql2, $args2);
    $last_pos = $conn2->result('MAX(position)');
}
$pos = $last_pos + 1;




$sql = "INSERT INTO qc_pr_wholesaler_doc_col (col_text, fk_doc_id, x_left, x_right, width, height, y_top, y_bottom, position, type) VALUES (?, ?, ? ,?, ?, ?, ?, ?, ?, ?)";
$args = array("siiiiiiiss", $name, $fk_doc_id, $x_left, $x_right, $width, $height, $y_top, $y_bottom, $pos, $type);
$conn = new database();

if ($conn->connect_error) {
    $return = "Connection failed: " . $conn->connect_error;
} else if ($conn->query($sql, $args)) {
    if ($conn->get_insert_id() > 0) {
        $newColumnID = $conn->get_insert_id();
        $conn = null;
        $arrayS['ErrorStatus'] = "0";
        $arrayS['ReturnColumn'] = $name; //same name we provided to the function
        $arrayS['NewColumnID'] = $newColumnID;
        $arrayS['Position'] = $pos;
        $arrayS['_POST'] = $_POST;
        $return = json_encode($arrayS);
    }else{
        $conn = null;
        $return = "Error: No column added pre";
    }
} else {
    $conn = null;
    $return = "Error: ". $_POST. $sql . "<br>" . $conn->error;
}

die($return);

// $conn->close();
?>
