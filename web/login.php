<?php

require_once 'include/UserTools.php';

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
        header("Location: games.php");
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
    $email = $_POST['email'];

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
            "paid" => "false"
        );

        $id = $userTools->createUser($data, 'users');

        //log them in
        $userTools->login($username, $password);
        //redirect them somewhere
        header("Location: games.php");

    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>

    </head>
    <body>


    <?php
        if($error != "") {
            echo $error."<br/>";
        }
    ?>

    <div data-role="tabs" id="tabs" style="max-width: 480px; margin: 0 auto;">
        <div>
            <img src="img/paul.talktopus.png" width="100%">
        </div>
        <div data-role="navbar" style="padding-top: 15px">
            <ul>
                <li><a href="#login" data-ajax="false">Sign In</a></li>
                <li><a href="#register" data-ajax="false">Register</a></li>
            </ul>
        </div>
        <div id="login" class="ui-body-d ui-content">
            <form action="login.php" method="post">
                Username: <input type="email" name="username" value="<?php echo $username; ?>" /><br/>
                Password: <input type="password" name="password" value="" /><br/>
                <input type="submit" value="Login" name="submit-login" />
            </form>
        </div>
        <div id="register" class="ui-body-d ui-content">
            <form action="login.php" method="post">
                Username: <input type="email" value="<?php echo $username; ?>" name="username" /><br/>
                Password: <input type="password" value="<?php echo $password; ?>" name="password" /><br/>
                <input type="submit" value="Register" name="submit-form" />
            </form>
        </div>
    </div>

    </body>
</html>