
<?php
include 'spotifytest2.php';
	
			$tracks = $api->getAlbumTracks('1oR3KrPIp4CbagPa3PhtPp');

			foreach ($tracks->items as $track) {
			echo '<b>' . $track->name . '</b> <br>';
		}
		
	
?>