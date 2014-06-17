<?php

require_once('../include/UserTools.php');
$userTools = new UserTools();

if (isset($_GET['email'])) {
    $userTools->unsubscribe($_GET["email"]);
    echo json_encode(array("result"=>"success"));
} else {
    echo json_encode(array("result"=>"missing_param"));
}
