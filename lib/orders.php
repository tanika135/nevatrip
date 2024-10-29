<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/tickets.php");

class Orders
{
    private $connection;

    public function __construct(Dataprovider $connection)
    {
        $this->connection = $connection;
        $this->createTable();
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS orders (
            id INT(10) NOT NULL AUTO_INCREMENT,
            event_id INT(10) NOT NULL,
            user_id VARCHAR(20) NOT NULL,
            equal_price INT(11) NOT NULL,
            created DATETIME NOT NULL,
            PRIMARY KEY (id))";

        $count = $this->connection->getConnection()->exec($query);

        if ($count === false) {
            throw new Exception("Не удалось создать таблицу" . print_r($this->connection->getConnection()->errorInfo(), true));
        }
    }

    public function saveOrder ($eventId, $userId, $equalPrice, $created, $types)
    {
        $this->connection->getConnection()->beginTransaction();
        $query = "INSERT INTO orders VALUES (
                                    NULL, 
                                    :eventId,
                                    :userId,
                                    :equalPrice,
                                    :created)";
        $tickets = $this->connection->getConnection()->prepare($query);
        $tickets->execute(
            [
                "eventId" => $eventId,
                "userId" => $userId,
                "equalPrice" => $equalPrice,
                "created" => $created,
            ],
        );

        $query = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";

        $OrderId = $this->connection->getConnection()->prepare($query);
        $OrderId->execute();

        $id = $OrderId->fetch(PDO::FETCH_COLUMN);;
        $ticket = new Tickets($this->connection);
        $ticket->saveTickets($eventId, $id, $types);

        $this->connection->getConnection()->commit();


    }
}