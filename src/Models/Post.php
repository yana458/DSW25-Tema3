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
        private ?int $userId,
    ) {}

    public function __toString()
    {
        return $this->id . ": " . $this->title. " " . $this->body . " " . $this->publicationDate->format('d-m-Y h:i:s');
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getBody() { return $this->body; }
    public function getRegisterDate() { return $this->publicationDate; }
    public function getUserId() { return $this->userId; }

    public function setId(int $id) {return $this->id = $id;}
    public function setTitle(string $title) {return $this->title = $title;}
    public function setEmail(string $body) {return $this->body= $body;}
    public function setUserId(int $userId) { return $this->userId = $userId; }
}