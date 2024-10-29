<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/connection.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/orders.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/events.php");

$connection = new Connection();
$order = new Orders($connection);
$event = new Events($connection);

if ($_POST["submit"]) {
    //массив для выбора типа билетов и их количества
    $types = array_intersect_key($_POST, [
        "ticket_adult" => 0,
        "ticket_kid" => 0,
        "ticket_preferential" => 0,
        "ticket_group" => 0
    ]);

    $totalPrice = $event -> getTotalPrice($types, $_POST["event"]);
    $order->saveOrder($_POST["event"], 1, $totalPrice, date("Y-m-d H:i:s"), $types);
}