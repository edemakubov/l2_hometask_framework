<?php

/**
 * @doc
 * Routes are defined here.
 * Each route is an array with the following
 */

use Src\Middleware\CsrfMiddleware;
use Src\Middleware\SessionMiddleware;
use Src\Middleware\XssProtectionMiddleware;

return [
    [
        'path' => '/',
        'method' => 'GET',
        'controller' => 'HomeController',
        'action' => 'indexAction',
        'middleware' => [
            SessionMiddleware::class,
            CsrfMiddleware::class,
            XssProtectionMiddleware::class
        ]
    ],

    [
        'path' => '/about',
        'method' => 'GET',
        'controller' => 'HomeController',
        'action' => 'aboutAction',
        'middleware' => []
    ],

    [
        'path' => '/contact',
        'method' => 'GET',
        'controller' => 'ContactsController',
        'action' => 'indexAction',
        'middleware' => []
    ],

    [
        'path' => '/contact',
        'method' => 'POST',
        'controller' => 'ContactsController',
        'action' => 'storeAction',
        'middleware' => []
    ],

    [
        'path' => '/login',
        'method' => 'POST',
        'controller' => 'AuthController',
        'action' => 'loginAction',
        'middleware' => []
    ],
    [
        'path' => '/login-jwt',
        'method' => 'POST',
        'controller' => 'AuthController',
        'action' => 'loginJwt',
        'middleware' => []
    ],

    [
        'path' => '/register',
        'method' => 'POST',
        'controller' => 'AuthController',
        'action' => 'registerAction',
        'middleware' => []
    ],


    [
        'path' => '/logout',
        'method' => 'GET',
        'controller' => 'AuthController',
        'action' => 'logoutAction',
        'middleware' => []
    ],

    [
        'path' => '/loginform',
        'method' => 'GET',
        'controller' => 'AuthController',
        'action' => 'loginForm',
        'middleware' => []
    ],

    [
        'path' => '/registerform',
        'method' => 'GET',
        'controller' => 'AuthController',
        'action' => 'registerForm',
        'middleware' => []
    ],

    [
        'path' => '/users',
        'method' => 'GET',
        'controller' => 'UsersController',
        'action' => 'index',
        'middleware' => []
    ],

    [
        'path' => '/cart',
        'method' => 'GET',
        'controller' => 'CartController',
        'action' => 'index',
        'middleware' => []
    ],

    [
        'path' => '/cart/add',
        'method' => 'POST',
        'controller' => 'CartController',
        'action' => 'add',
        'middleware' => []
    ],

    [
        'path' => '/cart/delete',
        'method' => 'POST',
        'controller' => 'CartController',
        'action' => 'delete',
        'middleware' => []
    ],

    [
        'path' => '/api/inventory',
        'method' => 'GET',
        'controller' => 'InventoryApiController',
        'action' => 'index',
        'middleware' => [
            \Src\Middleware\JwtAuthMiddleware::class
        ]
    ],

    [
        'path' => '/api/inventory',
        'method' => 'POST',
        'controller' => 'InventoryApiController',
        'action' => 'index',
        'middleware' => [
            \Src\Middleware\JwtAuthMiddleware::class

        ]
    ],

    [
        'path' => '/api/inventory',
        'method' => 'PUT',
        'controller' => 'InventoryApiController',
        'action' => 'update',
        'middleware' => [
            \Src\Middleware\JwtAuthMiddleware::class

        ]
    ],

    [
        'path' => '/api/inventory',
        'method' => 'DELETE',
        'controller' => 'InventoryApiController',
        'action' => 'delete',
        'middleware' => [
            \Src\Middleware\JwtAuthMiddleware::class

        ]
    ]
];
