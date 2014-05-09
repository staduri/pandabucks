<!DOCTYPE html>
<html>
<head>
    <?php

    require_once('../include/header.php');
    require_once('../include/UserTools.php');

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $userTools = new UserTools();

    $leaderboard = $userTools->getLeaderboard();
   
    if(is_null($leaderboard)) {
    die("error. could not retrieve leaderboard.");
}
    date_default_timezone_set('America/Los_Angeles');
    $page = $_SERVER['PHP_SELF'];
?>

    <meta http-equiv="refresh" content="10;URL='<?php echo $page?>'">
</head>
<body>
<div class="ui-grid-b">
    <div class="ui-block-a">
        <fieldset class="ui-grid-a">
            <div class="ui-block-a"><input type="submit" value="Picks" data-theme="a" onclick="location.href='index.php';" /></div>
            <div class="ui-block-b"><input type="reset" value="Leaderboard" data-theme="b" /></div>
        </fieldset>
    </div>
    <div class="ui-block-a">
        <div style="text-align: center">
            <div style="text-align: center">
                <h2><?php echo date('Y-m-d H:i:s'); ?></h2>
            </div>
        </div>
    </div>

    <div class="ui-block-a">
        <ul data-role="listview" > <!-- data-inset="true" -->
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">&nbsp;</div>
                    <div class="ui-block-b">Name</div>
                    <div class="ui-block-c">Points</div>
                </div>
            </li>
            <?php
                $rank_num = 1;
                foreach ($leaderboard as $row) {
                    echo '<li>';
                        echo '<div class="ui-grid-b">';
                        echo '<div class="ui-block-a">' . $rank_num . '</div>';
                        echo '<div class="ui-block-b">' . $row['user_id'] . '</div>';
                        echo '<div class="ui-block-c">' . number_format($row['points']) . '</div>';
                        echo '</div>';
                    echo '</li>';
            
                    $rank_num += 1;
                }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
