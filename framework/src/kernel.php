<?php

use Framework\Container\Container;
use Framework\Kernel\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


$routes = require __DIR__ . '/../app/routes.php';

//very simple DI container & routing. Can be changed to a more complex one if needed
$container = new Container();

foreach ($routes as $route) {
    $controllerName = $route['controller'];
    $container->set($controllerName, "App\\Http\\Controllers\\$controllerName");
}

$container->set('App\\Services\\HomeService', 'App\\Services\\HomeService');

// Create a new instance of the Router class
$router = new Router($routes, $container);


$request = Request::createFromGlobals();
$response = new Response();

$router->dispatch($request, $response)->send();
