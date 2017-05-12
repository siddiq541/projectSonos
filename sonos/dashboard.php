<?php
	session_start();
	include 'sonosconnect.php';
	//gets play button text
	if($controller->getState() == 202){
		$playtext = 'Pause';
	}else{
		$playtext = 'Play';
	}
	
	// gets volume for volume bar (assumes is on allspeakers so gets average)
	$speakers = $controller->getSpeakers();
	$totalVolume = 0;
	$i = 0;
	
	foreach($speakers as $speaker){
		$totalVolume += $speaker->getVolume();
		$i++;
	}
	
	$volume = $totalVolume / $i;
	
	// gets mute button text
	$mutetext = 'Unmute';
	
	foreach($speakers as $speaker){
		if($speaker->isMuted() == FALSE){
			$mutetext = 'Mute';
		}
	}
	
	// gets current track details
	$currentTrack = $controller->getStateDetails();
	// for checking if track has changed
	$_SESSION['trackuri'] = $currentTrack->uri;
	
	//get speakers
	$speakers = $controller->getSpeakers();
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">

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
		<div>
		<?php
			echo "<table><tr><th width='230'></th><th width='500'></th><th width='100'></th></tr>";
			
			// image
			echo "<tr><td><img width='200' id='albumArt' src=null></td>";
			
			echo "<td><br>";
			// seek bar
			// these span sections get filled in by setTimes()
			echo "<span id='position'></span> ";
			echo "<input type='range' id='seekBar' style='width: 360px; display:inline;' onchange='setPosition(this.value);'/>";
			echo "<span id='duration'></span>";
			echo "<script>setTimes(position, duration);";
			echo "updateSeekBar();</script>";
			echo "<br><br>";
			
			
			echo "<table><tr><th width='100'></th><th width='83'></th></tr><tr><td style='max-width: 260px'>";
			// now playing info
			echo "Now Playing: <br><br>";
			echo "Song: {$currentTrack->title}<br>";
			echo "Artist: {$currentTrack->artist}<br>";
			echo "Album: {$currentTrack->album}";
			echo "<br><br></td><td>";
			
			// box for likes/dislikes
			echo "</td><td>";
			echo "<p class=\"btn btn-primary\" >";
			
			// like/dislike
			echo "<input type='button' class=\"btn btn-primary\" id='like' onclick='like();' value='Like'/> ";
			echo "<input type='button' class=\"btn btn-primary\" id='dislike' onclick='dislike();' value='Dislike'/>";
			
			// display likes/dislikes
			echo "<br>";
			echo "Likes: <span id='likes'></span><br>";
			echo "<span id='dislikes'></span> to Skip";
			echo "<script>updateVotes();";
			echo "hasVoted();</script>";
			
			echo "</p></td></tr></table>";
			
			// drop down menu for selecting speaker
			echo "<select onchange='changeSpeaker();' id='changeSpeaker'>";
			echo "<option value='allspeakers'>All Speakers</option>";
			foreach ($speakers as $speaker){
				echo "<option value='$speaker->room'>$speaker->room</option>";
			}
			echo "</select> &nbsp";
			
			// volume controls
			echo "Volume : <input type='range'  id='volumeBar' style='width: 120px; display:inline;' oninput='adjustVolume(this.value);' onmouseup='recordVolumeChange();' value='$volume'/> &nbsp&nbsp";
			echo "<input type='button' class=\"btn btn-primary\" id='mute_unmute' onclick='mute_unmute();' value='$mutetext'> ";
			
			// play/pause
			echo "<input type='button' class=\"btn btn-primary\" id='play_pause' onclick='play_pause();' value='$playtext'/> ";
			echo "<br>";
			echo "<script>setSpeaker();";
			echo "changeSpeaker();</script>";
		?>
		</div>
	</body>
</html>