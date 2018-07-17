
<?php




$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";
$company_name = $_POST['company_name'];
$company_address = $_POST['company_address'];
$company_phone_number = $_POST['company_phone_number'];
$delivery_address = $_POST['delivery_address'];
$invoice_address = $_POST['invoice_address'];
$company_number = $_POST['company_number'];
$fk_user_id = $_SESSION['user']['id'];
echo "$company_name";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO company (name, address, phone_number, company_number, invoice_address, delivery_address, fk_creation_user_id)
VALUES ('$company_name', '$company_address', '$company_phone_number', '$company_number', '$invoice_address', '$delivery_address', '$fk_user_id')";

if ($conn->query($sql) === TRUE) {
  $last_id = $conn->insert_id;
  echo "New record created successfully. Last inserted ID is: " . $last_id;
  $conn->close();


  $conn2 = new mysqli($servername, $username, $password, $dbname);
  $sql2 = "UPDATE qc_users SET fk_company_id = 123  WHERE id = $fk_user_id;";
  if ($conn2->query($sql2) === TRUE) {
    echo "update of the user table was successfull";
  } else {
    echo "Error: " . $sql2 . "<br>" . $conn2->error;
    $conn2->close();
  }
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  $conn->close();
}


echo "done";

header("Location: https://www.quotecheck.tech/company_dashboard");

?>
