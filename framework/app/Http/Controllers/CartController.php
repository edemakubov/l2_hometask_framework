<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Repositories\CartRepository;
use Src\TemplateEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController
{

    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly TemplateEngine $templateEngine
    )
    {
    }

    public function index(Request $request, Response $response): Response
    {
        $html = $this->templateEngine->render('cart/index', ['items' => $this->cartRepository->list($request)]);
        return $response->setContent($html);
    }

    public function add(Request $request, Response $response): Response
    {
        $this->cartRepository->add(
            userId: (int)$request->getSession()->get('user_id'),
            inventoryId: (int)$request->get('inventory_id'),
            quantity: (int)$request->get('quantity'));
        return $this->index($request, $response);
    }

    public function delete(Request $request, Response $response): Response
    {
        $this->cartRepository->delete((int)$request->get('inventory_id'));
        return $this->index($request, $response);
    }
}