<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\DataClasses\LoginData;
use Src\TemplateEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{

    public function __construct(
        private readonly AuthService    $authService,
        private readonly TemplateEngine $templateEngine)
    {
    }


    public function loginForm(Request $request, Response $response): Response
    {
        $html = $this->templateEngine->render('auth/login');

        return $response->setContent($html);
    }

    public function loginAction(Request $request, Response $response): Response
    {
        $this->authService->login(LoginData::fromRequest($request->getPayload()), $request);
        $html = $this->templateEngine->render('message/index', ['message' => 'USER LOGGED IN']);
        return $response->setContent($html);
    }

    public function loginJwt(Request $request, Response $response): Response
    {
        $secret = $this->authService->loginJWT(LoginData::fromRequest($request->getPayload()), $request);
        return $response->setContent(json_encode(['token' => $secret]));

    }

    public function registerForm(Request $request, Response $response): Response
    {
        $html = $this->templateEngine->render('auth/register');

        return $response->setContent($html);
    }

    public function registerAction(Request $request, Response $response): Response
    {
        $this->authService->register(LoginData::fromRequest($request->getPayload()), $request);
        $html = $this->templateEngine->render('message/index', ['message' => 'USER REGISTERED']);
        return $response->setContent($html);
    }


    public function logoutAction(Request $request, Response $response)
    {
        $this->authService->logout($request);
        $html = $this->templateEngine->render('message/index', ['message' => 'USER LOGGED OUT']);
        return $response->setContent($html);
    }
}