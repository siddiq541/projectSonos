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
<div class="panel panel-primary" >
    <div class="panel-heading">
        <h3 class="panel-title">Mange Accounts</h3>
    </div>
    <div class="panel-body" >   

    <h3>Users</h3>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
        session_start();
        $id = $_SESSION["id"];

        //Query table.
        $stmt = $conn->prepare('SELECT is_admin FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($isAdmin);
        while ($stmt->fetch())//Fetch has to be handled in a while.

        //Redirect if not admin.
        if(htmlspecialchars($isAdmin) != 1)
        {
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/home.php";
            header("Location: $url");
        }

        echo "<table class=\"table table-bordered table-hover table-striped\" style=\"width:auto;\">
              <tr> <th>Name</th> <th>Display Name</th> <th>Admin</th>  <th>Delete</th></tr>";

        //Query table for user data.
        $stmt = $conn->prepare('SELECT * FROM users WHERE u_ID  != ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($id,$fname,$lname,$nickname,$avatar,$isAdmin,$isLoggedIn);
        while ($stmt->fetch())//Fetch has to be handled in a while.
        {
            //Post id as hidden value.
            echo "<form method='post'><input type='hidden' name='id' value='$id' />";

            //Display name.
            echo "<tr><td>".$fname." ".$lname."</td><td>";

            //Display nickname in textbox.
            $checkedName = htmlspecialchars($nickname);
            echo "<input   class=\"form-control input-sm\" id=\"exampleInputEmail1\" placeholder=\"Enter Name\" type='text' name='nickname' value='$checkedName'></td><td>";
           
            //Display isAdmin using a checkbox.
            echo "<input type='checkbox' name='isAdmin' ";
            if(htmlspecialchars($isAdmin) == 1){echo ' checked';};
            echo "></td>";

            //Delete box.
            echo "<td><input type='checkbox' name='delete'></td>";
            
            //Submit button.
            echo "<td><input type='submit' class=\"btn btn-primary btn-xs\" name='submit' value='Save'></td></tr>";
            echo "</form>";
        }
        echo "</table>";
        

        //Processing Users form data.
        if(isset($_POST['submit']))
        {
            //Save details and set is_loggedIn to 1.

            if(isset($_POST['isAdmin']))
                $isAdmin = 1;
            else
                $isAdmin = 0;

            include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
            $stmt = $conn->prepare('UPDATE users SET u_nickname = ?, is_admin = ? WHERE u_ID = ?;');
            $stmt->bind_param('sis', $_POST['nickname'], $isAdmin, $_POST["id"]);
            $stmt->execute();

            //Refresh.
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/manage.php";
            header("Location: $url");

            if(isset($_POST['delete']))
            {
                include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
                $stmt = $conn->prepare('DELETE FROM users WHERE u_ID = ?');
                $stmt->bind_param('s', $_POST["id"]);
                $stmt->execute();

                //Refresh.
                $url = "http://" . $_SERVER['HTTP_HOST'] . "/manage.php";
                header("Location: $url");
            }
        }


    echo "<h3>Add User</h3>";
    echo '<table class=\"table table-bordered table-hover table-striped\" style=\"width:auto;\">';
    echo "<tr> <th>Email</th> <th>Admin?</th></tr>";
    echo "<form method='post'><input type='hidden' name='id' value='$id' />";
    echo '<tr><td><input class=\"form-control input-sm\" id=\"exampleInputEmail1\" placeholder="Email" type="text" name="inviteEmail"></td>';
    echo "<td><input type='checkbox' name='adminInvite'></td>";
    echo "<td><input type='submit' class=\"btn btn-primary btn-xs\" name='submitAdd' value='Invite'></td></tr>";
    echo "</table></form>";

    //Processing Add Users form data.
    if(isset($_POST['submitAdd']) && isset($_POST['inviteEmail']))
    {
        if(isset($_POST['adminInvite']))
        {
            include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
            $stmt = $conn->prepare('INSERT INTO pendingAdmin (p_email,p_requestedBy) VALUES (?,?)');
            $stmt->bind_param('ss', $_POST['inviteEmail'], $_POST['id']);
            $stmt->execute();
            echo $_POST["inviteEmail"]." was invited as an admin.";
            $subject = 'Ideagen Sonos Music Service Invite - Admin';
        }
        else
        {
            echo $_POST["inviteEmail"]." was invited as a standard user.";   
            $subject = 'Ideagen Sonos Music Service Invite - Standard User';    
        }

        //Prepare Email.
        //Correct URL will have to be provided here and headers will need to be changed.
        $message = 'Please click the link to register on the Sonos Music System.';
        $headers = 'From: webmaster@example.com' . "\r\n" .'Reply-To: webmaster@example.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();

        //Send Email.
        mail($_POST['inviteEmail'], $subject, $message, $headers); 
    }



    ?>

        </div>
    </div>
</body>
</html>