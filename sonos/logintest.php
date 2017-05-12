<?php
	session_start();
	include '../resources/db.php';
	$_SESSION['id'] = null;	
?>
<html>
	<head>
		<title>Login Test</title>
	</head>
	<body>
		<form method='get'>
			Enter First Name: <input type='text' name='name'>
		</form>
		
		<?php
			if(isset($_GET['name'])){
				if($_GET['name'] != null){
					$stmt = $conn->prepare("SELECT u_ID FROM users WHERE u_fname = '" . $_GET['name'] . "'");
					$stmt->execute();
					$stmt->bind_result($id);
					$stmt->fetch();
					$stmt->reset();
					$_SESSION['id'] = $id;
					header("Location: sonostest.php");
				}
			}
		?>
	</body>
</html>