<?php
declare(strict_types=1);

namespace App\Repositories;

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

    public function getList(): array
    {
        return $this->pdo->query('SELECT * FROM inventory')->fetchAll();
    }

    public function delete(int $id): void
    {
        $query = $this->pdo->prepare('DELETE FROM inventory WHERE id = :id');
        $query->execute(['id' => $id]);
    }

}