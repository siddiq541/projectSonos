<html>
    <h2>Account</h2>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
        session_start();
        $id = $_SESSION["id"];
        //Query table for user's information.
        $stmt = $conn->prepare('SELECT u_fname, u_lname, u_nickname, is_admin FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($fName,$lName,$dName,$isAdmin);
        while ($stmt->fetch())//Fetch has to be handled in a while.

        //Find user type.
        if(htmlspecialchars($isAdmin) == 1)
            $userType = "Administrator";
        else
            $userType = "Standard";

        //Display information.
        echo "<p> Name: " . htmlspecialchars($fName) . " " .  htmlspecialchars($lName) . "</p>";
        echo "<p> Display name: " . htmlspecialchars($dName) . "</p>";
        echo "<p> User type: " . $userType . "</p>";

        //Link to delete account. Not implemented.
        echo "<a href=''>Delete account</a>";
    ?>

    <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur orci elit, accumsan eget est nec, euismod feugiat leo. Morbi pulvinar felis ac dui iaculis, sit amet dapibus risus efficitur. Nunc et sodales neque. Nullam ac dolor vestibulum, dignissim massa nec, laoreet metus. Ut interdum, odio varius dapibus viverra, leo elit iaculis lectus, at interdum odio magna a est. Vivamus id consequat orci. Maecenas vel velit nec nunc convallis tristique. Aliquam erat volutpat. Proin tincidunt neque velit, quis commodo orci pellentesque nec. Fusce rhoncus, libero aliquam commodo tristique, nulla nunc ultrices metus, tempor dictum nisi velit vitae lectus. Nam sed molestie urna. Mauris mollis, arcu ac auctor vestibulum, ligula lorem porta ligula, in semper mauris nisi quis libero. Aliquam erat volutpat. Ut tincidunt, magna at sagittis placerat, magna nulla scelerisque orci, eu semper risus lacus a nibh. Pellentesque facilisis velit ex.
    </p>
</html>