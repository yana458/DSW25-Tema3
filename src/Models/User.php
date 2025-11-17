<?php
namespace Dsw\Blog\Models;

use DateTime;

class User {
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private ?DateTime $registerDate,
    ) {}

    public function __toString()
    {
        return $this->id . ": " . $this->name . " " . $this->email . " " . $this->registerDate->format('d-m-Y h:i:s');
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRegisterDate() { return $this->registerDate; }

    public function setId(int $id) { $this->id = $id; }
    public function setName(string $name) { $this->name = $name; }
    public function setEmail(string $email) { $this->email = $email; }
}