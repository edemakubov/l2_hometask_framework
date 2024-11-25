<?php

declare(strict_types=1);

namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactsController
{
    public function indexAction(Request $request, Response $response): Response
    {
        return $response->setContent('Hello World');
    }

    public function aboutAction(Request $request, Response $response): Response
    {
        return $response->setContent('Hello World');
    }

}