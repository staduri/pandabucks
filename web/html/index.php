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
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

        <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>

    <body>
            <div class="row col-md-12">
                <div class="col-md-12">
                    <div data-role="header" style="height:80px; background: #00d170 url('img/full-logo.png'); background-position:center; background-size:75px; background-repeat:no-repeat;">
                        <div style="display: block; padding-top:30px; padding-right:15px; vertical-align: middle;float: right;">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                    <div class="btn-group col-md-12">
                        <button type="button" class="btn btn-default btn-lg col-md-6">Picks</button>
                        <button type="button" class="btn btn-default btn-lg col-md-6" onclick="location.href='leaderboard.php';">Leaders</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <div style="text-align: center">
                        <h2><?php echo date('j F h:i A'); ?></h2>
                        <h3>Make your picks</h3>
                    </div>
                </div>
                <div class="col-md-12">

                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    <h3>View Past Games</h3>
                                </a>
                            </h4>
                        </div>

                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div>
                                    <div class="col-md-12 divider"><hr></div>
                                    <?php foreach ($games as $game) {
                                        if ($game["time"] >= time()) {
                                            continue;
                                        }
                                        ?>
                                        <div>
                                            <div class="col-md-12">
                                                <div class="col-md-2" style="text-align: center; vertical-align:middle;">
                                                        <span style="font-size: small;font-family: Arial; color: black;">
                                                            <?php echo date("j F", $game["time"]) ?>
                                                        </span>
                                                                        <br>
                                                        <span style="font-size: x-small;font-family: Arial; color: black;">
                                                            <?php echo date("H:i", $game["time"]) ?> PST
                                                        </span>
                                                        <h3>
                                                            <?php echo $game["team1"] ?> vs <?php echo $game["team2"] ?>
                                                        </h3>
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
                                                                $flag_url = $flags[$game["team2_id"]];
                                                            } else {
                                                                $flag_url = "img/neutral.jpeg";
                                                            }
                                                            ?>

                                                            <span>Your Pick</span>
                                                            <img class="current_selection" style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flag_url ?>" /><br/>

                                                        <?php
                                                        } else {
                                                            ?>
                                                            Please make a selection below
                                                            <img class="current_selection" style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="" /><br/>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="col-md-12 divider"><hr></div>

                                                    <div class="col-md-12" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="1"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>

                                                        <div class="col-md-12">
                                                            <span><?php echo $game["team1"]; ?>: <strong><?php echo $game["team1_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team1_id"]]; ?>" /><br/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="2"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>
                                                        <div class="col-md-12">
                                                            <span><?php echo $game["team2"]; ?>: <strong><?php echo $game["team2_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team2_id"]]; ?>" /><br/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="X"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>
                                                        <div class="col-md-12">
                                                            <span>Draw: <strong><?php echo $game["draw_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px;display: block; margin: auto;" width="90%" height="60" src="img/neutral.jpeg" /><br/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    <h3>Upcoming games</h3>
                                </a>
                            </h4>
                        </div>

                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div> <!-- data-inset="true" -->
                                    <?php foreach ($games as $game) {
                                        if ($game["time"] < time()) {
                                            continue;
                                        }
                                        ?>

                                        <div>
                                            <div class="col-md-12 divider"><hr></div>
                                            <div class="col-md-12">
                                                <div class="col-md-2" style="text-align: center; vertical-align:middle;">
                                    <span style="font-size: small;font-family: Arial; color: black;">
                                        <?php echo date("j F", $game["time"]) ?>
                                    </span>
                                                    <br>
                                    <span style="font-size: x-small;font-family: Arial; color: black;">
                                        <?php echo date("H:i", $game["time"]) ?> PST
                                    </span>
                                                    <h3>
                                                        <?php echo $game["team1"] ?> vs <?php echo $game["team2"] ?>
                                                    </h3>
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
                                                                $flag_url = $flags[$game["team2_id"]];
                                                            } else {
                                                                $flag_url = "img/neutral.jpeg";
                                                            }
                                                            ?>

                                                            <span>Your Pick</span>
                                                            <img id="current_selection_<?php echo $game["game_id"] ?>" style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flag_url ?>" /><br/>

                                                        <?php
                                                        } else {
                                                            ?>
                                                            Please make a selection below
                                                            <img id="current_selection_<?php echo $game["game_id"] ?>" style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="" /><br/>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="col-md-12 divider"><hr></div>

                                                    <div class="col-md-12 selection" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="1"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>

                                                        <div class="col-md-12">
                                                            <span><?php echo $game["team1"]; ?>: <strong><?php echo $game["team1_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team1_id"]]; ?>" /><br/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 selection" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="2"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>
                                                        <div class="col-md-12">
                                                            <span><?php echo $game["team2"]; ?>: <strong><?php echo $game["team2_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px; display: block; margin: auto;" width="90%" height="60" src="<?php echo $flags[$game["team2_id"]]; ?>" /><br/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 selection" style="text-align: center; display: block;">
                                                        <?php
                                                        if ($game["time"] >= time()) {
                                                            ?>
                                                            <custom href="/pick.php" param_game="<?php echo $game["game_id"] ?>" param_user="<?php echo $uid?>" param_choice="X"></custom>
                                                        <?php
                                                        } else {

                                                        }
                                                        ?>
                                                        <div class="col-md-12">
                                                            <span>Draw: <strong><?php echo $game["draw_points"] ?> points</strong> </span>
                                                            <img style="max-width: 100px;display: block; margin: auto;" width="90%" height="60" src="img/neutral.jpeg" /><br/>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
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

            <script type="text/javascript">
                $(document).ready(function(){
                    $(".selection").click(function(){
                        var url = $(this).find("custom").attr("href");
                        var game = $(this).find("custom").attr("param_game");
                        var user = $(this).find("custom").attr("param_user");
                        var prediction = $(this).find("custom").attr("param_choice");
                        $.ajax({
                            type: "GET",
                            url: url,
                            data: {"game": game, "user_id": user, "radio-choice-h-2": prediction},
                            success: function(data){
                                var obj = $.parseJSON(data);
                                console.log("Successfully posted. New selection - " + obj["game"] + "\n" + obj["selection"]);
                                // refresh the selection
                                var cur = $("#current_selection_" + game);
                                cur.attr('src', obj["selection"]);
                            },
                            error: function(jqXHR, exception){
                                console.log("Something went wrong");
                            }
                        });
                        return false;
                    });

                    $(".selection").mouseenter(function(){
                        $(this).css({"background": "#f5f5f5"});
                        $(this).css({"cursor": "pointer"});
                    }).mouseleave(function(){
                            $(this).css({"background": ""});
                            $(this).css({"cursor": ""});
                    });
                });
            </script>
    </body>
</html>
