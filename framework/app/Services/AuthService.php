<?php
declare(strict_types=1);

namespace App\Services;

use App\Services\DataClasses\LoginData;

class AuthService
{
    public function login(LoginData $data): array
    {
        return $data->asArray();
    }

    public function register(array $data): array
    {
        return $data;
    }

    public function logout(array $data): array
    {
        return $data;
    }
}