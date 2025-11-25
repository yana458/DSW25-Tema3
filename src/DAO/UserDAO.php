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
        $sql = "UPDATE users SET name=:name, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'id' => $user->getId(),
            'name' => $user->getName(), 
            'email' => $user->getEmail()
        ]);
    }

    public function create(User $user): User {
        $sql = "INSERT INTO users (name, email) VALUES(:name, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $user->getName(), 
            'email' => $user->getEmail()
        ]);
        $user->setId($this->conn->lastInsertId());
        return $user;
    }

    public function login($name, $password): ?User {
        $sql = "SELECT * FROM users WHERE name=:name AND password=:password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'password' => $password
        ]);
        $register = $stmt->fetch();
        if ($register) {
            return new User($register['id'], $register['name'], $register['email'], $register['password'], $register['level'], new DateTime($register['register_date']));
        }
        return null;   
    }

    //BORRAR TODO CON TRANSACCION INCLUYENDO LIKES, FAVORITOS ETC
    public function deleteCompletely(int $userId): void
{
    try {
        // 🔹 1. Empezamos una TRANSACCIÓN.
        // A partir de aquí, los cambios no se guardan "de verdad"
        // hasta que hagamos commit().
        $this->conn->beginTransaction();

        // 🔹 2. Borrar los likes que ha dado el usuario en otros posts.
        // Tabla "likes" (ajusta el nombre si tu tabla se llama distinto).
        $sql = "DELETE FROM likes WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // 🔹 3. Borrar los likes que otros usuarios han hecho
        // sobre los posts de ESTE usuario.
        //
        // Hacemos un JOIN entre likes y posts:
        //   - posts.user_id = usuario propietario del post
        //   - likes.post_id = id del post
        //
        // Así borramos TODOS los likes de TODOS los posts de este usuario.
        $sql = "DELETE l
                FROM likes l
                JOIN posts p ON l.post_id = p.id
                WHERE p.user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // (Opcional) 🔹 3.1. Borrar comentarios del usuario o de sus posts
        // Si tienes tabla comments, podrías añadir algo parecido, por ejemplo:
        //
        // - Comentarios que ha hecho el usuario:
        //   DELETE FROM comments WHERE user_id = :id
        //
        // - Comentarios en los posts del usuario:
        //   DELETE c FROM comments c
        //   JOIN posts p ON c.post_id = p.id
        //   WHERE p.user_id = :id
        //
        // De momento no lo pongo para no liarte, pero la idea es la misma.

        // 🔹 4. Borrar los posts del usuario.
        // Ojo: primero hemos borrado los likes de esos posts
        // para evitar problemas de claves foráneas.
        $sql = "DELETE FROM posts WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // 🔹 5. Borrar el propio usuario.
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $userId]);

        // 🔹 6. Si TODO ha ido bien, confirmamos la transacción.
        // Ahora sí se aplican todos los borrados en la BD.
        $this->conn->commit();

    } catch (\PDOException $e) {
        // 🔹 7. Si cualquier paso de arriba lanza un error (excepción),
        // llegamos aquí y hacemos ROLLBACK.
        // Eso significa: deshacer TODAS las operaciones hechas
        // desde el beginTransaction().
        $this->conn->rollBack();

        // Volvemos a lanzar la excepción para que el controlador
        // pueda mostrar un mensaje o hacer algo con el error.
        throw $e;
    }
}

}