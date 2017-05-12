<?php
// checks if the track has changed, if it has, one user will remove the first track in queue and return true for the page to be reloaded
	session_start();
	include 'sonosconnect.php';
	$track = $controller->getStateDetails();
	$queue = $controller->getQueue();
	$oldNumber = $_REQUEST['number'];
	$oldTrack = $_SESSION['trackuri'];
	
	//having the second condition ensures that atleast one user enters this statement to remove the previous track if two tracks are the same
	if ($oldTrack != $track->uri || $oldNumber != $track->queueNumber){ 
		// this conditional ensures that only one user executes the statement within it
		if ($track->queueNumber > 0){
			if ($queue->removeTrack(0)){
				include 'removeTrack.php';
			}
		}
		echo true;
	}
?>