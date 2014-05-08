<?php

require_once '../include/UserTools.php';

$team1 = "";
$team2 = "";

//check to see if they've submitted the login form
if(isset($_POST['action'])) {
    echo "<script type='text/javascript'>alert('$_POST');</script>";
    $team1 = $_POST['team1-score'];
    $team2 = $_POST['team2-score'];

    $userTools = new UserTools();

    unset($_POST['action']);
}
?>

<html>
<head>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<body>
<?php
if($error != "") {
    echo $error."<br/>";
}
?>

<div data-role="tabs" id="tabs" style="max-width: 480px; margin: 0 auto;">
    <div data-role="navbar" style="padding-top: 15px">
        <ul>
            <li><a href="#input-scores" data-ajax="false">Enter Scores</a></li>
        </ul>
    </div>
    <div id="input-scores" class="ui-body-d ui-content">
        <form action="admin.php" method="post">
            <input list="games">
            <datalist id="games">
                <?php
                $userTools = new UserTools();
                $games = $userTools->getAllGames();
                foreach ($games as $game) {
                    echo("<option value='".$game["game_id"].". ".$game["team1"]." vs ". $game["team2"]. " - ". $game["stage"]
                        ."'>\n");
                }

                ?>
            </datalist>

            Team1: <input type="number" name="team1-score" value="" />
            Team2: <input type="number" name="team2-score" value="" />

            <input type="hidden" value="submit-results" name="action" />

            <input type="submit" value="Save" name="submit-results" />
        </form>
    </div>
</div>
</body>
</html>