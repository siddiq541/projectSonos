<?php
	session_start();
	include '../resources/db.php';
	include 'sonosconnect.php';
	include 'sonosFunctions.php';

	// check if user has voted
	$stmt = $conn->prepare("SELECT hasVoted FROM users WHERE u_ID = '" . $_SESSION['id'] . "'");
	$stmt->execute();
	$stmt->bind_result($hasVoted);
	$stmt->fetch();
	$stmt->reset();

	if($hasVoted == 0){
		// change hasVoted to 1
		$stmt = $conn->prepare("UPDATE users SET hasVoted = 1 WHERE u_ID = '" . $_SESSION['id'] . "'");
		$stmt->execute();
		$stmt->reset();
	
		// add vote to current playing
		$stmt = $conn->prepare("UPDATE currentTrack SET dislikes = dislikes+1");
		$stmt->execute();
		$stmt->reset();
		
		// get threshold
		$file = fopen("../resources/sonossettings.txt", "r");
		$threshold = fgets($file);
		fclose($file);
		
		// get dislikes
		$stmt = $conn->prepare("SELECT dislikes FROM currentTrack");
		$stmt->execute();
		$stmt->bind_result($dislikes);
		$stmt->fetch();
		$stmt->reset();
		
		$spotifyURI = substr($_SESSION['trackuri'], 34, 22);
		// check if song exists in trackHistory - incase song wasn't added by user
		$stmt = $conn->prepare("SELECT COUNT(URI) FROM trackHistory WHERE URI = '" . $spotifyURI . "'");
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->reset();
		
		//update track history if it does
		if ($count > 0){
			$stmt = $conn->prepare("UPDATE trackHistory SET votes = votes-1 WHERE URI = '" . $spotifyURI . "'");
			$stmt->execute();
			$stmt->reset();
		}
		else{
			// check if added from streaming service
			$stmt = $conn->prepare("SELECT user FROM queue WHERE position = 1");
			$stmt->execute();
			$stmt->bind_result($user);
			$stmt->fetch();
			$stmt->reset();
			
			// if it was, add it to trackhistory
			if ($user == 'Streaming'){
				$stmt = $conn->prepare("INSERT INTO trackHistory (URI, count, votes, date) VALUES ('" . $spotifyURI . "', 1, -" . $dislikes . ", '" . date("Y-m-d") . "')");
				$stmt->execute();
				$stmt->reset();
			}
		}
		
		//skip song
		if ($dislikes >= $threshold){
			include 'resetVotes.php';
			
			$queue = $controller->getQueue();
			
			// record track removal
			$track = $queue->getTracks(0, 1);
			recordActivity($track[0]->title . " by " . $track[0]->artist . " was skipped");
			
			// add a song from streaming service
			if ($queue->count() == 1){
				include 'streamTrack.php';
			}
			
			$controller->next();
		}
	}
	?>