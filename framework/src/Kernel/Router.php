<?php

declare(strict_types=1);

namespace Src\Kernel;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class Router
{

    public function __construct(
        private readonly array $routes,
        private readonly ContainerInterface $container,
        private readonly ResponseFactoryInterface $responseFactory)
    {
    }

    public function dispatch(RequestInterface $request): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                $controller = $this->container->get($route['controller']);
                $action = $route['action'];

                if (method_exists($controller, $action)) {
                    return $controller->$action($request);
                }
            }
        }

        return $this->responseFactory->createResponse(404, 'Not Found');
    }
}