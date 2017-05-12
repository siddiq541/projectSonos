<?php
	session_start();
	include 'sonosconnect.php';
	$track = $controller->getStateDetails();
	$queue = $controller->getQueue();
	$oldTrack = $_SESSION['trackuri'];
	$oldCount = $_REQUEST['count'];
	
	if ($oldTrack != $track->uri){
		$queue->removeTrack(0);
		echo true;
	}
	else if($oldCount != $queue->count()){
		echo true;
	}
	
?>