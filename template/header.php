<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/connection.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/events.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/tickets.php');


$connection = new Connection();
$event = new Events($connection);
$ticket = new Tickets($connection);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Покупка билетов</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="/ajax/script.js"></script>
</head>
<body>
