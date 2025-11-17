<?php
// Crear un usuario

use Dsw\Blog\DAO\UserDAO;
use Dsw\Blog\Models\User;

require_once '../bootstrap.php';

if (isset($_POST['email'], $_POST['name'])) {
    $user = new User(null, $_POST['name'], $_POST['email'], null);

    $userDAO = new UserDAO($conn);
    $user = $userDAO->create($user);
}

header('Location: users.php');
exit();
