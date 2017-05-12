<?php
	include '../resources/db.php';
	
	$stmt = $conn->prepare("UPDATE currentTrack SET likes=0, dislikes = 0");
	$stmt->execute();
	$stmt->reset();
	
	$stmt = $conn->prepare("UPDATE users SET hasVoted = 0");
	$stmt->execute();
	$stmt->reset();
?>