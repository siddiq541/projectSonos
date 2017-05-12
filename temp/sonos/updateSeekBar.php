<?php
// used to set current position and max value in seekbar on the dashboard
	include 'sonosconnect.php';
	$currentTrack = $controller->getStateDetails();
	echo "$currentTrack->duration, $currentTrack->position";
?>