<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

$postDAO = new PostDAO($conn);
$posts = $postDAO->getAll();

$titulo = "Lista de articulos";
include '../includes/header.php';
?>

<body>
    <h1>Listado de Artículos</h1>
    <!-- <p>
        <a href="createPost.php">Crear un artículo</a>
    </p> -->
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
    $userDAO = new UserDAO($conn);
    foreach($posts as $post) {
        $userId = $post->getUserId();
        $user = $userDAO->get($userId);
        echo "<tr>";
        printf('<td>%s</td>', $post->getId());
        printf("<td> <a href=\"post.php?id=%s\"> %s</a></td>", $post->getId(), $post->getTitle());
        printf('<td>%s</td>', $user->getName());
        echo "</tr>";
    }
?>
        </tbody>
    </table>
<?php
include '../includes/footer.php';
?>