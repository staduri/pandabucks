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
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

    <style type="text/css">
        .sortable {
            cursor: pointer;
            background-image: url(img/asc_desc.png);
            background-repeat: no-repeat;
            background-size: 20px;
            background-position: right;
        }
    </style>
</head>
<body>
<div class="row col-md-12"">
    <div class="col-md-12">
        <div data-role="header" style="height:80px; background: #00d170 url('img/full-logo.png'); background-position:center; background-size:75px; background-repeat:no-repeat;">
            <div style="display: block; padding-top:30px; padding-right:15px; vertical-align: middle;float: right;">
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="btn-group col-md-12">
            <button type="button" class="btn btn-default btn-lg col-md-6" onclick="location.href='index.php';">Picks</button>
            <button type="button" class="btn btn-default btn-lg col-md-6">Leaders</button>
        </div>
    </div>
    <div class="col-md-12">
        <div style="text-align: center">
            <div style="text-align: center">
                <h2><?php echo date('j F h:i A'); ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-12" style="width: 100%;">
        <table id="leaderboard" class="table tablesorter">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="sortable">Points</th>
                    <th class="sortable"># Correct</th>
                    <th class="sortable"># Incorrect</th>
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
                            echo '<td>' . $row['correct_guesses'] . '</td>';
                            echo '<td>' . $row['incorrect_guesses'] . '</td>';
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

    <script type="text/javascript">
        $(document).ready(function() {
            $.tablesorter.addParser({
                id: 'custom',
                is: function(s) {
                    return false;
                },
                format: function(s) {
                    return s.replace(/,/,'');
                },
                type: 'numeric'
            });

            $("#leaderboard").tablesorter({
                widthFixed: true,
                headers: {
                    1: {sorter: false},
                    2: {sorter: false},
                    3: {sorter: false},
                    4: { sorter: "custom"},
                    5: { sorter: "digit"},
                    6: { sorter: "digit"}
                }
            });
        });
    </script>
</div>
</body>
</html>
