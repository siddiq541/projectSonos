<html>
    <h2>Manage Accounts</h2>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
        session_start();
        $id = $_SESSION["id"];

        //Query table to confirm admin.
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

        //Query table for user data.
        $stmt = $conn->prepare('SELECT is_admin FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($isAdmin);
        while ($stmt->fetch())//Fetch has to be handled in a while.
        

    ?>
</html>