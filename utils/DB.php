<?php

class DB
{
    private static ?DB $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $this->connection = $this->createConnection();
    }

    private function createConnection(): PDO
    {
        // Replace with your database connection details
        $dsn = 'mysql:host=localhost;dbname=php_test;charset=utf8mb4';
        $username = 'root';
        $password = '';

        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function exec(string $sql, array $params = []): int
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function select(string $sql, array $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
