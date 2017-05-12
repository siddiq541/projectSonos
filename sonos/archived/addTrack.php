<?php
	include 'sonosconnect.php';
	use duncan3dc\Sonos\Tracks\Spotify;
	$queue = $controller->getQueue();
	$queue->addTrack(new Spotify($_REQUEST['uri']));
?>