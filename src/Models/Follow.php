<?php
namespace Dsw\Blog\Models;

class Follow {
    public function __construct(
        private int $followerId,
        private int $followedId
    ) {}

    public function getFollowerId(): int {
        return $this->followerId;
    }

    public function getFollowedId(): int {
        return $this->followedId;
    }

    public function setFollowerId(int $followerId): void {
        $this->followerId = $followerId;
    }

    public function setFollowedId(int $followedId): void {
        $this->followedId = $followedId;
    }
}
