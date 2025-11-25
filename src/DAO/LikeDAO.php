<?php
namespace Dsw\Blog\DAO;

class LikeDAO {
    public function __construct(
        private \PDO $conn
    ) {}


    public function addLike(int $userId, int $postId): void {
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
    }

    public function removeLike(int $userId, int $postId): void {
        $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
    }

    public function hasUserLikedPost(int $userId, int $postId): bool {
        $sql = "SELECT COUNT(*) as like_count FROM likes WHERE user_id = :user_id AND post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'post_id' => $postId
        ]);
        $result = $stmt->fetch();
        return $result['like_count'] > 0;
    }
    
    public function countLikes(int $postId): int {
        $sql = "SELECT COUNT(*) as like_count FROM likes WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['post_id' => $postId]);
        $result = $stmt->fetch();
        return (int)$result['like_count'];
    }


}