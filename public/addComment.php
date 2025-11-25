<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\CommentDAO;

require_once '../bootstrap.php';

// Solo usuarios logueados pueden comentar
accessControl($user);

// 1. Validar datos recibidos por POST
if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    die('El id del post no es válido.');
}

if (!isset($_POST['body']) || trim($_POST['body']) === '') {
    die('El comentario no puede estar vacío.');
}

$postId = (int)$_POST['post_id'];
$body   = trim($_POST['body']);

// 2. Comprobar que el post existe
$postDAO = new PostDAO($conn);
$post = $postDAO->get($postId);

if (!$post) {
    die('El artículo no existe.');
}

// 3. Guardar el comentario en BD
$commentDAO = new CommentDAO($conn);
$commentDAO->add($postId, $user->getId(), $body);

// 4. Volver a la página del post
header('Location: post.php?id=' . $postId);
exit();
