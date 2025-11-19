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
                $register['user_id']
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
                $register['user_id']
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
                $register['user_id']
            );
        }
        return $posts;
    }

    public function create(Post $post): Post {
        $sql = "INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'user_id' => $post->getUserId()
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
        $sql = "UPDATE posts SET title=:title, body=:body, user_id=:user_id WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'body' => $post->getBody(),
            'user_id' => $post->getUserId()
        ]);
    }
}
