<?php

date_default_timezone_set('America/Los_Angeles');

require_once('../include/UserTools.php');
$userTools = new UserTools();

$start_time = strtotime('tomorrow');
$end_time = strtotime('tomorrow 23:59');

$games = $userTools->getAllGamesByDate($start_time, $end_time);

$to = 'sid@pandora.com';

$subject = 'Test email';

$headers = "From: sid@pandacup.us"  . "\r\n";
$headers .= "Reply-To: sid@pandacup.us" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = file_get_contents("reminder.html");
echo $message;
mail($to, $subject, $message, $headers);

?>