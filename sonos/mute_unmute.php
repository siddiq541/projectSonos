<?php
	include 'sonosconnect.php';
	$speakerName = $_GET['speaker'];
	
	if ($speakerName == "allspeakers"){
		$speakers = $controller->getSpeakers();
		// check the current state of the speakers
		$isMuted = TRUE;
		
		foreach($speakers as $speaker){
			if($speaker->isMuted() == FALSE){
				$isMuted = FALSE;
			}
		}
		
		// mute or unmute each speaker depending on the current state
		if($isMuted == FALSE){
			foreach($speakers as $speaker){
				$speaker->mute();
			}
		}else{
			foreach($speakers as $speaker){
				$speaker->unmute();
			}
		}
	}
	else{
		$speaker = $sonos->getSpeakerByRoom($speakerName);
		if($speaker->isMuted() == FALSE){
			$speaker->mute();
		}else{
			$speaker->unmute();
		}
	}
	
?>