<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Tema3: Blog</h1>
<?php
if ($user) {
    printf('<p>%s - %s</p>', $user->getName(), $user->getLevel());
}   
?>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
            <?php if ($user) { 
                    if ($user->isAdmin()) {
            ?>
            
                <li><a href="users.php">Usuarios</a></li>
            <?php
                    }   
            ?>

                <li><a href="posts.php">Artículos</a></li>
                <li><a href="favorites.php">Favoritos</a></li>
                <li><a href="timeline.php">Timeline</a></li>
                <li><a href="topPosts.php">Top Posts</a></li>
                <li><a href="searchPost.php">Buscar</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php
            } else {
                echo '<li><a href="login.php">Login</a></li>';
            }
            ?>   
            </ul>
        </nav>
    </header>
    <main>
        <h1><?= $titulo ?></h1>
        <div id="container">