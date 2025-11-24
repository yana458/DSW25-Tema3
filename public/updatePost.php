<?php

use Dsw\Blog\DAO\PostDAO;

require_once '../bootstrap.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('El id no es válido.');
}

$id = $_GET['id'];

if (isset($_POST['title'], $_POST['body'], $_POST['user_id'])) {
    $postDAO = new PostDAO($conn);

    $post = $postDAO->get($id);

    if ($post) {
        // Si no es el usuario el autor del post, se redirige a prohibido. 
        if ($user->getId() !== $post->getUserId()) {
            header('Location: prohibido.php');
            exit();
        }
    
        $post->setTitle($_POST['title']);
        $post->setBody($_POST['body']);
        $post->setUserId($_POST['user_id']);
    
        $postDAO->update($post);
    }
}

header('Location: posts.php');
exit();