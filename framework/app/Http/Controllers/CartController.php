<?php
declare(strict_types=1);

namespace App\Http\Controllers;


use App\Repositories\CartRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController
{

    public function __construct(private readonly CartRepository $cartService)
    {
    }

    public function add(Request $request, Response $response): Response
    {
        return $response->send($this->add($request->get('data')));
    }

    public function delete(Request $request, Response $response): Response
    {
        return $response->send($this->delete($request->get('id')));

    }
}