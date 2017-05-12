<?php
	session_start();
	include 'sonosconnect.php';
	//gets play button text
	if($controller->getState() == 202){
		$playtext = 'Pause';
	}else{
		$playtext = 'Play';
	}
	//gets mute button text
	if($controller->isMuted() == FALSE){
		$mutetext = 'Mute';
	}else{
		$mutetext = 'Unmute';
	}
	// gets volume for volume bar
	$volume = $controller->getVolume();
	// gets current track details
	$currentTrack = $controller->getStateDetails();
	// for checking if track has changed
	$_SESSION['trackuri'] = $currentTrack->uri;
?>
<html>
	<head>
		<title>Dashboard</title>
		<script src="sonos.js" type="text/javascript"></script>
		<script>
		var albumArt = "<?php echo $currentTrack->albumArt ?>";
		setTimeout("setImage(albumArt)", 10);
		// queuenumber also for checking if track has changed (if two tracks are identical)
		var number = "<?php echo $currentTrack->queueNumber ?>";
		setInterval("refreshDashboard(number);", 3000);
		setInterval("updateRegularly();", 1000);
		// need to initialise these to initially set the position and duration times 
		var position = "<?php echo $currentTrack->position ?>";
		var duration = "<?php echo $currentTrack->duration ?>";
		</script>
	</head>
	
	<body>
		<?php
			echo "<input type='button' id='play_pause' onclick='play_pause();' value='$playtext'/>";
			echo "<input type='button' onclick='skip();' value='Skip'/>";
			echo "<input type='button' id='mute_unmute' onclick='mute_unmute();' value='$mutetext'>";
			echo "<br><br>";
			
			echo "Volume : <input type='range'  id='volumeBar' oninput='adjustVolume(this.value);' value='$volume'/>";
			echo "<br><br>";
			
			echo "<img width='400' id='albumArt'>";
			echo "<br><br>";
			
			echo "Now Playing: {$currentTrack->title} from {$currentTrack->album} by {$currentTrack->artist}";
			echo "<br>";
			// these span sections get filled in by setTimes()
			echo "<span id='position'></span> ";
			echo "<input type='range' id='seekBar' onchange='setPosition(this.value);'/>";
			echo "<span id='duration'></span>";
			echo "<script>setTimes(position, duration);";
			echo "updateSeekBar();</script>";
		?>
	</body>
</html>