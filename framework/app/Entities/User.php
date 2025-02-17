<?php

declare(strict_types=1);

namespace App\Entities;

use App\Constants\UserRoleEnum;

class User
{
    private int $id;
    private string $email;
    private string $password;

    private string $role;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function checkPassword(string $getPassword): bool
    {
        return $this->password === hash('sha256', $getPassword);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }

    public function getRole(): UserRoleEnum
    {
        return UserRoleEnum::from($this->role);
    }
}
