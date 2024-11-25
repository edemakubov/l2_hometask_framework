<?php

declare(strict_types=1);

namespace Framework\Kernel;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public function __construct(
        private readonly array              $routes,
        private readonly ContainerInterface $container
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

                if (method_exists($controller, $action)) {
                    return $controller->$action($request, $response);
                }
            }
        }

        return $response->setStatusCode(404);
    }
}