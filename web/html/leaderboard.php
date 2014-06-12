<?php

    require_once('../include/UserTools.php');

    $userTools = new UserTools();
    $uidt = $userTools->checkSession();

    $leaderboard = $userTools->getLeaderboard();

    if(is_null($leaderboard)) {
        die("error. could not retrieve leaderboard.");
    }
    date_default_timezone_set('America/Los_Angeles');
    $page = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php
        require_once('../include/header.php');
    ?>

</head>
<body>
<div class="ui-grid-a" style="width: 100%;">
    <div class="ui-block-a" style="width: 100%;">
        <div data-role="header" style="height:80px; background: #00d170 url('img/full-logo.png'); background-position:center; background-size:75px; background-repeat:no-repeat;">
            <div style="display: block; padding-top:30px; padding-right:15px; vertical-align: middle;float: right;">
                <a href="logout.php">Logout</a>
            </div>
        </div>

        <fieldset class="ui-grid-a">
            <div class="ui-block-a"><input type="submit" value="Picks" data-theme="a" onclick="location.href='index.php';" /></div>
            <div class="ui-block-b"><input type="reset" value="Leaders" data-theme="b" /></div>
        </fieldset>
    </div>
    <div class="ui-block-a">
        <div style="text-align: center">
            <div style="text-align: center">
                <h2><?php echo date('j F h:i A'); ?></h2>
            </div>
        </div>
    </div>

    <div class="ui-block-a" style="width: 100%;">
        <table data-role="table" data-mode="reflow" class="ui-responsive table-stroke ui-grid-solo">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $rank_num = 1;
                    foreach ($leaderboard as $row) {
                        echo '<tr>';
                            echo '<td><img height="150px" src="img/'.$row["user_id"].'.jpg"</td>';
                            echo '<td>' . $rank_num . '</td>';
                            echo '<td>' . $row['nickname'] . '</td>';
                            echo '<td>' . $row['user_id'] . '</td>';
                            echo '<td>' . number_format($row['points']) . '</td>';
                        echo '</tr>';

                        $rank_num += 1;
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-51832818-1', '54.243.222.155');
        ga('send', 'pageview');

    </script>
</div>
</body>
</html>
