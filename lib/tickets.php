<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/lib/api.php');

class Tickets
{
    private $connection;

    const BARCODE_LENGTH = 8;

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
     * @param int $orderId
     * @param array $ticketType
     * @param string $barcode
     * @return void
     * Сохраняет данные о билетах в БД
     */
    public function saveTickets(int $eventId, int $orderId, array $types) :void
    {
        foreach ($types as $type => $quantity) {
            if ($quantity != 0) {
                for ($i = 0; $i < $quantity; $i++) {
                    $this->saveTicket($eventId, $orderId, $type);
                }
            }
        }
    }

    public function saveTicket (int $eventId, int $orderId, string $type)
    {
        try {
            $code = $this->getBarcode($eventId, $type, self::BARCODE_LENGTH);

            $query = "INSERT INTO tickets VALUES (
                                    NULL, 
                                    :order,
                                    :ticketType,
                                    :barcode)";
            $tickets = $this->connection->getConnection()->prepare($query);
            $tickets->execute(
                [
                    "order" => $orderId,
                    "ticketType" => $type,
                    "barcode" => $code,
                ],
            );

        } catch (Exception $e) {
            echo $e;
            return false;
        }
        return true;
    }

    public function getBarcode(int $eventId, $type, int $length = 8)
    {
        $foundRemote = false;

        $event = new Events($this->connection);
        $eventData = $event->getEvent($eventId);

        $api = new Api();

        $adultQuantity = $type == 'ticket_adult' ? 1 : 0;
        $kidQuantity = $type == 'ticket_kid' ? 1 : 0;

        do {
            $code = $this->generateBarcode($length);

            $foundLocal = $this->searchBarcodeLocal($code);
            if ($foundLocal)
                continue;

            $foundRemote = !$api->book($eventId, $eventData['event_date'], (int) $eventData['ticket_adult_price'],
                $adultQuantity, (int) $eventData['ticket_kid_price'], $kidQuantity, $code);

            echo $foundRemote;

        } while($foundRemote);

        if ($api->approve($code)) {
            return $code;
        } else {
            throw new Exception($api->message);
        }
    }

    public function searchBarcodeLocal(string $barcode)
    {
        $query = "SELECT * FROM tickets WHERE barcode = :barcode LIMIT 1" ;
        $tickets = $this->connection->getConnection()->prepare($query);
        $tickets->execute(
            [
                "barcode" => $barcode,
            ],
        );
        return $tickets->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     * генерация баркода
     */
    public function generateBarcode(int $length = 8)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}