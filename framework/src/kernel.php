<?php

use Framework\Container\Container;
use Framework\Kernel\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$container = new Container();

$routes = require __DIR__ . '/../app/routes.php';
foreach ($routes as $route) {
    $controllerName = $route['controller'];
    $container->set($controllerName, "App\\Http\\Controllers\\$controllerName");
}

$serviceDir = __DIR__ . '/../app/Services';
foreach (new DirectoryIterator($serviceDir) as $fileInfo) {
    if ($fileInfo->isDot() || $fileInfo->getExtension() !== 'php') {
        continue;
    }
    $className = 'App\\Services\\' . $fileInfo->getBasename('.php');
    $container->set($className, $className);
}

// Create a new instance of the Router class
$router = new Router($routes, $container);
$request = Request::createFromGlobals();
$response = new Response();

$router->dispatch($request, $response)->send();
