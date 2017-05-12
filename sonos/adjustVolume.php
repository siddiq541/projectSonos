<?php
	session_start();
	include 'sonosconnect.php';
	include 'sonosFunctions.php';
	$speakerName = $_GET['speaker'];
	
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
		
		// adjust all speakers by the difference
		$controller->adjustVolume($_REQUEST['val'] - $volume);
	}
	else{
		$speaker = $sonos->getSpeakerByRoom($speakerName);
		$speaker->setVolume($_REQUEST['val']);
	}
?>