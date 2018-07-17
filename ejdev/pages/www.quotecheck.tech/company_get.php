<?php

function company_select_on_load()
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

$sql = "SELECT name, id FROM company";
$result = $conn->query($sql);
if ($result->num_rows > 0) {// output data of each row
    while($row = $result->fetch_assoc()) {
        $company_name = $row["name"];
        $company_id = $row["id"];
        //  $user_wholesaler_array += [$wholesaler_name=> $wholesaler_id];
        ?>
        <option value=<?php echo"$company_id"?>><?php echo"$company_name"?></option>
        <?php
        ;
    }
} else {
    echo "No Companies found";
}

$conn->close();

}


























































 ?>
