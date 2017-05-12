<html>
	<head>
		
		<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
			<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
			<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
			<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">

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
		<form  class="form-horizontal text-justify" role="form" method='get'>
			<input type="search" class="form-control" id="inputEmail3" placeholder="Search by Artist" name='artist'value='<?php if(isset($_GET['album'])){ echo $_GET['album']; }?>'>
		</form>
		
		<form  class="form-horizontal text-justify" role="form" method='get'>
			<input type='search'  class="form-control" id="inputPassword3" placeholder="Search by Album" name='album'value='<?php if(isset($_GET['album'])){ echo $_GET['album']; }?>'>
		</form>
		
		<form class="form-horizontal text-justify" role="form" method='get'>
			<input type='search' class="form-control" id="inputPassword3" placeholder="Search by Track" name='track' value='<?php if(isset($_GET['track'])){ echo $_GET['track']; }?>'><br>
		</form>
		
		
		
		<?php
			require 'vendor/autoload.php';
			$api = new SpotifyWebAPI\SpotifyWebAPI();
			
			
			
			if(isset($_GET['artist'])){
				if($_GET['artist'] != null){
				
				$results = $api->search($_GET['artist'], 'artist');
				echo "Artists:<br>";
				
				foreach ($results->artists->items as $artist) {
	
				echo "<a href='artistalbums.php?id1=$artist->id'>$artist->name</a><br>";
				
			  }
		   }
		}
		
			
			if(isset($_GET['album'])){
				if($_GET['album'] != null){
					
				$results = $api->search($_GET['album'], 'album');
				echo "Albums:<br>";
				
				foreach ($results->albums->items as $album) {
				
				echo "<a href='albumtracks.php?id2=$album->id'>$album->name</a><br>";
						
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
						<div class="col-md-11 text-right">
						<input type='button' class="btn btn-primary btn-xs" onclick='addTrack("<?php echo $uri ?>");' value='Add to Queue'/><br>
						</div>
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
