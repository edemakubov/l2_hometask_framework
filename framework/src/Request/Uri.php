<?php

namespace Src\Request;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    private string $scheme;
    private string $userInfo;
    private string $host;
    private string $port;
    private string $path;
    private string $query;
    private string $fragment;

    public function __construct(
    ) {
        $this->scheme = $_SERVER['REQUEST_SCHEME'] ?? 'http';
        $this->userInfo = '';
        $this->host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $this->port = $_SERVER['SERVER_PORT'] ?? null;
        $this->path = explode('?', $_SERVER['REQUEST_URI'])[0] ?? '/';
        $this->query = $_SERVER['QUERY_STRING'] ?? '';
        $this->fragment = '';
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        $authority = $this->host;
        if ($this->userInfo) {
            $authority = $this->userInfo . '@' . $authority;
        }
        if ($this->port) {
            $authority .= ':' . $this->port;
        }
        return $authority;
    }

    public function getUserInfo(): string
    {
        return $this->userInfo;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getFragment(): string
    {
        return $this->fragment;
    }

    public function withScheme($scheme): UriInterface
    {
        $new = clone $this;
        $new->scheme = $scheme;
        return $new;
    }

    public function withUserInfo($user, $password = null): UriInterface
    {
        $new = clone $this;
        $new->userInfo = $user . ($password ? ':' . $password : '');
        return $new;
    }

    public function withHost($host): UriInterface
    {
        $new = clone $this;
        $new->host = $host;
        return $new;
    }

    public function withPort($port): UriInterface
    {
        $new = clone $this;
        $new->port = $port;
        return $new;
    }

    public function withPath($path): UriInterface
    {
        $new = clone $this;
        $new->path = $path;
        return $new;
    }

    public function withQuery($query): UriInterface
    {
        $new = clone $this;
        $new->query = $query;
        return $new;
    }

    public function withFragment($fragment): UriInterface
    {
        $new = clone $this;
        $new->fragment = $fragment;
        return $new;
    }

    public function __toString(): string
    {
        $uri = '';
        if ($this->scheme) {
            $uri .= $this->scheme . ':';
        }
        if ($authority = $this->getAuthority()) {
            $uri .= '//' . $authority;
        }
        if ($this->path) {
            if ($uri && $this->path[0] !== '/') {
                $uri .= '/';
            }
            $uri .= $this->path;
        }
        if ($this->query) {
            $uri .= '?' . $this->query;
        }
        if ($this->fragment) {
            $uri .= '#' . $this->fragment;
        }
        return $uri;
    }
}