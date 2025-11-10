<?php
//Modificar un usuario

use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die('El id no es válido.');
}
$id = $_POST['id'];

if(isset($_POST['name'], $_POST['email'])){
    $userDAO = new UserDAO($conn);
    //Obtengo el usuario
    $user = $userDAO->get($id);

    //Modifico los datos
    $user->setName($_POST['name']);
    $user->setEmail($_POST['email']);

    //Guardo el usuario:
    $userDAO->update($user);
}

header('Location: users.php');
exit();