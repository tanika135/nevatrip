<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/connection.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/tickets.php");

$connection = new Connection();
$ticket = new Tickets($connection);

if ($_POST["submit"]) {
    $ticket->saveTicket(1, "ticket_kid", "jfjvjvfmk");
}