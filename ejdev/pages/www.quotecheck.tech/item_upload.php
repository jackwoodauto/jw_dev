
<?php




$servername = "localhost";
$dbname = "ejdev_db";
$username = "ejdev_db";
$password = "autoSquared01_db";

$code	= $_POST['code'];
$name = $_POST['name'];
$quote_price = $_POST['quote_price'];
$quote_number = $_POST['quote_number'];
$quote_discount	= $_POST['quote_discount'];
$quote_total_price = $_POST['quote_total_price'];
$invoice_price = $_POST['invoice_price'];
$invoice_number	= $_POST['invoice_number'];
$invoice_discount = $_POST['invoice_discount'];
$invoice_total_price = $_POST['invoice_total_price'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO items (code, name, quote_price, quote_number, quote_discount, quote_total_price, invoice_price, invoice_number, invoice_discount, invoice_total_price)
VALUES ('$code', '$name', '$quote_price', '$quote_number', '$quote_discount', '$quote_total_price', '$invoice_price', '$invoice_number', '$invoice_discount', '$invoice_total_price')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
echo "done";
header("Location: https://www.quotecheck.tech/admin_portal");


?>
