<html>
<head>
	<title>Settings</title>
</head>
<body>
	<?php
		$file = fopen($_SERVER["DOCUMENT_ROOT"]."/resources/sonossettings.txt", "r");
		$dislikeThreshold = rtrim(fgets($file));
		$daysBeforeRemoved = rtrim(fgets($file));
		$controllerName = rtrim(fgets($file));
		$client = rtrim(fgets($file));
		$secret = rtrim(fgets($file));
		fclose($file);
		echo "<form method='post'>";
			echo "Dislike/Skip threshold: <input type='text' name='dislikeThreshold' value='$dislikeThreshold'><br>";
			echo "Days before track is removed from history: <input type='text' name='daysBeforeRemoved' value='$daysBeforeRemoved'><br>";
			echo "Main controller/speaker name: <input type='text' name='controllerName' value='$controllerName'><br>";
			echo "Spotify client: <input type='text' name='client' value='$client'><br>";
			echo "Spotify secret: <input type='text' name='secret' value='$secret'><br>";
			echo "<input type='submit' value='Submit'>";
		echo "</form>";

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if (isset($_POST['dislikeThreshold'])){
				$dislikeThreshold = $_POST['dislikeThreshold'];
			}
			if (isset($_POST['daysBeforeRemoved'])){
				$daysBeforeRemoved = $_POST['daysBeforeRemoved'];
			}
			if (isset($_POST['controllerName'])){
				$controllerName = $_POST['controllerName'];
			}
			if (isset($_POST['client'])){
				$client = $_POST['client'];
			}
			if (isset($_POST['secret'])){
				$secret = $_POST['secret'];
			}
			$file = fopen($_SERVER["DOCUMENT_ROOT"]."/resources/sonossettings.txt", "w");
			fwrite($file, $dislikeThreshold."\n");
			fwrite($file, $daysBeforeRemoved."\n");
			fwrite($file, $controllerName."\n");
			fwrite($file, $client."\n");
			fwrite($file, $secret."\n");
			fclose($file);
			header("Location: settings.php");
		}
	?>
	* http://localhost/sonos/generaterecommendations.php must be added as a redirect URL when adding this application as a Spotify app to get a client and secret
</body>
</html>