<?php
	session_start();
	include 'sonosconnect.php';
	//gets queue for printing and counting queue
	$queue = $controller->getQueue();
	$count = $queue->count();
	// gets play button text
	if($controller->getState() == 202){
		$playtext = 'Pause';
	}else{
		$playtext = 'Play';
	}
	// gets mute button text
	if($controller->isMuted() == FALSE){
		$mutetext = 'Mute';
	}else{
		$mutetext = 'Unmute';
	}
	// gets volume for volume bar
	$volume = $controller->getVolume();
	// gets current track details
	$currentTrack = $controller->getStateDetails();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../index.css">
		<script>
		//makes sure album artwork loading delay does not affect page functionality
		setTimeout("setImage()", 10);
		// refresh page if song changes, check every 3 seconds
		var count = "<?php echo $count ?>"
		setInterval("refresh();", 3000);
		function refresh() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		       if (this.readyState == 4 && this.status == 200) {
				   if (this.responseText == true){
					   window.location.reload();
				   }
		       }
		    };
		    xmlhttp.open("GET", "refresh.php?count=" + count, true);
		    xmlhttp.send();
		}
		
		//keeps updating current position in track
		setInterval("updateRegularly();", 1000);
		function updateRegularly() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		       if (this.readyState == 4 && this.status == 200) {
				   var array = this.responseText.split(',');
				   document.getElementById("position").innerHTML = array[0];
				   document.getElementById("seekBar").value = positionToSeconds(array[0]);
				   document.getElementById("volumeBar").value = array[1];
				   document.getElementById("play_pause").value = array[2];
				   document.getElementById("mute_unmute").value = array[3];
		       }
		    };
		    xmlhttp.open("GET", "updateRegularly.php", true);
		    xmlhttp.send();
		}
		
		function play_pause() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "play_pause.php", true);
		    xmlhttp.send();
		}
		
		function skip() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "skip.php", true);
		    xmlhttp.send();
		}
		
		function mute_unmute() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "mute_unmute.php", true);
		    xmlhttp.send();
		}
		
		function adjustVolume(val) {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "adjustVolume.php?val=" + val, true);
		    xmlhttp.send();
		}
		
		function addSong(val) {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		       if (this.readyState == 4 && this.status == 200) {
				   document.getElementById("addSong").value = "";
		       }
		    };
		    xmlhttp.open("GET", "addSong.php?val=" + val, true);
		    xmlhttp.send();
		}
		
		function setPosition(val) {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "setPosition.php?val=" + val, true);
		    xmlhttp.send();
		}
		
		function positionToSeconds(val){
			var array = val.split(':');
			return ((parseInt(array[1]*60) + parseInt(array[2])));
		}
		
		//function secondsToPosition(val){
		//		var seconds = val % 60;
		//       var minutes = (val - seconds) / 60;
		//        return '00:' + minutes.toString() + ':' + seconds.toString();
		//}
		
		function updateSeekBar(){
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		       if (this.readyState == 4 && this.status == 200) {
				   var array = this.responseText.split(',');
				   document.getElementById("seekBar").max = positionToSeconds(array[0]);
				   document.getElementById("seekBar").value = positionToSeconds(array[1]);
		       }
		    };
		    xmlhttp.open("GET", "updateSeekBar.php", true);
		    xmlhttp.send();
		}
		
		function setImage(){
			albumArt = "<?php echo $currentTrack->albumArt ?>";
			document.getElementById('albumArt').src =  albumArt;
		}
		</script>
		<title>Sonos Test</title>
	</head>
	
	<body>
		<?php echo "<input type='button' id='play_pause' onclick='play_pause();' value='$playtext'/>"?>
		<input type='button' onclick='skip();' value='Vote to Skip'/>
		<?php echo "<input type='button' id='mute_unmute' onclick='mute_unmute();' value='$mutetext'>"?>
		
		<br><br>
		<?php echo "Volume : <input type='range'  id='volumeBar' oninput='adjustVolume(this.value);' value='$volume'/>"?>
		
		<br><br>
		Add Song: <input type='text' id='addSong' onchange='addSong(this.value);'>
		<br><br>
		
		<?php
			//show now playing details, with artwork and seekbar
			echo "Now Playing: <span id='track'>{$currentTrack->title} from {$currentTrack->album} by {$currentTrack->artist}</span><br>";	
			echo "<span id='position'>$currentTrack->position</span> ";
			echo "<input type='range' id='seekBar' onchange='setPosition(this.value);'/>";
			echo " $currentTrack->duration <br><br>";
			//echo $currentTrack->albumArt;
			echo "<img width='500' id='albumArt'><br><br>";
			echo "<script>updateSeekBar();</script>";
			
			//count queue
			echo "Songs in queue: $count<br><br>";
			
			$tracks = $queue->getTracks();
			// PRINT TABLE
			echo "Up Next: <table>";
			echo "<tr><th width='20'>&nbsp</th><th width='150'>Song Name</th><th width='150'>Artist</th><th width='150'>Album</th></tr>";
			for ($i = 1; $i < $count; $i++) {
				echo "<tr><td>$i</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->title) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->artist) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->album) . "</td></tr>";
			}
			echo "</table>";
			
			//passes this to refresh.php
			$_SESSION['trackuri'] = $currentTrack->uri;
		?>
	</body>
</html>
