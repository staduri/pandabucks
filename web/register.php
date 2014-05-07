<?php
//register.php

require_once 'includes/UserTools.php';

//initialize php variables used in the form
$username = "";
$password = "";
$email = "";
$error = "";

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

    if($success) {
        //if the user is being registered for the first time.
        $data = array(
            "username" => $username,
            "password" => md5($password),
            "join_date" => $email
        );

        $this->id = $userTools->createUser($data, 'users');

        //log them in
        $userTools->login($username, $password);

        //redirect them somewhere

    }
}
//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
    <title>Registration</title>
</head>
<body>
<?php echo ($error != "") ? $error : ""; ?>
<form action="register.php" method="post">

    Username: <input type="text" value="<?php echo $username; ?>" name="username" /><br/>
    Password: <input type="password" value="<?php echo $password; ?>" name="password" /><br/>
    Password (confirm): <input type="password" value="<?php echo $password_confirm; ?>" name="password-confirm" /><br/>
    E-Mail: <input type="text" value="<?php echo $email; ?>" name="email" /><br/>
    <input type="submit" value="Register" name="submit-form" />

</form>
</body>
</html>