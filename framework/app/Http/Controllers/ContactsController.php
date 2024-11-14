<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Response\Response;

class ContactsController
{
    public function indexAction(RequestInterface $request): ResponseInterface
    {
        echo 'Contacts Index';
        echo 'Some Address';
        echo 'Some Phone';

        return new Response(200, 'OK');
    }

    public function storeAction(RequestInterface $request): ResponseInterface
    {
        echo 'Store Contact';

        return new Response(200, 'OK');
    }

}