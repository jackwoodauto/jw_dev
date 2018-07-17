<?php
// $servername = "localhost";
// $dbname = "ejdev_db";
// $username = "ejdev_db";
// $password = "autoSquared01_db";
//
// $conn = new mysqli($servername, $username, $password, $dbname);
$return="";

$name= $_POST['new_wholesaler_name1'];
$fk_user_id = $_SESSION['user']['id'];

//add new Wholesaler to the DB. Check for duplicates here and return error if necessary
$sql = "INSERT INTO qc_pr_wholesaler (wholesaler_name, fk_user_id) VALUES (?, ?)";
$args = array("si", $name, $fk_user_id);
$conn = new database();

if ($conn->connect_error) {
    $return = "Connection failed: " . $conn->connect_error;
} else if ($conn->query($sql, $args)) {
    if ($conn->get_insert_id() > 0) {
        $newWholesalerID = $conn->get_insert_id();
        $conn = null;
        $arrayS['ErrorStatus'] = "0";
        $arrayS['ReturnWholesaler'] = $name; //same name we provided to the function
        $arrayS['NewWholesalerID'] = $newWholesalerID;
        $return = json_encode($arrayS);
    }else{
        $conn = null;
        $return = "Error: No wholesaler added";
    }
} else {
    $conn = null;
    $return = "Error: " . $sql . "<br>" . $conn->error;
}

die($return);

// $conn->close();
 ?>
