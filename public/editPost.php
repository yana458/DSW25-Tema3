<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

$postDAO = new PostDAO($conn);
$post = $postDAO->get($id);

if (!$post) {
    die('Artículo no encontrado');
}

// Si no es el usuario el autor del post, se redirige a prohibido. 
if ($user->getId() !== $post->getUserId()) {
    header('Location: prohibido.php');
    exit();
}

$titulo = "Editar Artículo";
include "../includes/header.php";
?>
    <form action="updatePost.php?id=<?=  $id ?>" method="post">
        <p>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required value="<?= $post->getTitle() ?>">
        </p>
        <p>
            <label for="body">Contenido</label>
            <textarea name="body" id="body"><?=  $post->getBody() ?></textarea>
        </p>
        <p>
            <label for="user">Usuario: </label>
            <select name="user_id" id="user">
<?php
    $userDAO = new UserDAO($conn);
    $users = $userDAO->getAll();
    foreach ($users as $user) {
        // if ($user->getId() === $post->getUserId()) {
        //     printf('<option value="%s" selected>%s</option>', $user->getId(), $user->getName());
        // } else {
        //     printf('<option value="%s">%s</option>', $user->getId(), $user->getName());
        // }
        $autor = $user->getId() === $post->getUserId() ? 'selected' : ''; 
         printf('<option value="%s" %s>%s</option>', $user->getId(), $autor, $user->getName());
    }
?>
                
            </select>
        </p>
        <p>
            <button type="submit">Modificar</button>
        </p>
    </form>
<?php
include "../includes/footer.php";
?>