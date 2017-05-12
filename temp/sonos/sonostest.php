<?php
	session_start();
	include 'db.php';
?>
<html>
	<head>
		<title>Sonos Test</title>
		<script>
		// function to call restore script to restore system
		function restore(){
		    var xmlhttp = new XMLHttpRequest();
		    xmlhttp.open("GET", "restore.php", true);
		    xmlhttp.send();
		}
		function populate(id, script){
			document.getElementById(id).data = script;
		}
		</script>
	</head>
	<body>
		<?php
		// shows who is logged in 
			$stmt = $conn->prepare("SELECT u_fname, u_lname FROM users WHERE u_ID = '" . $_SESSION['id'] . "'");
			$stmt->execute();
			$stmt->bind_result($fname, $lname);
			$stmt->fetch();
			$stmt->reset();
			if ($fname != null && $lname != null){
				echo "Logged in as $fname $lname";
			}else{
				echo "Logged in as Guest";
			}
		?>
		
		<input type='button' onclick="window.location.href='logintest.php'" value='Logout'/>
		<input type='button' onclick='restore();' value='Restore'/>
		
		<table>
			<tr><th width='600'></th><th width='600'></th></tr>
			<tr height='575' valign='top'>
				<td><object width="100%" height="100%" type="text/html" id='dashboard'</object></td>
				<td><object width="100%" height="100%" type="text/html" data='spotifytest.php' ></object></td>
			</tr>
		</table>
		
			<object width="100%" height="100%" type="text/html" id='queue'></object>
			
			<!-- this allows the page to load while waiting on searching for the sonos, but nothing will be functional -->
			<script>populate('dashboard', 'dashboard.php')</script>
			<script>populate('queue', 'queue.php')</script>
	</body>
</html>