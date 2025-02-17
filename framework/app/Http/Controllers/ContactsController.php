<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ContactService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactsController
{
    public function __construct(private readonly ContactService $contactService)
    {
    }

    public function indexAction(Request $request, Response $response): Response
    {
        return $response->setContent($this->contactService->index());
    }

    public function aboutAction(Request $request, Response $response): Response
    {
        return $response->setContent('Hello World');
    }
}
