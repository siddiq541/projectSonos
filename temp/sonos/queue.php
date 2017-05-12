<?php
	include 'db.php';
	include 'sonosconnect.php';
	$queue = $controller->getQueue();
	$count = $queue->count();
?>

<html>
	<head>
		<title>Queue</title>
		<link rel="stylesheet" type="text/css" href="../archived/index.css">
		<script src="sonos.js" type="text/javascript"></script>
		<script>
			// count used to determine if queue has changed
			var count = "<?php echo $count ?>";
			setInterval("refreshQueue(count);", 1000);
		</script>
	</head>
	<body>
		<?php
			$tracks = $queue->getTracks();
			// PRINT TABLE
			echo "Queue: <table>";
			echo "<tr><th width='80'>Added by</th><th width='150'>Song Name</th><th width='150'>Artist</th><th width='150'>Album</th></tr>";
			for ($i = 0; $i < $count; $i++) {
				// sql auto increment starts from 1, not 0
				$stmt = $conn->prepare("SELECT u_nickname FROM users WHERE u_ID = (SELECT user FROM queue WHERE position = " . 
					($i+1) . ")");
				$stmt->execute();
				$stmt->bind_result($username);
				$stmt->fetch();
				$stmt->reset();
				
				echo "<tr><td>$username</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->title) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->artist) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->album) . "</td></tr>";
			}
			echo "</table>";
		?>
	</body>
</html>