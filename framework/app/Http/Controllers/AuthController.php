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


    public function loginForm(Request $request, Response $response): Response
    {
        $html = <<<HTML
            <html lang="en">
                <head>
                    <title>Login</title>
                </head>
                <body>
                    <form action="/login" method="POST">
                        <input type="text" name="username" placeholder="Username" required/>
                        <input type="password" name="password" placeholder="Password" required/>
                        <input type="hidden" name="_csrf_token" value="{$_SESSION['csrf_token']}">
                        <input type="submit" value="submit"/>
                    </form>
                </body>
            </html>
            HTML;


        return $response->setContent($html);
    }

    public function loginAction(Request $request, Response $response): Response
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
