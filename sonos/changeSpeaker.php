<?php
	include 'sonosconnect.php';
	$speakerName = $_GET['speaker'];

	if ($speakerName == "allspeakers"){
		$volume = $controller->getVolume();
		if($controller->isMuted() == FALSE){
			$mutetext = 'Mute';
		}else{
			$mutetext = 'Unmute';
		}
	}
	else{
		$speaker = $sonos->getSpeakerByRoom($speakerName);
		$volume = $speaker->getVolume();
		if($speaker->isMuted() == FALSE){
			$mutetext = 'Mute';
		}else{
			$mutetext = 'Unmute';
		}
	}
	
	echo "$volume, $mutetext";
?>