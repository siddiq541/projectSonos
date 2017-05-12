<?php
	session_start();
	include 'sonosfunctions.php';
	include '../resources/db.php';
	
	$stmt = $conn->prepare("SELECT u_nickname FROM users WHERE u_ID = '" . $_SESSION['id'] . "'");
	$stmt->execute();
	$stmt->bind_result($username);
	$stmt->fetch();
	$stmt->reset();
	
	recordActivity($username  . " changed the volume on " . $_REQUEST['speaker']);
?>