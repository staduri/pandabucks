<?php

require_once '../include/UserTools.php';

$userTools = new UserTools();
if(isset($_SESSION) && array_key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"] == 1) {
    $userTools->logout();
    header("Location: logout.php");
} else {
    // nothign
}

?>
<html>
<head>
</head>
<body>
<div>
    <p>You will lose 30 points for doing this.</p>
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