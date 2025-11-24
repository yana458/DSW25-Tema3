<?php

use Dsw\Blog\DAO\LikeDAO;
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
    die('Artículo no existe');
}

// Obtenemos el autor del artículo.
$autorId = $post->getUserId();
$userDAO = new UserDAO($conn);
$autor = $userDAO->get($autorId);

$titulo = $post->getTitle();
include "../includes/header.php";
printf('<p>%s</p>', $post->getBody());
printf('<h3>Autor: %s</h3>', $autor->getName());

if ($user->getId() === $autorId) {
    printf('<p><a href="editPost.php?id=%s">Editar artículo</a></p>',$post->getId());        
    printf('<p><a href="deletePost.php?id=%s">Eliminar artículo</a></p>',$post->getId());        
} else {
    $likeDAO = new LikeDAO($conn);
    $buttonText = 'Me Gusta';
    if ($likeDAO->hasUserLikedPost($user->getId(), $post->getId())) {
        printf('<p>¡Te gusta este artículo!</p>');
        $buttonText = 'Quitar me gusta';
    }
    printf('<form method="post" action="likePost.php">
            <input type="hidden" name="post_id" value="%s">
            <button type="submit">%s</button>
        </form>', $post->getId(), $buttonText);
}
include "../includes/footer.php";