<?php
declare(strict_types=1);

namespace App\Repositories;

class CartRepository extends Repository
{

    public function add(int $inventoryId, int $quantity): void
    {
        $query = $this->pdo->prepare('INSERT INTO cart (inventory_id, quantity) VALUES (:inventory_id, :quantity)');
        $query->execute([
            'inventory_id' => $inventoryId,
            'quantity' => $quantity
        ]);

    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM cart WHERE id = :id');
        $query->execute(['id' => $id]);
    }

}