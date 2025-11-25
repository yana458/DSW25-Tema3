<?php
namespace Dsw\Blog\DAO;

use Dsw\Blog\Models\Category;
use PDO;

class CategoryDAO
{
    public function __construct(
        private PDO $conn
    ) {}

    // Obtener todas las categorías (para el <select>, por ejemplo)
    public function findAll(): array
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->query($sql);

        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(
                (int)$row['id'],
                $row['name']
            );
        }

        return $categories;
    }

    // (Opcional) Obtener una categoría por id
    public function get(int $id): ?Category
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        return new Category(
            (int)$row['id'],
            $row['name']
        );
    }
}
