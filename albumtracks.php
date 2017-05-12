<?php
include 'SpotifySearch.php';

if(isset($_GET['id2'])){
	if($_GET['id2'] != null){
		$id = $_GET['id2'];
		$tracks = $api->getAlbumTracks($id);
		echo "Tracks:<br>";
		foreach ($tracks->items as $track){
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
