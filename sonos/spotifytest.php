<?php
	session_start();
?>
<html>
	<head>
		<script>
			// resets the form variables to ensure refreshing doesn't send form again
		    if(typeof window.history.pushState == 'function') {
		        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
		    }
			// sends id of track to script that connects to sonos and db
			function addTrack(uri){
			    var xmlhttp = new XMLHttpRequest();
			    xmlhttp.open("GET", "addTrack.php?uri=" + uri, true);
			    xmlhttp.send();
			}
		</script>
		<title>Spotify Test</title>
	</head>
	
	<body>
		<!-- the php here is so that after a form is sent, the search text remains -->
		<form method='get'>
			Search by Track: <input type='search' name='track' value='<?php if(isset($_GET['track'])){ echo $_GET['track']; }?>'><br><br>
		</form>
		
		<?php
			require_once __DIR__ . "/../vendor/autoload.php";
			$api = new SpotifyWebAPI\SpotifyWebAPI();
			
			if(isset($_GET['track'])){
				// ensures user can't enter nothing (this crashes page)
				if($_GET['track'] != null){
					$results = $api->search($_GET['track'], 'track');
					echo "Tracks:<br>";
					foreach ($results->tracks->items as $track) {
						$artist = $track->artists[0]->name;
						echo "$track->name by $artist";
						$uri = $track->id;?>
						<!-- calls addTrack() and passes the uri of track -->
						<input type='button' onclick='addTrack("<?php echo $uri ?>");' value='Add to Queue'/><br>
						<?php
					}
				}
			}
		?>
	</body>
</html>
