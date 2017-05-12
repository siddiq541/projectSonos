<html>
    <h2>Register</h2>

    <?php
        echo "<p>Hi " . htmlspecialchars($_GET['fName']) . " " . htmlspecialchars($_GET['sName']) . ", this is the first time you have used the Sonos Music Service.</p>";
    ?>
    <p>Please could you check the details below and click "Register" when you are happy.</p>
    
    <form name="registerForm" method="post">
        Display Name: <?php echo "<input type='text' name='input_dName' value='" . htmlspecialchars($_GET['dName']) . "'>";?>
        <br>
        <input type="checkbox" name="terms" value="agree"> I agree to the <a href="http://www.pointless.com/">Terms and Conditions.</a>
        <br>
        <input type="submit" value="Register">
    </form>

    <?php
        session_start();
        //Processing form data.
        //Need to add verication and validation.
        //Update is_loggedIn
        //Set session variable "id"
        if(isset($_POST["terms"]) && ($_POST["input_dName"] != NULL))
        {
            //Save details and set is_loggedIn to 1.
            include $_SERVER['DOCUMENT_ROOT'] . '/resources/db.php';
            $stmt = $conn->prepare('INSERT INTO users (u_ID, u_fname, u_lname, u_nickname, u_avatar, is_admin, is_loggedIn) VALUES (?,?,?,?, "null", 0, 1);');
            $stmt->bind_param('ssss',$_GET['id'], $_GET['fName'], $_GET['sName'], $_POST["input_dName"]);//need to alter table and tell muhammad
            $stmt->execute();

            //Set session variable.
            $_SESSION["id"] = $_GET['id'];

            //Re-direct.
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/home.php";
            header("Location: $url");
        }
    ?>
</html>