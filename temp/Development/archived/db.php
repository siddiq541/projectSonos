
<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	
	$db_host = 'localhost'; //127.0.0.1
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'psypk1';
	
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($conn->connect_errno) echo "failed to connect to database";
?>


