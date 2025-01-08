<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController
{

    public function __construct(private readonly UserRepository$repository)
    {
    }

    public function index(Request $request, Response $response): Response
    {
        return $response->send($this->repository->getList());
    }

    public function findByEmail(Request $request, Response $response):Response
    {
        return $response->send($this->repository->findByEmail($request->get('email')));
    }

    public function update(Request $request, Response $response):Response
    {
        return $response->send($this->repository->update($request->get('email'), $request->get('data')));
    }

    public function delete(Request $request, Response $response):Response
    {
        return $response->send($this->repository->delete($request->get('email')));
    }
}