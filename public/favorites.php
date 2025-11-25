<?php
//MOSTRAR FAVORITOS DEL USUARIO LOGUEADO
use Dsw\Blog\DAO\FavoriteDAO;

require_once '../bootstrap.php';

// Solo usuarios logueados
accessControl($user);

$favoriteDAO = new FavoriteDAO($conn);
$favorites = $favoriteDAO->getFavoritesByUser($user->getId());

$titulo = "Mis favoritos";
include '../includes/header.php';

echo '<h1>Mis artículos favoritos</h1>';

if (empty($favorites)) {
    echo '<p>No tienes artículos en favoritos.</p>';
} else {
    echo '<ul>';
    foreach ($favorites as $post) {
        printf(
            '<li><a href="post.php?id=%s">%s</a></li>',
            $post->getId(),
            htmlspecialchars($post->getTitle())
        );
    }
    echo '</ul>';
}

include '../includes/footer.php';
