<?php
namespace Dsw\Blog;

use PDO;

class UserDao{
    public function __construct(
            private PDO $conn
        )
        {
            
        }

    public function get($id): ?User {
        $sql = "SELECT * FROM users WHERW id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $register = $stmt->fetch();

        if($register){
        return new User($id, $register['name'], $register['email'], $register['register_date']);
        }
        return null;
    }
}