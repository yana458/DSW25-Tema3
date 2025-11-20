<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;
require_once '../bootstrap.php';

$userDAO = new UserDAO($conn);
$users = $userDAO->getAll();

$titulo = "Lista de usuarios";
include '../includes/header.php';
?>

    <p>
        <a href="create.php">Crear ususario nuevo</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha registro</th>
                <th>Numero articulos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $postDAO = new PostDAO($conn);
            
            foreach($users as $user){
                $posts = $postDAO->getByUser($user->getId());
                echo"<tr>";
                printf("<td><a href=\"user.php?id=%s\"</a>%s</td>", $user->getId(), $user->getId());
                printf("<td>%s</td>", $user->getName());
                printf("<td>%s</td>", $user->getEmail());
                printf("<td>%s</td>", $user->getRegisterDate()->format('d-m-Y'));
                printf("<td><a href=\"postUser.php?id=%s\">%s</a></td>", $user->getId(), count($posts));
                echo"</tr>";

            }
            ?>
        </tbody>
    </table>
<?php
include '../includes/footer.php';
?>