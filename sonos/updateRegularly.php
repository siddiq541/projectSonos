<?php
// updates the position in the current song, the amount of time left (duration), the current volume, whether the sonos is playing and whether it is muted; this is updated on the dashboard
	include 'sonosconnect.php';
	$track = $controller->getStateDetails();
	$speakerName = $_GET['speaker'];
	
	if($controller->getState() == 202){
		$playtext = 'Pause';
	}else{
		$playtext = 'Play';
	}
	
	if ($speakerName == "allspeakers"){
		// need to get average of all speakers
		$speakers = $controller->getSpeakers();
		$totalVolume = 0;
		$i = 0;
		foreach($speakers as $speaker){
			$totalVolume += $speaker->getVolume();
			$i++;
		}
		$volume = $totalVolume / $i;
		
		// only shows as muted if all speakers are muted
		$mutetext = 'Unmute';
		foreach($speakers as $speaker){
			if($speaker->isMuted() == FALSE){
				$mutetext = 'Mute';
			}
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
	echo "$track->position,$track->duration,$volume,$playtext,$mutetext";
?>