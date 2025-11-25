<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Crear Artículo</h1>
    <form action="storePost.php?user_id=<?=  $id ?>" method="post">
        <p>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
        </p>
        <p>
            <label for="body">Contenido</label>
            <textarea name="body" id="body"></textarea>
        </p>
        <p>
        <label for="category_id">Categoría:</label>
        <select name="category_id" id="category_id">
            <option value="">Sin categoría</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->getId(); ?>">
                    <?= htmlspecialchars($cat->getName()); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
        <p>
            <button type="submit">Crear</button>
        </p>
    </form>
</body>
</html>
<?php
} else {
    die("Id de usuario no válido");
}
?>
