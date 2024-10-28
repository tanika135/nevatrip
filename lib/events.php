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
     * Получает названия всех событий из БД
     */
    public function getEvent () :array
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
}