<?php

namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionMiddleware implements MiddlewareInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function handle(Request $request, Response $response, callable $next): Response
    {
        $this->getSession();

        $request->setSession($this->session);

        return $next($request, $response);
    }

    private function getSession(): SessionInterface
    {
        if (!$this->session->isStarted()) {
            $this->session->start();
        }

        return $this->session;
    }
}