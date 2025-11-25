<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

// Solo usuarios logueados pueden ver el timeline
accessControl($user);

$postDAO = new PostDAO($conn);

// Posts de los usuarios a los que sigue el usuario logueado
$posts = $postDAO->findByFollowedUsers($user->getId(), 20);

$userDAO = new UserDAO($conn);

$titulo = "Timeline de usuarios que sigues";
include '../includes/header.php';

echo '<h1>Timeline</h1>';

if (empty($posts)) {
    echo '<p>Aún no hay artículos de usuarios que sigues.</p>';
} else {
    foreach ($posts as $post) {
        // Obtenemos el autor de cada post
        $autor = $userDAO->get($post->getUserId());

        ?>
        <article>
            <h2>
                <a href="post.php?id=<?= $post->getId(); ?>">
                    <?= htmlspecialchars($post->getTitle()); ?>
                </a>
            </h2>
            <p><em>
                Autor:
                <?= $autor ? htmlspecialchars($autor->getName()) : 'Usuario desconocido'; ?>
            </em></p>
            <p>
                <?= nl2br(htmlspecialchars(mb_substr($post->getBody(), 0, 200))); ?>...
            </p>
            <hr>
        </article>
        <?php
    }
}

include '../includes/footer.php';
