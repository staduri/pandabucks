<?php
//register.php

require_once 'include/UserTools.php';

//initialize php variables used in the form
$username = "";
$password = "";
$email = "";



//If the form wasn't submitted, or didn't validate
//then we show the registration form again
?>

<html>
<head>
    <title>Registration</title>
</head>
<body>
<?php echo ($error != "") ? $error : ""; ?>
</body>
</html>