<?php

require_once('../include/UserTools.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userTools = new UserTools();

$uid = $userTools->checkSession()["user_id"];

if(!isset($_GET["game"])) {
    die("error. could not retrieve game.");
}

$flags = $userTools->getAllFlags();
$game = $userTools->getAGame($_GET["game"]);



$userPick = $userTools->getAPick($uid, $_GET["game"]);
if(isset($userPick) && !(is_array($userPick) && sizeof($userPick) == 0)) {
   //set user current selection in  ui
}
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/header.php') ?>
</head>
<body>
<div class="ui-grid-b">

    <div class="ui-block-a">
        <div style="text-align: center">
            <h2>Pick a result</h2>

        </div>
    </div>
    <div class="ui-block-a">
         <div style="text-align: center">
            <fieldset data-role="controlgroup" data-type="horizontal" >
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2a" value="on" >    <!-- checked="checked" -->
                <label for="radio-choice-h-2a">
                    <img width="100" height="66" src="<?php echo $flags[$game["team1_id"]]; ?>" />
                    <h3><?php echo $game["team1"]; ?></h3></label>
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2b" value="off">
                <label for="radio-choice-h-2b">
                    <img width="100" height="66" src="<?php echo $flags[$game["team2_id"]]; ?>" />
                    <h3><?php echo $game["team2"]; ?></h3></label>
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2c" value="other">
                <label for="radio-choice-h-2c">
                    <h3>DRAW</h3></label>
            </fieldset>
         </div>
    </div>
    <div class="ui-block-a">
        &nbsp;
    </div>
    <div class="ui-block-a">
        <input type="submit" value="Done."  />
    </div>
</div>
</body>
</html>
