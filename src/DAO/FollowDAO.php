<?php
namespace Dsw\Blog\DAO;

use PDO;

class FollowDAO {
    public function __construct(
        private PDO $conn
    ) {}

    public function follow(int $followerId, int $followedId): void {
        $sql = "INSERT INTO follows (follower_id, followed_id)
                VALUES (:follower_id, :followed_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'follower_id' => $followerId,
            'followed_id' => $followedId
        ]);
    }

    public function unfollow(int $followerId, int $followedId): void {
        $sql = "DELETE FROM follows
                WHERE follower_id = :follower_id
                  AND followed_id = :followed_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'follower_id' => $followerId,
            'followed_id' => $followedId
        ]);
    }

    public function isFollowing(int $followerId, int $followedId): bool {
        $sql = "SELECT COUNT(*) AS c
                FROM follows
                WHERE follower_id = :follower_id
                  AND followed_id = :followed_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'follower_id' => $followerId,
            'followed_id' => $followedId
        ]);
        $row = $stmt->fetch();
        return $row && $row['c'] > 0;
    }

    public function countFollowers(int $userId): int {
        $sql = "SELECT COUNT(*) AS c
                FROM follows
                WHERE followed_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch();
        return (int)$row['c'];
    }

    public function countFollowing(int $userId): int {
        $sql = "SELECT COUNT(*) AS c
                FROM follows
                WHERE follower_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $row = $stmt->fetch();
        return (int)$row['c'];
    }
}
