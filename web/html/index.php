<?php

require_once('../include/UserTools.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

$userTools = new UserTools();

$uidt = $userTools->checkSession();
$uid = $uidt["user_id"];

$flags = $userTools->getAllFlags();
$games = $userTools->getAllGames();
$predictions = $userTools->getPredictions($uid);

date_default_timezone_set('America/Los_Angeles');

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('../include/header.php') ?>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    </head>
    <body>
            <div class="row col-md-10 col-md-offset-1">
                <div class="col-md-12">
                    <div data-role="header" style="height:80px; background: #00d170 url('img/full-logo.png'); background-position:center; background-size:75px; background-repeat:no-repeat;">
                        <div style="display: block; padding-top:30px; padding-right:15px; vertical-align: middle;float: right;">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>

                    <fieldset class="ui-grid-a">
                        <div class="ui-block-a"><input type="button" value="Picks" data-theme="b" /></div>
                        <div class="ui-block-b"><input type="button" value="Leaders" data-theme="a" onclick="location.href='leaderboard.php';" /></div>
                    </fieldset>
                </div>
                <div class="col-md-12">
                    <div style="text-align: center">
                        <h2><?php echo date('j F h:i A'); ?></h2>
                        <h3>Make your picks</h3>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul data-role="listview" > <!-- data-inset="true" -->
                        <?php foreach ($games as $game) { ?>
                        <li>
                            <a href="pick.php?game=<?php echo $game["game_id"]; ?>">
                            <div class="col-md-12">
                                <div class="col-md-2" style="text-align: center; vertical-align:middle;">
                                    <span style="font-size: small;font-family: Arial; color: black;">
                                        <?php echo date("j F", $game["time"]) ?>
                                    </span>
                                    <br>
                                    <span style="font-size: x-small;font-family: Arial; color: black;">
                                        <?php echo date("H:i", $game["time"]) ?> PST
                                    </span>
                                </div>
                                <div class="col-md-10">

                                    <div class="col-md-12" style="text-align: center;">
                                        <?php

                                        if (array_key_exists($game["game_id"], $predictions)) {
                                            $prediction = $predictions[$game["game_id"]];
                                            $flag_url = "";
                                            if ($prediction == "1") {
                                                $flag_url = $flags[$game["team1_id"]];
                                            } else if ($prediction == "2") {
                                                $flag_url = $flags[$game["team1_id"]];
                                            } else {
                                                $flag_url = "img/neutral.jpeg";
                                            }
                                        ?>

                                        <span>Your Pick</span>
                                        <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flag_url ?>" /><br/>

                                        <?php
                                        } else {
                                        ?>
                                            No Selection
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-12 divider"><hr></div>
                                    <div class="col-md-12" style="text-align: center;">
                                        <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team1_id"]]; ?>" /><br/>
                                        <span><?php echo $game["team1"]; ?></span>
                                    </div>
                                    <div class="col-md-12" style="text-align: center; color: #DCCCCC;">
                                        <span>vs</span>
                                    </div>
                                    <div class="col-md-12" style="text-align: center;">
                                        <img style="max-width: 100px;display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team2_id"]]; ?>" /><br/>
                                        <span><?php echo $game["team2"]; ?></span>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-51832818-1', '54.243.222.155');
                ga('send', 'pageview');

            </script>
    </body>
</html>
