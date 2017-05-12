<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
    if(isset($_GET['code']))
    {
        //Declaring URL and variables for POST request.
        $url = "https://login.microsoftonline.com/common/oauth2/token";
        $myvars = "grant_type=authorization_code&redirect_uri=http://localhost/token/&client_id=84898151-2c1f-4c0a-a097-29c1b8b7f66a&client_secret=TWr7jYsnL0RCNeS0kSNOTvGVLVRaR6xYqGtai64GjDM=&code=" . $_GET['code'] . "&resource=https://graph.microsoft.com/";

        //Request token (POST).
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );

        //Extract token from response.
        $response = substr($response, 194);
        $response =  explode(",", $response);
        $response = $response[0];
        $token = substr($response, 0, -1);
        //header("Location: http://localhost/test.php?token=".$token);//This is only tempory, needs to be hidden. Maybe a session?

        $url = "https://graph.microsoft.com/v1.0/me";
        $headers = array("Authorization : Bearer ". $token);

        //GET request with authorisation token in header.
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec( $ch );

        //Strip relevant information.
        $responses = explode(",",$response);
        $dName = explode('"',$responses[4]);
        $dName = $dName[3];
        $id = explode('"',$responses[1]);
        $id = $id[3];
        $fName = explode('"',$responses[4]);
        $fName = $fName[3];
        $sName = explode('"',$responses[10]);
        $sName = $sName[3];
        
        //Query table for user.
        $stmt = $conn->prepare('SELECT count(1) FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->bind_result($exists);
        while ($stmt->fetch())//Fetch has to be handled in a while.

        //Dont have these values yet.
        $avatar = "void";
        $isAdmin = 0;

        //Check if user is in database.
        if($exists == 1)
        {
            //Set is_loggedIn to 1.
            $stmt = $conn->prepare('UPDATE users SET is_loggedIn = 1 WHERE u_ID = ?;');
            $stmt->bind_param('s',$id);
            $stmt->execute();

            //Set session variable.
            $_SESSION["id"] = $id;
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/home.php";
            header("Location: $url");
        }
        else
        {
            //If not in database redirect to register.php with details through GET.
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/register.php?id=" . $id . "&dName=" . $dName . "&fName=" . $fName . "&sName=" . $sName;
            header("Location: $url");
        }    
    }
    else
        echo "No Code Recieved";
?>
</html>