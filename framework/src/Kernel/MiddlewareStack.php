<?php

declare(strict_types=1);

namespace Src\Kernel;

use Src\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareStack
{
    private array $middlewares = [];

    public function add(MiddlewareInterface $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request, Response $response, callable $core)
    {
        $middleware = array_shift($this->middlewares);

        if ($middleware) {
            return $middleware->handle($request, $response, function ($request, $response) use ($core) {
                return $this->handle($request, $response, $core);
            });
        }

        return $core($request, $response);
    }
}