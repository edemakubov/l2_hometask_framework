<?php

declare(strict_types=1);

namespace Src\Kernel;

use Psr\Container\ContainerInterface;
use Src\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareStack
{
    private array $middlewares = [];

    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function add(MiddlewareInterface|string $middleware): void
    {

        $this->middlewares[] = $middleware;
    }

    public function handle(Request $request, Response $response, callable $core)
    {
        $middleware = array_shift($this->middlewares);
        if ($middleware) {
            $middlewareInstance = $this->container->get($middleware);

            return $middlewareInstance->handle($request, $response, function ($request, $response) use ($core) {
                return $this->handle($request, $response, $core);
            });
        }

        return $core($request, $response);
    }
}