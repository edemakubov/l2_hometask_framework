<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\HomeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __construct(private readonly HomeService $homeService)
    {
    }

    public function indexAction(Request $request, Response $response): Response
    {
        return $response->setContent($this->homeService->index());
    }

    public function aboutAction(Request $request, Response $response): Response
    {
        return $response->setContent($this->homeService->about());
    }
}
