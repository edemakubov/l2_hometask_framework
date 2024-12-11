<?php

declare(strict_types=1);


namespace Src\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class XssProtectionMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next): Response
    {
        // Sanitize all input data
        $sanitizedRequest = $this->sanitizeRequest($request);

        // Call the next middleware/controller
        return $next($sanitizedRequest, $response);
    }

    private function sanitizeRequest(Request $request): Request
    {
        $sanitizedRequest = clone $request;

        foreach ($request->request->all() as $key => $value) {
            $sanitizedRequest->request->set($key, $this->sanitize($value));
        }

        foreach ($request->query->all() as $key => $value) {
            $sanitizedRequest->query->set($key, $this->sanitize($value));
        }

        return $sanitizedRequest;
    }

    private function sanitize($value)
    {
        if (is_array($value)) {
            return array_map([$this, 'sanitize'], $value);
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}