<?php

use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\DAO\FollowDAO;  

require_once '../bootstrap.php';
accessControl($user, 'admin');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

$userDAO = new UserDAO($conn);
// Hay confilcto entre $user (usuario logueado) y $user (usuario a mostrar).
// Renombrar a $userDetail al usuario a mostrar.
$userDetail = $userDAO->get($id);

$titulo = "Detalle de usuario";
include '../includes/header.php';
    if ($userDetail) {
         // Crear el DAO de follows
        $followDAO = new FollowDAO($conn);

        // Número de seguidores y seguidos del usuario que estamos viendo
        $followers = $followDAO->countFollowers($userDetail->getId());
        $following = $followDAO->countFollowing($userDetail->getId());

        // ¿El usuario logueado ya sigue a este usuario?
        $yaSigue = $followDAO->isFollowing($user->getId(), $userDetail->getId());

        printf("<h1>%s: %s</h1>", $userDetail->getId(), $userDetail->getName());
        printf("<h2>%s</h2>", $userDetail->getEmail());
        printf("<h3>%s</h3>", $userDetail->getRegisterDate()->format('d/m/Y'));

        // Mostrar contadores
        printf("<p>Seguidores: %d | Siguiendo: %d</p>", $followers, $following);

        // Botón seguir/dejar de seguir (si no es tu propio usuario)
        if ($user->getId() !== $userDetail->getId()) {
            ?>
            <form method="post" action="followUser.php">
                <input type="hidden" name="user_id" value="<?= $userDetail->getId() ?>">
                <button type="submit">
                    <?= $yaSigue ? 'Dejar de seguir' : 'Seguir' ?>
                </button>
            </form>
            <?php
        }

        printf("<h1>%s: %s</h1>", $userDetail->getId(), $userDetail->getName());
        printf("<h2>%s</h2>", $userDetail->getEmail());
        printf("<h3>%s</h3>", $userDetail->getRegisterDate()->format('d/m/Y'));
        printf("<p><a href=\"edit.php?id=%s\">Editar</a></p>", $userDetail->getId());
        printf("<p><a href=\"delete.php?id=%s\">Borrar</a></p>", $userDetail->getId());
        printf("<p><a href=\"createPost.php?id=%s\">Crear Artículo</a></p>", $userDetail->getId());
    } else {
        echo "Usuario no encontrado.";
    }

include '../includes/footer.php'; 


