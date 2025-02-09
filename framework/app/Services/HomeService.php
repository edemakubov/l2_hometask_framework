<?php

declare(strict_types=1);

namespace App\Services;

class HomeService
{
    public function index(): string
    {
        return 'Hello World';
    }

    public function about(): string
    {
        return 'About Index';
    }
}
