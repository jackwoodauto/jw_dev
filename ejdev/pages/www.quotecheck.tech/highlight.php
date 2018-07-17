
<?php
$output_inv_id = $_GET['output_inv_id'];

if ($output_inv_id != "") {
	//    $database_table = base64_encode(serialize($comp_table));
	$db = new database($servername, $username, $password, $dbname);
	if ($db->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT database_table FROM qc_pr_invoices  WHERE id=?"; //  retuns all the times from when the booking date is x
	$args = array("s", $output_inv_id);
	$db = new database();
	$db->query($sql, $args);
	$db_new_table = $db->all();
	$db = null;
	$invoice_against_quote_array = unserialize(base64_decode($db_new_table[0]['database_table']));
	// echo "<pre>";
	// print_r($invoice_against_quote_array);
	// echo "</pre>";
} else {
	$invoice_against_quote_array = $_SESSION['invoice_against_quote'];
}
?>
