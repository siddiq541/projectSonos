<?php
	// removes tracks that are more than x days old
	include '../resources/db.php';
	
	// read settings to get amount of days before tracks should get removed
	$file = fopen("../resources/sonossettings.txt", "r");
	// get rid of first line
	fgets($file);
	$days = fgets($file);
	fclose($file);
		
	$tracks = array(
		array(), // 0 keeps URI
		array() // 1 keeps date
	);
	$currentDate = new DateTime(date("Y-m-d"));
	$i = 0;
	
	$stmt = $conn->prepare("SELECT URI, date FROM trackHistory");
	$stmt->execute();
	$stmt->bind_result($URI, $date);
	while($stmt->fetch()){
		$tracks[$i][0] = $URI;
		$tracks[$i][1] = new DateTime($date);
		$i++;
	}
	$stmt->reset();
	
	foreach ($tracks as $track){
		$interval = $currentDate->diff($track[1]);
		if ($interval->days > $days){
		  $stmt = $conn->prepare("DELETE FROM trackHistory WHERE URI = ?");
		  $stmt->bind_param('s', $track[0]);
		  $stmt->execute();
		  $stmt->reset();
		}
	}
?>