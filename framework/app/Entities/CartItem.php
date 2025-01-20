<?php
declare(strict_types=1);

namespace App\Entities;

use App\Constants\UserRoleEnum;

class CartItem
{
    private int $id;
    private int $user_id;
    private int $inventory_id;

    private int $quantity;

    private string $title;
    private int $price;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInventoryId(): int
    {
        return $this->inventory_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'inventory_id' => $this->inventory_id,
            'quantity' => $this->quantity
        ];
    }

    public function setId(int $param)
    {
        $this->id = $param;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setInventoryId(int $inventory_id): void
    {
        $this->inventory_id = $inventory_id;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }
}