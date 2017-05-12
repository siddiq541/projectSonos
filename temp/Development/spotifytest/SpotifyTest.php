<?php
    
	include 'SpotifyProtol.php';
    $track = Spotify::searchTrack('Taylor Swift');
    $uri = Spotify::getUri($track); 
	$track_id = substr($track_uri, strripos($track_uri, ':'));
    echo "<a href="/{$track_id}"/>Play Song with Spotify</a>";
?>