<?php
	session_start();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../index.css">
		<script>
		// refresh page if song changes, check every 3 seconds
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
		    xmlhttp.open("GET", "refresh.php", true);
		    xmlhttp.send();
		}
		
		//keeps updating current position in track
		setInterval("updateTime();", 1000);
		function updateTime() {
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		       if (this.readyState == 4 && this.status == 200) {
				   document.getElementById("position").innerHTML = this.responseText;
		       }
		    };
		    xmlhttp.open("GET", "updateTime.php", true);
		    xmlhttp.send();
		}
		</script>
		<title>Sonos Test</title>
	</head>
	
	<body>
		<META HTTP-EQUIV="refresh" CONTENT="1000">
		<form method='get'>
			<input type='submit' name='play/pause' value='Play/Pause'>
			<input type='submit' name='previous' value='Previous'>
			<input type='submit' name='next' value='Next'>
			<input type='submit' name='mute/unmute' value='Mute/Unmute'>
			<input type='submit' name='volumeUp' value='Volume Up'>
			<input type='submit' name='volumeDown' value='Volume Down'>
			<input type='submit' name='clear' value='Clear Queue'>
			
		</form>
		
		<form method='get'>
			Set Volume: <input type='text' name='setVolume'>
		</form>
		
		<form method='get'>
			Add Song: <input type='text' name='spotifyURI'>
		</form>
		
		<form method='get'>
			Skip to: <input type='text' name='seek'>
		</form>
		
		<?php
			include 'sonosconnect.php';
			use duncan3dc\Sonos\Network;
			use duncan3dc\Sonos\Tracks\Spotify;
	
			$speakers = $sonos->getSpeakers();
			$queue = $controller->getQueue();
			
			//play/pause
			if(isset($_GET['play/pause'])){
				if($controller->getState() == 202){
					$controller->pause();
				}else{
					$controller->play();
				}
				redirect();
			}
			
			//previous
			if(isset($_GET['previous'])){
				$controller->previous();
				redirect();
			}
			
			//next
			if(isset($_GET['next'])){
				$controller->next();
				$queue->removeTrack(0);
				redirect();
			}
			
			//mute/unmute
			if(isset($_GET['mute/unmute'])){
				if($controller->isMuted() == FALSE){
					$controller->mute();
				}else{
					$controller->unmute();
				}
				redirect();
			}
			
			//volume up
			if(isset($_GET['volumeUp'])){
				$controller->adjustVolume(10);
				redirect();
			}
			
			//volume down
			if(isset($_GET['volumeDown'])){
				$controller->adjustVolume(-10);
				redirect();
			}
			
			//set volume
			if(isset($_GET['setVolume'])){
				$controller->setVolume($_GET['setVolume']);
				redirect();
			}
			
			//print volume
			$volume = $controller->getVolume();
			echo "Volume : $volume<br>";
			
			//count queue
			$count = $queue->count();
			echo "Songs in queue: $count<br><br>";
			
			//clear queue
			if(isset($_GET['clear'])){
				$queue->clear();
				redirect();
			}
			
			//add song
			if(isset($_GET['spotifyURI'])){
				$track = new Spotify($_GET['spotifyURI']);
				$queue->addTrack($track);
				redirect();
			}
			
			//skip to part of song
			if(isset($_GET['seek'])){
				$controller->seek($_GET['seek']);
				redirect();
			}
			
			$currentTrack = $controller->getStateDetails();
			echo "Now Playing: {$currentTrack->title} from {$currentTrack->album} by {$currentTrack->artist}<br>";	
			echo "<span id='position'>$currentTrack->position</span>";
			echo " / $currentTrack->duration <br><br>";
			echo "<img width='500' src='{$currentTrack->albumArt}'><br><br>";
			
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
			
			//prevents duplicate form submissions
			function redirect(){
				header('Location: sonostest.php');
				exit();
			}
			
			$_SESSION['trackuri'] = $currentTrack->uri;
	
		?>
	</body>
</html>
