<?php
// checks if the track has changed, if it has, one user will remove the first track in queue and return true for the page to be reloaded
	session_start();
	include 'sonosconnect.php';
	include 'sonosFunctions.php';
	include '../resources/db.php';
	$track = $controller->getStateDetails();
	$queue = $controller->getQueue();
	
	$oldNumber = $_REQUEST['number'];
	$oldTrack = $_SESSION['trackuri'];
	$queueNumber = $track->queueNumber;

	//having the second condition ensures that atleast one user enters this statement to remove the previous track if two tracks are the same
	if ($oldTrack != $track->uri || $oldNumber != $track->queueNumber){ 
		// this conditional ensures that only one user executes the statement within it
		if ($queueNumber > 0){
			for ($i = 0 ; $i < $queueNumber ; $i++){
				if ($queue->removeTrack(0)){
					include 'removeTrack.php';
				}
			}
			include 'resetVotes.php';
		}
		echo true;
	}
	
	// Do this if there is less than 10 seconds left in the track
	$timeLeft = positionToSeconds($track->duration) - positionToSeconds($track->position);
	if ($timeLeft < 10 && $queue->count() == 1){
		// stream a track if there is not one up next
		include 'streamTrack.php';
	}	
	
?>