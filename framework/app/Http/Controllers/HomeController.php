<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\HomeService;
use Src\TemplateEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function __construct(
        private readonly HomeService $homeService,
        private TemplateEngine $templateEngine
    ) {
    }

    public function indexAction(Request $request, Response $response): Response
    {
        $content = $this->templateEngine->render('home/index', ['message' => $this->homeService->index()]);
        return $response->setContent($content);
    }

    public function aboutAction(Request $request, Response $response): Response
    {
        return $response->setContent($this->homeService->about());
    }
}
