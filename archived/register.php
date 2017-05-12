<?php
	session_start();
	include 'db.php';
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="index.css">
		<script src="formvalidation.js" type="text/javascript"></script>
		<title>Register User</title>
	</head>
	
	<body class="index">
	<div class="index-main-body">
		<div class="index-header">
			<h1 class="logo hide-text"> Ideagen Sonos Music Service </h1>
		</div>
		<div class="desk-front">
			<div class="view-signin">
				<form method"get" onsubmit='return validateRegister();'>

				<div class="group-inputs">
					<div class="email input-wrapper">
						<input type="text" id="fName" name="fName" aria-label="username" placeholder="First Name" required >
					</div>
					<div class="password input-wrapper">
						<input type="text" id="lName" name="lName" aria-label="username" placeholder="Last Name" required >
					</div>
				</div>

				<div class="Sign-in-button">
					<button class="sign-button submit" type="submit" name='submit'>Submit</button>
				</div>
				</form>
			</div>
		</div>
	</div>
		<?php
			include 'db.php';
			if(isset($_GET['submit'])){
				$stmt = $conn->prepare("INSERT INTO users (u_fname,  u_lname, u_email) VALUES ('" . $_GET['fName'] . "','" . $_GET['lName'] . "','" . $_SESSION['email'] . "')");
				$stmt->execute();
				$stmt->reset();
				
				$stmt = $conn->prepare("SELECT LAST_INSERT_ID()");
				$stmt->execute();
				$stmt->bind_result($u_id);
				$stmt->fetch();
				//$stmt->reset();
				
				$_SESSION['u_id'] = $u_id;
				
				header("Location: welcome.php");
			}
		?>
	</body>
</html>