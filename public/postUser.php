<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

// Obteniendo el usuario
$userDAO = new UserDAO($conn);
$user = $userDAO->get($id);

if (!$user) {
    die("Usuario no encontrado");
}

// Obteniendo los artículos del usuario.
$postDAO = new PostDAO($conn);
$posts = $postDAO->getByUser($user->getId());

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listado de Artículos</h1>
    <h2>Usuario: <?= $user->getName() ?></h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($posts as $post) {
        echo "<tr>";
        printf('<td>%s</td>', $post->getId());
        printf('<td>%s</td>', $post->getTitle());
        echo "</tr>";
    }
?>
        </tbody>
    </table>
</body>
</html>