<?php
	session_start();
	include 'sonosfunctions.php';
	include '../resources/db.php';
	
	// records volume change activity
	$stmt = $conn->prepare("SELECT u_nickname FROM users WHERE u_ID = ?");
	$stmt->bind_param('s', $_SESSION['id']);
	$stmt->execute();
	$stmt->bind_result($username);
	$stmt->fetch();
	$stmt->reset();
	
	recordActivity($username  . " changed the volume on " . $_REQUEST['speaker']);
?>