<?php

$errors = '';


$_SESSION['$cap_name'] = $_POST['name'];
$_SESSION['$cap_telephone'] = $_POST['telephone'];
$_SESSION['$cap_email'] = $_POST['email'];
$_SESSION['$cap_message'] = $_POST['message'];


$_SESSION['$Reload'] =  1 ;





$_SESSION['$Reload'] = 0;
$myemail = "jackw@automationsquared.com";//<-----Put Your email address here.
if(empty($_POST['name'])  ||
   empty($_POST['email']) ||
   empty($_POST['message']))
{
    $errors .= "\n Error: all fields are required";
}
$name = $_POST['name'];
$phone_number = $_POST['telephone'];
$email_address = $_POST['email'];
$message = $_POST['message'];

if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
$email_address))
{
///    $errors .= "\n Error: Invalid email address";
}

if( empty($errors))
{
$to = $myemail;
$email_subject = "new contact from entry: $name";
$email_body = "someone has used the contact form. ".
" Here are the details:\n Name: $name \n ".
"Email: $email_address\n Phone Number: $phone_number\n Message: \n $message" ;
$headers = "From: $myemail\n";
$headers .= "Reply-To: $email_address";
mail($to,$email_subject,$email_body,$headers);
//redirect to the 'thank you' page

$upload_time = date("Y-m-d h:i:sa");

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

$sql = "INSERT INTO contact_form (name, email, phone_number, message, upload_time)
VALUES ('$name', '$email_address', '$phone_number', '$message', '$upload_time')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();



header("Location:" . "http://www.quotecheck.tech");
die();
}

echo "end of file";
echo $errors;
?>
