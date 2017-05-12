<html>
	<head>
		<script>    
		    if(typeof window.history.pushState == 'function') {
		        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
		    }
		</script>
		<title>Spotify Test</title>
	</head>
	
	<body>
		<form method='get'>
			Search by Track: <input type='text' name='track'><br>
		</form>
		
		<form method='get'>
			Search by Artist: <input type='text' name='artist'><br>
		</form>
		
		<form method='get'>
			Search by Album: <input type='text' name='album'><br>
		</form>
		
		<?php
			require 'vendor/autoload.php';
			$api = new SpotifyWebAPI\SpotifyWebAPI();
			
			if(isset($_GET['track'])){
				$results = $api->search($_GET['track'], 'track');
				echo "Tracks:<br>";
				foreach ($results->tracks->items as $track) {
				    echo "$track->name <br>";
				}
			}
			
			if(isset($_GET['artist'])){
				$results = $api->search($_GET['artist'], 'artist');
				echo "Artists:<br>";
				foreach ($results->artists->items as $artist) {
				    echo "$artist->name <br>";
				}
			}
			
			if(isset($_GET['album'])){
				$results = $api->search($_GET['album'], 'album');
				echo "Albums:<br>";
				foreach ($results->albums->items as $album) {
				    echo "$album->name <br>";
				}
			}
			
			function redirect(){
				header('Location: spotifytest.php');
				exit();
			}
		?>
	</body>
</html>
