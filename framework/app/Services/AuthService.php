<?php
declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Services\DataClasses\LoginData;

class AuthService
{

    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function login(LoginData $data): array
    {
        $user = $this->repository->findByEmail($data->getEmail());

        if (!$user || $user['password'] !== hash('sha256', $data->getPassword())) {
            return [];
        }

        $_SESSION['user_id'] = $data->getEmail();
        $_SESSION['user_role'] = 'admin';
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