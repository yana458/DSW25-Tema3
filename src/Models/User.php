<?php
namespace Dsw\Blog\Models;

use DateTime;

class User {
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email,
        private string $password,
        private string $level,
        private ?DateTime $registerDate,
    ) {}

    public function __toString()
    {
        return $this->id . ": " . $this->name . " " . $this->email . " " . $this->registerDate->format('d-m-Y h:i:s');
    }

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    //get password no se debe hacer
    public function getRegisterDate() { return $this->registerDate; }
    public function getLevel() { return $this->level; }

    public function setId(int $id) {return $this->id = $id;}
    public function setName(string $name) {return $this->name = $name;}
    public function setEmail(string $email) {return $this->email= $email;}
    public function setPassword(string $password){$this->password = $password;}
    public function setLevel(string $level){$this->level = $level;}
}