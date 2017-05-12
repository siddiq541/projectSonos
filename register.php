<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
</head>



<body>
<div id="wapper" style="position: relative;height: auto; min-height: 100%">
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Sonos Music System (a working title)</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Contacts</a>
                </li>
            </ul>
        </div>
    </div>
</div>
    <div class="section" style="margin-bottom: 30px;height: 90%; min-height: 400px; ">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section" style="
    padding-top: 0px;
    padding-bottom: 35px;
">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h1>Register</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">

                                <form style="width: 50%" name="registerForm" method="post">
                                    <h4>Display Name:</h4> <?php echo "<input type='text' class=\"form-control\" id=\"inputEmail3\" placeholder=\"Input your display name.\"  name='input_dName' value='" . htmlspecialchars($_GET['dName']) . "'>";?>
                                    <br>
                                    <input type="checkbox" name="terms" value="agree"> I agree to the <a href =http://localhost/Terms.php target="_blank">Terms and Conditions.</a>

                                    <br>
                                    <p></p>
                                    <p></p>
                                    <input type="submit" class="btn btn-primary" value="Register">
                                </form>

                                <?php
                                session_start();
                                //Processing form data.
                                if(isset($_POST["terms"]) && ($_POST["input_dName"] != NULL))
                                {
                                    //Check if Email is in pendingAdmin
                                    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
                                    $stmt = $conn->prepare('SELECT count(1) FROM pendingAdmin WHERE p_email = ?;');
                                    $stmt->bind_param('s',$_GET['email']);
                                    $stmt->execute();
                                    $stmt->bind_result($exists);
                                    while ($stmt->fetch())//Fetch has to be handled in a while.
                                    if($exists == 1)
                                    {
                                        $admin = 1;
                                        //Remove pendingAdmin entry.
                                        include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
                                        echo $_GET["email"];
                                        $stmt = $conn->prepare('DELETE FROM pendingAdmin WHERE p_email = ?');
                                        $stmt->bind_param('s',$_GET['email']);
                                        $stmt->execute();
                                    }
                                    else
                                        $admin = 0;

                                    //Save details and set is_loggedIn to 1.
                                    include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
                                    $stmt = $conn->prepare('INSERT INTO users (u_ID, u_fname, u_lname, u_nickname, u_avatar, is_admin, is_loggedIn) VALUES (?,?,?,?, "null", ?, 1);');
                                    $stmt->bind_param('ssssi',$_GET['id'], $_GET['fName'], $_GET['sName'], $_POST["input_dName"], $admin);//need to alter table and tell muhammad
                                    $stmt->execute();


                                    //Set session variable.
                                    $_SESSION["id"] = $_GET['id'];

                                    //Re-direct.
                                    $url = "http://" . $_SERVER['HTTP_HOST'] . "/home.php";
                                    header("Location: $url");
                                }
                                ?>




                            </div>
                            <div class="col-md-4">
                                <?php echo "<p>Hi " . htmlspecialchars($_GET['fName']) . " " . htmlspecialchars($_GET['sName']) . ", this is the first time you have used the Sonos Music Service.</p>";
                                ?>
                                <p>Please could you check the details left and click "Register" when you are happy.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <footer style="height:30px;width:100%;position:fixed;bottom:5px;left:0px;">
        <div class="section section-primary" style="padding-bottom: 0px; padding-top: 10px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <p>Group 35</p>
                    </div>
                    <div class="col-md-2">

                    </div>
                    <div class="col-md-5">

                    </div>
                    <div class="col-md-1"><a href="#"><img src="resources/ideagen-logo.svg" class="img-responsive"></a></div><div class="col-md-1"><a href="#"><img src="resources/sonos-logo.jpg" class="img-responsive"></a></div><div class="col-md-1"><a href="#"><img src="resources/spotify-logo.jpg" class="img-responsive"></a></div>
                </div>
            </div>
        </div>

    </footer>
</div>

</body>

