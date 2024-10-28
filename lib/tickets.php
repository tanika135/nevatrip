<?php

class Tickets
{
    private $connection;

    public function __construct(Dataprovider $connection)
    {
        $this->connection = $connection;
    }

    public function createTable()
    {
        $query = "CREATE TABLE IF NOT EXISTS tickets (
            id INT(10) NOT NULL AUTO_INCREMENT,
            order_id INT(10) NOT NULL,
            ticket_type VARCHAR(20) NOT NULL,
            barcode VARCHAR(120) NOT NULL,
            PRIMARY KEY (id))";

        $count = $this->connection->getConnection()->exec($query);

        if ($count === false) {
            throw new Exception("Не удалось создать таблицу" . print_r($this->connection->getConnection()->errorInfo(), true));
        }
    }

    /**
     * @param int $eventId
     * @param int $userId
     * @param string $ticketType
     * @param string $barcode
     * @return void
     * Сохраняет данные о билете в БД
     */
    public function saveTicket (int $orderId, string $ticketType, string $barcode)
    {
        $query = "INSERT INTO tickets VALUES (
                                    NULL, 
                                    :order,
                                    :ticketType,
                                    :barcode)";
        $tickets = $this->connection->getConnection()->prepare($query);
        $tickets->execute(
            [
                "order" => $orderId,
                "ticketType" => $ticketType,
                "barcode" => $barcode,
            ],
        );
    }
}