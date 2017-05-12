<?php
// used to check if the sonos queue and the queue table are in sync, if the count between them is incorrect, the integrity between the queues has been compromised; count in table corrected to match sonos queue and all user values set to null
	include 'db.php';
	include 'sonosconnect.php';
	
	// count queue
	$queue = $controller->getQueue();
	$count = $queue->count();
	
	// get count for queue table
	$stmt = $conn->prepare("SELECT MAX(position) FROM queue");
	$stmt->execute();
	$stmt->bind_result($max);
	$stmt->fetch();
	$stmt->reset();
	
	
	if ($max != $count){
		// delete queue table, reset auto increment
		$stmt = $conn->prepare("TRUNCATE queue");
		$stmt->execute();
		$stmt->reset();
	
		// fill queue table to count with null values for user
		for ($i = 0 ; $i < $count ; $i++){
			$stmt = $conn->prepare("INSERT INTO queue (user) VALUES (null)");
			$stmt->execute();
			$stmt->reset();
		}
	}
?>