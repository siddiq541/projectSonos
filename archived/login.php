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
				<form method"get" onsubmit='return validateLogin();'>
					<div class="group-inputs">
						<div class="email input-wrapper">
							<input type="text" id="email" name="email" aria-label="username" placeholder="Email" required >
						</div>
						<div class="Sign-in-button">
							<button class="sign-button submit" type="submit" name='submit'>Sign In</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php
			include 'db.php';
			if(isset($_GET['submit'])){
				$stmt = $conn->prepare("SELECT u_id FROM users WHERE u_email = '" . $_GET['email'] . "'");
				$stmt->execute();
				$stmt->bind_result($u_id);
				$stmt->fetch();
				$stmt->reset();
				
				if($u_id == NULL){
					$_SESSION['email'] = $_GET['email'];
					header("Location: register.php");
				}
				else{
					$_SESSION['u_id'] = $u_id;
					header("Location: welcome.php");
				}
			}
		?>
	</body>
</html>