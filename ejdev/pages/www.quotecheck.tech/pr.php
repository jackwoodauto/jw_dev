<?php

function wholesaler_select_on_load()
{
// FIND DETAILS OF wholesaler AND DISPLAY
$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT wholesaler_name, id FROM qc_pr_wholesaler";
$result = $conn->query($sql);
if ($result->num_rows > 0) {// output data of each row
    while($row = $result->fetch_assoc()) {
        $wholesaler_name = $row["wholesaler_name"];
        $wholesaler_id = $row["id"];
        //  $user_wholesaler_array += [$wholesaler_name=> $wholesaler_id];
        ?>
        <option value=<?php echo"$wholesaler_id"?><?php if ($wholesaler_id==11) echo ' selected="selected" ';?>><?php echo"$wholesaler_name"?></option>
        <?php
        ;
    }
} else {
    echo "No Wholesalers found";
}

$conn->close();


}


























































 ?>
