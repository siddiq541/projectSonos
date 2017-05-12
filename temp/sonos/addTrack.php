<?php
// takes a spotify uri for a track and adds it to the sonos queue and queue table
	session_start();
	include 'db.php';
	include 'sonosconnect.php';
	use duncan3dc\Sonos\Tracks\Spotify;
	$queue = $controller->getQueue();
	if ($queue->addTrack(new Spotify($_REQUEST['uri']))){
		$stmt = $conn->prepare("INSERT INTO queue (user) VALUES ('" . $_SESSION['id'] . "')");
		$stmt->execute();
	}
?>