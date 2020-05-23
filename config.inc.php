<?php

$db_host = "";
$db_user = "";
$db_pass = "";
$db_db = "";

$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_db);

if ($mysqli->connect_errno) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	exit;
}

function validate_form_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES);

	return $data;
}

?>
