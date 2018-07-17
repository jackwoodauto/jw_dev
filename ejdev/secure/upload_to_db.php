<?php
  $servername = "localhost";
  $username = "ejdev_db";
  $password = "autoSquared01_db";
  $dbname = "ejdev_db";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$quantity = $_POST['quantity'];
$company_infomation = $_POST['company_infomation'];
$invoice_total = $_POST['invoice_total'];
$quote_total = $_POST['quote_total'];
$price = $_POST['price'];
$customer_order_no = $_POST['customer_order_no'];
$product_name_infomation = $_POST['product_name_infomation'];




$sql = "INSERT INTO qc_secure_info (quantity, company_infomation, invoice_total, quote_total, price, customer_order_no, product_name_infomation)
VALUES ('$quantity', '$company_infomation', '$invoice_total', '$quote_total', '$price', '$customer_order_no', '$product_name_infomation')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();




?>
