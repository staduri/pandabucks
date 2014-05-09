<html>
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<body>
<?php

require_once '../include/UserTools.php';

$error = "";
$username = "";
$password = "";

//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userTools = new UserTools();
    if($userTools->login($username, $password)){
        //successful login, redirect them somewhere
        //header("Location: http://localhost:8000/games.php");
        js_redirect("index.php");
    } else{
        $error = "Oops! Something is wrong. Try again?";
    }

    unset($_POST['submit-login']);
}

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) {

    //retrieve the $_POST variables
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nickname = $_POST['nickname'];

    //initialize variables for form validation
    $success = true;
    $userTools = new UserTools();

    //check to see if user name already exists
    if($userTools->checkUsernameExists($username)) {
        $error .= "That username is already taken.<br/> \n\r";
        $success = false;
    }

    //check to see if user is allowed
    if($userTools->checkUserNotAllowedAccess($username)) {
        $error .= "This user isn't allowed access.<br/> \n\r";
        $success = false;
    }

    if($success) {
        //if the user is being registered for the first time.
        $data = array(
            "email" => $username,
            "password" => md5($password),
            "nickname" => $nickname,
            "paid" => "false"
        );

        $id = $userTools->createUser($data, 'users');

        //log them in
        $userTools->login($username, $password);
        //redirect them somewhere
        //header("Location: http://localhost:8000/games.php");
        js_redirect("index.php");

    }
}
            if($error != "") {
                echo $error."<br/>";
            }

function js_redirect($url) {
    echo "<script language=\"JavaScript\">\n";
    echo "window.location = \"" . $url . "\";\n";
    echo "</script>\n";
    return true;
}
?>
        <div data-role="tabs" id="tabs" style="background-color: #00d170; max-width: 480px; margin: 0 auto;">
            <img height="150px" src="img/full-logo.png" style="display: block; margin:auto;">
            <div data-role="navbar" style="padding-top: 15px">
                <ul>
                    <li><a href="#login" data-ajax="false">Login</a></li>
                    <li><a href="#register" data-ajax="false">Sign Up</a></li>
                </ul>
            </div>
            <div id="login" class="ui-body-d ui-content">
                <form action="login.php" method="post">
                    <input type="email" name="username" value="<?php echo $username; ?>" placeholder="Pandora Email"/><br/>
                    <input type="password" name="password" value="" placeholder="Password"/><br/>
                    <input type="submit" value="Login" name="submit-login" />
                </form>
            </div>
            <div id="register" class="ui-body-d ui-content">
                <form action="login.php" method="post">
                    <input type="text" value="" name="nickname" placeholder="Nickname"/><br/>
                    <input type="email" value="" name="username" placeholder="Pandora Email"/><br/>
                    <input type="password" value="" name="password" placeholder="Password"/><br/>

                    <div class="ui-grid-a">
                        <div class="ui-block-a">
                            <img width="200px" src="img/paylocity-holding-corp-logo.png">
                        </div>
                        <div class="ui-block-b">
                            <input type="checkbox" id="terms" checked/>
                            <label for="terms">Please deduct all my losses from Paylocity</label>
                        </div>
                    </div><!-- /grid-a -->

                    <input type="submit" value="Sign Up" name="submit-form"/>
                </form>
            </div>
            <footer style="color: white; text-align: center">&copy; 2014 Pandathletico Soccer PERG</footer>
        </div>

    </body>
</html>