<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
</head>

<body style="background-color: transparent;">
	<div class="panel panel-primary" style="height: 100%">
		<div class="panel-heading">
			<h3 class="panel-title">Account</h3>
		</div>
		<div class="panel-body"  style="height: 100%">
			<?php
			include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
			session_start();
			$id = $_SESSION["id"];
			// query table for user's information.
			$stmt = $conn->prepare('SELECT u_fname, u_lname, u_nickname, is_admin FROM users WHERE u_ID = ?;');
			$stmt->bind_param('s',$id);
			$stmt->execute();
			$stmt->bind_result($fName,$lName,$dName,$isAdmin);
			// fetch has to be handled in a while.
			while ($stmt->fetch())

				// find user type.
				if(htmlspecialchars($isAdmin) == 1)
					$userType = "Administrator";
				else
					$userType = "Standard";

			echo "<table class=\"table table-bordered table-hover table-striped\" style=\"width:auto;\">
				 <tr> <th>Name</th> <th colspan='2'>Display Name</th> <th>Account Type</th></tr>";

			// display information.
			echo "<tr><td>" . htmlspecialchars($fName) . " " .  htmlspecialchars($lName) . "</td>";

			 $checkedName = htmlspecialchars($dName);
			// display nickname in textbox.
			echo "<form method='post'><td> <input class=\"form-control input-sm\" id=\"exampleInputEmail1\" placeholder=\"Enter Name\" type='text' name='nickname' value='$checkedName'>";
			echo "<td> <input type='submit' class=\"btn btn-primary btn-xs\" name='submit' value='Save'> </td></form>";
			
			echo "<td> " . $userType . "</td></tr>";

			// link to delete account. Not implemented.
			// echo "<a class=\"btn btn-primary btn-xs\" href=''>Delete account</a>";
			// processing form data.
			if(isset($_POST['submit']))
			{
				include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
				$stmt = $conn->prepare('UPDATE users SET u_nickname = ? WHERE u_ID = ?;');
				$stmt->bind_param('ss', $_POST['nickname'], $id);
				$stmt->execute();

				// refresh.
				$url = "http://" . $_SERVER['HTTP_HOST'] . "/account.php";
				header("Location: $url");
			}
			?>

		</div>
	</div>
</body>
</html>