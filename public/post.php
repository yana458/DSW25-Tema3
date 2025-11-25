<?php

use Dsw\Blog\DAO\LikeDAO;
use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\DAO\CommentDAO;
use Dsw\Blog\DAO\FavoriteDAO;


require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = (int)$_GET['id'];

$postDAO = new PostDAO($conn);
$post = $postDAO->get($id);

if (!$post) {
    die('Artículo no existe');
}

// Obtenemos el autor del artículo.
$autorId = $post->getUserId();
$userDAO = new UserDAO($conn);
$autor = $userDAO->get($autorId);

// Obtenemos los comentarios del artículo.
$commentDAO = new CommentDAO($conn);
$comments = $commentDAO->findByPost($post->getId());

$titulo = $post->getTitle();
include "../includes/header.php";

// Contenido del post
printf('<p>%s</p>', nl2br(htmlspecialchars($post->getBody())));
printf('<h3>Autor: %s</h3>', htmlspecialchars($autor->getName()));

// Zona edición / likes
if ($user && $user->getId() === $autorId) {
    // El autor ve opciones de editar / eliminar
    printf(
        '<p><a href="editPost.php?id=%s">Editar artículo</a></p>',
        $post->getId()
    );
    printf(
        '<p><a href="deletePost.php?id=%s">Eliminar artículo</a></p>',
        $post->getId()
    );
} else {
    // Otros usuarios pueden dar like (solo si hay usuario logueado)
    if ($user) {
        $likeDAO = new LikeDAO($conn);
        $buttonText = 'Me gusta';

        if ($likeDAO->hasUserLikedPost($user->getId(), $post->getId())) {
            printf('<p>¡Te gusta este artículo!</p>');
            $buttonText = 'Quitar me gusta';
        }

        printf(
            '<form method="post" action="likePost.php">
                <input type="hidden" name="post_id" value="%s">
                <button type="submit">%s</button>
            </form>',
            $post->getId(),
            $buttonText
        );

        // ==== FAVORITOS ====
        $favoriteDAO = new FavoriteDAO($conn);
        $favText = 'Guardar en favoritos';

         if ($favoriteDAO->hasUserFavoritedPost($user->getId(), $post->getId())) {
            printf('<p>Este artículo está en tus favoritos.</p>');
            $favText = 'Quitar de favoritos';
        }
         printf(
            '<form method="post" action="favoritePost.php">
                <input type="hidden" name="post_id" value="%s">
                <button type="submit">%s</button>
            </form>',
            $post->getId(),
            $favText
        );

    } else {
        echo '<p>Inicia sesión para dar me gusta o guardar en favoritos.</p>';
    }
}

// =====================
// Zona de COMENTARIOS
// =====================

echo '<h2>Comentarios</h2>';

if (empty($comments)) {
    echo '<p>No hay comentarios todavía.</p>';
} else {
    foreach ($comments as $comment) {
        printf(
            '<div class="comentario">
                <p><strong>%s</strong> el %s</p>
                <p>%s</p>',
            htmlspecialchars($comment->getUserName() ?? 'Anónimo'),
            $comment->getCreatedAt()->format('d/m/Y H:i'),
            nl2br(htmlspecialchars($comment->getBody()))
        );

        // 🔹 Botón eliminar solo si:
        //    - hay usuario logueado
        //    - y es admin o autor del comentario
        if ($user && ($user->isAdmin() || $user->getId() === $comment->getUserId())) {
            ?>
            <form method="post" action="delete_comment.php" style="display:inline;">
                <input type="hidden" name="comment_id" value="<?= $comment->getId(); ?>">
                <button type="submit">Eliminar</button>
            </form>
            <?php
        }

        echo '<hr></div>';
    }
}


// Formulario para añadir comentario
if ($user) {
    ?>
    <h3>Deja tu comentario</h3>
    <form method="post" action="add_comment.php">
        <input type="hidden" name="post_id" value="<?= $post->getId(); ?>">
        <p>
            <textarea name="body" rows="4" cols="40" required></textarea>
        </p>
        <p>
            <button type="submit">Comentar</button>
        </p>
    </form>
    <?php
} else {
    echo '<p>Inicia sesión para comentar.</p>';
}

include "../includes/footer.php";
