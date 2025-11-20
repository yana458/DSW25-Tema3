<?php
namespace Dsw\Blog\DAO;

use DateTime;
use Dsw\Blog\Models\User;
use PDO;

class UserDAO {
    public function __construct(
        private PDO $conn
    ) {}

    public function get(int $id): ?User {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $register = $stmt->fetch();
        if ($register) {
            return new User($id, $register['name'], $register['email'], $register['password'], $register['level'], new DateTime($register['register_date']));
        }
        return null;        
    }

    public function getAll(): array {
        $users = [];
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $registers = $stmt->fetchAll();
        foreach($registers as $register) {
            $users[] = new User($register['id'], $register['name'], $register['email'], $register['password'], $register['level'], new DateTime($register['register_date']));
        }
        return $users;
    }

    public function delete(int $id): void {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
    }

    public function update(User $user) {
        $sql = "UPDATE users SET name= :name, email = :email WHERE id= :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ]);
    }

    public function create(User $user): User{
        $sql = "INSERT INTO users (name, email) VALUES(:name, :email)";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);
        $user->setId($this->conn->lastInsertId());
        return $user;
    }

    public function login($name, $password): ?User{  //devuelve un usuario o NULO
        $sql = "SELECT * FROM users WHERE name=:name AND password=:password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'password' => $password,
        ]);
        $register = $stmt->fetch();
        if ($register) {
            return new User($register['id'], $register['name'], $register['email'], $register['password'], $register['level'], new DateTime($register['register_date']));
        }
        return null;        
    }
}