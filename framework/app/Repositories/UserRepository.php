<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Services\DataClasses\LoginData;
use Src\Kernel\DatabaseConnection;

class UserRepository extends Repository
{

    public function __construct(DatabaseConnection $connection)
    {
        parent::__construct($connection);
    }

    public function getList(): array
    {
        return $this->pdo->query('SELECT * FROM users')->fetchAll();
    }

    public function create(LoginData $data): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        $stmt->execute([
            'email' => $data->getEmail(),
            'password' => hash('sha256', $data->getPassword())
        ]);
    }

    public function findByEmail(mixed $get): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $get]);
        return $stmt->fetch();
    }

    public function update(mixed $get, LoginData $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET email = :email, password = :password WHERE email = :email');
        return $stmt->execute([
            'email' => $data->getEmail(),
            'password' => hash('sha256', $data->getPassword())
        ]);
    }

    public function delete(mixed $get): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE email = :email');
        return $stmt->execute(['email' => $get]);
    }
}