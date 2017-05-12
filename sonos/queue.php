<?php
	include '../resources/db.php';
	include 'sonosconnect.php';
	$queue = $controller->getQueue();
	$count = $queue->count();
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">

		<title>Queue</title>
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
			echo "<table class=\"table table-bordered table-hover table-striped\" style=\"width:auto;\">";
			echo "<thead><tr><th width='100'>Added by</th><th width='170'>Song Name</th><th width='180'>Artist</th><th width='170'>Album</th></tr></thead>";
			for ($i = 0; $i < $count; $i++) {
				// sql auto increment starts from 1, not 0
				$stmt = $conn->prepare("SELECT u_nickname FROM users WHERE u_ID = (SELECT user FROM queue WHERE position = " . 
					($i+1) . ")");
				$stmt->execute();
				$stmt->bind_result($username);
				$stmt->fetch();
				$stmt->reset();
				
				echo "<tbody><tr><td>$username</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->title) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->artist) . "</td>";
				echo "<td>" . htmlspecialchars($tracks[$i]->album) . "</td></tr></tbody>";
			}
			echo "</table>";
		?>
	</body>
</html>
