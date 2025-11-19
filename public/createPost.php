<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crear Articulo</h1>
    <form action="storePost.php?user_id=<?= $id ?>" method="post">
        <p>
            <label for="title">Titulo:</label>
            <input type="text" name="title" id="title" required>
        </p>
        <p>
            <label for="body">Contenido</label>
            <textarea name="body" id="body"></textarea>
        </p>
        <p>
            <button type="submit">Crear</button>
        </p>
    </form>
</body>
</html>
<?php
}else{
    die("Id de usuario no válido");
}
?>