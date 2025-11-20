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
        <h1>Tema 3: Blog</h1>
        <?php
        if($user){
            printf('<p>%s - %s</p>', $user->getName(), $user->getLevel());
        }
        ?>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <?php
                if($user){
                    if($user->getLevel() === "admin") {

                    }
                }
                <li><a href="users.php">Usuarios</a></li>
                <li><a href="posts.php">Articulos</a></li>
                <?php
                if($user){
                    echo '<li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <h1><?= $titulo ?></h1>
    <div id="container">
        
  