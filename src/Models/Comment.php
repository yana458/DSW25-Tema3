<?php
namespace Dsw\Blog\Models;

class Comment
{
    public function __construct(
        private ?int $id,
        private string $body,
        private int $postId,
        private int $userId,
        private \DateTime $createdAt,
        private ?string $userName = null   // nombre del autor (para mostrar)
    ) {}

    public function getId(): ?int {
        return $this->id;
    }

    public function getBody(): string {
        return $this->body;
    }

    public function getPostId(): int {
        return $this->postId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }

    public function getUserName(): ?string {
        return $this->userName;
    }

    public function setUserName(?string $userName): void {
        $this->userName = $userName;
    }
}
