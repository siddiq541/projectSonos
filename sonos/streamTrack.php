<?php
	include 'sonosconnect.php';
	include '../resources/db.php';
	use duncan3dc\Sonos\Tracks\Spotify;
	$queue = $controller->getQueue();
	
	// find number of tracks in recommended
	$stmt = $conn->prepare("SELECT COUNT(ID) FROM recommendedTracks");
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->reset();
	
	// generate random number based on this
	if ($count > 0){
		$rand = mt_rand(1, $count);
	}
	else{
		$rand = 0;
	}
	
	// select a random track
	$stmt = $conn->prepare("SELECT track FROM recommendedTracks WHERE ID = ?");
	$stmt->bind_param('i', $rand);
	$stmt->execute();
	$stmt->bind_result($track);
	$stmt->fetch();
	$stmt->reset();
	
	// ensures only one user will enter this
	if ($queue->count() == 1){
		// checks to make sure the recommended tracks table isn't empty (shouldn't ever happen)
		if ($count > 0){
			if ($queue->addTrack(new Spotify($track))){
				// update queue table
				$stmt = $conn->prepare("INSERT INTO queue (user) VALUES ('Streaming')");
				$stmt->execute();
				$stmt->reset();
			}
		}
		
		if ($count > 5){
			// delete track that was added
			$stmt = $conn->prepare("DELETE FROM recommendedTracks WHERE ID = ?");
			$stmt->bind_param('i', $rand);
			$stmt->execute();
			$stmt->reset();
		
			// update auto increment
			$stmt = $conn->prepare("UPDATE recommendedTracks SET ID = ID-1 WHERE ID > ?");
			$stmt->bind_param('i', $rand);
			$stmt->execute();
			$stmt->reset();
		}
		else{
			// if not enough songs in recommended, update the trackhistory and generate more from this
			include 'updateTrackHistory.php';
			include 'generateRecommendations.php';
		}
	}
	
?>