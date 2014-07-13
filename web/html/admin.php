<html>
<head>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
</head>
<body>

<?php
require_once '../include/UserTools.php';

if (isset($_POST['action'])) {
    $team1 = $_POST['team1-score'];
    $team2 = $_POST['team2-score'];
    $team90a = $_POST['team1-90-score'];
    $team90b = $_POST['team2-90-score'];
    $selection = $_POST['game'];

    $userTools = new UserTools();
    $data = array(
        "game_id" => $selection,
        "score_team_a" => $team1,
        "score_team_b" => $team2,
        "score_team_a_90" => $team90a,
        "score_team_b_90" => $team90b
    );

    $userTools->saveResult($data);
}

?>

<?php
if($error != "") {
    echo $error."<br/>";
}
?>

<div data-role="tabs" id="tabs" style="max-width: 480px; margin: 0 auto;">
    <div data-role="navbar" style="padding-top: 15px">
        <ul>
            <li><a href="#input-scores" data-ajax="false">Enter Scores</a></li>
            <li><a href="#results" data-ajax="false">Results</a></li>
        </ul>
    </div>
    <div id="input-scores" class="ui-body-d ui-content">
        <form action="admin.php" method="post">
            <input name="game" list="games">
            <datalist id="games">
                <?php
                $userTools = new UserTools();
                $games = $userTools->getAllGames();
                foreach ($games as $game) {
                    echo("<option value='".$game["game_id"]."'>".$game["team1"]." vs ". $game["team2"]. " - ". $game["stage"]
                        ."</option>\n");
                }

                ?>
            </datalist>

            Team1: <input type="number" name="team1-score" value="" />
            Team2: <input type="number" name="team2-score" value="" />
            Team1 90 min score: <input type="number" name="team1-90-score" value="" />
            Team2 90 min score: <input type="number" name="team2-90-score" value="" />

            <input type="hidden" value="submit-results" name="action" />

            <input type="submit" value="Save" name="submit-results" />
        </form>
    </div>
    <div id="results" class="ui-body-d ui-content">
        <table data-role="table" data-mode="reflow" class="ui-responsive table-stroke">
            <thead>
                <tr>
                    <th data-priority="1">Team A</th>
                    <th data-priority="2">Team B</th>
                    <th data-priority="3">Stage</th>
                    <th data-priority="4">GS</th>
                    <th data-priority="5">GS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $userTools = new UserTools();
                    $games = $userTools->getAllResults();
                    foreach ($games as $game) {
                        echo("<tr>"
                            ."<td>".$game['team1_name']."</td>"
                            ."<td>".$game['team2_name']."</td>"
                            ."<td>".$game['stage']."</td>"
                            ."<td>".$game['score_a']."</td>"
                            ."<td>".$game['score_b']."</td>"
                            ."</tr>\n");
                    }

                ?>
            </tbody>
        </table>
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