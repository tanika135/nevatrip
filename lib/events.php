<?php

class Events
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO(
                'mysql:host=localhost;dbname=tickets',
                'root',
                '',
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

        } catch (\PDOException $e) {
            echo "Невозможно установить соединение с базой данных";
        }
    }

    public function getEvent () :array
    {
        try {
            $query = "SELECT event_name FROM events";

            $event = $this->pdo->prepare($query);
            $event->execute();
            $events = $event->fetchAll();

        } catch (PDOException $e) {
            echo "Ошибка выполнения запроса: " . $e->getMessage();
        }

        return $events ? $events : [];
    }
}