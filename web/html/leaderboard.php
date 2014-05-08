<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <style type="text/css">
        .ui-block-b  {
            text-align: left;
        }
        .ui-block-c {
            text-align: right;
        }
    </style>
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
            <h2>Leaderboard</h2>
            <h3>Updated whenever</h3>
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
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
            <li>
                <div class="ui-grid-b">
                    <div class="ui-block-a">1</div>
                    <div class="ui-block-b">Joe Person</div>
                    <div class="ui-block-c">70</div>
                </div>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
