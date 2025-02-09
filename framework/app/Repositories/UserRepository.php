<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Constants\UserRoleEnum;
use App\Entities\User;
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

    public function create(LoginData $data): User
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password, role) VALUES (:email, :password, :role)');
        $stmt->execute([
            'email' => $data->getEmail(),
            'password' => hash('sha256', $data->getPassword()),
            'role' => UserRoleEnum::USER->value
        ]);
        return $this->findByEmail($data->getEmail());
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetchObject(User::class);

        return $user ?: null;
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
