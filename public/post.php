<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\UserDAO;

require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

$postDAO = new PostDAO($conn);
$post = $postDAO->get($id);

$userId = $post->getUserId();
$userDAO = new UserDAO($conn);
$user = $userDAO->get($userId);

if(!$post) {
    die('Articulo no existe');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
</head>
<body>
    <h1><?= $post->getTitle()?></h1>
    <p><?= $post->getBody() ?></p>
    <h3><? $user->getName() ?></h3>
</body>
</html>
