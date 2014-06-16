<?php

require_once('../include/UserTools.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userTools = new UserTools();

$uidt = $userTools->checkSession();
$uid = $uidt["user_id"];

if(!isset($_GET["game"])) {
    die("error. could not retrieve game.");
}

$flags = $userTools->getAllFlags();
$game = $userTools->getAGame($_GET["game"]);


if (isset($_GET['radio-choice-h-2'])) {
    if ($game["time"] < time()) {
        echo "Betting for this game is now closed";
    } else {
        $data = json_decode(file_get_contents('php://input'), true);
        print_r($data);
        $userTools->setAPick($_GET["user_id"], $_GET["game"], $_GET['radio-choice-h-2']);
        $flag = "img/neutral.jpeg";
        if ($_GET["radio-choice-h-2"] == '1') {
            $flag = $flags[$game["team1_id"]];
        } else if ($_GET["radio-choice-h-2"] == '2'){
            $flag = $flags[$game["team2_id"]];
        }
        $arr = array("selection"=> $flag, "game"=>$_GET["game"]);

        echo json_encode($arr);
        //echo $flag;
        //header("Location: index.php");
    }
}

$userPick = $userTools->getAPick($uid, $_GET["game"]);
$is_selection_1="";
$is_selection_2="";
$is_selection_3="";
if(isset($userPick) && !(is_array($userPick) && sizeof($userPick) == 0)) {
    //set user current selection in  ui
    if ($userPick['prediction'] == "1") {
        $is_selection_1="checked";
    } else if ($userPick['prediction'] == "2") {
        $is_selection_2="checked";
    } else if ($userPick['prediction'] == "X") {
        $is_selection_3="checked";
    }
}


?>