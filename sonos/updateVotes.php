<?php
// displays votes in dashboard
	include '../resources/db.php';
	
	// gets likes & dislikes
	$stmt = $conn->prepare("SELECT likes, dislikes FROM currentTrack");
	$stmt->execute();
	$stmt->bind_result($likes, $dislikes);
	$stmt->fetch();
	$stmt->reset();
	
	// get threshold
	$file = fopen("../resources/sonossettings.txt", "r");
	$threshold = fgets($file);
	fclose($file);
	
	// calculated votes to skip
	$dislikes = $threshold - $dislikes;
	
	echo "$likes, $dislikes";
?>