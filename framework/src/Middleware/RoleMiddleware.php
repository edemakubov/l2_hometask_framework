<?php

declare(strict_types=1);

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware implements MiddlewareInterface
{
    private array $allowedRoles;

    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function handle(Request $request, Response $response, callable $next): Response
    {
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], $this->allowedRoles)) {
            return new Response('Forbidden', 403);
        }

        return $next($request, $response);
    }
}