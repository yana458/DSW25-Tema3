<?php
// Crear un usuario

use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\Models\User;

require_once '../bootstrap.php';
accessControl($user, 'admin');

if (isset($_POST['email'], $_POST['name'], $_POST['password'], $_POST['role'])) {
    $user = new User(null, $_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'], null);

    $userDAO = new UserDAO($conn);
    $user = $userDAO->create($user);
}

header('Location: users.php');
exit();