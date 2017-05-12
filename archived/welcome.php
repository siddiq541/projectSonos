<?php
	session_start();
	include 'db.php';
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="index.css">
		<title>Welcome</title>
	</head>
	
	<body class="index">
		<div class="index-main-body">
			<div class="index-header">
				<h1 class="logo hide-text"> Ideagen Sonos Music Service </h1>
			</div>
			<div class="desk-front">
				<?php
				
					$stmt = $conn->prepare("SELECT u_fname, u_lname FROM users WHERE u_id = '" . $_SESSION['u_id'] . "'");
					$stmt->execute();
					$stmt->bind_result($fName, $lName);
					$stmt->fetch();
					$stmt->reset();
			
					echo "<p>Welcome $fName $lName</p>";
				?>

				<div class="Sign-in-button">
					<form>
						<button class="sign-button submit" type="submit" value="logout" name='logout'>Log out!</button>
						<button class="sign-button submit" type="submit" value="unregister" name='unregister'>Unregister</button>
					</form>
				</div>
			</div>
		</div>
		<?php
			if(isset($_GET['unregister'])){
				$stmt = $conn->prepare("DELETE FROM users WHERE u_id = '" . $_SESSION['u_id'] . "'");
				$stmt->execute();
				$stmt->reset();
			
				header("Location: login.php");
			}
			if(isset($_GET['logout'])){
				session_destroy();
				header("Location: login.php");
			}
		?>
	</body>
</html>