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

<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body >

<div id="wapper" style="position: relative;height: auto; min-height: 100% ">
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
                    <!--<a href="#">Home</a>-->
                </li>
                <li>
                    <!--<a href="#">Contacts</a>-->
                </li>
            </ul>
        </div>
    </div>
</div>


    <div class="section" style="padding-bottom:30px;width:100%; height: 90%;min-height: 750px;">
    <div class="container">


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
        <!Navigation Bar>






        <div class="row hidden-lg hidden-md" style="height:40%">
                <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <h3 class="panel-title">Too Small</h3>
                    </div>
                    <div class="panel-body">
                        The browser size is too small to display full functionality. Please expand the browser size
                       </div>
                </div>
        </div>


        <div class="row hidden-sm hidden-xs" style="height:40%">
            <div class="col-md-8"  style=" height:100%">
                <div  style=" height:100%">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Sonos Player</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="MusicPLayer">
                                        <object width="100%" style="height:85%" type="text/html" data='sonos/dashboard.php' ></object>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills">
                            <a style="display: inline;"><a class="btn btn-primary" href ="#" onclick="load('sonos/queue.php')">Play Queue</a>
                                <a style="display: inline;"><a class="btn btn-primary" href ="#" onclick="load('resources/activity.txt')">Activity History</a></a>

                                <!Display 'Manage Accounts' if user is an admin.>
                                <!Will require additional is admin check on 'Manage Accounts' page.>
                                <?php
                                if(htmlspecialchars($isAdmin) == 1)
                                {
                                    echo '<a style="display: inline;"><a class="btn btn-primary" href ="#" onclick="load(';
                                    echo "'manage.php'";
                                    echo ')">Manage Accounts</a></li>';
                                    echo '<a style="display: inline;"><a class="btn btn-primary" href ="#" onclick="load(';
                                    echo "'settings.php'";
                                    echo ')">Settings</a></li>';
                                }
                                ?>

                                <a style="display: inline;"><a  class="btn btn-primary" href ="#" onclick="load('account.php')"><?php echo htmlspecialchars($dName); ?></a>
                                    <a class="btn btn-primary" href="http://localhost/logout.php"">Logout</a>
                        </ul>
                    </div>
                </div>
                <div  id="Main" style=" height:100%">
                </div>
            </div>

            <div class="col-md-4" style=" height:200%">
                <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <h3 class="panel-title">Spotify</h3>
                    </div>
                    <div class="panel-body">
                        <object width="100%" style=" height:95%" type="text/html" data='spotifySearch.php' ></object></div>
                </div>
            </div>
            <p>

        </div>





        <script>
        function load(pageUrl) {
            document.getElementById("Main").innerHTML='<object width="100%" style="height:100%" type="text/html" data='+ pageUrl +' ></object>';
        }
        load('sonos/queue.php');//Default.
    </script>

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
</html>