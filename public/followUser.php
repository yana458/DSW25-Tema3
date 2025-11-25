<?php
use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\DAO\FollowDAO;

require_once '../bootstrap.php';
accessControl($user); // requiere usuario logueado

if (!isset($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
    die('El id del usuario no es válido.');
}

$targetId = (int)$_POST['user_id'];

// No puedes seguirte a ti misma
if ($targetId === $user->getId()) {
    die('No puedes seguirte a ti misma.');
}

// Comprobamos que el usuario a seguir existe
$userDAO = new UserDAO($conn);
$targetUser = $userDAO->get($targetId); // ya lo tienes en tu UserDAO :contentReference[oaicite:4]{index=4}

if (!$targetUser) {
    die('El usuario no existe.');
}

// Togglear follow / unfollow
$followDAO = new FollowDAO($conn);

if ($followDAO->isFollowing($user->getId(), $targetId)) {
    // dejar de seguir
    $followDAO->unfollow($user->getId(), $targetId);
} else {
    // empezar a seguir
    $followDAO->follow($user->getId(), $targetId);
}

// Volver al perfil del usuario seguido
header('Location: perfil.php?id=' . $targetId);
exit();
