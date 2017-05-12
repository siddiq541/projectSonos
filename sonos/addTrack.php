<?php
// takes a spotify uri for a track and adds it to the sonos queue and queue table
	session_start();
	include '../resources/db.php';
	include 'sonosconnect.php';
	include 'sonosfunctions.php';
	use duncan3dc\Sonos\Tracks\Spotify;
	$queue = $controller->getQueue();
	
	// if request is successful
	if ($queue->addTrack(new Spotify($_REQUEST['uri']))){
		// update queue table
		$stmt = $conn->prepare("INSERT INTO queue (user) VALUES (?)");
		$stmt->bind_param('s', $_SESSION['id']);
		$stmt->execute();
		$stmt->reset();
		
		// check if song exists in trackHistory
		$stmt = $conn->prepare("SELECT COUNT(URI) FROM trackHistory WHERE URI = ?");
		$stmt->bind_param('s', $_REQUEST['uri']);
		$stmt->execute();
		$stmt->bind_result($count);
		$stmt->fetch();
		$stmt->reset();
		
		// if it exists, add 1 to count, update date
		if ($count > 0){
			$stmt = $conn->prepare("UPDATE trackHistory SET count = count+1 WHERE URI = ?");
			$stmt->bind_param('s', $_REQUEST['uri']);
			$stmt->execute();
			$stmt->reset();
		}
		// if not, add to table, set count to 1, and set date
		else{
			$stmt = $conn->prepare("INSERT INTO trackHistory (URI, count, date) VALUES (?, 1, ?)");
			$stmt->bind_param('ss', $_REQUEST['uri'], date("Y-m-d"));
			$stmt->execute();
			$stmt->reset();
		}
		
		// record activity
		$stmt = $conn->prepare("SELECT u_nickname FROM users WHERE u_ID = ?");
		$stmt->bind_param('s', $_SESSION['id']);
		$stmt->execute();
		$stmt->bind_result($username);
		$stmt->fetch();
		$stmt->reset();
		
		$track = $queue->getTracks($queue->count()-1, 1);
		recordActivity($username . " added " . $track[0]->title . " by " . $track[0]->artist . "");
		
	}
?>