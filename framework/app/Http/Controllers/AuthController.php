<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\DataClasses\LoginData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{

    public function __construct(private readonly AuthService $authService)
    {
    }

    public function login(Request $request, Response $response): Response
    {
        $user = $this->authService->login(LoginData::fromRequest($request->getPayload()));
        return $response->setContent(json_encode($user));
    }

    public function register()
    {

    }

    public function logout()
    {

    }
}