<html>
	<head>
		<title>Settings</title>
	</head>
	
	<body>
		<?php
			$file = fopen($_SERVER["DOCUMENT_ROOT"]."/resources/sonossettings.txt", "r");
			$dislikethreshold = rtrim(fgets($file));
			$daysbeforeremoved = rtrim(fgets($file));
			$controllername = rtrim(fgets($file));
			$client = rtrim(fgets($file));
			$secret = rtrim(fgets($file));
			fclose($file);
			
			echo "<form method='post'>";
				echo "Dislike/Skip threshold: <input type='text' name='dislikethreshold' value='$dislikethreshold'><br>";
				echo "Days before track is removed from history: <input type='text' name='daysbeforeremoved' value='$daysbeforeremoved'><br>";
				echo "Main controller/speaker name: <input type='text' name='controllername' value='$controllername'><br>";
				echo "Spotify client: <input type='text' name='client' value='$client'><br>";
				echo "Spotify secret: <input type='text' name='secret' value='$secret'><br>";
				echo "<input type='submit' value='Submit'>";
			echo "</form>";
			
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				if (isset($_POST['dislikethreshold'])){
					$dislikethreshold = $_POST['dislikethreshold'];
				}
				if (isset($_POST['daysbeforeremoved'])){
					$daysbeforeremoved = $_POST['daysbeforeremoved'];
				}
				if (isset($_POST['controllername'])){
					$controllername = $_POST['controllername'];
				}
				if (isset($_POST['client'])){
					$client = $_POST['client'];
				}
				if (isset($_POST['secret'])){
					$secret = $_POST['secret'];
				}
			
			
				$file = fopen($_SERVER["DOCUMENT_ROOT"]."/resources/sonossettings.txt", "w");
				fwrite($file, $dislikethreshold."\n");
				fwrite($file, $daysbeforeremoved."\n");
				fwrite($file, $controllername."\n");
				fwrite($file, $client."\n");
				fwrite($file, $secret."\n");
				fclose($file);
				
				header("Location: settings.php");
			}
		?>
		
		* http://localhost/sonos/generaterecommendations.php must be added as a redirect URL when adding this application as a Spotify app to get a client and secret
	</body>
</html>