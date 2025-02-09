<?php

use Src\Container\Container;
use Src\Kernel\DatabaseConnection;
use Src\Kernel\MiddlewareStack;
use Src\Kernel\Router;
use Src\Middleware\AuthMiddleware;
use Src\Middleware\CsrfMiddleware;
use Src\Middleware\JwtAuthMiddleware;
use Src\Middleware\SessionMiddleware;
use Src\Middleware\XssProtectionMiddleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//create a middleware to handle the request and response

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

$serviceDir = __DIR__ . '/../app/Repositories';
foreach (new DirectoryIterator($serviceDir) as $fileInfo) {
    if ($fileInfo->isDot() || $fileInfo->getExtension() !== 'php') {
        continue;
    }
    $className = 'App\\Repositories\\' . $fileInfo->getBasename('.php');
    $container->set($className, $className);
}

$JwtService = new Src\Services\JwtService();
$jwtAuthMiddleware = new JwtAuthMiddleware($JwtService);

$container->set('middlewareStack', MiddlewareStack::class);

$container->set(SessionMiddleware::class, SessionMiddleware::class);
$container->set(CsrfMiddleware::class, CsrfMiddleware::class);
$container->set(XssProtectionMiddleware::class, XssProtectionMiddleware::class);
$container->set(AuthMiddleware::class, AuthMiddleware::class);
$container->set(Src\Services\JwtService::class, $JwtService);
$container->set(JwtAuthMiddleware::class, $jwtAuthMiddleware);

$container->set(DatabaseConnection::class, function() {
    return new DatabaseConnection('postgres', 5432, 'mydatabase', 'myuser', 'mypassword');
});

$globalMiddleware = [
//    SessionMiddleware::class,
//    CsrfMiddleware::class,
//    XssProtectionMiddleware::class
];

$router = new Router($routes, $container, $globalMiddleware);
$request = Request::createFromGlobals();
$response = new Response();


$response = $router->dispatch($request, $response);

$response->send();
