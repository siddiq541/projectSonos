<?php
    session_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
    if(isset($_GET['code'])){
        // declaring URL and variables for POST request.
        $url = "https://login.microsoftonline.com/common/oauth2/token";
        $myvars = "grant_type=authorization_code&redirect_uri=http://localhost/token/&client_id=84898151-2c1f-4c0a-a097-29c1b8b7f66a&client_secret=TWr7jYsnL0RCNeS0kSNOTvGVLVRaR6xYqGtai64GjDM=&code=" . $_GET['code'] . "&resource=https://graph.microsoft.com/";
        // request token (POST).
        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec( $ch );
        // json Decode
        $obj = json_decode($response);
        $_SESSION["token"] = $obj->{'access_token'};
        $url = "https://graph.microsoft.com/v1.0/me";
        $headers = array("Authorization : Bearer ". $obj->{'access_token'});
        // get request with authorisation token in header.
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec( $ch );
        // json decode.
        $obj = json_decode($response);
        
        // query table for user.
        $stmt = $conn->prepare('SELECT count(1) FROM users WHERE u_ID = ?;');
        $stmt->bind_param('s',$obj->{'id'});
        $stmt->execute();
        $stmt->bind_result($exists);
        while ($stmt->fetch())//Fetch has to be handled in a while.
        // dont have these values yet.
        $avatar = "void";
        $isAdmin = 0;

        // check if user is in database.
        if($exists == 1){
            // set is_loggedIn to 1.
            $stmt = $conn->prepare('UPDATE users SET is_loggedIn = 1 WHERE u_ID = ?;');
            $stmt->bind_param('s',$obj->{'id'});
            $stmt->execute();
            // set session variable.
            $_SESSION["id"] = $obj->{'id'};
            // update DB with AD information.
            include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
            $stmt = $conn->prepare('UPDATE users SET u_fname = ?, u_lname = ? WHERE u_ID = ?;');
            $stmt->bind_param('sss', $obj->{'givenName'}, $obj->{'surname'}, $obj->{'id'});
            $stmt->execute();
            // redirect to homepage
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/home.php";
            header("Location: $url");
        }
        else{
            // if not in database redirect to register.php with details through get.
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/register.php?id=" . $obj->{'id'} . "&dName=" . $obj->{'displayName'} . "&fName=" . $obj->{'givenName'} . "&sName=" . $obj->{'surname'} . "&email=" . $obj->{'mail'};
            echo $url;
            header("Location: $url");
        }    
    }
    else
        echo "No Code Recieved";
?>
</html>