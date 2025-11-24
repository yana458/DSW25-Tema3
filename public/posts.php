<?php

use Dsw\Blog\DAO\LikeDAO;
use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

accessControl($user); // No hay que poner el level porque está 'user' por defecto.

$postDAO = new PostDAO($conn);
$posts = $postDAO->getAll();

$titulo ="Publicaciones";
include '../includes/header.php';
?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Usuario</th>
                <th>Me gusta</th>
            </tr>
        </thead>
        <tbody>
<?php
    $userDAO = new UserDAO($conn);
    foreach($posts as $post) {
        $userId = $post->getUserId();
        $user = $userDAO->get($userId);
        $likeDAO = new LikeDAO($conn);
        echo "<tr>";
        printf('<td>%s</td>', $post->getId());
        printf('<td><a href="post.php?id=%s">%s</a></td>', $post->getId(), $post->getTitle());
        printf('<td>%s</td>', $user->getName());
        printf('<td>%s</td>', $likeDAO->countLikes($post->getId()));
        echo "</tr>";
    }
?>
        </tbody>
    </table>
<?php
include '../includes/footer.php';
?>