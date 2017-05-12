<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
    if(isset($_SESSION["id"]))
    {
        //If a session exists.
        //Set is_loggedIn to 0.
        $stmt = $conn->prepare('UPDATE users SET is_loggedIn = 0 WHERE u_ID = ?;');
        $stmt->bind_param('s',$_SESSION["id"]);
        $stmt->execute();

        //Unset session variable(s).
        session_unset();
        //Destroy session.
        session_destroy(); 
    }
    //Return to login page. 
    $url = "http://" . $_SERVER['HTTP_HOST'];
    header("Location: $url");
?>