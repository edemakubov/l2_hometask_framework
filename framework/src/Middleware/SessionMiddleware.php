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

        // Save session data to a cookie
        foreach ($_SESSION as $key => $value) {
            setcookie($key, serialize($value), time() + 3600, "/");
        }

        // Save and close the session
        session_write_close();

        return $response;
    }
}