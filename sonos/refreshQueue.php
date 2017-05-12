<?php
// checks in the count in queue has changed, ensures queues are synced and returns true for page to be refreshed
	session_start();
	include 'sonosconnect.php';
	$track = $controller->getStateDetails();
	$queue = $controller->getQueue();
	$oldCount = $_REQUEST['count'];
		
	include 'syncQueues.php';
	
	// true = refresh
	if($oldCount != $queue->count()){
		echo true;
	}
?>