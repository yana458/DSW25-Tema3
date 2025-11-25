<?php

use Dsw\Blog\DAO\CommentDAO;

require_once '../bootstrap.php';

// Solo usuarios logueados pueden borrar comentarios
accessControl($user);

// 1. Validar datos recibidos por POST
if (!isset($_POST['comment_id']) || !is_numeric($_POST['comment_id'])) {
    die('El id del comentario no es válido.');
}

$commentId = (int)$_POST['comment_id'];

$commentDAO = new CommentDAO($conn);
$comment = $commentDAO->get($commentId);

if (!$comment) {
    die('El comentario no existe.');
}

// 2. Comprobar permisos:
//    - Puede borrar si es admin
//    - o si es el autor del comentario
$esAdmin = $user->isAdmin();
$esAutorComentario = ($user->getId() === $comment->getUserId());

if (!$esAdmin && !$esAutorComentario) {
    die('No tienes permiso para borrar este comentario.');
}

// 3. Borrar
$commentDAO->delete($commentId);

// 4. Volver al post al que pertenecía el comentario
$postId = $comment->getPostId();
header('Location: post.php?id=' . $postId);
exit();
