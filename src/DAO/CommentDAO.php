<?php
namespace Dsw\Blog\DAO;

use Dsw\Blog\Models\Comment;
use PDO;

class CommentDAO
{
    public function __construct(
        private PDO $conn
    ) {}

    // Añadir un comentario a un post
    public function add(int $postId, int $userId, string $body): int
    {
        $sql = "INSERT INTO comments (body, post_id, user_id, created_at)
                VALUES (:body, :post_id, :user_id, NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'body'    => $body,
            'post_id' => $postId,
            'user_id' => $userId,
        ]);

        return (int)$this->conn->lastInsertId();
    }

    // 🔹 NUEVO: obtener un comentario por id
    public function get(int $id): ?Comment
    {
        $sql = "SELECT * FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Comment(
            (int)$row['id'],
            $row['body'],
            (int)$row['post_id'],
            (int)$row['user_id'],
            new \DateTime($row['created_at'])
        );
    }

    // Obtener todos los comentarios de un post (con nombre de usuario)
    public function findByPost(int $postId): array
    {
        $sql = "SELECT c.*, u.name AS user_name
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.post_id = :post_id
                ORDER BY c.created_at ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['post_id' => $postId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];

        foreach ($rows as $row) {
            $comments[] = new Comment(
                (int)$row['id'],
                $row['body'],
                (int)$row['post_id'],
                (int)$row['user_id'],
                new \DateTime($row['created_at']),
                $row['user_name']     // nombre del autor
            );
        }

        return $comments;
    }

    // Borrar un comentario por id
    public function delete(int $id): void
    {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
}
