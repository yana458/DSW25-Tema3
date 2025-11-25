<?php

use Dsw\Blog\DAO\PostDAO;
use Dsw\Blog\DAO\CategoryDAO;

require_once '../bootstrap.php';

// Si quieres que solo los usuarios logueados puedan ver esto, descomenta:
// accessControl($user);

// Creamos los DAOs
$postDAO     = new PostDAO($conn);
$categoryDAO = new CategoryDAO($conn);

// 1) Leer la categoría seleccionada desde la URL (?category=3 por ejemplo)
$categoryId = null;

if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $categoryId = (int) $_GET['category'];
}

// 2) Cargar todas las categorías para el <select>
$categories = $categoryDAO->findAll();

// 3) Obtener los posts según si hay categoría seleccionada o no
if ($categoryId !== null) {
    // Si hay categoría en la URL → filtramos por esa categoría
    $posts = $postDAO->findByCategory($categoryId);
} else {
    // Si no hay categoría → mostramos todos los posts
    // Usa aquí el método que ya tengas para listarlos (por ejemplo findAll())
    $posts = $postDAO->getAll();
}

// 4) Título de la página y cabecera común
$titulo = "Artículos por categoría";
include '../includes/header.php';
?>

<h1>Artículos por categoría</h1>

<!-- Formulario de filtro por categoría -->
<form method="get" action="postsByCategory.php">
    <label for="category">Filtrar por categoría:</label>
    <select name="category" id="category" onchange="this.form.submit()">
        <!-- Opción para ver todas -->
        <option value="">Todas</option>

        <?php foreach ($categories as $cat): ?>
            <option
                value="<?= $cat->getId(); ?>"
                <?= ($categoryId === $cat->getId()) ? 'selected' : ''; ?>
            >
                <?= htmlspecialchars($cat->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Por si el navegador no soporta JS -->
    <noscript>
        <button type="submit">Filtrar</button>
    </noscript>
</form>

<hr>

<?php if (empty($posts)): ?>

    <p>No hay artículos para esta categoría.</p>

<?php else: ?>

    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <!-- Enlace al detalle del post -->
                <a href="post.php?id=<?= $post->getId(); ?>">
                    <?= htmlspecialchars($post->getTitle()); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>

<?php include '../includes/footer.php'; ?>
