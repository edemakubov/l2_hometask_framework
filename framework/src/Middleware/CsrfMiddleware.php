<?php

declare(strict_types=1);

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next): Response
    {
        if ($request->getMethod() === 'POST') {
            $sessionToken = $_SESSION['csrf_token'] ?? '';
            $requestToken = $request->request->get('_csrf_token', '');

            if (!$sessionToken || !$requestToken || $sessionToken !== $requestToken) {
                return new Response('Invalid CSRF token', 403);
            }
        }

        // Generate a new CSRF token for the next request
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Call the next middleware/controller
        return $next($request, $response);
    }

}