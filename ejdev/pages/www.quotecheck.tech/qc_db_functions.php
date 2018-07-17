<?php

function selectJobFromDB($jobid,$userid)) {
    $servername = "localhost";
    $dbname = "ejdev_db";
    $username = "ejdev_db";
    $password = "autoSquared01_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $selectedJob


    $sql = "SELECT job_name, id FROM qc_pr_job_names WHERE fk_user_id = ? AND job_name=?"; //  retuns all the times from when the booking date is x
    $args = array("ss",$fk_user_id_set, $selectedJob );
    $db = new database();
    $db->query($sql,$args);


    $result = $conn->query($sql);
    if ($result->num_rows > 0) {// output data of each row
        while($row = $result->fetch_assoc()) {
            $job_name = $row["job_name"];
            $job_id = $row["id"];
            $user_job_array += [$job_name=> $job_id];
        }
    }
}

?>
