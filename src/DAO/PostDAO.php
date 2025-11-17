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

    // FUNCION PARA CONTAR CUANTOS ARTICULOS TIENE CADA USUARIO
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
}