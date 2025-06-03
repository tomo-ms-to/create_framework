<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
        $dbHost = 'db'; // docker-compose.ymlで定義したサービス名
        $dbName = 'my_database';
        $dbUser = 'my_user';
        $dbPass = 'my_password';

        $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $dbUser, $dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query(string $sql, array $params = []): false|\PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}