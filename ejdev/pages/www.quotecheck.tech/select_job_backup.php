<?php
// $servername = "localhost";
// $dbname = "ejdev_db";
// $username = "ejdev_db";
// $password = "autoSquared01_db";
include(DOC_ROOT . "/pages/" . DOMAIN_DIR . "/display_job_info.php");

$conn = new database();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$jobid = $_POST['jobid'];
$fk_user_id = $_SESSION['user']['id'];

//$sql = "SELECT qc_pr_job_names.job_name, qc_pr_invoices.input_file FROM ((qc_pr_job_names LEFT JOIN qc_pr_invoices ON qc_pr_job_names.id = qc_pr_invoices.fk_job_id) LEFT JOIN  qc_pr_quotes ON qc_pr_job_names.id = qc_pr_quotes.fk_job_id) WHERE qc_pr_job_names.fk_user_id = ? AND qc_pr_job_names.id = ?";



$sql = "SELECT job_name FROM qc_pr_job_names WHERE fk_user_id = ? AND id = ?";
// $sql2 = "SELECT input_file FROM qc_pr_invoices WHERE fk_user_id = ? AND fk_job_id = ?";
// $sql3 = "SELECT input_file FROM qc_pr_quotes WHERE fk_user_id = ? AND fk_job_id = ?";
//
// $sql = "SELECT * FROM qc_pr_job_names WHERE id = $jobid";

$arrayargs = array("ii", $fk_user_id, $jobid);

$conn->query($sql);//, $arrayargs);
$results = $conn->all();

// $conn->query($sql2, $arrayargs);
// $results2 = $conn->all();
//
// $conn->query($sql3, $arrayargs);
// $results3 = $conn->all();


$conn = null;


if (count($results)>0){

    $myarray = array($results, $results2, $results3);
    $datareturned = json_encode($myarray);

    //$datareturned = json_encode($results[0]);
    }
    else {
        $datareturned = json_encode("empty");
    }


die($datareturned);

?>
