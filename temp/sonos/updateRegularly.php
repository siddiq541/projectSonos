<?php
// updates the position in the current song, the amount of time left (duration), the current volume, whether the sonos is playing and whether it is muted; this is updated on the dashboard
	include 'sonosconnect.php';
	$track = $controller->getStateDetails();
	$volume = $controller->getVolume();
	
	if($controller->getState() == 202){
		$playtext = 'Pause';
	}else{
		$playtext = 'Play';
	}
	
	if($controller->isMuted() == FALSE){
		$mutetext = 'Mute';
	}else{
		$mutetext = 'Unmute';
	}
	echo "$track->position,$track->duration,$volume,$playtext,$mutetext";
?>