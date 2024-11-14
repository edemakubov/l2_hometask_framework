<?php

use Src\Container\Container;
use Src\Kernel\Router;
use Src\Request\Request;
use Src\Request\Stream;
use Src\Request\Uri;
use Src\Response\ResponseFactory;

$container = new Container();
$responseFactory = new ResponseFactory();

$routes = require __DIR__ . '/../app/routes.php';

//very simple DI container & routing. Can be changed to a more complex one if needed

foreach ($routes as $route) {
    $controllerName = $route['controller'];
    $container->set($controllerName, "App\\Http\\Controllers\\$controllerName");
}


// Create a new instance of the Router class
$router = new Router($routes, $container, $responseFactory);


$request = new Request();
$request = $request->withUri(new Uri())
    ->withBody(new Stream());

return $router->dispatch($request);

