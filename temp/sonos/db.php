
<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	
	//set up this way as my local host has a personal password
	$db_host = 'localhost';
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'psypk1';
	
	$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($conn->connect_errno){
		exit("error: failed to connect to database");
	}
?>


