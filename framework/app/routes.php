<?php

/**
 * @doc
 * Routes are defined here.
 * Each route is an array with the following
 */

return [
    [
        'path' => '/',
        'method' => 'GET',
        'controller' => 'HomeController',
        'action' => 'indexAction',
        'middleware' => []
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
        'path' => '/loginform',
        'method' => 'GET',
        'controller' => 'AuthController',
        'action' => 'loginForm',
        'middleware' => []
    ]
];
