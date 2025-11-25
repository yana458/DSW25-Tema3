<?php

namespace Dsw\Blog\Models;

class Like {
    public function __construct(
        private int $userId,
        private int $postId,
    ) {}

    public function getUserId(): int {
        return $this->userId;
    }

    public function getPostId(): int {
        return $this->postId;
    }

    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }

    public function setPostId(int $postId): void {
        $this->postId = $postId;
    }
}