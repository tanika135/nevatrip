<?php

require_once __DIR__ . '/dataprovider.php';

class Connection implements Dataprovider
{
    protected $pdo;

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

    public function getConnection()
    {
        return $this->pdo;
    }
}