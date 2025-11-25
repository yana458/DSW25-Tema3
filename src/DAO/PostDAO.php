<?php
namespace Dsw\Blog\DAO;

use DateTime;
use Dsw\Blog\Models\Post;
use PDO;

class PostDAO {
    public function __construct(
        private PDO $conn
    ) {}

    public function get(int $id): ?Post {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $register = $stmt->fetch();
        if ($register) {
            return new Post($id, 
                $register['title'], 
                $register['body'], 
                new DateTime($register['publication_date']),
                $register['user_id'],
                $register['category_id'] !== null ? (int)$register['category_id'] : null   // 👈 NUEVO
            );
        }
        return null;        
    }

    public function getAll(): array {
        $posts = [];
        $sql = "SELECT * FROM posts";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $registers = $stmt->fetchAll();
        foreach($registers as $register) {
            $posts[] = new Post($register['id'], 
                $register['title'], 
                $register['body'], 
                new DateTime($register['publication_date']),
                $register['user_id'],
                $register['category_id'] !== null ? (int)$register['category_id'] : null
            );
        }
        return $posts;
    } 

    public function getByUser($userId): array {
        $posts = [];
        $sql = "SELECT * FROM posts WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $registers = $stmt->fetchAll();
        foreach($registers as $register) {
            $posts[] = new Post($register['id'], 
                $register['title'], 
                $register['body'], 
                new DateTime($register['publication_date']),
                $register['user_id'],
                $register['category_id'] !== null ? (int)$register['category_id'] : null
            );
        }
        return $posts;
    }

    public function create(Post $post): Post {
        $sql = "INSERT INTO posts (title, body, publication_date, user_id, category_id)
            VALUES (:title, :body, NOW(), :user_id, :category_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'user_id' => $post->getUserId(),
            'category_id' => $post->getCategoryId(),  // puede ser null
        ]);

        $post->setId($this->conn->lastInsertId());
        return $post;
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function update(Post $post) {
        $sql = "UPDATE posts SET title=:title, body=:body, user_id=:user_id,  category_id = :category_id  WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'user_id' => $post->getUserId()
        ]);
    }

    public function findByFollowedUsers(int $userId, int $limit = 10): array
{
    $sql = "SELECT p.*
            FROM posts p
            JOIN follows f ON p.user_id = f.followed_id
            WHERE f.follower_id = :user_id
            ORDER BY p.publication_date DESC
            LIMIT :limit";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    $posts = [];

    foreach ($rows as $row) {
        $posts[] = new \Dsw\Blog\Models\Post(
            (int)$row['id'],
            $row['title'],
            $row['body'],
            new \DateTime($row['publication_date']),
            (int)$row['user_id']
        );
    }

    return $posts;
}
    public function getMostLiked(int $limit = 5): array
{
    // Esta consulta busca los posts y cuenta cuántos likes tiene cada uno.
    // LEFT JOIN: para que también salgan posts con 0 likes.
    $sql = "SELECT p.*, COUNT(l.post_id) AS like_count
            FROM posts p
            LEFT JOIN likes l ON p.id = l.post_id
            GROUP BY p.id
            ORDER BY like_count DESC, p.id DESC
            LIMIT :limit";

    // Preparamos la consulta (IMPORTANTE para evitar inyección y poder usar parámetros)
    $stmt = $this->conn->prepare($sql);

    // bindValue porque pasamos un valor concreto (no una variable que vaya a cambiar luego)
    // PARAM_INT porque LIMIT debe ser un número entero
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    // Ejecutamos la consulta
    $stmt->execute();

    // Devolvemos todos los resultados como array asociativo
    // Cada fila tendrá: id, title, body, publication_date, user_id, like_count
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}

public function searchByKeyword(string $keyword): array
{
    // 🔹 1. Preparamos el patrón para el LIKE
    // Si buscas "php", queremos encontrar "php", "curso php", "aprender php hoy", etc.
    // Por eso usamos %palabra% (contiene).
    $like = '%' . $keyword . '%';

    // 🔹 2. La consulta busca en title y en body
    // ORDER BY para mostrar primero los más recientes (por fecha de publicación).
    $sql = "SELECT *
            FROM posts
            WHERE title LIKE :q
               OR body  LIKE :q
            ORDER BY publication_date DESC";

    // 🔹 3. Preparamos la consulta (IMPORTANTE para evitar inyección SQL)
    $stmt = $this->conn->prepare($sql);

    // 🔹 4. Enlazamos el parámetro :q con nuestro patrón %keyword%
    // bindValue porque le pasamos el VALOR ya calculado.
    $stmt->bindValue(':q', $like, PDO::PARAM_STR);

    // 🔹 5. Ejecutamos la consulta
    $stmt->execute();

    // 🔹 6. Obtenemos todas las filas como array asociativo
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🔹 7. Convertimos cada fila en un objeto Post
    $posts = [];

    foreach ($rows as $row) {
        $posts[] = new \Dsw\Blog\Models\Post(
            (int)$row['id'],
            $row['title'],
            $row['body'],
            // Suponemos que la columna se llama publication_date
            new \DateTime($row['publication_date']),
            (int)$row['user_id']
        );
    }

    // 🔹 8. Devolvemos un array de objetos Post
    return $posts;
}

public function findByCategory(int $categoryId): array
{
    $sql = "SELECT * FROM posts
            WHERE category_id = :category_id
            ORDER BY publication_date DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['category_id' => $categoryId]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $posts = [];

    foreach ($rows as $row) {
        $posts[] = new Post(
            (int)$row['id'],
            $row['title'],
            $row['body'],
            $row['publication_date'] ? new DateTime($row['publication_date']) : null,
            (int)$row['user_id'],
            $row['category_id'] !== null ? (int)$row['category_id'] : null
        );
    }

    return $posts;
}


}