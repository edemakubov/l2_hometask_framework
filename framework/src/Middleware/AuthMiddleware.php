<?php

declare(strict_types=1);

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next): Response
    {
        if (!isset($_SESSION['user_id'])) {
            return new Response('Unauthorized', 401);
        }

        return $next($request, $response);
    }
}