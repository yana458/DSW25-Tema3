<?php

use Dsw\Blog\DAO\PostDAO;

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Editar Artículo</h1>
    <form action="updatePost.php?id=<?=  $id ?>" method="post">
        <input type="hidden" name="user_id" value="<?= $post->getUserId() ?>">
        <p>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required value="<?= $post->getTitle() ?>">
        </p>
        <p>
            <label for="body">Contenido</label>
            <textarea name="body" id="body"><?=  $post->getBody() ?></textarea>
        </p>
        <p>
            <button type="submit">Modificar</button>
        </p>
    </form>
</body>
</html>