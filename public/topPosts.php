<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

// Opcional: si quieres que solo usuarios logueados vean el top
// accessControl($user);

$postDAO = new PostDAO($conn);
$userDAO = new UserDAO($conn);

// Obtenemos los 5 posts con más likes
$topPosts = $postDAO->getMostLiked(5);

// Título de la página
$titulo = "Top posts con más likes";

include '../includes/header.php';
?>

<h1>Top posts con más likes</h1>

<?php if (empty($topPosts)): ?>

    <p>No hay artículos todavía.</p>

<?php else: ?>

    <ol>
        <?php foreach ($topPosts as $postRow): ?>
            <?php
                // $postRow es un array asociativo con:
                // id, title, body, publication_date, user_id, like_count

                // Obtenemos el autor del post (opcional, para mostrar su nombre)
                $autor = $userDAO->get((int)$postRow['user_id']);
                $autorName = $autor ? $autor->getName() : 'Autor desconocido';

                // Pequeño resumen del cuerpo (primeros 150 caracteres)
                $resumen = mb_substr($postRow['body'], 0, 150) . '...';
            ?>
            <li>
                <h2>
                    <!-- Enlace al detalle del post -->
                    <a href="post.php?id=<?= (int)$postRow['id']; ?>">
                        <?= htmlspecialchars($postRow['title']); ?>
                    </a>
                </h2>
                <p>
                    <strong>Autor:</strong>
                    <?= htmlspecialchars($autorName); ?>
                </p>
                <p>
                    <strong>Likes:</strong>
                    <?= (int)$postRow['like_count']; ?>
                </p>
                <p>
                    <?= nl2br(htmlspecialchars($resumen)); ?>
                </p>
                <hr>
            </li>
        <?php endforeach; ?>
    </ol>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>
