<?php

namespace Config;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Cargar variables de entorno
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $database = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        try {
            $this->connection = new \PDO(
                "mysql:host=$host;dbname=$database;charset=utf8mb4",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (\PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
