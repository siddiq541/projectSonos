<html>
	<head>
		<script>    
		    if(typeof window.history.pushState == 'function') {
		        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
		    }
			
			function addTrack(uri){
			    var xmlhttp = new XMLHttpRequest();
			    xmlhttp.open("GET", "addTrack.php?uri=" + uri, true);
			    xmlhttp.send();
			}
			
		</script>
		<title>Spotify Test</title>
	</head>
	
	<body>
		<form method='get'>
			Search by Artist: <input type='search' name='artist'value='<?php if(isset($_GET['album'])){ echo $_GET['album']; }?>'><br>
		</form>
		
		<form method='get'>
			Search by Album: <input type='search' name='album'value='<?php if(isset($_GET['album'])){ echo $_GET['album']; }?>'><br>
		</form>
		
		<form method='get'>
			Search by Track: <input type='search' name='track' value='<?php if(isset($_GET['track'])){ echo $_GET['track']; }?>'><br><br>
		</form>
		
		
		
		<?php
			require 'vendor/autoload.php';
			$api = new SpotifyWebAPI\SpotifyWebAPI();
		
			if(isset($_GET['artist'])){
				if($_GET['artist'] != null){
				$results = $api->search($_GET['artist'], 'artist');
				echo "Artists:<br>";
			
				foreach ($results->artists->items as $artist) {
				$id = $artist->id;
			
				$link_address = "https://api.spotify.com/v1/artists/$id/albums/";
				    echo "<a href='". $link_address. "'>$artist->name</a><br>";
				 }
			}
		}
			
			if(isset($_GET['album'])){
				if($_GET['album'] != null){
				$results = $api->search($_GET['album'], 'album');
				echo "Albums:<br>";
				foreach ($results->albums->items as $album) {
				 $album_id = $album->id;
				 $link_address2 = "albumtracks.php";
				  echo "<a href='". $link_address2. "'>$album->name</a><br>";
						
			}
		}
	}
		
			if(isset($_GET['track'])){
				if($_GET['track'] != null){
					$results = $api->search($_GET['track'], 'track');
					echo "Tracks:<br>";
					foreach ($results->tracks->items as $track) {
						$artist = $track->artists[0]->name;
						echo "$track->name by $artist";
						$uri = $track->id;
						
						?>
						<input type='button' onclick='addTrack("<?php echo $uri ?>");' value='Add to Queue'/><br>
						<?php
					}
				}
			}
		
			
			function redirect(){
				header('Location: spotifytest2.php');
				exit();
			}
		?>
	</body>
</html>
