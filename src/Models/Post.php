<?php
namespace Dsw\Blog\Models;

use DateTime;
use Dsw\Blog\DAO\UserDAO;

class Post {
    public function __construct(
        private ?int $id,
        private string $title,
        private string $body,
        private ?DateTime $publicationDate,
        private int $userId,
        private ?int $categoryId = null     // 👈 NUEVO, opcional para no romper nada
    ) {}

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getBody() { return $this->body; }
    public function getPublicationDate() { return $this->publicationDate; }
    public function getUserId() { return $this->userId; }
    public function getCategoryId(): ?int { return $this->categoryId; }  // 👈 NUEVO

    public function setId(int $id) { $this->id = $id; }
    public function setTitle(string $title) { $this->title = $title; }
    public function setBody(string $body) { $this->body = $body; }
    public function setUserId(int $userId) { $this->userId = $userId; }
    public function setCategoryId(?int $categoryId): void {              // 👈 NUEVO
        $this->categoryId = $categoryId;
    }


}