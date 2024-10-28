<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/events.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/tickets.php');

$event = new Events();
$ticket = new Tickets();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Покупка билетов</title>
</head>
<body>
