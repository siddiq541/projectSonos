<?php
	include '../resources/db.php';
	
	// connecting to spotify
	require '../vendor/autoload.php';
	
	// read client and secret
	$file = fopen("../resources/sonossettings.txt", "r");
	// get rid of first three lines
	fgets($file);
	fgets($file);
	fgets($file);
	
	$client = rtrim(fgets($file));
	$secret = rtrim(fgets($file));
	
	fclose($file);
	
	$session = new SpotifyWebAPI\Session($client, $secret, 'http://localhost/sonos/generaterecommendations.php');
	$api = new SpotifyWebAPI\SpotifyWebAPI();

	$scopes = array();
	
	$session->requestCredentialsToken($scopes);
	$accessToken = $session->getAccessToken();
	$api->setAccessToken($accessToken);
	
	$stmt = $conn->prepare("SELECT COUNT(URI) FROM trackhistory");
	$stmt->execute();
	$stmt->bind_result($trackHistoryCount);
	$stmt->fetch();
	$stmt->reset();
	
	if ($trackHistoryCount > 0){
		// array to store tracks from trackhistory
		$tracks = array(
			array(), // 0 keeps URI
			array() // 1 keeps points
		);
	
		// array to store URIs of tracks that will be used as seeds
		$seedTracks = array();
	
		// array to store recommended tracks
		$recommendedTracks = array(); 
	
		// get all tracks from trackhistory, ignore tracks with negative ratings
		$i = 0;
		$stmt = $conn->prepare("SELECT uri, count, votes FROM trackhistory WHERE votes >= 0");
		$stmt->execute();
		$stmt->bind_result($uri, $count, $votes);
		// store in array
		while($stmt->fetch()){
			$tracks[$i][0] = $uri;
			$tracks[$i][1] = $count + $votes;
			$i++;
		}
		$stmt->reset();
	
		// function to sort the tracks from track history
		function cmp($tracka, $trackb){
			if ($tracka[1] == $trackb[1]) {
			        return 0;
			    }
			    return ($trackb[1] < $tracka[1]) ? -1 : 1;
		}
		// sort the array
		usort($tracks, "cmp");
	
		// calculate how many tracks (10% of the array) we want to use as seeds
		$arraySize = count($tracks);
		$seedTracksNumber = ceil($arraySize / 10);
	
		// delete the tracks that aren't in the top 10%
		$tracks = array_slice($tracks, 0, $seedTracksNumber);
	
		// put all the URIs into an array
		$i = 0;
		foreach ($tracks as $track) {
		    $seedTracks[$i] = $track[0];
			$i++;
		}
	
		// get recommendations using seedtracks
		$recommendations = $api->getRecommendations([
		    'seed_tracks' => $seedTracks,
			'limit' => 100]);
		
		// store recommendations into array
		$i = 0;
		foreach($recommendations->tracks as $track){
			$recommendedTracks[$i] = $track->id;
			$i++;
		}
	
		// make arrays into strings to allow inserting into db in single statements
		$seedsstring = implode("'),('", $seedTracks);
		$recommendationsstring = implode("'),('", $recommendedTracks);
	
		// delete contents of recommendedTracks
		$stmt = $conn->prepare("TRUNCATE recommendedTracks");
		$stmt->execute();
		$stmt->reset();
	
		// insert seeds into recommended tracks table
		$stmt = $conn->prepare("INSERT INTO recommendedTracks (track) VALUES ('" . $seedsstring . "')");
		$stmt->execute();
		$stmt->reset();
	
		// insert recommendations into recommended tracks table
		$stmt = $conn->prepare("INSERT INTO recommendedTracks (track) VALUES ('" . $recommendationsstring . "')");
		$stmt->execute();
		$stmt->reset();
	}
	else {
		// no tracks in trackhistory
	}
	
?>