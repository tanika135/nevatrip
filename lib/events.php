<?php

class Events
{
    private $connection;

    public function __construct(Dataprovider $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     * Получает все события из БД
     */
    public function getEvents () :array
    {
        try {
            $query = "SELECT * FROM events";

            $event = $this->connection->getConnection()->prepare($query);
            $event->execute();
            $events = $event->fetchAll();

        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: " . $e->getMessage();
        }
        return $events ? $events : [];
    }

    /**
     * @param int $id
     * @return array
     * Получает событие id
     */
    public function getEvent (int $id) :array
    {
        try {
            $query = "SELECT * FROM events WHERE id = :id LIMIT 1";

            $event = $this->connection->getConnection()->prepare($query);
            $event->execute([
                'id' => $id
            ]);
            $events = $event->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: " . $e->getMessage();
        }
        return $events ? $events : [];
    }

    /**
     * @param array $tickets
     * @param int $eventId
     * @return int
     * Считает стоимость заказа
     */
    public function getTotalPrice (array $tickets, int $eventId) :int
    {
        $totalPrice = 0;
        foreach ($tickets as $priceName => $quantity){
            try {

                $name = $priceName."_price";

                $query = "SELECT $name FROM events WHERE id = :id";

                $price = $this->connection->getConnection()->prepare($query);
                $price->bindParam(':id', $eventId, PDO::PARAM_INT);
                $price->execute();
                $prices = $price->fetch(PDO::FETCH_COLUMN);

                $totalPrice += $prices * $quantity;

            } catch (PDOException $e) {
                echo "Ошибка выполнения запроса: " . $e->getMessage();
            }
        }
        return $totalPrice;
    }
}