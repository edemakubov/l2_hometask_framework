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
        'action' => 'indexAction'
    ],

    [
        'path' => '/about',
        'method' => 'GET',
        'controller' => 'HomeController',
        'action' => 'aboutAction'
    ],

    [
        'path' => '/contact',
        'method' => 'GET',
        'controller' => 'ContactsController',
        'action' => 'indexAction'
    ],

    [
        'path' => '/contact',
        'method' => 'POST',
        'controller' => 'ContactsController',
        'action' => 'storeAction'
    ]
];