<?php
// Crear un artículo

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\Models\Post;

require_once '../bootstrap.php';

if (isset($_GET['user_id'], $_POST['title'], $_POST['body'])) {

    $userId      = (int)$_GET['user_id'];
    $title       = trim($_POST['title']);
    $body        = trim($_POST['body']);
    $categoryId  = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;

    // Crear el post con categoryId (puede ser null)
    $post = new Post(
        null,
        $title,
        $body,
        null,       // publicationDate (la pondrá la BD con NOW() o similar)
        $userId,
        $categoryId // 👈 NUEVO
    );

    $postDAO = new PostDAO($conn);
    $postDAO->create($post);
}

header('Location: posts.php');
exit();
