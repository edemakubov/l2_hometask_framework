<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\User;
use App\Repositories\UserRepository;
use App\Services\DataClasses\LoginData;
use Exception;
use Src\Services\JwtService;
use Symfony\Component\HttpFoundation\Request;

class AuthService
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly JwtService $jwtService
    ) {
    }

    public function login(LoginData $data, Request $request): User
    {
        $user = $this->repository->findByEmail($data->getEmail());

        if (!$user || !$user->checkPassword($data->getPassword())) {
            throw new Exception('Invalid credentials');
        }

        $this->setSessionForUser($user, $request);

        return $user;
    }

    public function register(LoginData $data, Request $request): User
    {
        $user = $this->repository->findByEmail($data->getEmail());

        if ($user) {
            throw new Exception('User already exists');
        }

        $user = $this->repository->create($data);

        $this->setSessionForUser($user, $request);

        return $user;
    }

    public function logout(Request $request): void
    {
        $session = $request->getSession();
        $session->remove('user_id');
        $session->remove('user_email');
        $session->remove('user_role');
    }

    private function setSessionForUser(User $user, Request $request): void
    {
        $session = $request->getSession();
        $session->set('user_id', $user->getId());
        $session->set('user_email', $user->getEmail());
        $session->set('user_role', $user->getRole()->value);
    }


    public function loginJWT(LoginData $data, Request $response): string
    {
        $user = $this->repository->findByEmail($data->getEmail());

        if (!$user || !$user->checkPassword($data->getPassword())) {
            throw new Exception('Invalid credentials');
        }

        return $this->jwtService->createToken([
            'user_id' => $user->getId(),
            'user_email' => $user->getEmail(),
            'user_role' => $user->getRole()->value
        ]);
    }
}
