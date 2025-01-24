<?php
declare(strict_types=1);

namespace Src\Middleware;

use Src\Services\JwtService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthMiddleware implements MiddlewareInterface
{
    private JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function handle(Request $request, Response $response, callable $next): Response
    {
        $authHeader = $request->headers->get('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return new Response('Unauthorized', 401);
        }

        $token = $matches[1];

        try {
            $this->jwtService->validateToken($token);
        } catch (\InvalidArgumentException $e) {
            return new Response('Unauthorized', 401);
        }

        return $next($request, $response);
    }
}