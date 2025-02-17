<?php
declare(strict_types=1);

namespace Src\Kernel;

use PDO;
use PDOException;

class DatabaseConnection
{
    private PDO $connection;

    public function __construct(string $host, int$port,string $dbname, string $user, string $password)
    {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        try {
            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \RuntimeException('Connection failed: ' . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}