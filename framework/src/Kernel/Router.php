<?php

declare(strict_types=1);

namespace Src\Kernel;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function __construct(
        private readonly array              $routes,
        private readonly ContainerInterface $container,
        private array $globalMiddleware = []
    )
    {
    }

    public function dispatch(Request $request, Response $response): Response
    {
        $path = $request->getPathInfo();
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                $controller = $this->container->get($route['controller']);
                $action = $route['action'];

                $middlewareStack = new MiddlewareStack($this->container);

                // Add global middleware
                foreach ($this->globalMiddleware as $middleware) {
                    $middlewareStack->add($this->container->get($middleware));
                }

                // Add route-specific middleware
                foreach ($route['middleware'] as $middleware) {
                    $middlewareStack->add($middleware);
                }

                return $middlewareStack->handle($request, $response, function($request, $response) use ($controller, $action) {
                    return $controller->$action($request, $response);
                });
            }
        }

        return $response->setStatusCode(404);
    }
}