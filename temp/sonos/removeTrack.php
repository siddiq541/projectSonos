<?php
// removes the first track in the queue
	include 'db.php';
	
	// delete row
	$stmt = $conn->prepare("DELETE FROM queue WHERE position = 1");
	$stmt->execute();
	$stmt->reset();
		
	// move all other rows down
	$stmt = $conn->prepare("UPDATE queue SET position = position-1 WHERE position > 1");
	$stmt->execute();
	$stmt->reset();
		
	// find end of queue
	$stmt = $conn->prepare("SELECT MAX(position) FROM queue");
	$stmt->execute();
	$stmt->bind_result($number);
	$stmt->fetch();
	$stmt->reset();
	
	if ($number == null){
		// reset auto increment
		$stmt = $conn->prepare("TRUNCATE queue");
		$stmt->execute();
		$stmt->reset();
	} else{
		// set auto increment to end of queue
		$stmt = $conn->prepare("ALTER TABLE queue AUTO_INCREMENT = " . $number . "");
		$stmt->execute();
		$stmt->reset();
	}
?>