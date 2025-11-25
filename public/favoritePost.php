<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\FavoriteDAO;

require_once '../bootstrap.php';

// Solo usuarios logueados
accessControl($user);

if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    die('El id del post no es válido.');
}

$postId = (int)$_POST['post_id'];

// Comprobar que el post existe
$postDAO = new PostDAO($conn);
$post = $postDAO->get($postId);

if (!$post) {
    die('Artículo no existe');
}

// (Opcional) Si no quieres que un usuario guarde sus propios posts, descomenta:
// if ($user->getId() === $post->getUserId()) {
//     die('No puedes guardar en favoritos tu propio artículo.');
// }

$favoriteDAO = new FavoriteDAO($conn);

if ($favoriteDAO->hasUserFavoritedPost($user->getId(), $postId)) {
    // Ya estaba en favoritos → quitar
    $favoriteDAO->remove($user->getId(), $postId);
} else {
    // No estaba → añadir
    $favoriteDAO->add($user->getId(), $postId);
}

// Volver al post
header('Location: post.php?id=' . $postId);
exit();
