<?php

use Dsw\Blog\DAO\PostDAO;

require_once '../bootstrap.php';
accessControl($user);

if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    die('El id del post no es válido.');
}

$postId = $_POST['post_id'];

$postDAO = new PostDAO($conn);
$post = $postDAO->get($postId);

if (!$post) {
    die('Artículo no existe');
}

if ($user->getId() === $post->getUserId()) {
    die('No puedes darle me gusta a tu propio artículo.');
}

$likeDAO = new \Dsw\Blog\DAO\LikeDAO($conn);
if ($likeDAO->hasUserLikedPost($user->getId(), $post->getId())) {
    // Quitar me gusta
    $likeDAO->removeLike($user->getId(), $post->getId());
} else {
    // Añadir me gusta
    $likeDAO->addLike($user->getId(), $post->getId());
}

header('Location: post.php?id=' . $post->getId());
exit();