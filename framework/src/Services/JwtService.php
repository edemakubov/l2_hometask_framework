<?php
declare(strict_types=1);

namespace Src\Services;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtService
{
    private string $secretKey;

    public function __construct(string $secretKey= 'secret')
    {
        $this->secretKey = $secretKey;
    }

    public function createToken(array $payload): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour from the issued time
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expirationTime;

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function validateToken(string $token): array
    {
        try {
            return (array) JWT::decode($token, new Key($this->secretKey, 'HS256'));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid token');
        }
    }
}