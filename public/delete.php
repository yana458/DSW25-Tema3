<?php

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

$userDAO = new UserDAO($conn);
$user = $userDAO->delete($id);

// Vuelve a mostrar la tabla
header('Location: users.php');
exit();
