<?php

require_once('../include/UserTools.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userTools = new UserTools();

$uidt = $userTools->checkSession();
$uid = $uidt["user_id"];

$flags = $userTools->getAllFlags();
$games = $userTools->getAllGames();


date_default_timezone_set('America/Los_Angeles');

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('../include/header.php') ?>
    </head>
    <body>
            <div class="ui-grid-a" style="width: 680px; margin: 0 auto;">
                <div class="ui-block-a">
                    <div data-role="header" style="background-color: #00d170;">
                        <img height="75px" src="img/full-logo.png" style="display: block; margin:auto;">
                    </div>
                    <fieldset class="ui-grid-a">
                        <div class="ui-block-a"><input type="button" value="Picks" data-theme="b" /></div>
                        <div class="ui-block-b"><input type="button" value="Leaders" data-theme="a" onclick="location.href='leaderboard.php';" /></div>
                    </fieldset>
                </div>
                <div class="ui-block-a">
                    <div style="text-align: center">
                        <h2><?php echo date('j F h:i A'); ?></h2>
                        <h3>Make your picks</h3>
                    </div>
                </div>
                <div class="ui-block-a">
                    <ul data-role="listview" > <!-- data-inset="true" -->
                        <?php foreach ($games as $game) { ?>
                        <li>
                            <a href="pick.php?game=<?php echo $game["game_id"]; ?>">
                            <div class="ui-grid-c">
                                <div class="ui-block-a">
                                    <img width="100" height="60" src="<?php echo $flags[$game["team1_id"]]; ?>" /><br/>
                                    <?php echo $game["team1"]; ?>
                                </div>
                                <div class="ui-block-b">
                                    <span style="font-family: Arial; color: #CCCCCC; text-align: center;">
                                    <h3>
                                    <?php echo date("j F", $game["time"]) ?>
                                    </h3>
                                    </span>
                                </div>
                                <div class="ui-block-c">
                                    <img width="100" height="60" src="<?php echo $flags[$game["team2_id"]]; ?>" /><br/>
                                    <?php echo $game["team2"]; ?>
                                </div>
                            </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
    </body>
</html>
