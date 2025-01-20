<?php
declare(strict_types=1);

namespace App\Services\DataClasses;

use Symfony\Component\HttpFoundation\InputBag;

class LoginData
{
    public function __construct(
        private readonly string $email,
        private readonly string $password
    )
    {}

    public static function fromRequest(InputBag $getPayload): self
    {
        return new self(
            email: $getPayload->get('email'),
            password: $getPayload->get('password')
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}