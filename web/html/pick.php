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
    if ($game['time'] > time()) {
        echo("Bidding for this game is now closed");
    } else {
        $userTools->setAPick($_GET["user_id"], $_GET["game"], $_GET['radio-choice-h-2']);
    }

    header("Location: index.php");
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
<!DOCTYPE html>
<html>
<head>
    <?php require_once('../include/header.php') ?>
    <style type="text/css">
        .center {
            margin: 0 auto;
            display: block;
            width: 100%;
        }
    </style>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
    <script src="js/jquery.jplayer.min.js"></script>
</head>
<body>
    <div class="ui-grid-a" style="width: 100%;">
        <form id="aform" action="pick.php" method="get">
            <input id="game" name="game" type="hidden" value="<?php echo $game["game_id"] ?>">
            <input id="user_id" name="user_id" type="hidden" value="<?php echo $uid ?>">
                <div class="ui-block-a" style="width: 100%;">
                    <div data-role="header" style="height:80px; background: #00d170 url('img/full-logo.png'); background-position:center; background-size:75px; background-repeat:no-repeat;">
                        <div style="display: block; padding-top:30px; padding-right:15px; vertical-align: middle;float: right;">
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>

                    <div style="position:relative; text-align: center;">
                        <h4>Pick a Result</h4>
                    </div>
                </div>

                <div class="ui-block-a">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2a" value="1" <?php echo $is_selection_1 ?>>    <!-- checked="checked" -->
                        <label for="radio-choice-h-2a">
                            <table>
                                <tr>
                                    <td>
                                        <img width="100" height="60" src="<?php echo $flags[$game["team1_id"]]; ?>" />
                                        <h3><?php echo $game["team1"]; ?></h3>
                                    </td>
                                    <td><?php echo $game["team1_points"] ?> pts</td>
                                </tr>
                            </table>
                        </label>
                        <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2b" value="2" <?php echo $is_selection_2 ?>>
                        <label for="radio-choice-h-2b">
                            <table>
                                <tr>
                                    <td>
                                        <img width="100" height="60" src="<?php echo $flags[$game["team2_id"]]; ?>" />
                                        <h3><?php echo $game["team2"]; ?></h3>
                                    </td>
                                    <td><?php echo $game["team2_points"] ?> pts</td>
                                </tr>
                            </table>
                        </label>
                        <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2c" value="X" <?php echo $is_selection_3 ?>>
                        <label for="radio-choice-h-2c">
                            <table>
                                <tr>
                                    <td>
                                        <img width="100" height="60" src="img/neutral.jpeg" />
                                        <h3>Draw</h3>
                                    </td>
                                    <td><?php echo $game["draw_points"] ?> pts</td>
                                </tr>
                            </table>
                        </label>
                    </fieldset>
                 </div>
                <div class="ui-block-a">
                    &nbsp;
                </div>
                <div class="ui-block-a">
                    <input id="submit" type="submit" value="Done" class="center"/>
                </div>
        </form>
    </div>
    <div id="jquery_jplayer_1"></div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#submit").click(function(ev) {
            //ev.preventDefault();
            var items = ["1.mp3", "2.mp3", "3.mp3"];

            $('#jquery_jplayer_1').jPlayer({
                ready: function() {
                $(this).jPlayer('setMedia', {
                    mp3: 'audio/'+items[Math.floor(Math.random()*items.length)]
                }).jPlayer('play');
                var click = document.ontouchstart === undefined ? 'click' : 'touchstart';
                var kickoff = function () {
                $('#jquery_jplayer_1').jPlayer('play');
                    document.documentElement.removeEventListener(click, kickoff, true);
                };
                document.documentElement.addEventListener(click, kickoff, true);
                },
                loop: false,
                swfPath: 'js'
            });
        });
    });
</script>
</body>
</html>
