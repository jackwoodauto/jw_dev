
<?php

$job_id = $_POST["job_selected"];
$user_id  =""
$job_id =""
$quote_file =""



$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";

 $targetfolder = "pdfs/";

 $targetfolder = $targetfolder . basename( $_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))

 {

 echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

 $imagick = new Imagick();
 $imagick->readImage($_FILES['file']['name']);
 $imagick->writeImage($_FILES['file']['name'".jpg"]);
 }

 else {

 echo "Problem uploading file";
 }

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO qc_pr_quotes (fk_user_id, fk_job_id, quote_file)
VALUES ('$user_id','$job_id','$quote_file',)";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo "done";
header("Location: https://www.quotecheck.tech/admin_portal");


?>
