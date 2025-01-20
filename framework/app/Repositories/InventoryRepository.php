<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Inventory;

class InventoryRepository extends Repository
{
    public function create(string $title, string $description, int $price): void
    {
        $query = $this->pdo->prepare('INSERT INTO inventory (title, description, price) VALUES (:title, :description, :price)');
        $query->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price
        ]);
    }

    public function update(int $id, string $title, string $description, int $price): void
    {
        $query = $this->pdo->prepare('UPDATE inventory SET title = :title, description = :description, price = :price WHERE id = :id');
        $query->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'price' => $price
        ]);
    }

    /**
     * @return array[Inventory::class]
     */
    public function getList(): array
    {
        $rows = $this->pdo->query('SELECT * FROM inventory')->fetchAll();
        $inventories = [];

        foreach ($rows as $row) {
            $inventory = new Inventory();
            $inventory->setId((int)$row['id']);
            $inventory->setTitle((string)$row['title']);
            $inventory->setDescription((string)$row['description']);
            $inventory->setPrice((int)$row['price']);
            $inventories[] = $inventory;
        }

        return $inventories;
    }

    public function getById(int $id): Inventory
    {
        $query = $this->pdo->prepare('SELECT * FROM inventory WHERE id = :id');
        $query->execute(['id' => $id]);
        return $query->fetchObject(Inventory::class);
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM inventory WHERE id = :id');
        $query->execute(['id' => $id]);
    }

}