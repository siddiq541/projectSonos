<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
    if(!isset($_SESSION["id"]))
    {
        $url = "http://" . $_SERVER['HTTP_HOST'];
        header("Location: $url");
    }
    else
        $id = $_SESSION["id"];
?>

<html>
    <header>
        <title>Sonos Music System</title>
    </header>
    <h1>Sonos Music System <small>(a working title)</small></h1>

     <!Music Player Section.>
    <div class="MusicPLayer">
        <!PUT IT HERE PRANEIL! IN 'data'>
        <object width="100%" style="height:25%" type="text/html" data='sonos/dashboard.php' ></object>
    </div>

    <br>

    <!Main Section.>

    <!Query user display name from database.>
    <?php
     //Query table for user's display name.
        $stmt = $conn->prepare('SELECT u_nickname , is_admin FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($dName,$isAdmin);
        while ($stmt->fetch())//Fetch has to be handled in a while.
    ?>

    <!Log out link>
    <a href="http://localhost/logout.php">Logout</a>

    <!Navigation Bar>
    <ul class="navigation" style="padding: 0;">
        <li style="display: inline;"><a href ="#" onclick="load('sonos/queue.php')">Play Queue</a></li>
        <li style="display: inline;"><a href ="#" onclick="load('tabletemplate.html')">Activity History</a></li>

        <!Display 'Manage Accounts' if user is an admin.>
        <!Will require additional is admin check on 'Manage Accounts' page.>
        <?php 
            if(htmlspecialchars($isAdmin) == 1)
            {
                echo '<li style="display: inline;"><a href ="#" onclick="load(';
                echo "'manage.php'";
                echo ')">Manage Accounts</a></li>';
            }
        ?>

        <li style="display: inline;"><a href ="#" onclick="load('account.php')"><?php echo htmlspecialchars($dName); ?></a></li>
    </ul>

    <hr>
    
    <table height="45%">
        <tr height="100%">
            <td width="75%"><div style="padding:0;height:100%" id="Main"></div></td>
            <td width="25%"><div style="padding:0;height:100%"><object width="100%" style="height:100%" type="text/html" data='spotifySearch.php' ></object></div></td>
        </tr>
    </table>
    

    <script>
        function load(pageUrl) {
            document.getElementById("Main").innerHTML='<object width="100%" style="height:100%" type="text/html" data='+ pageUrl +' ></object>';
        }
        load('sonos/queue.php');//Default.
    </script>

    <hr>

    <footer>
        <img src="resources/ideagen-logo.svg" alt="Ideagen Logo" height="15" width=auto>
        <img src="resources/sonos-logo.jpg" alt="Sonos Logo" height="15" width=auto>
        <img src="resources/spotify-logo.jpg" alt="Sonos Logo" height="18" width=auto>
        Created by Team 35
    </footer>

    
</html>