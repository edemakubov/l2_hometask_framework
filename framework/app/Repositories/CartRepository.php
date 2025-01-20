<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\CartItem;
use Symfony\Component\HttpFoundation\Request;

class CartRepository extends Repository
{

    public function list(Request $request): array
    {
        $query = $this->pdo->prepare('SELECT
        cart.*,
        inventory.price,
        inventory.title
    FROM
        cart
    JOIN
        inventory ON cart.inventory_id = inventory.id
    WHERE
        cart.user_id = :user_id');
        $query->execute([
            'user_id' => $request->getSession()->get('user_id')
        ]);
        $rows = $query->fetchAll();

        $cartItems = [];
        foreach ($rows as $row) {
            $cartItem = new CartItem();
            $cartItem->setId((int)$row['id']);
            $cartItem->setUserId((int)$row['user_id']);
            $cartItem->setInventoryId((int)$row['inventory_id']);
            $cartItem->setQuantity((int)$row['quantity']);
            $cartItem->setTitle((string)$row['title']);
            $cartItem->setPrice((int)$row['price']);
            $cartItems[] = $cartItem;
        }

        return $cartItems;

    }

    public function add(int $userId, int $inventoryId, int $quantity): bool
    {
        if ($item = $this->findByUserIdAndInventoryId($userId, $inventoryId)) {
            $query = $this->pdo->prepare('UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND inventory_id = :inventory_id');
            return $query->execute([
                'user_id' => $userId,
                'inventory_id' => $inventoryId,
                'quantity' => $item->getQuantity() + $quantity
            ]);
        }

        $query = $this->pdo->prepare('INSERT INTO cart (user_id, inventory_id, quantity) VALUES (:user_id,:inventory_id, :quantity)');
        return $query->execute([
            'user_id' => $userId,
            'inventory_id' => $inventoryId,
            'quantity' => $quantity
        ]);

    }

    public function delete(int $id): bool
    {
        $query = $this->pdo->prepare('DELETE FROM cart WHERE id = :id');
        return $query->execute([
            'id' => $id
        ]);
    }

    public function findByUserIdAndInventoryId(int $userId, int $inventoryId): CartItem|bool
    {
        $query = $this->pdo->prepare('SELECT * FROM cart WHERE user_id = :user_id AND inventory_id = :inventory_id');
        $query->execute([
            'user_id' => $userId,
            'inventory_id' => $inventoryId
        ]);
        return $query->fetchObject(CartItem::class);
    }

}