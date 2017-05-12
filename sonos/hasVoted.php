<?php
	session_start();
	include '../resources/db.php';
	
	// check if user has voted
	$stmt = $conn->prepare("SELECT hasVoted FROM users WHERE u_ID = '" . $_SESSION['id'] . "'");
	$stmt->execute();
	$stmt->bind_result($hasVoted);
	$stmt->fetch();
	$stmt->reset();
	
	echo false;
	
	if ($hasVoted == 1){
		echo true;
	}
?>