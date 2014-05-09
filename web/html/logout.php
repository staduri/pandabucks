<?php

require_once '../include/UserTools.php';

$userTools = new UserTools();
if(isset($_SESSION) && array_key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"] == 1) {
    $userTools->logout();
    header("Location: logout.php");
} else {
    // nothign
}

?>
<html>
<head>
</head>
<body>
<div>
    <p>You will lose 30 points for doing this.</p>
</div>
</body>
</html>