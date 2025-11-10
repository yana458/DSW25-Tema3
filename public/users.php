<?php
use Dsw\Blog\DAO\UserDAO;
require_once '../bootstrap.php';

$userDAO = new UserDAO($conn);
$users = $userDAO->getAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios </title>
</head>
<body>
    <h1>Lista de usuarios</h1>
    <p>
        <a href="create.php">Crear Ususario Nuevo</a>
    </p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha registro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($users as $user){
                echo"<tr>";
                printf("<td><a href=\"user.php?id=%s\"</a>%s</td>", $user->getId(), $user->getId());
                printf("<td>%s</td>", $user->getName());
                printf("<td>%s</td>", $user->getEmail());
                printf("<td>%s</td>", $user->getRegisterDate()->format('d-m-Y'));
                echo"</tr>";

            }
            ?>
        </tbody>
    </table>
</body>
</html>