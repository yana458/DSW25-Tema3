<?php
use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

$postDAO = new PostDAO($conn);
$posts = $postDAO->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios </title>
</head>
<body>
    <h1>Listado de Articulos</h1>
    <p>
        <a href="">Crear articulo nuevo</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($posts as $post){
                $userId = $post->getUserId();
                $userDAO = new UserDAO($conn);
                $user = $userDAO->get($userId);
                echo"<tr>";
                printf("<td>%s</td>", $post->getId());
                printf("<td>%s</td>", $post->getTitle());
                printf("<td>%s</td>", $user->getName());
                echo"</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>