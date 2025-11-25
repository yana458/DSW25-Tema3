<?php
namespace Dsw\Blog\DAO;

use Dsw\Blog\Models\Post;
use PDO;

class FavoriteDAO
{
    public function __construct(
        private PDO $conn
    ) {}

    // Añadir a favoritos
    public function add(int $userId, int $postId): void
    {
        $sql = "INSERT INTO favorites (user_id, post_id)
                VALUES (:user_id, :post_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
    }

    // Quitar de favoritos
    public function remove(int $userId, int $postId): void
    {
        $sql = "DELETE FROM favorites
                WHERE user_id = :user_id
                  AND post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);
    }

    // ¿El usuario ya tiene guardado este post?
    public function hasUserFavoritedPost(int $userId, int $postId): bool
    {
        $sql = "SELECT COUNT(*) AS c
                FROM favorites
                WHERE user_id = :user_id
                  AND post_id = :post_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId,
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['c'] > 0;
    }

    // Obtener todos los posts favoritos de un usuario
    public function getFavoritesByUser(int $userId): array
    {
        $sql = "SELECT p.*
                FROM posts p
                JOIN favorites f ON f.post_id = p.id
                WHERE f.user_id = :user_id
                ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $posts = [];

        foreach ($rows as $row) {
            $posts[] = new Post(
                (int)$row['id'],
                $row['title'],
                $row['body'],
                new \DateTime($row['publication_date']),
                (int)$row['user_id']
            );
        }

        return $posts;
    }
}
