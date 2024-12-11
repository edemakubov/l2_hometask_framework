<?php

declare(strict_types=1);


namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next): Response
    {
        // Start the session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Call the next middleware/controller
        $response = $next($request, $response);

        // Save and close the session
        session_write_close();

        return $response;
    }
}