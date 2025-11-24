<?php

use Dsw\Blog\DAO\UserDAO;

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


