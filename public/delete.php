<?php

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';
accessControl($user, 'admin');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = (int)$_GET['id'];

$userDAO = new UserDAO($conn);
// Antes: $userDAO->delete($id);
$userDAO->deleteCompletely($id);

header('Location: users.php'); // o donde quieras
exit();

