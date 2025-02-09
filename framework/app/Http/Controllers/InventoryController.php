<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\InventoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InventoryController
{
    public function __construct(protected readonly InventoryRepository $repository)
    {
    }

    public function index(Request $request, Response $response): Response
    {
        return $response->send($this->repository->getList());
    }

    public function add(Request $request, Response $response): Response
    {
        return $response->send($this->repository->add($request->get('data')));
    }

    public function update(Request $request, Response $response): Response
    {
        return $response->send($this->repository->update($request->get('id'), $request->get('data')));
    }

    public function delete(Request $request, Response $response): Response
    {
        return $response->send($this->repository->delete($request->get('id')));
    }
}
