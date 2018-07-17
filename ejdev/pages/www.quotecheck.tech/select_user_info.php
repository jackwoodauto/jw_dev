
<?php
$return = array();
$return['ErrorStatus'] = "0";
$return['html'] = "";


$fk_user_id = $_SESSION['user']['id'];

//add new job to the DB. Check for duplicates here and return error if necessary
$sql = "SELECT * FROM qc_users WHERE id = ?";
$args = array("i", $fk_user_id,);
$conn = new database();


if ($conn->connect_error) {
    $return = "Connection failed: " . $conn->connect_error;
} else if ($conn->query($sql, $args)) {

    $user_info = $conn->all();
    if (count($user_info) >0) {







    $return['user_data'] = $user_info;
} else {
    $return['ErrorStatus'] = "Error: " . $sql . "<br>" . $conn->error;
}
die(json_encode($return));
}
?>
