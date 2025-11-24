<?php
// Modificar un usuario

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';
accessControl($user, 'admin');

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die('El id no es válido.');
}

$id = $_POST['id'];

if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
    $userDAO = new UserDAO($conn);

    //Obtengo el usuario:
    $user = $userDAO->get($id);

    // Modifico los datos:
    $user->setName($_POST['name']);
    $user->setEmail($_POST['email']);
    $user->setPassword($_POST['password']);
    $user->setLevel($_POST['role']);

    // Guardo el usuario:
    $userDAO->update($user);

}


header('Location: users.php');
exit();