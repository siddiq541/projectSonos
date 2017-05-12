<?php
include 'SpotifySearch.php';

		
					if(isset($_GET['id1'])){
					if($_GET['id1'] != null){
						
					$id = $_GET['id1'];
					$albums = $api->getArtistAlbums($id);
					
					echo "Albums:<br>";
					foreach ($albums->items as $album) {
						
						
					echo "<a href='albumtracks.php?id2=$album->id'>$album->name</a><br>";
						
					}
					
					$tracks = $api->getArtistTopTracks($id, array('country' => 'se'));
					echo "<br> Artist Top Tracks:<br>";
					
					foreach ($tracks->tracks as $track) {
						
					$artist = $track->artists[0]->name;
					echo "$track->name by $artist";
					$uri = $track->id;
						
						?>
						<div class="col-md-11 text-right">
						<input type='button' class="btn btn-primary btn-xs" onclick='addTrack("<?php echo $uri ?>");' value='Add to Queue'/><br>
						</div>
						<?php
		}
					}
					}
	
			
?>
