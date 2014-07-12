<?php

require_once('../include/UserTools.php');

$userTools = new UserTools();

$uidt = $userTools->checkSession();
$uid = $uidt["user_id"];

$game = $userTools->getAGame($_GET["game_id"]);

if ($game["time"] < time()) {
    echo "Betting for this game is now closed";
} else {
    $data = json_decode(file_get_contents('php://input'), true);
    $userTools->setScorelinePrediction($_GET["game_id"], $_GET["user_id"], $_GET["team1_score"], $_GET['team2_score']);
}

?>