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

        label {
            height: 100px;
            width: 150px;
        }
    </style>
</head>
<body>
<div class="ui-grid-b">

    <div class="ui-block-a">
        <div style="text-align: center">
            <h2>Pick a result</h2>

        </div>
    </div>
    <div class="ui-block-a">
         <div style="text-align: center">
            <fieldset data-role="controlgroup" data-type="horizontal" >
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2a" value="on" checked="checked">
                <label for="radio-choice-h-2a">
                    <img width="100" height="66" src="https://dl.dropboxusercontent.com/sh/uzii4bdixy0gvqy/28QhjxboVH/200px-Flag_of_Uruguay.svg.png?token_hash=AAEM1ThQOdHafAvcUmAs620V7MXebXOrgH7XPUzC5U
A1Sw" />
                    <h3>Team ONE</h3></label>
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2b" value="off">
                <label for="radio-choice-h-2b">
                    <img width="100" height="66" src="https://dl.dropboxusercontent.com/sh/uzii4bdixy0gvqy/JIN-22f5we/200px-Flag_of_the_Netherlands.svg.png?token_hash=AAEM1ThQOdHafAvcUmAs620V7MXebXOrgH
7XPUzC5UA1Sw" />
                    <h3>Team TWO</h3></label>
                <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2c" value="other">
                <label for="radio-choice-h-2c">
                    <h3>DRAW</h3></label>
            </fieldset>
         </div>
    </div>
    <div class="ui-block-a">
        &nbsp;
    </div>
    <div class="ui-block-a">
        <input type="submit" value="Done."  />
    </div>
</div>
</body>
</html>
