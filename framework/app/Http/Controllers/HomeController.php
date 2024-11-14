<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Response\Response;

class HomeController
{

    public function indexAction(RequestInterface $request): ResponseInterface
    {
        echo 'Home Index';
        return new Response(200, 'OK');
    }

    public function aboutAction(): ResponseInterface
    {
        echo 'About Index';
        return new Response(200, 'OK');
    }
}