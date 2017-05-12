<?php
// clears sonos queue and truncates queue table (deletes all rows and resets auto increment)
	include 'db.php';
	include 'sonosconnect.php';
	
	// clear queue
	$queue = $controller->getQueue();
	$queue->clear();
	
	// truncate queue table
	$stmt = $conn->prepare("TRUNCATE queue");
	$stmt->execute();
	$stmt->reset();
?>