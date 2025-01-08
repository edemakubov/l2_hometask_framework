<?php
declare(strict_types=1);

namespace App\Repositories;

use Src\Kernel\DatabaseConnection;

class Repository
{
    protected $pdo;

    public function __construct(DatabaseConnection $connection)
    {
        $this->pdo = $connection->getConnection();
    }
}