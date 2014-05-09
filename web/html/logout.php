<?php

require_once '../include/UserTools.php';

$userTools = new UserTools();
$uidt = $userTools->checkSession();
$userTools->logout();

header("Location: login.php");
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